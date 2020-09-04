<?php

namespace App\Application\Controllers\Web;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;

class WebController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('UnescapeJsonResponse');
        $this->middleware('auth:web');
    }

    /**
     * ファイルアップロード
     *
     * @param [type] $fileProperty
     * @return string
     */
    protected function tempFileupload($fileProperty): string
    {
        $fileName = "";
        try {
            $fileName = request()->$fileProperty->getClientOriginalName();

            request()->$fileProperty->storeAs('temp', $fileName);
        } catch (Exception $e) {
            throw $e;
        }

        return $fileName;
    }

    /**
     * SESSION User 取得
     *
     * @return void
     */
    protected function getSessionUser()
    {
        $authInfo = null;
        $authInfoKey = Config::get('session.user');
        if (session()->has($authInfoKey)) {
            $authInfo = session()->get($authInfoKey);
        }

        return $authInfo;
    }
}
