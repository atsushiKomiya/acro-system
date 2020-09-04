<?php

namespace App\Application\Controllers\Web;

use App\Application\UseCases\AddressUseCase;
use App\Application\UseCases\DepoCalAprInfoUseCase;
use App\Application\UseCases\DepoUseCase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * デポ稼働日確認画面用コントローラー
 */
class CalendarConfirmController extends WebController
{

    /**
     * 初期表示
     *
     * @param Request $request
     * @param DepoUseCase $depoUsecase
     * @param AddressUseCase $addressUseCase
     * @return void
     */
    public function index(Request $request, DepoUseCase $depoUsecase, AddressUseCase $addressUseCase, DepoCalAprInfoUseCase $depoCalAprInfoUsecase)
    {
        // 検索パラメータ（初期値）
        $time = new Carbon(Carbon::now());
        $searchYm = $time->format('Ym');
        $searchPrefCd = 0;

        // 画面パラメータがある場合
        if ($request->searchYm && $request->searchDepoCd) {
            $searchYm = $request->searchYm;
            $depoCd = $request->searchDepoCd;
            // 指定デポが含まれている都道府県を取得する
            $depoInfo = $depoUsecase->findDepo($depoCd);
            if ($depoInfo) {
                $searchPrefCd = $depoInfo->depoPref;
            }
        }

        $searchParam = [
            'searchYm' => $searchYm,
            'searchPrefCd' => $searchPrefCd,
            'searchIsNotApproval' => false,
            'searchIsNotConfirm' => false,
            'searchDisplayType' => 0
        ];

        //対象年月リスト取得
        $ymList = $depoCalAprInfoUsecase->findMonthList(null);

        // 都道府県
        $prefList = $addressUseCase->findPrefList();

        // 表示グループ
        $displayTypeList = Config::get('depo.display_type');

        // 締め時間リスト
        $deadlineTimeList = Config::get('delivery.deadline_time_list');

        // 検索処理
        $calendarList = [];

        // 返却
        return view('C_L10', compact(
            'searchParam',
            'ymList',
            'prefList',
            'displayTypeList',
            'calendarList',
            'deadlineTimeList'
        ));
    }
}
