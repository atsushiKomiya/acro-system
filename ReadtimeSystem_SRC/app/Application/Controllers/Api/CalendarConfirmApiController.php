<?php

namespace App\Application\Controllers\Api;

use App\Application\Requests\CalendarConfirmApprovalRequest;
use App\Application\Requests\CalendarConfirmSearchRequest;
use App\Application\Responses\Api\BaseApiResponse;
use App\Application\UseCases\CalendarCsvDownloadUseCase;
use App\Application\UseCases\DepoCalAprInfoUseCase;
use App\Application\UseCases\OrderUpdateCsvExportUseCase;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * デポ稼働日確認画面用APIコントローラー
 */
class CalendarConfirmApiController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        // 全県対応（12万件以上を一時的に扱う可能性があるため）
        ini_set('memory_limit', '1024M');
    }

    /**
     * 検索
     *
     * @param Request $request
     * @return void
     */
    public function search(CalendarConfirmSearchRequest $request, DepoCalAprInfoUseCase $depoCalAprInfoUseCase)
    {
        $res = new BaseApiResponse();
        try {
            // 検索処理
            $calendarList = $depoCalAprInfoUseCase->findDepoCalendarList(
                $request->searchYm,
                $request->searchPrefCd,
                $request->searchIsNotApproval,
                $request->searchIsNotConfirm,
                $request->searchDisplayType
            );
            // 返却処理
            $res->apiSuccessful();
            $res->data = $calendarList;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L10.search'));
        }

        // 返却
        return $res;
    }
    
    /**
     * デポ稼働日確認リスト件数取得
     * @param Request $request
     * @return void
     */
    public function count(CalendarConfirmSearchRequest $request, DepoCalAprInfoUseCase $depoCalAprInfoUseCase)
    {
        $res = new BaseApiResponse();
        try {
            // 検索処理
            $calendarList = $depoCalAprInfoUseCase->countDepoCalendarList(
                $request->searchYm,
                $request->searchPrefCd,
                $request->searchIsNotApproval,
                $request->searchIsNotConfirm,
                $request->searchDisplayType
            );
            // 返却処理
            $res->apiSuccessful();
            $res->data = $calendarList;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L10.search'));
        }

        // 返却
        return $res;
    }
    
    /**
     * CSVダウンロード
     *
     * @param Request $request
     * @return void
     */
    public function download(Request $request, CalendarCsvDownloadUseCase $csvUsecase)
    {
        $fileName = Config::get('csvexp.file_name.calendar');

        // ヘッダ指定
        $headers = $csvUsecase->makeHeaderWithFilename($fileName . '_' . $request->searchYm . '.csv');

        // CSV作成
        $callback = function () use ($request, $csvUsecase) {
            $targetYm = $request->searchYm ?? null;
            $prefCd = $request->searchPrefCd;
            $isNotApproval = $request->searchIsNotApproval ?? false;
            $isNotConfirm = $request->searchIsNotConfirm ?? false;
            $displayType = $request->searchDisplayType ?? 0;

            // CSV作成
            $csvUsecase->calendarCsv($targetYm, $prefCd, $isNotApproval, $isNotConfirm, $displayType);
        };
        // ダウンロード処理
        return response()->stream($callback, 200, $headers);
    }

    /**
     * 承認処理
     *
     * @param CalendarConfirmApprovalRequest $request
     * @param DepoCalAprInfoUseCase $usecase
     * @param OrderUpdateCsvExportUseCase $orderCsvExpUsecase
     * @return void
     */
    public function approval(CalendarConfirmApprovalRequest $request, DepoCalAprInfoUseCase $usecase, OrderUpdateCsvExportUseCase $orderCsvExpUsecase)
    {
        // 登録処理
        $targetYm = $request->searchYm;
        $depoCd = $request->depoCd;

        $res = new BaseApiResponse();
        try {
            DB::beginTransaction();
            // 認証情報取得
            $user = Auth::user();
            // 承認処理
            $resultEntity = $usecase->approval($targetYm, $depoCd, $user->login_cd);
            $res = BaseApiResponse::byResultEntity($resultEntity);

            // C_LI_03_受注データ更新用CSV出力
            $depoCdList = [$depoCd];
            $carbon = Carbon::createFromFormat('Ym', $targetYm);
            $from = $carbon->firstOfMonth()->format('Ymd');
            $to = $carbon->endOfMonth()->format('Ymd');

            $orderCsvExpUsecase->chgDepoInfoCsv($depoCdList, null, null, $from, $to, null);

            // コミット
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            $res = new BaseApiResponse();
            $res->apiServerError(500, Lang::get('error.C_L10.approval'));
        }


        return $res;
    }
}
