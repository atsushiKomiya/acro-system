<?php

namespace App\Application\Controllers\Api;

use App\Application\Requests\DefaultCalendarRegisterRequest;
use App\Application\Requests\DefaultCalendarSearchRequest;
use App\Application\Requests\DefaultCalendarUpdateBatchRequest;
use App\Application\Responses\Api\BaseApiResponse;
use App\Application\UseCases\DepoDefaultUseCase;
use App\Consts\AppConst;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * デフォルト設定（カレンダーデフォルト）API
 */
class DefaultCalendarApiController extends ApiController
{
    /**
     * カレンダーデフォルト検索
     *
     * @param DefaultCalendarSearchRequest $request
     * @param DepoDefaultUseCase $usecase
     * @return void
     */
    public function search(DefaultCalendarSearchRequest $request, DepoDefaultUseCase $usecase)
    {
        $depoCd = $request->depoCd;

        $res = new BaseApiResponse();
        try {
            // カレンダーデフォルト情報の取得
            $tabCalendarModel = $usecase->findDepoDefault($depoCd);
            // 返却
            $res->apiSuccessful();
            $res->data = $tabCalendarModel;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.calendar.search'));
        }
        return $res;
    }

    /**
     * カレンダーデフォルト情報登録
     *
     * @param DefaultCalendarRegisterRequest $request
     * @param DepoDefaultUseCase $usecase
     * @return void
     */
    public function save(DefaultCalendarRegisterRequest $request, DepoDefaultUseCase $usecase)
    {
        $res = new BaseApiResponse();
        try {
            DB::beginTransaction();
            // カレンダー情報更新
            $usecase->saveDepoDefault($request->all());
            // 返却
            $res->apiSuccessful();
            // コミット
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.calendar.save'));
        }

        return $res;
    }

    /**
     * カレンダー反映処理
     *
     * @param DefaultCalendarUpdateBatchRequest $request
     * @return void
     */
    public function reflect(DefaultCalendarUpdateBatchRequest $request)
    {
        $depoCd = $request->depoCd;
        $startDate = $request->startDate;

        $res = new BaseApiResponse();
        try {
            // C_LB_02_カレンダーデータ更新バッチ実行
            $command = 'php "' . base_path('artisan') . '" batch:reloadcalendar ' . AppConst::RELOAD_CALENDAR_MODE['UPDATE'] .' ' . $startDate .' ' . $depoCd . ' > /dev/null &';
            exec($command);
            // 返却
            $res->apiSuccessful();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L21.calendar.reflect'));
        }
        return $res;
    }
}
