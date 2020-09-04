<?php
namespace App\Application\Controllers\Web;

use App\Application\UseCases\DepoCalInfoUseCase;
use App\Application\UseCases\DepoCalAprInfoUseCase;
use App\Application\UseCases\DepoCalInfoTmpUseCase;
use App\Application\UseCases\DepoListUseCase;
use App\Application\UseCases\DepoUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Consts\AppConst;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;

/**
 * 【C_L11】デポ休業等申請画面コントローラ
 */
class DepoRequestController extends WebController
{
    /**
     * 初期表示
     *
     * @param Request $request
     * @param DepoCalInfoUseCase $depoCalInfoUsecase
     * @param DepoUseCase $depoUsecase
     * @param DepoListUseCase $depoListUsecase
     * @return void
     */
    public function index(Request $request, DepoCalInfoUseCase $depoCalInfoUsecase, DepoUseCase $depoUsecase, DepoListUseCase $depoListUsecase)
    {
        // 削除 (指定の値を個別に)
        $request->session()->forget('C_L11_list_param');
        return redirect()->route('C_L11.search');
    }


    /**
     * 検索
     * @param Request $request
     * @param DepoCalInfoUseCase $depoCalInfoUsecase
     * @param DepoCalAprInfoUseCase $depoCalAprInfoUsecase
     * @param DepoCalInfoTmpUseCase $depoCalInfoTmpUsecase
     * @param DepoUseCase $depoUsecase
     * @param DepoListUseCase $depoListUsecase
     * @return void
     */
    public function search(
        Request $request,
        DepoCalInfoUseCase $depoCalInfoUsecase,
        DepoCalAprInfoUsecase $depoCalAprInfoUsecase,
        DepoCalInfoTmpUseCase $depoCalInfoTmpUsecase,
        DepoUseCase $depoUsecase,
        DepoListUseCase $depoListUsecase
    ) {
        $searchParam = null;
        $searchDepocd = null;
        $searchYm = null;
        $searchDeponame = null;
        // 検索対象デポ情報
        $depoInfo = null;
        // 承認状態
        $approvalStatus = null;
        // 確認状態
        $confirmStatus = null;
        // 表示日付文字列
        $displayDateStr = null;
        // デポ休業等申請情報モデル
        $displayDepoCalInfoModel = null;
        // エラーメッセージ
        $errorMsgList = array();
        // 一覧へリスト表示
        $listBackUrl = null;

        // 遷移元とパラメータの確認
        $referrerUrl = $request->headers->get('referer');
        if (strpos($referrerUrl, url('C_L10')) !== false) {
            // 一覧からの遷移の場合は
            $searchYm = $request->searchYm;
            $searchDepocd = $request->searchDepocd;
            $sessionParam = [
                'searchYm' => $searchYm,
                'searchDepoCd' => $searchDepocd,
            ];
            session()->put(['C_L11_list_param' => $sessionParam]);
        }
        // 一覧へのURL作成
        if ($request->session()->has('C_L11_list_param')) {
            $params = $request->session()->get('C_L11_list_param', array());
            $listBackUrl = url('C_L10') . '?searchYm=' . $params['searchYm'] . '&searchDepoCd=' . $params['searchDepoCd'];
        }

        // SESSIONからユーザー情報取得
        $authInfo = $request->session()->get('auth_info');

        // 検索対象のデポコードを判定
        if ($authInfo->AUTH_CLS == AppConst::AUTH_CLS['shain']) {
            // 社員の場合はパラメータ
            $searchDepocd = $request->searchDepocd;
        } else {
            // ログイン時のデポコード
            $searchDepocd = $authInfo->DEPO_CD;
        }

        // 対象年月の取得
        if ($request->searchYm) {
            $searchYm = $request->searchYm;
        } else {
            $searchYm = Carbon::now()->format('Ym');
        }

        // デポ区分取得
        if (!is_null($searchDepocd)) {
            $depoInfo = $depoUsecase->findDepo($searchDepocd);
            $searchDeponame = $depoInfo->deponame;
        }

        // 検索パラメータ
        $searchParam = [
            'searchDepocd' => $searchDepocd,
            'searchYm' => $searchYm,
            'searchDeponame' => $searchDeponame,
        ];

        //対象年月リスト取得
        $monthList = $depoCalAprInfoUsecase->findMonthList($searchDepocd);

        //配送時間リスト取得
        $deliveryDeadlineList = collect(Config::get('delivery.deadline_time_list'));

        // カレンダー情報取得
        if (!is_null($searchDepocd) && !is_null($searchYm)) {
            // デポ休業等申請情報取得
            $displayDepoCalInfoModel = $depoCalAprInfoUsecase->findChangeRequestCalendar($searchDepocd, $searchYm);

            if (is_null($displayDepoCalInfoModel)) {
                // 取得できなかった場合のメッセージ
                $errorMsgList[] = Lang::get('error.C_L11.search');
            } else {
                // 承認状態
                if (empty($displayDepoCalInfoModel->approvalDate)) {
                    $approvalStatus = AppConst::APPLYING;
                } else {
                    $approvalStatus = AppConst::APPROVED;
                }
                // 確認状態
                if ($displayDepoCalInfoModel->confirmFlg === false) {
                    $confirmStatus = AppConst::UNCONFIRMED;
                } else {
                    $confirmStatus = AppConst::CONFIRMED;
                }
                // 表示日付
                if ($depoInfo->displayType == AppConst::DEPO_DISPLAY_CLS_NOMAL || $depoInfo->displayType == AppConst::DEPO_DISPLAY_CLS_SURP) {
                    $displayDateStr = AppConst::NOTIFICATION_DATE;
                } else {
                    $displayDateStr = AppConst::SHIP_DATE;
                }
            }
        }

        return view('C_L11', compact(
            'authInfo',
            'monthList',
            'deliveryDeadlineList',
            'searchParam',
            'depoInfo',
            'displayDepoCalInfoModel',
            'approvalStatus',
            'confirmStatus',
            'displayDateStr',
            'errorMsgList',
            'listBackUrl',
        ));
    }
}
