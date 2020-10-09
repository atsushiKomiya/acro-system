<?php

namespace App\Application\Controllers\Api;

use App\Application\Requests\DefaultAddressSearchRequest;
use App\Application\Requests\DefaultDepoAddressRegisterRequest;
use App\Application\Requests\DefaultDepoAddressSearchRequest;
use App\Application\Responses\Api\BaseApiResponse;
use App\Application\UseCases\AddressUseCase;
use App\Application\UseCases\DefaultCsvDownloadUseCase;
use App\Application\UseCases\DefaultCsvImportUseCase;
use App\Application\UseCases\LeadtimeUseCase;
use App\Application\UseCases\OrderUpdateCsvExportUseCase;
use App\Application\Utilities\AppUtility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * デフォルト設定（デポ住所コード紐付情報）API
 */
class DefaultDepoAddressApiController extends ApiController
{

    /**
     * 住所一覧を取得する
     *
     * @param DefaultAddressSearchRequest $request
     * @param AddressUseCase $usecase
     * @return void
     */
    public function addressList(DefaultAddressSearchRequest $request, AddressUseCase $usecase)
    {
        $prefCd = $request->prefCd;

        $res = new BaseApiResponse();
        try {
            // 住所リスト取得
            $list = $usecase->findPrefAddressList($prefCd);
            // 返却処理
            $res->apiSuccessful();
            $res->data = $list;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.address.master_search'));
        }


        return $res;
    }

    /**
     * デポ住所紐付け一覧を取得する
     *
     * @param DefaultDepoAddressSearchRequest $request
     * @param LeadtimeUseCase $usecase
     * @return void
     */
    public function depoAddressList(DefaultDepoAddressSearchRequest $request, LeadtimeUseCase $usecase)
    {
        // 取得処理
        $prefCd = $request->prefCd;
        $depoCd = $request->depoCd;

        $res = new BaseApiResponse();
        try {
            // デポ商品コード紐付情報取得
            $list = $usecase->findDepoAddressListCursor($depoCd, $prefCd);
            // 返却処理
            $res->apiSuccessful();
            $res->data = $list;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.address.search'));
        }

        return $res;
    }

    /**
     * CSVダウンロード
     *
     * @param DefaultDepoAddressSearchRequest $request
     * @param DefaultCsvDownloadUseCase $csvUsecase
     * @return void
     */
    public function download(DefaultDepoAddressSearchRequest $request, DefaultCsvDownloadUseCase $csvUsecase)
    {
        $fileName = Config::get('csvexp.file_name.depo_address');

        // ヘッダ指定
        $headers = $csvUsecase->makeHeaderWithFilename(AppUtility::createFileName($fileName));

        // CSV作成
        $callback = function () use ($request, $csvUsecase) {
            $depoCd = $request->depoCd;
            $prefCd = $request->prefCd;

            // CSV作成
            $csvUsecase->depoAddressCsv($depoCd, $prefCd);
        };
        // ダウンロード処理
        return response()->stream($callback, 200, $headers);
    }

    /**
     * CSVアップロード
     *
     * @param Request $request
     * @return void
     */
    public function upload(Request $request, DefaultCsvImportUseCase $usecase)
    {
        $res = new BaseApiResponse();
        try {
            // ファイルアップロード
            $fileName = $this->tempFileupload('uploadFile');

            // アップロード処理
            $csvImportEntity = $usecase->depoAddressCsv($fileName);

            if($csvImportEntity->isSuccess) {
                // 成功
                $res->apiSuccessful($csvImportEntity->totalRowCount . '件の取込を行いました。');
            } else {
                // 失敗
                $res->apiFailed(200,implode('<br>',$csvImportEntity->errorList));
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.address.upload'));
        }

        return $res;
    }

    /**
     * デポ住所コード紐付情報更新処理
     *
     * @param DefaultDepoAddressRegisterRequest $request
     * @param LeadtimeUseCase $usecase
     * @param OrderUpdateCsvExportUseCase $orderCsvExpUsecase
     * @return void
     */
    public function save(DefaultDepoAddressRegisterRequest $request, LeadtimeUseCase $usecase, OrderUpdateCsvExportUseCase $orderCsvExpUsecase)
    {
        // 登録処理
        $depoCd = $request->depoCd;
        $depoAddressList = $request->depoAddressList;

        $res = new BaseApiResponse();
        try {
            DB::beginTransaction();
            // 登録処理
            $resultEntity = $usecase->saveDepoAddressForLeadtime($depoCd, $depoAddressList);
            $res = BaseApiResponse::byResultEntity($resultEntity);
    
            // C_LI_03_受注データ更新用CSV出力
            $depoCdList = [$depoCd ];
            $addressList = collect($depoAddressList)->map(function ($address) {
                return[
                    'prefCd' => $address['prefCd'],
                    'siku' => $address['siku'],
                    'tyou' => $address['tyou']
                ];
            })->all();
            $orderCsvExpUsecase->chgDepoInfoCsv($depoCdList, $addressList, null, null, null, null);

            // コミット
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.address.save'));
        }

        return $res;
    }
}
