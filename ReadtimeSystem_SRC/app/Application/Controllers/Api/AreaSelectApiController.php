<?php

namespace App\Application\Controllers\Api;

use App\Application\UseCases\AddressUseCase;
use Illuminate\Http\Request;
use App\Application\Responses\Api\BaseApiResponse;

class AreaSelectApiController extends ApiController
{
    public function index(Request $request, AddressUseCase $addressUseCase)
    {
        //パラメータ受け取り
        $selectCity = $request->jiscode;
        //都道府県
        $addresslist= $addressUseCase->findAddressList($selectCity);
        $res = new BaseApiResponse();
        $res->apiSuccessful();
        $res->data = $addresslist;
        return $res;
    }
}
