<?php

namespace App\Application\Controllers\Api;

use App\Application\UseCases\AddressUseCase;
use Illuminate\Http\Request;
use App\Application\Responses\Api\BaseApiResponse;
use App\Application\UseCases\DepoAddressUseCase;
use Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * 共通系のAPIコントローラー
 */
class CommonApiController extends ApiController
{
    /**
     * デポ紐付き都道府県リストの取得
     *
     * @param Request $request
     * @param DepoAddressUseCase $depoAddressUseCase
     * @return void
     */
    public function depoPrefList(Request $request, DepoAddressUseCase $depoAddressUseCase)
    {

        $depoCd = $request->depoCd;
        $res = new BaseApiResponse();
        try {
            // デポ紐付き都道府県Entity
            $depoPrefEntity = $depoAddressUseCase->findDepoPrefEntity($depoCd);
            // 返却
            $res->apiSuccessful();
            $res->data = $depoPrefEntity;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.common.depo_pref.search'));
        }
        return $res;
    }
}
