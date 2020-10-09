<?php

namespace App\Application\Controllers\Web;

use App\Application\UseCases\DepoListUseCase;
use App\Application\UseCases\AddressUseCase;
use App\Application\UseCases\DepoUseCase;
use Illuminate\Http\Request;

/**
 * 【C_L50/C_L51】デポ選択画面コントローラ
 */
class DepoSelectController extends WebController
{

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('check.direct.access');
        $this->middleware('check.auth');
    }

    /**
     * デポ単一選択
     *
     * @param Request $request
     * @param AddressUseCase $addressUsecase
     * @param DepoUseCase $depoUsecase
     * @param DepoListUseCase $depoListUsecase
     * @return void
     */
    public function index(Request $request, AddressUseCase $addressUsecase, DepoUseCase $depoUsecase, DepoListUseCase $depoListUsecase)
    {
        // Map化
        $prefList = $addressUsecase->findPrefList();

        // 表示グループ区分
        $displayGroupTypeList = $depoUsecase->findDisplayGroupList();

        // デポ一覧の取得
        $depoList = $depoListUsecase->findDepoListAll();

        // 単一
        $isMulti = false;

        return view('C_L50', compact(
            'prefList',
            'displayGroupTypeList',
            'depoList',
            'isMulti',
        ));
    }

    /**
     * デポ複数選択
     *
     * @param Request $request
     * @param AddressUseCase $addressUsecase
     * @param DepoUseCase $depoUsecase
     * @param DepoListUseCase $depoListUsecase
     * @return void
     */
    public function multiple(Request $request, AddressUseCase $addressUsecase, DepoUseCase $depoUsecase, DepoListUseCase $depoListUsecase)
    {
        // Map化
        $prefList = $addressUsecase->findPrefList();

        // 表示グループ区分
        $displayGroupTypeList = $depoUsecase->findDisplayGroupList();

        // デポ一覧の取得
        $depoList = $depoListUsecase->findDepoListAll();

        // 複数
        $isMulti = true;

        return view('C_L51', compact(
            'prefList',
            'displayGroupTypeList',
            'depoList',
            'isMulti',
        ));
    }
}
