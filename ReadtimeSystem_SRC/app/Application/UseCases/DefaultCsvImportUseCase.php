<?php

namespace App\Application\UseCases;

use App\Consts\AppConst;
use App\Domain\Entities\CsvImportResultEntity;
use App\Domain\Factories\DepoAddressLeadtimeFactory;
use App\Domain\Factories\DepoItemInfoFactory;
use App\Domain\Repositories\DepoAddressLeadtimeRepositoryInterface;
use App\Domain\Repositories\DepoItemInfoRepositoryInterface;
use App\Domain\Repositories\ViewAddressRepositoryInterface;
use Exception;
use DB;
use Illuminate\Support\Facades\Lang;
use Log;
use Validator;

class DefaultCsvImportUseCase extends BaseCsvImportUseCase
{

    // Usecase
    private $depoListUsecase;
    private $itemUsecase;

    // デポ住所リードタイム情報
    private $iDepoAddressLeadtimeRepository;

    // デポ取扱商品情報
    private $iDepoItemInfoRepository;

    // 住所一覧
    private $iViewAddressRepository;

    /**
     * コンストラクタ
     *
     * @param DepoAddressLeadtimeRepositoryInterface $iDepoAddressLeadtimeRepository
     */
    public function __construct(
        DepoAddressLeadtimeRepositoryInterface $iDepoAddressLeadtimeRepository,
        DepoItemInfoRepositoryInterface $iDepoItemInfoRepository,
        DepoListUseCase $depoListUsecase,
        ItemUseCase $itemUsecase,
        ViewAddressRepositoryInterface $iViewAddressRepository
    ) {
        $this->iDepoAddressLeadtimeRepository = $iDepoAddressLeadtimeRepository;
        $this->iDepoItemInfoRepository = $iDepoItemInfoRepository;
        $this->iViewAddressRepository = $iViewAddressRepository;
        $this->depoListUsecase = $depoListUsecase;
        $this->itemUsecase = $itemUsecase;
    }

    /**
     * Leadtimeタブ用のCSV取り込み処理
     *
     * @param string $fileName
     * @return CsvImportResultEntity
     */
    public function leadtimeCsv(string $fileName): CsvImportResultEntity
    {
        $parseErrors = [];
        $this->totalCount = 0;
        $this->errorCount = 0;

        $resultEntity = new CsvImportResultEntity();

        try {
            // デポ取得
            $depoList = $this->depoListUsecase->findDepoListAll();

            DB::beginTransaction();
            $parseErrors = $this->importFile($fileName, function ($rows, $lineNo) use ($depoList) {
                // データ行
                $this->totalCount++;
                // baseカラム数
                $baseColumns = $this->getImportColumns('lead_time');

                // カラム数チェック
                if (count($rows) == $baseColumns) {
                    try {
                        // 初期化
                        $errors = [];
                        // 値取得
                        $depoCd = $rows[0];
                        $jiscode = $rows[3];
                        $zipCd = $rows[4];
                        $prefCd = $rows[5];
                        $siku = $rows[6];
                        $tyou = $rows[7];
                        $nextDayTimeType = $rows[8];
                        $isAreaTodayDeliveryFlg = empty($rows[9]) ? 0 : $rows[9];
                        $nextDayTimeDeadline = $rows[10];
                        $todayTimeDeadline1 = $rows[11];
                        $todayTimeDeadline2 = $rows[12];
                        // 住所情報のvalidationチェック
                        $validatorAddress = Validator::make(
                            [
                                'depoCd' => $depoCd,
                                'jiscode' => $jiscode,
                                'zipCd' => $zipCd,
                                'prefCd' => $prefCd,
                                'siku' => $siku,
                                'tyou' => $tyou
                            ],
                            [
                                'depoCd' => 'required|integer',
                                'jiscode' => 'nullable|string|max:40',
                                'zipCd' => 'nullable|string|max:8',
                                'prefCd' => 'required|integer|max:99',
                                'siku' => 'required|string|max:40',
                                'tyou' => 'required|string|max:100'
                            ]
                        );
                        if ($validatorAddress->fails()) {
                            foreach($validatorAddress->errors()->all() as $errorMsg) {
                                $errors[] = $errorMsg;
                            }
                        }

                        // デポ存在チェック
                        $depo = $depoList->first(function ($obj, $key) use ($depoCd) {
                            return $obj->depocd == $depoCd;
                        });
                        if (is_null($depo)) {
                            $errors[] = Lang::get('error.CSV.depo_not_exist',['depoCd' => $depoCd]);
                        } else {
                        // デポ区分による必須判定
                            $rule = [];
                            if($depo->depoType == AppConst::DEPO_DISPLAY_CLS_SURP) {
                                // サプライズ
                                $rule = [
                                    'nextDayTimeType' => 'nullable|integer|max:9999',
                                    'isAreaTodayDeliveryFlg' => 'required|boolean',
                                    'nextDayTimeDeadline' => 'nullable|integer|max:9999',
                                    'todayTimeDeadline1' => 'required|integer|max:9999',
                                    'todayTimeDeadline2' => 'nullable|integer|max:9999',
                                ];

                            } else if($depo->depoType == AppConst::DEPO_DISPLAY_CLS_ENTERME) {
                                // エンタメ
                                $rule = [
                                    'nextDayTimeType' => 'required|integer|max:9999',
                                    'isAreaTodayDeliveryFlg' => 'nullable|boolean',
                                    'nextDayTimeDeadline' => 'required|integer|max:9999',
                                    'todayTimeDeadline1' => 'nullable|integer|max:9999',
                                    'todayTimeDeadline2' => 'nullable|integer|max:9999',
                                ];
                            } else {
                                // 通常
                                $rule = [
                                    'nextDayTimeType' => 'required|integer|max:9999',
                                    'isAreaTodayDeliveryFlg' => 'required|boolean',
                                    'nextDayTimeDeadline' => 'required|integer|max:9999',
                                    'todayTimeDeadline1' => 'required|integer|max:9999',
                                    'todayTimeDeadline2' => 'nullable|integer|max:9999',
                                ];
                            }
                            $validatorLeadtime = Validator::make(
                                [
                                    'nextDayTimeType' => $nextDayTimeType,
                                    'isAreaTodayDeliveryFlg' => $isAreaTodayDeliveryFlg,
                                    'nextDayTimeDeadline' => $nextDayTimeDeadline,
                                    'todayTimeDeadline1' => $todayTimeDeadline1,
                                    'todayTimeDeadline2' => $todayTimeDeadline2,
                                ],
                                $rule
                            );
                            if ($validatorLeadtime->fails()) {
                                foreach($validatorLeadtime->errors()->all() as $errorMsg) {
                                    $errors[] = $errorMsg;
                                }
                            }
                        }

                        // 住所存在チェック
                        $address = $this->iViewAddressRepository->findAddress($prefCd,$siku,$tyou);
                        if (is_null($address)) {
                            $errors[] = Lang::get('error.CSV.address_not_exist',[
                                'prefCd' => $prefCd,
                                'siku' => $siku,
                                'tyou' => $tyou,
                            ]);
                        }

                        if(count($errors) == 0) {
                            // Entitiy設定
                            $entity = (new DepoAddressLeadtimeFactory())->makeDefaultLeadtimeCsv(
                                null,
                                $depoCd,
                                $zipCd,
                                null,
                                $jiscode,
                                $prefCd,
                                $siku,
                                $tyou,
                                $nextDayTimeType,
                                $isAreaTodayDeliveryFlg,
                                $nextDayTimeDeadline,
                                $todayTimeDeadline1,
                                $todayTimeDeadline2
                            );

                            // 登録処理
                            $this->iDepoAddressLeadtimeRepository->upsert($entity);
                        } else {
                            throw new Exception(implode(',',$errors));
                        }

                    } catch (Exception $lex) {
                        $errorMsg = Lang::get('error.CSV.row_error',[
                            'errorMsg' => $lex->getMessage(),
                            'baseColumns' => $baseColumns,
                            'targetColumns' => count($rows),
                            'lineNo' => $lineNo
                        ]);
                        Log::error($errorMsg . "行:" . $lineNo);
                        $errors[] = $errorMsg;
                        $this->errorCount++;
                        throw $lex;
                    }
                } else {
                    // data error
                    $errorMsg = Lang::get('error.CSV.csv_format_error',['baseColumns' => $baseColumns,'targetColumns' => count($rows)]);
                    $errors[] = $errorMsg;
                    Log::error($errorMsg . "行:" . $lineNo);
                    $this->errorCount++;
                    throw new Exception($errorMsg);
                }
            });
            if(count($parseErrors) == 0) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Exception $ex) {
            DB::rollBack();
            $errors[] = $ex->getMessage();
            Log::error($ex->getMessage());
        }

        // result entity
        $resultEntity = $this->resultEntitySet($parseErrors,$this->totalCount,$this->errorCount);

        return $resultEntity;
    }


    /**
     * デポ商品コード紐付タブ用のCSV取り込み処理
     *
     * @param string $fileName
     * @return CsvImportResultEntity
     */
    public function depoItemCsv(string $fileName): CsvImportResultEntity
    {
        $parseErrors = [];
        $this->totalCount = 0;
        $this->errorCount = 0;

        $resultEntity = new CsvImportResultEntity();

        try {
            // デポ取得
            $depoList = $this->depoListUsecase->findDepoListAll();
            // 商品一覧取得
            $itemList = $this->itemUsecase->findViewItemList();

            DB::beginTransaction();
            $parseErrors = $this->importFile($fileName, function ($rows, $lineNo) use ($depoList,$itemList) {
                // データ行
                $this->totalCount++;
                // baseカラム数
                $baseColumns = $this->getImportColumns('depo_item');

                // カラム数チェック
                if (count($rows) == $baseColumns) {
                    try {
                        $errors = [];
                        $depoCd = $rows[0];
                        $itemCd = $rows[2];
                        // validationチェック
                        $validator = Validator::make(['depoCd' => $depoCd,'itemCd' => $itemCd], [
                            'depoCd' => 'required|integer',
                            'itemCd' => 'required|string'
                        ]);
                        if ($validator->fails()) {
                            foreach($validator->errors()->all() as $errorMsg) {
                                $errors[] = $errorMsg;
                            }
                        }                        
                        // デポ存在チェック
                        $depo = $depoList->first(function ($obj, $key) use ($depoCd) {
                            return $obj->depocd == $depoCd;
                        });
                        if (is_null($depo)) {
                            $errors[] = Lang::get('error.CSV.depo_not_exist',['depoCd' => $depoCd]);
                        }

                        // 商品存在チェック
                        $item = collect($itemList)->first(function ($obj, $key) use ($itemCd) {
                            return $obj->itemCd == $itemCd;
                        });
                        if (is_null($item)) {
                            $errors[] = Lang::get('error.CSV.item_not_exist',['itemCd' => $itemCd]);
                        }

                        if(count($errors) == 0) {
                            // 登録処理
                            $entity = (new DepoItemInfoFactory())->makeUpdate(
                                $depoCd,
                                $itemCd
                            );    
                            $this->iDepoItemInfoRepository->save($entity);
                        } else {
                            throw new Exception(implode(',',$errors));
                        }
                    } catch (Exception $lex) {
                        $errorMsg = Lang::get('error.CSV.row_error',[
                            'errorMsg' => $lex->getMessage(),
                            'baseColumns' => $baseColumns,
                            'targetColumns' => count($rows),
                            'lineNo' => $lineNo
                        ]);
                        Log::error($errorMsg . "行:" . $lineNo);
                        $errors[] = $errorMsg;
                        $this->errorCount++;
                        throw $lex;
                    }
                } else {
                    // data error
                    $errorMsg = Lang::get('error.CSV.csv_format_error',['baseColumns' => $baseColumns,'targetColumns' => count($rows)]);
                    $errors[] = $errorMsg;
                    Log::error($errorMsg . "行:" . $lineNo);
                    $this->errorCount++;
                    throw new Exception($errorMsg);
                }
            });

            if(count($parseErrors) == 0) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Exception $ex) {
            DB::rollBack();
            $errors[] = $ex->getMessage();
            Log::error($ex->getMessage());
        }

        // result entity
        $resultEntity = $this->resultEntitySet($parseErrors,$this->totalCount,$this->errorCount);

        return $resultEntity;
    }

    /**
     * デポ住所コード紐付タブ用のCSV取り込み処理
     *
     * @param string $fileName
     * @return CsvImportResultEntity
     */
    public function depoAddressCsv(string $fileName): CsvImportResultEntity
    {
        $parseErrors = [];
        $this->totalCount = 0;
        $this->errorCount = 0;

        $resultEntity = new CsvImportResultEntity();

        try {
            // デポ取得
            $depoList = $this->depoListUsecase->findDepoListAll();

            DB::beginTransaction();
            $parseErrors = $this->importFile($fileName, function ($rows, $lineNo) use ($depoList) {
                // データ行
                $this->totalCount++;
                // baseカラム数
                $baseColumns = $this->getImportColumns('depo_address');

                // カラム数チェック
                if (count($rows) == $baseColumns) {
                    try {
                        $errors = [];
                        // 値取得
                        $depoCd = $rows[0];
                        $jiscode = $rows[2];
                        $zipCd = $rows[3];
                        $prefCd = $rows[4];
                        $siku = $rows[5];
                        $tyou = $rows[6];
                        // validationチェック
                        $validator = Validator::make(
                            [
                                'depoCd' => $depoCd,
                                'jiscode' => $jiscode,
                                'zipCd' => $zipCd,
                                'prefCd' => $prefCd,
                                'siku' => $siku,
                                'tyou' => $tyou
                            ],
                            [
                                'depoCd' => 'required|integer',
                                'jiscode' => 'nullable|string|max:40',
                                'zipCd' => 'nullable|string|max:8',
                                'prefCd' => 'required|integer|max:99',
                                'siku' => 'required|string|max:40',
                                'tyou' => 'required|string|max:100',
                            ]
                        );
                        if ($validator->fails()) {
                            foreach($validator->errors()->all() as $errorMsg) {
                                $errors[] = $errorMsg;
                            }
                        }                        

                        // デポ存在チェック
                        $depo = $depoList->first(function ($obj, $key) use ($depoCd) {
                            return $obj->depocd == $depoCd;
                        });
                        if (is_null($depo)) {
                            $errors[] = Lang::get('error.CSV.depo_not_exist',['depoCd' => $depoCd]);
                        }

                        // 住所存在チェック
                        $address = $this->iViewAddressRepository->findAddress($prefCd,$siku,$tyou);
                        if (is_null($address)) {
                            $errors[] = Lang::get('error.CSV.address_not_exist',[
                                'prefCd' => $prefCd,
                                'siku' => $siku,
                                'tyou' => $tyou,
                            ]);
                        }

                        if(count($errors) == 0) {
                            // 登録処理
                            $entity = (new DepoAddressLeadtimeFactory())->makeDepoAddressCsv(
                                $depoCd,
                                $jiscode,
                                $zipCd,
                                $prefCd,
                                $siku,
                                $tyou
                            );
                            $this->iDepoAddressLeadtimeRepository->addressCsvUploadSave($entity);
                        } else {
                            throw new Exception(implode(',',$errors));
                        }
                    } catch (Exception $lex) {
                        $errorMsg = Lang::get('error.CSV.row_error',[
                            'errorMsg' => $lex->getMessage(),
                            'baseColumns' => $baseColumns,
                            'targetColumns' => count($rows),
                            'lineNo' => $lineNo
                        ]);
                        Log::error($errorMsg . "行:" . $lineNo);
                        $errors[] = $errorMsg;
                        $this->errorCount++;
                        throw $lex;
                    }
                } else {
                    // data error
                    $errorMsg = Lang::get('error.CSV.csv_format_error',['baseColumns' => $baseColumns,'targetColumns' => count($rows)]);
                    $errors[] = $errorMsg;
                    Log::error($errorMsg . "行:" . $lineNo);
                    $this->errorCount++;
                    throw new Exception($errorMsg);
                }
            });
            if(count($parseErrors) == 0) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Exception $ex) {
            DB::rollBack();
            $errors[] = $ex->getMessage();
            Log::error($ex->getMessage());
        }

        // result entity
        $resultEntity = $this->resultEntitySet($parseErrors,$this->totalCount,$this->errorCount);

        return $resultEntity;
    }
}
