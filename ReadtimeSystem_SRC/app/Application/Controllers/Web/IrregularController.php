<?php

namespace App\Application\Controllers\Web;

use App\Application\UseCases\IrregularUseCase;
use App\Consts\AppConst;
use App\Domain\Factories\IrregularFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * 【C_L31】イレギュラー設定画面コントローラ
 */
class IrregularController extends WebController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('check.auth');
    }

    /**
     * イレギュラー設定画面表示
     *
     * @param Request $request
     * @param IrregularUseCase $irregularUseCase
     * @return void
     */
    public function index(Request $request, IrregularUseCase $irregularUseCase)
    {
        //用途選択肢取得
        $cUseList = $irregularUseCase->findCUseList();
        //時間選択選択肢取得
        $timeSelectList = Config::get('delivery.time_select_list');

        //パラメータからirregularId受け取り
        $irregularId = $request->irregularId;

        $irregular = (new IrregularFactory())->makeInitialize();;
        $irregularAreaList=[];
        $irregularItemList=[];
        $irregularDepoList=[];
        $irregularDeliveryDayofweekList=[];
        $irregularOrderDayofweekList=[];

        if ($irregularId) {
            //編集
            $isEdit = true;
        } else {
            //新規登録
            $isEdit = false;
        }

        if ($isEdit) {
            //イレギュラー情報取得
            $irregular = $irregularUseCase->findIrregular($irregularId);
            //イレギュラー地域情報取得
            $irregularAreaList = $irregularUseCase->findIrregularArea($irregularId);
            //イレギュラー商品情報取得
            $irregularItemList = $irregularUseCase->findIrregularItem($irregularId);
            //イレギュラーデポ情報取得
            $irregularDepoList = $irregularUseCase->findIrregularDepo($irregularId);
            //イレギュラー曜日情報取得
            $irregularDayofweekList = $irregularUseCase->findIrregularDayofweek($irregularId);
            $dayofweekCollect = collect($irregularDayofweekList);
            // お届け日
            $irregularDeliveryDayofweekList = $dayofweekCollect->filter(function($item){
                return $item->dateType == AppConst::DATE_TYPE['DELIVERY_DATE'];
            })->values();
            // 受注日
            $irregularOrderDayofweekList = $dayofweekCollect->filter(function($item){
                return $item->dateType == AppConst::DATE_TYPE['ORDER_DATE'];
            })->values();
        }

        // 用途初期化
        if ($irregular->cUse == null) {
            // 初期値「すべて」にする
            $irregular->cUse = '';
        }
        // 不可制御エリア 配送時間初期化
        if ($irregular->timeSelect == null) {
            // 初期値「なし」にする
            $irregular->timeSelect = '';
        }

        // 配送不可&受注制御 デポ初期化
        if ($irregular->isDepo == null) {
            // 初期値「すべて」にする
            $irregular->isDepo = false;
        }

        return view('C_L31', compact(
            'cUseList',
            'isEdit',
            'timeSelectList',
            'irregular',
            'irregularAreaList',
            'irregularItemList',
            'irregularDepoList',
            'irregularDeliveryDayofweekList',
            'irregularOrderDayofweekList',
        ));
    }

    /**
     * 複製
     *
     * @param Request $request
     * @param IrregularUseCase $irregularUseCase
     * @return void
     */
    public function remake(Request $request, IrregularUseCase $irregularUseCase)
    {
        //用途選択肢取得
        $cUseList = $irregularUseCase->findCUseList();
        //時間選択選択肢取得
        $timeSelectList = Config::get('delivery.time_select_list');

        //編集モードチェック
        $isEdit = false;

        $irregularId = $request->irregularId;
        $irregular = null;
        $irregularAreaList=[];
        $irregularItemList=[];
        $irregularDepoList=[];
        $irregularDeliveryDayofweekList=[];
        $irregularOrderDayofweekList=[];

        //イレギュラー情報取得
        $irregular = $irregularUseCase->findIrregular($irregularId);
        //イレギュラー地域情報取得
        $irregularAreaList = $irregularUseCase->findIrregularArea($irregularId);
        //イレギュラー商品情報取得
        $irregularItemList = $irregularUseCase->findIrregularItem($irregularId);
        //イレギュラーデポ情報取得
        $irregularDepoList = $irregularUseCase->findIrregularDepo($irregularId);
        //イレギュラー曜日情報取得
        $irregularDayofweekList = $irregularUseCase->findIrregularDayofweek($irregularId);
        $dayofweekCollect = collect($irregularDayofweekList);
        // お届け日
        $irregularDeliveryDayofweekList = $dayofweekCollect->filter(function($item){
            return $item->dateType == AppConst::DATE_TYPE['DELIVERY_DATE'];
        })->values();
        // 受注日
        $irregularOrderDayofweekList = $dayofweekCollect->filter(function($item){
            return $item->dateType == AppConst::DATE_TYPE['ORDER_DATE'];
        })->values();
        //複製用
        $irregular->irregularId = null;

        // 用途初期化
        if ($irregular->cUse == null) {
            // 初期値「すべて」にする
            $irregular->cUse = '';
        }
        // 不可制御エリア 配送時間初期化
        if ($irregular->timeSelect == null) {
            // 初期値「なし」にする
            $irregular->timeSelect = '';
        }

        // 配送不可&受注制御 デポ初期化
        if ($irregular->isDepo == null) {
            // 初期値「すべて」にする
            $irregular->isDepo = false;
        }

        return view('C_L31', compact(
            'cUseList',
            'isEdit',
            'timeSelectList',
            'irregular',
            'irregularAreaList',
            'irregularItemList',
            'irregularDepoList',
            'irregularDeliveryDayofweekList',
            'irregularOrderDayofweekList',
        ));
    }
}
