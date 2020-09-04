<?php

namespace App\Application\Controllers\Api;

use App\Application\Requests\IrregularDeleteRequest;
use App\Application\Requests\IrregularRegisterRequest;
use App\Application\Responses\Api\BaseApiResponse;
use App\Application\UseCases\IrregularUseCase;
use Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * イレギュラーAPIコントローラ
 */
class IrregularApiController extends ApiController
{
    /**
     * イレギュラー登録
     *
     * @param IrregularRegisterRequest $request
     * @param IrregularUseCase $irregularUseCase
     * @return void
     */
    public function reflect(IrregularRegisterRequest $request, IrregularUseCase $irregularUseCase)
    {
        $irregular                      = (object) $request->irregular;
        $irregularDepoList              = $request->irregularDepoList;
        $irregularAreaList              = $request->irregularAreaList;
        $irregularItemList              = $request->irregularItemList;
        $irregularDeliveryDayofweekList = $request->irregularDeliveryDayofweekList;
        $irregularOrderDayofweekList    = $request->irregularOrderDayofweekList;
        $res = new BaseApiResponse();
        try {
            // 登録
            $irregularId = $irregularUseCase->createIrregular(
                $irregular,
                $irregularDepoList,
                $irregularAreaList,
                $irregularItemList,
                $irregularDeliveryDayofweekList,
                $irregularOrderDayofweekList
            );
            // 返却
            $res->apiSuccessful();
            $res->data = $irregularId;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L31.register'));
        }
        return $res;
    }

    /**
     * イレギュラー削除
     *
     * @param IrregularDeleteRequest $request
     * @param IrregularUseCase $irregularUseCase
     * @return void
     */
    public function delete(IrregularDeleteRequest $request, IrregularUseCase $irregularUseCase)
    {
        $irregularId = $request->irregularId;
        $res = new BaseApiResponse();
        try {
            // 削除
            $irregularUseCase->deleteIrregular($irregularId);
            // 返却
            $res->apiSuccessful();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L31.delete'));
        }
        return $res;
    }
}
