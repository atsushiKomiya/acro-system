<?php

namespace App\Application\Controllers\Api;

use App\Application\Requests\DefaultLeadtimeRegisterRequest;
use App\Application\Requests\DefaultLeadtimeSearchRequest;
use App\Application\Responses\Api\BaseApiResponse;
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
 * デフォルト設定（リードタイム）API
 */
class DefaultLeadtimeApiController extends ApiController
{

    /**
     * リードタイム情報一覧CSVダウンロード
     *
     * @param DefaultLeadtimeSearchRequest $request
     * @param DefaultCsvDownloadUseCase $csvUsecase
     * @return void
     */
    public function download(DefaultLeadtimeSearchRequest $request, DefaultCsvDownloadUseCase $csvUsecase)
    {
        $fileName = Config::get('csvexp.file_name.lead_time');

        // ヘッダ指定
        $headers = $csvUsecase->makeHeaderWithFilename(AppUtility::createFileName($fileName));

        // CSV作成
        $callback = function () use ($request, $csvUsecase) {
            $depoCd = $request->depoCd;

            // CSV作成
            $csvUsecase->leadtimeCsv($depoCd);
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
            $csvImportEntity = $usecase->leadtimeCsv($fileName);

            if($csvImportEntity->isSuccess) {
                // 成功
                $res->apiSuccessful($csvImportEntity->totalRowCount . '件の取込を行いました。');
            } else {
                // 失敗
                $res->apiFailed(200,implode('<br>',$csvImportEntity->errorList));
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.leadtime.upload'));
        }

        return $res;
    }

    /**
     * リードタイム情報検索
     *
     * @param DefaultLeadtimeSearchRequest $request
     * @param LeadtimeUseCase $leadtimeUsecase
     * @return void
     */
    public function search(DefaultLeadtimeSearchRequest $request, LeadtimeUseCase $leadtimeUsecase)
    {
        // パラメータ取得
        $prefCd = $request->prefCd;
        $depoCd = $request->depoCd;

        $res = new BaseApiResponse();
        try {
            // リードタイム情報取得
            $list = $leadtimeUsecase->findLeadtimeAddressList($depoCd, $prefCd);
            // 返却
            $res->apiSuccessful();
            $res->data = $list;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.leadtime.search'));
        }

        return $res;
    }

    /**
     * リードタイム情報更新処理
     *
     * @param DefaultLeadtimeRegisterRequest $request
     * @return void
     */
    public function save(DefaultLeadtimeRegisterRequest $request, LeadtimeUseCase $usecase, OrderUpdateCsvExportUseCase $orderCsvExpUsecase)
    {
        $depoCd = $request->depoCd;
        $leadtimeList = $request->leadtimeList;

        $res = new BaseApiResponse();
        try {
            DB::beginTransaction();
            // 登録処理
            $resultEntity = $usecase->save($leadtimeList);
            $res = BaseApiResponse::byResultEntity($resultEntity);

            // C_LI_03_受注データ更新用CSV出力
            $depoCdList = [$depoCd ];
            $addressList = collect($leadtimeList)->map(function ($leadtime) {
                return[
                    'prefCd' => $leadtime['prefCd'],
                    'siku' => $leadtime['siku'],
                    'tyou' => $leadtime['tyou']
                ];
            })->all();
            $orderCsvExpUsecase->chgDepoInfoCsv($depoCdList, $addressList, null, null, null);
            
            // コミット
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.leadtime.save'));
        }

        return $res;
    }
}
