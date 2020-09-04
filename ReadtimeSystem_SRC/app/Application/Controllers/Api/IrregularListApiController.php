<?php

namespace App\Application\Controllers\Api;

use App\Application\Requests\IrregularListSearchRequest;
use App\Application\Responses\Api\BaseApiResponse;
use App\Application\UseCases\AddressUseCase;
use App\Application\UseCases\DepoUseCase;
use App\Application\UseCases\IrregularCsvDownloadUseCase;
use App\Application\UseCases\IrregularListUseCase;
use App\Application\UseCases\IrregularUseCase;
use App\Application\UseCases\ItemCategoryLargeUseCase;
use App\Application\UseCases\ItemCategoryMediumUseCase;
use App\Application\UseCases\ItemUseCase;
use App\Domain\Entities\IrregularListSearchEntity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * イレギュラーリストダウンロードAPI
 */
class IrregularListApiController extends ApiController
{

    /**
     * イレギュラー一覧画面表示
     *
     * @param Request $request
     * @param AddressUseCase $addressUseCase
     * @param DepoUseCase $depoUsecase
     * @param ItemCategoryLargeUseCase $itemCategoryLargeUseCase
     * @param ItemCategoryMediumUseCase $itemCategoryMediumUseCase
     * @param ItemUseCase $itemUseCase
     * @param IrregularListUseCase $irregularListUseCase
     * @return void
     */
    public function search(
        IrregularListSearchRequest $request,
        IrregularListUseCase $irregularListUseCase
    ) {
        // 検索パラメータ
        $searchParam = new IrregularListSearchEntity();
        $searchParam->searchIrregularConfig = $request->searchIrregularConfig;
        $searchParam->searchTitle = $request->searchTitle;
        $searchParam->searchDepocd = $request->searchDepocd;
        $searchParam->searchDeponame = $request->searchDeponame;
        $searchParam->searchTransDeponame = $request->searchTransDeponame;
        $searchParam->searchTransDepocd = $request->searchTransDepocd;
        $searchParam->searchDisplayType = $request->searchDisplayType;
        $searchParam->searchItemCategoryLargecd = $request->searchItemCategoryLargecd;
        $searchParam->searchItemCategoryLargename = $request->searchItemCategoryLargename;
        $searchParam->searchItemCategoryMediumcd = $request->searchItemCategoryMediumcd;
        $searchParam->searchItemCategoryMediumname = $request->searchItemCategoryMediumname;
        $searchParam->searchItemCd = $request->searchItemCd;
        $searchParam->searchItemName = $request->searchItemName;
        $searchParam->searchOrderType = $request->searchOrderType;
        $searchParam->searchOrderDate = $request->searchOrderDate;
        $searchParam->searchOrderPeriodStart = $request->searchOrderPeriodStart;
        $searchParam->searchOrderPeriodEnd = $request->searchOrderPeriodEnd;
        $searchParam->searchOrderWeekList = $request->searchOrderWeekList;
        $searchParam->searchOrderHolidayList = $request->searchOrderHolidayList;
        $searchParam->searchZipcdList = $request->searchZipcdList;
        $searchParam->searchPrefList = $request->searchPrefList;
        $searchParam->searchPrefNameList = $request->searchPrefNameList;
        $searchParam->searchSikuList = $request->searchSikuList;
        $searchParam->searchTyouList = $request->searchTyouList;
        $searchParam->searchCUseCd = $request->searchCUseCd;
        $searchParam->searchIsValid = $request->searchIsValid;
        $searchParam->searchDeliveryTime = $request->searchDeliveryTime;
        $searchParam->searchDeliveryDateType = $request->searchDeliveryDateType;
        $searchParam->searchDeliveryDate = $request->searchDeliveryDate;
        $searchParam->searchDeliveryPeriodStart = $request->searchDeliveryPeriodStart;
        $searchParam->searchDeliveryPeriodEnd = $request->searchDeliveryPeriodEnd;
        $searchParam->searchDeliveryWeekList = $request->searchDeliveryWeekList;
        $searchParam->searchDeliveryHolidayList = $request->searchDeliveryHolidayList;
        $searchParam->searchIsBeforeDeadline = $request->searchIsBeforeDeadline;
        $searchParam->searchIsTodayDelivery = $request->searchIsTodayDelivery;
        $searchParam->searchIsTimeSelect = $request->searchIsTimeSelect;
        $searchParam->searchIsPrivateHome = $request->searchIsPrivateHome;

        $res = new BaseApiResponse();
        try {
            // イレギュラー一覧
            $irregularList = $irregularListUseCase->findIrregularList($searchParam);
            // 返却
            $res->apiSuccessful();
            $res->data = $irregularList;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L30.search'));
        }
        return $res;

    }

    /**
     * CSVダウンロード
     *
     * @param IrregularListSearchRequest $request
     * @param IrregularCsvDownloadUseCase $csvUseCase
     * @return void
     */
    public function download(IrregularListSearchRequest $request, IrregularCsvDownloadUseCase $csvUseCase)
    {
        $fileName = Config::get('csvexp.file_name.irregular_list');
        
        // ヘッダ指定
        $headers = $csvUseCase->makeHeaderWithFilename($fileName);
        
        // CSV作成
        $callback = function () use ($request, $csvUseCase) {
        // 検索パラメータ
            $searchParam = new IrregularListSearchEntity();
            $searchParam->searchIrregularConfig = $request->searchIrregularConfig;
            $searchParam->searchTitle = $request->searchTitle;
            $searchParam->searchDepocd = $request->searchDepocd;
            $searchParam->searchDeponame = $request->searchDeponame;
            $searchParam->searchTransDeponame = $request->searchTransDeponame;
            $searchParam->searchTransDepocd = $request->searchTransDepocd;
            $searchParam->searchDisplayType = $request->searchDisplayType;
            $searchParam->searchItemCategoryLargecd = $request->searchItemCategoryLargecd;
            $searchParam->searchItemCategoryLargename = $request->searchItemCategoryLargename;
            $searchParam->searchItemCategoryMediumcd = $request->searchItemCategoryMediumcd;
            $searchParam->searchItemCategoryMediumname = $request->searchItemCategoryMediumname;
            $searchParam->searchItemCd = $request->searchItemCd;
            $searchParam->searchItemName = $request->searchItemName;
            $searchParam->searchOrderType = $request->searchOrderType;
            $searchParam->searchOrderDate = $request->searchOrderDate;
            $searchParam->searchOrderPeriodStart = $request->searchOrderPeriodStart;
            $searchParam->searchOrderPeriodEnd = $request->searchOrderPeriodEnd;
            $searchParam->searchOrderWeekList = $request->searchOrderWeekList;
            $searchParam->searchOrderHolidayList = $request->searchOrderHolidayList;
            $searchParam->searchZipcdList = $request->searchZipcdList;
            $searchParam->searchPrefList = $request->searchPrefList;
            $searchParam->searchPrefNameList = $request->searchPrefNameList;
            $searchParam->searchSikuList = $request->searchSikuList;
            $searchParam->searchTyouList = $request->searchTyouList;
            $searchParam->searchCUseCd = $request->searchCUseCd;
            $searchParam->searchIsValid = $request->searchIsValid;
            $searchParam->searchDeliveryTime = $request->searchDeliveryTime;
            $searchParam->searchDeliveryDateType = $request->searchDeliveryDateType;
            $searchParam->searchDeliveryDate = $request->searchDeliveryDate;
            $searchParam->searchDeliveryPeriodStart = $request->searchDeliveryPeriodStart;
            $searchParam->searchDeliveryPeriodEnd = $request->searchDeliveryPeriodEnd;
            $searchParam->searchDeliveryWeekList = $request->searchDeliveryWeekList;
            $searchParam->searchDeliveryHolidayList = $request->searchDeliveryHolidayList;
            $searchParam->searchIsBeforeDeadline = $request->searchIsBeforeDeadline;
            $searchParam->searchIsTodayDelivery = $request->searchIsTodayDelivery;
            $searchParam->searchIsTimeSelect = $request->searchIsTimeSelect;
            $searchParam->searchIsPrivateHome = $request->searchIsPrivateHome;

            // CSV作成
            $csvUseCase->IrregularListCsv($searchParam);
        };

        // ダウンロード処理
        return response()->stream($callback, 200, $headers);
    }
}
