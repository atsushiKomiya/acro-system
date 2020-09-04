<?php

namespace App\Application\Controllers\Web;

use Illuminate\Http\Request;

/**
 * 【C_L54】日付選択画面コントローラ
 */
class DateSelectController extends WebController
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
     * @return void
     */
    public function index(Request $request)
    {
        return view('C_L54');
    }
}
