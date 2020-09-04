<?php

namespace App\Application\Controllers\Web;

use App\Application\UseCases\AddressUseCase;
use App\Application\UseCases\IrregularListUseCase;
use App\Application\UseCases\IrregularUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * 【C_L30】イレギュラー一覧画面コントローラ
 */
class IrregularListController extends WebController
{
    /**
     * 初期表示
     *
     * @param Request $request
     * @param AddressUseCase $addressUseCase
     * @param IrregularListUseCase $irregularListUseCase
     * @return void
     */
    public function index(
        Request $request,
        AddressUseCase $addressUseCase,
        IrregularListUseCase $irregularListUseCase,
        IrregularUseCase $irregularUseCase
    ) {
        // イレギュラー設定区分
        $irregularConfigClassificationList = Config::get('delivery.irregular_config_classification_list');
        //　用途選択肢取得
        $cUseList = $irregularUseCase->findCUseList();
        // 有効区分
        $validList = Config::get('delivery.valid_classification_list');
        // 配送時間
        $deliveryDateList = Config::get('delivery.time_select_list');
        // イレギュラー一覧
        $irregularList = [];

        return view('C_L30', compact(
            'irregularConfigClassificationList',
            'cUseList',
            'validList',
            'deliveryDateList',
            'irregularList',
        ));
    }

}
