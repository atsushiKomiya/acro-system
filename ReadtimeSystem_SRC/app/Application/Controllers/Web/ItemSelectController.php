<?php

namespace App\Application\Controllers\Web;

use App\Application\UseCases\ItemCategoryLargeUseCase;
use App\Application\UseCases\ItemCategoryMediumUseCase;
use App\Application\UseCases\ItemCategoryRelationUseCase;
use App\Application\UseCases\ItemUseCase;
use Illuminate\Http\Request;

/**
 * 【C_L52/C_L53】商品選択画面コントローラ
 */
class ItemSelectController extends WebController
{

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('check.direct.access');
    }

    /**
     * 単一選択初期表示
     *
     * @param Request $request
     * @param ItemCategoryLargeUseCase $itemCategoryLargeUseCase
     * @param ItemCategoryMediumUseCase $itemCategoryMediumUseCase
     * @param ItemUseCase $itemUseCase
     * @param ItemCategoryRelationUseCase $itemCategoryRelationUseCase
     * @return void
     */
    public function index(Request $request, ItemCategoryLargeUseCase $itemCategoryLargeUseCase, ItemCategoryMediumUseCase $itemCategoryMediumUseCase, ItemUseCase $itemUseCase, ItemCategoryRelationUseCase $itemCategoryRelationUseCase)
    {
        //商品カテゴリ大
        $itemCategoryLargeList = $itemCategoryLargeUseCase->findItemCategoryLargeList();

        //商品カテゴリ中
        $itemCategoryMediumList = $itemCategoryMediumUseCase->findItemCategoryMediumList();

        //商品
        $viewItemList = $itemUseCase->findViewItemList();

        //パラメータ区分
        //$isList = ((bool)$request->get('isList'));
        $isList = false;
        if ($request->isList=='true') {
            $isList = true;
        }

        return view('C_L52', compact(
            'itemCategoryLargeList',
            'itemCategoryMediumList',
            'viewItemList',
            'isList'
        ));
    }

    /**
     * 複数選択初期表示
     *
     * @param Request $request
     * @param ItemCategoryLargeUseCase $itemCategoryLargeUseCase
     * @param ItemCategoryMediumUseCase $itemCategoryMediumUseCase
     * @param ItemUseCase $itemUseCase
     * @param ItemCategoryRelationUseCase $itemCategoryRelationUseCase
     * @return void
     */
    public function multiple(Request $request, ItemCategoryLargeUseCase $itemCategoryLargeUseCase, ItemCategoryMediumUseCase $itemCategoryMediumUseCase, ItemUseCase $itemUseCase, ItemCategoryRelationUseCase $itemCategoryRelationUseCase)
    {

        //商品カテゴリ大
        $itemCategoryLargeList = $itemCategoryLargeUseCase->findItemCategoryLargeList();

        //商品カテゴリ中
        $itemCategoryMediumList = $itemCategoryMediumUseCase->findItemCategoryMediumList();

        //商品
        $viewItemList = $itemUseCase->findViewItemList();

        //パラメータ区分
        //$isList = ((bool)$request->get('isList'));
        $isList = false;
        if ($request->isList=='true') {
            $isList = true;
        }

        return view('C_L53', compact(
            'itemCategoryLargeList',
            'itemCategoryMediumList',
            'viewItemList',
            'isList'
        ));
    }
}
