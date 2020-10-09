<?php

namespace App\Application\Controllers\Api;

use App\Application\Requests\DefaultDepoItemRegisterRequest;
use App\Application\Requests\DefaultDepoItemSearchRequest;
use App\Application\Responses\Api\BaseApiResponse;
use App\Application\UseCases\DefaultCsvDownloadUseCase;
use App\Application\UseCases\DefaultCsvImportUseCase;
use App\Application\UseCases\DepoItemUseCase;
use App\Application\UseCases\OrderUpdateCsvExportUseCase;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * デフォルト設定（デポ商品コード紐付）API
 */
class DefaultDepoItemApiController extends ApiController
{

    /**
     * CSVダウンロード
     *
     * @param DefaultDepoItemSearchRequest $request
     * @param DefaultCsvDownloadUseCase $csvUsecase
     * @return void
     */
    public function download(DefaultDepoItemSearchRequest $request, DefaultCsvDownloadUseCase $csvUsecase)
    {
        $fileName = Config::get('csvexp.file_name.depo_item');

        // ヘッダ指定
        $headers = $csvUsecase->makeHeaderWithFilename($fileName);

        // CSV作成
        $callback = function () use ($request, $csvUsecase) {
            $depoCd = $request->depoCd;

            // CSV作成
            $csvUsecase->depoItemCsv($depoCd);
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
            $csvImportEntity = $usecase->depoItemCsv($fileName);

            if($csvImportEntity->isSuccess) {
                // 成功
                $res->apiSuccessful($csvImportEntity->totalRowCount . '件の取込を行いました。');
            } else {
                // 失敗
                $res->apiFailed(200,implode('<br>',$csvImportEntity->errorList));
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.item.upload'));
        }

        return $res;
    }
    
    /**
     * デポ商品取扱情報更新処理
     *
     * @param DefaultDepoItemRegisterRequest $request
     * @param DepoItemUseCase $usecase
     * @param OrderUpdateCsvExportUseCase $orderCsvExpUsecase
     * @return void
     */
    public function save(DefaultDepoItemRegisterRequest $request, DepoItemUseCase $usecase, OrderUpdateCsvExportUseCase $orderCsvExpUsecase)
    {
        $depoCd = $request->depoCd;
        $depoItemList = $request->depoItemList;

        $res = new BaseApiResponse();
        try {
            DB::beginTransaction();
            // 登録処理
            $resultEntity = $usecase->upsert($depoCd, $depoItemList);
            $res = BaseApiResponse::byResultEntity($resultEntity);

            // C_LI_03_受注データ更新用CSV出力
            $depoCdList = [$depoCd];
            $itemList = collect($depoItemList)->map(function ($item) {
                return array(
                        'itemCategoryLargeCd' => $item['itemCategoryLargeCd'],
                        'itemCategoryMediumCd' => $item['itemCategoryMediumCd'],
                        'itemCd' => $item['itemCd']);
            })->all();
            $orderCsvExpUsecase->chgDepoInfoCsv($depoCdList, null, $itemList, null, null, null);

            // コミット
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.item.save'));
        }

        return $res;
    }


    /**
     * デポ商品紐付け一覧を取得する
     *
     * @param DefaultDepoItemSearchRequest $request
     * @param DepoItemUseCase $depoItemUseCase
     * @return void
     */
    public function depoItemList(DefaultDepoItemSearchRequest $request, DepoItemUseCase $depoItemUseCase)
    {
        // 取得処理
        $depoCd = $request->depoCd;
        $res = new BaseApiResponse();
        try {
            // デポ商品コード紐付情報取得
            $list = $depoItemUseCase->findDepoItemInfoList($depoCd);
            // 返却処理
            $res->apiSuccessful();
            $res->data = $list;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.item.search'));
        }

        return $res;
    }
}
