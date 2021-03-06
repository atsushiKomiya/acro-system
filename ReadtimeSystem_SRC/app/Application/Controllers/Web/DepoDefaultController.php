<?php

namespace App\Application\Controllers\Web;

use App\Application\UseCases\DepoDefaultUseCase;
use App\Application\UseCases\DepoDefaultListUseCase;
use App\Application\UseCases\DepoUseCase;
use App\Application\UseCases\AddressUseCase;
use App\Application\UseCases\ItemCategoryLargeUseCase;
use App\Application\UseCases\ItemCategoryMediumUseCase;
use App\Application\UseCases\ItemUseCase;
use App\Consts\AppConst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Exception;

/**
 * 【C_L21】デフォルト設定画面コントローラ
 */
class DepoDefaultController extends WebController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('check.auth');
    }

    /**
     * 初期表示
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        // SESSION削除
        session()->forget(Config::get('session.C_L21_search'));

        return redirect()->route('C_L21.search');
    }

    /**
     * 検索
     *
     * @param Request $request
     * @return void
     */
    public function search(
        Request $request,
        DepoUseCase $depoUsecase,
        DepoDefaultUseCase $colDefaUsecase,
        AddressUseCase $addressUseCase
    ) {
        $searchParam = null;
        $searchDepocd = null;
        $searchDeponame = null;
        $searchDisplayType = null;
        $depoInfo = null;
        // エラーメッセージ
        $errorMsgList = array();
        if ($request->searchDepocd) {
            $searchDepocd = $request->searchDepocd;
            session()->put([Config::get('session.C_L21_search') => $searchDepocd]);
        } elseif (session()->has(Config::get('session.C_L21_search'))) {
            $searchDepocd = session()->get(Config::get('session.C_L21_search'));
        }

        if (!is_null($searchDepocd)) {
            // デポ検索
            try {
                $depoInfo = $depoUsecase->findDepo($searchDepocd);
                $searchDepocd = $depoInfo->depocd;
                $searchDeponame = $depoInfo->deponame;
                $searchDisplayType = $depoInfo->displayType;
            } catch (Exception $e) {
                // 取得できなかった場合のメッセージ
                $errorMsgList[] = Lang::get('error.C_L21.calendar.search');
            }
        }

        // 検索パラメータ
        $searchParam = [
            'searchDepocd' => $searchDepocd,
            'searchDeponame' => $searchDeponame,
            'searchDisplayType' => $searchDisplayType,
        ];

        // 慶長区分可否リスト
        $keichoTypeList = collect(Config::get('delivery.keicho_type'))
        ->map(function ($value, $key) {
            return ['type' => $key,'name' => $value];
        })->values();

        // 翌日時間指定リスト
        $timeSelectList = Config::get('delivery.time_select_list');

        // 締め時間リスト
        $deadlineTimeList = Config::get('delivery.deadline_time_list');

        //都道府県
        $prefList = $addressUseCase->findPrefList();

        return view('C_L21', compact(
            'searchParam',
            'depoInfo',
            'prefList',
            'keichoTypeList',
            'timeSelectList',
            'deadlineTimeList',
            'errorMsgList'
        ));
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return void
     */
    public function list(
        Request $request,
        DepoUseCase $depoUsecase,
        DepoDefaultUseCase $colDefaUsecase,
        DepoDefaultListUseCase $depoDefaultListUseCase,
        ItemCategoryLargeUseCase $itemCategoryLargeUseCase,
        ItemCategoryMediumUseCase $itemCategoryMediumUseCase,
        ItemUseCase $itemUseCase,
        AddressUseCase $addressUseCase
    )
    {
        $searchParam = null;
        $defaultList = [];
        //都道府県
        $prefList = $addressUseCase->findPrefList();

        // 慶長区分可否リスト
        $keichoTypeList = collect(Config::get('delivery.keicho_type'))
        ->map(function ($value, $key) {
            return ['type' => $key,'name' => $value];
        })->values();

        // 時間指定リスト
        $timeSelectList = collect(Config::get('delivery.time_select_list'));

        // 締め時間リスト
        $deadlineTimeList = Config::get('delivery.deadline_time_list');

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
        $searchParam = [
            'searchDepocd' => $searchDepocd,
        ];
        // デポ区分取得
        if (!is_null($searchDepocd)) {
            $depoInfo = $depoUsecase->findDepo($searchDepocd);
            $searchDeponame = $depoInfo->deponame;
            $searchParam['searchDeponame'] = $searchDeponame;
        }

        return view('C_L20', compact(
            'prefList',
            'searchParam',
            'defaultList',
            'keichoTypeList',
            'timeSelectList',
            'deadlineTimeList'
        ));
    }
}
