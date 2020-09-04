<?php

namespace App\Application\Controllers\Web;

use App\Application\UseCases\AddressUseCase;
use Illuminate\Http\Request;

/**
 * 【C_L55】地域選択画面コントローラ
 */
class AreaSelectController extends WebController
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
     * 初期表示
     *
     * @param Request $request
     * @param AddressUseCase $addressUseCase
     * @return void
     */
    public function index(Request $request, AddressUseCase $addressUseCase)
    {
        //都道府県
        $prefList = $addressUseCase->findPrefList();

        //市区町村一覧
        $cityList = $addressUseCase->findCityList();

        //パラメータ区分
        $isAddress = false;
        if ($request->isAddress) {
            $isAddress = true;
        }

        return view('C_L55', compact(
            'cityList',
            'prefList',
            'isAddress'
        ));
    }
}
