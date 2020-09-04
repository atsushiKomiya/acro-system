<?php

namespace App\Application\Controllers\Api;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        ini_set('max_execution_time', 180);
        $this->middleware('UnescapeJsonResponse');
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
}
