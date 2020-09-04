<?php

namespace App\Application\Controllers\Web;

use App\Application\UseCases\TopUseCase;
use App\Consts\AppConst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class TopController extends WebController
{
    public function index(Request $request, TopUseCase $usecase)
    {
        $unapprovedCount = null;
        $messages = array();

        // 未承認情報取得
        $authInfo = $request->session()->get('auth_info');
        if ($authInfo->AUTH_CLS == AppConst::AUTH_CLS['shain']) {
            $unapprovedCount = $usecase->findUnapproved();
        }

        // 文言通知取得
        $messages = $usecase->findInfoMessage();

        // タイトル一覧取得
        $titles = Lang::get('html');

        return view('C_L01', compact(
            'unapprovedCount',
            'messages',
            'titles'
        ));
    }
}
