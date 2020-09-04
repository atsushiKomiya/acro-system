<?php

namespace App\Application\Controllers\Api;

use App\Application\Requests\DefaultListSearchRequest;
use App\Application\Responses\Api\BaseApiResponse;
use App\Application\UseCases\DefaultCsvDownloadUseCase;
use App\Application\UseCases\DepoDefaultListUseCase;
use App\Application\UseCases\ItemUseCase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * デフォルト設定（デポ商品コード紐付）API
 */
class DefaultListApiController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        // 全県対応（12万件以上を一時的に扱う可能性があるため）
        ini_set('memory_limit', '1024M');
        // CSVダウンロード　全県対応
        ini_set('max_execution_time', 600);
    }

    /**
     * デフォルト一覧検索
     *
     * @param DefaultListSearchRequest $request
     * @param DepoDefaultListUseCase $depoDefaultListUseCase
     * @return void
     */
    public function search(
        DefaultListSearchRequest $request,
        DepoDefaultListUseCase $depoDefaultListUseCase
    )
    {
        $prefCd = $request->prefCd;
        $depoCd = $request->depoCd;
        $itemCategoryLargecd = $request->itemCategoryLargecd;
        $itemCategoryMediumcd = $request->itemCategoryMediumcd;
        $itemCd = $request->itemCd;
        $isConfig = $request->isConfig;

        $res = new BaseApiResponse();
        try {
            // デフォルトリスト
            $defaultList = $depoDefaultListUseCase->findDepoDefaultList($prefCd, $depoCd, $itemCategoryLargecd, $itemCategoryMediumcd ,$itemCd, $isConfig);
            // 返却
            $res->apiSuccessful();
            $res->data = $defaultList;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L11.search'));
        }
        return $res;


    }

    /**
     * CSVダウンロード
     *
     * @param Request $request
     * @return void
     */
    public function download(DefaultListSearchRequest $request, DefaultCsvDownloadUseCase $csvUsecase, ItemUseCase $itemUseCase)
    {
        $fileName = Config::get('csvexp.file_name.default_list');
        
        // ヘッダ指定
        $headers = $csvUsecase->makeHeaderWithFilename($fileName);

        $items = $itemUseCase->findViewItemNameList();
        $names = [];
        foreach ($items as $item) {
            \array_push($names, $item->itemName);
        }

        // CSV作成
        $callback = function () use ($request, $csvUsecase, $names) {
            $prefCd = $request->prefCd;
            $depoCd = $request->depoCd;
            $itemCategoryLargecd = $request->itemCategoryLargecd;
            $itemCategoryMediumcd = $request->itemCategoryMediumcd;
            $itemCd = $request->itemCd;
            $isConfig = $request->isConfig;
            // CSV作成
            $csvUsecase->defaultListCsv($prefCd, $depoCd, $itemCategoryLargecd, $itemCategoryMediumcd ,$itemCd, $isConfig, $names);
        };

        // ダウンロード処理
        return response()->stream($callback, 200, $headers);
    }
}
