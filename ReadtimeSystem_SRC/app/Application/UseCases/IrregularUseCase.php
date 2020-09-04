<?php

namespace App\Application\UseCases;

use App\Consts\AppConst;
use App\Domain\Entities\IrregularAreaEntity;
use App\Domain\Entities\IrregularDayofweekEntity;
use App\Domain\Entities\IrregularDepoEntity;
use App\Domain\Entities\IrregularEntity;
use App\Domain\Entities\IrregularItemEntity;
use App\Domain\Entities\MessageSearchEntity;
use App\Domain\Factories\IrregularMailFactory;
use App\Domain\Repositories\CUseRepositoryInterface;
use App\Domain\Repositories\IrregularAreaRepositoryInterface;
use App\Domain\Repositories\IrregularDayofweekRepositoryInterface;
use App\Domain\Repositories\IrregularDepoRepositoryInterface;
use App\Domain\Repositories\IrregularItemRepositoryInterface;
use App\Domain\Repositories\IrregularRepositoryInterface;
use App\Domain\Repositories\ViewAddressRepositoryInterface;
use App\Domain\Repositories\ViewDepoRepositoryInterface;
use App\Domain\Repositories\ViewItemRepositoryInterface;
use Exception;
use DB;
use App\Mail\IrregularMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class IrregularUseCase
{
    //用途
    private $iCUseRepository;
    //イレギュラー
    private $iIrregularRepository;
    private $iIrregularAreaRepository;
    private $iIrregularItemRepository;
    private $iIrregularDepoRepository;
    private $iIrregularDayofweekRepository;
    private $iViewDepoRepositoryInterface;
    private $iViewItemRepositoryInterface;
    private $iViewAddressRepositoryInterface;
    // usecase
    private $orderCsvExpUsecase;

    /**
     * コンストラクタ
     * @param mixed $name
     */
    public function __construct(
        CUseRepositoryInterface $iCUseRepository,
        IrregularRepositoryInterface $iIrregularRepository,
        IrregularAreaRepositoryInterface $iIrregularAreaRepository,
        IrregularItemRepositoryInterface $iIrregularItemRepository,
        IrregularDepoRepositoryInterface $iIrregularDepoRepository,
        IrregularDayofweekRepositoryInterface $iIrregularDayofweekRepository,
        ViewDepoRepositoryInterface $iViewDepoRepositoryInterface,
        ViewItemRepositoryInterface $iViewItemRepositoryInterface,
        ViewAddressRepositoryInterface $iViewAddressRepositoryInterface,
        OrderUpdateCsvExportUseCase $orderCsvExpUsecase
    ) {
        $this->iCUseRepository = $iCUseRepository;
        $this->iIrregularRepository = $iIrregularRepository;
        $this->iIrregularAreaRepository = $iIrregularAreaRepository;
        $this->iIrregularItemRepository = $iIrregularItemRepository;
        $this->iIrregularDepoRepository = $iIrregularDepoRepository;
        $this->iIrregularDayofweekRepository = $iIrregularDayofweekRepository;
        $this->iViewDepoRepositoryInterface = $iViewDepoRepositoryInterface;
        $this->iViewItemRepositoryInterface = $iViewItemRepositoryInterface;
        $this->iViewAddressRepositoryInterface = $iViewAddressRepositoryInterface;
        $this->orderCsvExpUsecase = $orderCsvExpUsecase;
    }

    /**
     * イレギュラー情報取得（編集）
     *
     * @param [type] $irregularId
     * @return IrregularEntity
     */
    public function findIrregular($irregularId): IrregularEntity
    {
        //イレギュラー取得
        $irregular = $this->iIrregularRepository->findIrregular($irregularId);

        return $irregular;
    }

    /**
     * イレギュラー地域情報取得（編集）
     */
    public function findIrregularArea($irregularId)
    {
        //イレギュラー地域取得
        $irregularAreaList = $this->iIrregularAreaRepository->findIrregularArea($irregularId);

        return $irregularAreaList;
    }

    /**
     * イレギュラー商品情報取得（編集）
     */
    public function findIrregularItem($irregularId)
    {
        //イレギュラー商品情報
        $irregularItemList = $this->iIrregularItemRepository->findIrregularItem($irregularId);

        return $irregularItemList;
    }

    /**
     * イレギュラーデポ情報取得（編集）
     */
    public function findIrregularDepo($irregularId)
    {
        //イレギュラーデポ情報
        $irregularDepoList = $this->iIrregularDepoRepository->findIrregularDepo($irregularId);

        return $irregularDepoList;
    }

    /**
     * イレギュラー曜日情報取得（編集）
     */
    public function findIrregularDayofweek($irregularId)
    {
        //イレギュラー曜日情報
        $irregularDayofweekList = $this->iIrregularDayofweekRepository->findIrregularDayofweek($irregularId);

        return $irregularDayofweekList;
    }

    /**
     * イレギュラー設定登録
     *
     * @param array $irregular
     * @param array $irregularDepoList
     * @param array $irregularAreaList
     * @param array $irregularItemList
     * @param array $irregularDeliveryDayofweekList
     * @param array $irregularOrderDayofweekList
     * @return void
     */
    public function createIrregular(object $irregular, array $irregularDepoList, array $irregularAreaList, array $irregularItemList, array $irregularDeliveryDayofweekList, array $irregularOrderDayofweekList): int
    {
        $irregularId = 0;
        try {
            DB::beginTransaction();
            // ユーザ取得
            $loginUser = Auth::user();
            $orderCsvDepoList = [];
            $orderCsvAddressList = [];
            $orderCsvItemList = [];

            $irregularEntity = new IrregularEntity();
            // 共通
            $irregularEntity->irregularId             = $irregular->irregularId;
            $irregularEntity->irregularType           = $irregular->irregularType;
            $irregularEntity->title                   = $irregular->title;
            $irregularEntity->cUse                    = $irregular->cUse;
            $irregularEntity->isValid                 = $irregular->isValid;
            $irregularEntity->deliveryDateType        = $irregular->deliveryDateType;
            $irregularEntity->deliveryDate            = $irregular->deliveryDate;
            $irregularEntity->deliveryDateFrom        = $irregular->deliveryDateFrom;
            $irregularEntity->deliveryDateTo          = $irregular->deliveryDateTo;
            $irregularEntity->isItem                  = $irregular->isItem;
            $irregularEntity->isArea                  = $irregular->isArea;
            $irregularEntity->errorMessage            = $irregular->errorMessage;
            $irregularEntity->remark                  = $irregular->remark;

            if ($irregularEntity->irregularType == AppConst::IRREGULAR_CLS_TRANSFER) {
                // 配送先振替
                $irregularEntity->orderDateType           = $irregular->orderDateType;
                $irregularEntity->orderDate               = $irregular->orderDate;
                $irregularEntity->orderDateFrom           = $irregular->orderDateFrom;
                $irregularEntity->orderDateTo             = $irregular->orderDateTo;
                $irregularEntity->transDepoCd             = $irregular->transDepoCd;
            } else {
                // 配送不可 ・ 受注制御共通
                $irregularEntity->isTodayDeadlineUndeliv  = $irregular->isTodayDeadlineUndeliv;
                $irregularEntity->isPersonalDelivery      = $irregular->isPersonalDelivery;
                $irregularEntity->isDepo                  = $irregular->isDepo;
                $irregularEntity->annoFrom                = $irregular->annoFrom;
                $irregularEntity->annoTo                  = $irregular->annoTo;
                $irregularEntity->annoAddr                = $irregular->annoAddr;
                $irregularEntity->annoPeriod              = $irregular->annoPeriod;
                $irregularEntity->annoTrans               = $irregular->annoTrans;
    
                if ($irregularEntity->irregularType == AppConst::IRREGULAR_CLS_NO) {
                    // 配送不可
                    $irregularEntity->isBeforeDeadlineUndeliv = $irregular->isBeforeDeadlineUndeliv;
                    $irregularEntity->isTimeSelectUndeliv     = $irregular->isTimeSelectUndeliv;
                } else {
                    // 受注制御
                    $irregularEntity->timeSelect              = $irregular->timeSelect;
                }
            }
            $irregularId = $this->iIrregularRepository->save($irregularEntity);

            //イレギュラー地域登録
            $areaEntityList = [];
            if ($irregularEntity->isArea) {
                foreach ($irregularAreaList as $area) {
                    // 受注CSV用
                    $orderCsvAddressList[] = [
                        'prefCd' => $area['pref'],
                        'siku' => $area['siku'],
                        'tyou' => $area['tyou']
                    ];
                    // エリア登録
                    $irregularAreaEntity = new IrregularAreaEntity();
                    $irregularAreaEntity->irregularId = $irregularId;
                    $irregularAreaEntity->addrCd = $area['addrcd'];
                    $irregularAreaEntity->zipcode = $area['zipcode'];
                    $irregularAreaEntity->prefCd = $area['pref'];
                    $irregularAreaEntity->siku = $area['siku'];
                    $irregularAreaEntity->tyou = $area['tyou'];

                    if ($area['mode'] == AppConst::LIST_ADD_MODE) {
                        if (isset($area['irregularAreaId'])) {
                            //更新
                            $irregularAreaEntity->irregularAreaId = $area['irregularAreaId'];
                            $this->iIrregularAreaRepository->save($irregularAreaEntity);
                        } else {
                            //登録
                            $this->iIrregularAreaRepository->save($irregularAreaEntity);
                        }
                        //メール
                        $areaEntity = $this->iViewAddressRepositoryInterface->findPref($area['pref']);
                        $areaEntity->siku = $area['siku'];
                        $areaEntity->tyou = $area['tyou'];
                        array_push($areaEntityList, $areaEntity);
                    } elseif ($area['mode'] == AppConst::LIST_DEL_MODE) {
                        //削除
                        $this->iIrregularAreaRepository->deleteById($area['irregularAreaId'], $loginUser->login_cd);
                    }
                }
            } else {
                // 受注CSV用
                $areaList = $this->iIrregularAreaRepository->findIrregularArea($irregularId);
                $orderCsvAddressList = collect($areaList)->map(function ($address) {
                    return [
                        'prefCd' => $address->prefCd,
                        'siku' => $address->siku,
                        'tyou' => $address->tyou
                    ];
                })->all();
                
                //削除
                $this->iIrregularAreaRepository->deleteByIrregularId($irregularId, $loginUser->login_cd);
            }
            //イレギュラーデポ登録
            $depoEntityList = [];
            if ($irregularEntity->isDepo) {
                foreach ($irregularDepoList as $depo) {
                    // 受注CSV用
                    $orderCsvDepoList[] = $depo['depocd'];
                    // デポ登録
                    $irregularDepoId = isset($depo['irregularDepoId']) ? $depo['irregularDepoId'] : null;
                    $irregularDepoEntity = new IrregularDepoEntity();
                    $irregularDepoEntity->irregularDepoId = $irregularDepoId;
                    $irregularDepoEntity->irregularId = $irregularId;
                    $irregularDepoEntity->depoCd = $depo['depocd'];

                    if ($depo['mode'] == AppConst::LIST_ADD_MODE) {
                        if ($irregularDepoId) {
                            //更新
                            $irregularDepoEntity->irregularDepoId = $irregularDepoId;
                            $this->iIrregularDepoRepository->save($irregularDepoEntity);
                        } else {
                            //登録
                            $this->iIrregularDepoRepository->save($irregularDepoEntity);
                        }
                        //メール
                        $depoEntity = $this->iViewDepoRepositoryInterface->findViewDepo($depo['depocd']);
                        array_push($depoEntityList, $depoEntity);
                    } elseif ($depo['mode'] == AppConst::LIST_DEL_MODE) {
                        //削除
                        $this->iIrregularDepoRepository->deleteById($irregularDepoId, $loginUser->login_cd);
                    }
                }
            } else {
                // 受注CSV用
                $depoList = $this->iIrregularDepoRepository->findIrregularDepo($irregularId);
                $orderCsvDepoList = collect($depoList)->map(function ($depo) {
                    return $depo->depoCd;
                })->all();
                
                //削除
                $this->iIrregularDepoRepository->deleteByIrregularId($irregularId, $loginUser->login_cd);
            }
            //イレギュラー商品登録
            $itemEntityList = [];
            if ($irregularEntity->isItem) {
                foreach ($irregularItemList as $item) {
                    // 受注CSV用
                    $orderCsvItemList[] = $item['itemCd'];
                    // 商品登録
                    $irregularItemId = isset($item['irregularItemId']) ? $item['irregularItemId'] : null;
                    $irregularItemEntity = new IrregularItemEntity();
                    $irregularItemEntity->irregularItemId = $irregularItemId;
                    $irregularItemEntity->irregularId = $irregularId;
                    $irregularItemEntity->itemCategoryLargeCd = $item['itemCategoryLargeCd'];
                    $irregularItemEntity->itemCategoryMediumCd = $item['itemCategoryMediumCd'];
                    $irregularItemEntity->itemCd = $item['itemCd'];

                    if ($item['mode'] == AppConst::LIST_ADD_MODE) {
                        if ($irregularItemId) {
                            //更新
                            $irregularItemEntity->irregularItemId = $irregularItemId;
                            $this->iIrregularItemRepository->save($irregularItemEntity);
                        } else {
                            //登録
                            $this->iIrregularItemRepository->save($irregularItemEntity);
                        }
                        //メール
                        $itemEntity = $this->iViewItemRepositoryInterface->findViewItem($item['itemCd']);
                        array_push($itemEntityList, $itemEntity);
                    } elseif ($depo['mode'] == AppConst::LIST_DEL_MODE) {
                        //削除
                        $this->iIrregularItemRepository->deleteById($irregularItemId, $loginUser->login_cd);
                    }
                }
            } else {
                // 受注CSV用
                $itemList = $this->iIrregularItemRepository->findIrregularItem($irregularId);
                $orderCsvItemList = collect($itemList)->map(function ($item) {
                    return $item->itemCd;
                })->all();
                
                //削除
                $this->iIrregularItemRepository->deleteByIrregularId($irregularId, $loginUser->login_cd);
            }
            //イレギュラー曜日削除〜登録
            $irregularDayofweekEntityList = [];
            // お届け
            if ($irregularEntity->deliveryDateType == AppConst::DELIVERY_DATE_TYPE['WEEK']) {
                foreach ($irregularDeliveryDayofweekList as $week) {
                    $irregularDayofweekEntity = new IrregularDayofweekEntity();
                    $irregularDayofweekEntity->irregularId = $irregularId;
                    $irregularDayofweekEntity->dateType = $week['dateType'];
                    $irregularDayofweekEntity->dayofweek = $week['dayofweek'];
                    $irregularDayofweekEntity->publicHolidayStatus = $week['publicHolidayStatus'];

                    $this->iIrregularDayofweekRepository->save($irregularDayofweekEntity);
                    array_push($irregularDayofweekEntityList, $irregularDayofweekEntity);
                }
            } else {
                $this->iIrregularDayofweekRepository->forceDeleteByIrregularId($irregularId, AppConst::DATE_TYPE['DELIVERY_DATE']);
            }

            // 受注日
            if ($irregularEntity->orderDateType == AppConst::ORDER_DATE_TYPE['WEEK']) {
                foreach ($irregularOrderDayofweekList as $week) {
                    $irregularDayofweekEntity = new IrregularDayofweekEntity();
                    $irregularDayofweekEntity->irregularId = $irregularId;
                    $irregularDayofweekEntity->dateType = $week['dateType'];
                    $irregularDayofweekEntity->dayofweek = $week['dayofweek'];
                    $irregularDayofweekEntity->publicHolidayStatus = $week['publicHolidayStatus'];

                    $this->iIrregularDayofweekRepository->save($irregularDayofweekEntity);
                    array_push($irregularDayofweekEntityList, $irregularDayofweekEntity);
                }
            } else {
                $this->iIrregularDayofweekRepository->forceDeleteByIrregularId($irregularId, AppConst::DATE_TYPE['ORDER_DATE']);
            }
                
            // C_LI_03_受注データ更新用CSV出力
            $this->orderCsvExpUsecase->chgDepoInfoCsv($orderCsvDepoList, $orderCsvAddressList, $orderCsvItemList, null, null);

            //commit
            DB::commit();

            //メール送信
            $irregularMailEntity = (new IrregularMailFactory)->mackMailEntity(
                $irregularEntity,
                $depoEntityList,
                $itemEntityList,
                $areaEntityList,
                $irregularDayofweekEntityList,
                $irregularEntity->transDepoCd
            );

            if ($irregularEntity->irregularId) {
                $res = Mail::send(new IrregularMail(null, $irregularMailEntity));
            } else {
                $res = Mail::send(new IrregularMail(IrregularMail::MODE_NEW, $irregularMailEntity));
            }
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return $irregularId;
    }
   
    /**
     * イレギュラー削除
     *
     * @param [type] $irregularId
     * @return void
     */
    public function deleteIrregular(int $irregularId)
    {
        try {
            DB::beginTransaction();
            // ログイン情報
            $loginUser = Auth::user();
            // イレギュラー
            $this->iIrregularRepository->deleteByIrregularId($irregularId, $loginUser->login_cd);
            // イレギュラーエリア
            $this->iIrregularAreaRepository->deleteByIrregularId($irregularId, $loginUser->login_cd);
            // イレギュラーデポ
            $this->iIrregularDepoRepository->deleteByIrregularId($irregularId, $loginUser->login_cd);
            // イレギュラー商品
            $this->iIrregularItemRepository->deleteByIrregularId($irregularId, $loginUser->login_cd);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /**
     * 用途選択肢取得
     */
    public function findCUseList():array
    {
        $cUseList = $this->iCUseRepository->findCUseList();

        return $cUseList;
    }

    /**
     * イレギュラーメッセージ一一覧取得
     *
     * @param MessageSearchEntity $entity
     * @return void
     */
    public function findAnnoMessageList(MessageSearchEntity $entity)
    {
        $resultList = $this->iIrregularRepository->findAnnoMessageList($entity);

        return $resultList;
    }
}
