<?php

namespace App\Application\Controllers\Web;

use App\Application\Requests\MessageDuplicationSearchRequest;
use App\Application\UseCases\DepoAddressUseCase;
use App\Application\UseCases\DepoCalAprInfoUseCase;
use App\Application\UseCases\DepoItemUseCase;
use App\Application\UseCases\IrregularUseCase;
use App\Application\Utilities\AppUtility;
use App\Consts\AppConst;
use App\Domain\Entities\MessageSearchEntity;
use App\Domain\Factories\MessageDuplicationFactory;
use Carbon\Carbon;

/**
 * 【C_L56】メッセージ重複確認画面コントローラ
 */
class MessageDuplicationController extends WebController
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
     * @param MessageDuplicationSearchRequest $request
     * @param DepoCalAprInfoUseCase $depoCalAprInfoUseCase
     * @param DepoAddressUseCase $depoAddressUseCase
     * @param DepoItemUseCase $depoItemUseCase
     * @param IrregularUseCase $irregularUseCase
     * @return void
     */
    public function index(
        MessageDuplicationSearchRequest $request,
        DepoCalAprInfoUseCase $depoCalAprInfoUseCase,
        DepoAddressUseCase $depoAddressUseCase,
        DepoItemUseCase $depoItemUseCase,
        IrregularUseCase $irregularUseCase
    ) {
        // 戻り値 初期化
        $messageList = [];
        $depoNameList = $request->depoCdNameList ? $request->depoCdNameList : [];
        $itemCategoryLargeCdNameList = [];
        $itemCategoryMediumCdNameList = [];
        $itemCdNameList = [];
        $prefCdNameList = [];
        $sikuList = [];
        $tyouList = [];
        $deliveryDate = '';
        $deliveryPeriod = '';
        $deliveryDayofweekList = [];

        //パラメータ取得
        // 遷移元特定 1:デポ休業等申請、2:イレギュラー設定
        $messageType = $request->messageType;
        // デポCDリスト
        $depoCdList = $request->depoCdList;
        // 商品
        $itemList =  $request->itemList ? json_decode($request->itemList) : [];
        // 住所
        $addressList = $request->addressList ? json_decode($request->addressList) : [];
        // 日付
        $deliveryDateType = $request->deliveryDateType;
        $deliveryDate     = $request->deliveryDate;
        $deliveryDateFrom = $request->deliveryDateFrom;
        $deliveryDateTo = $request->deliveryDateTo;
        $dayOfWeekList = $request->dayOfWeekList ? $request->dayOfWeekList : [];
        $publicHolidayStatusList = $request->publicHolidayStatusList ? $request->publicHolidayStatusList : [];

        // 一時データ
        $depoCalInfoList = [];
        $irregularList = [];
        $deliveryDateList = [];

        // デポカレンダー申込画面表示注釈（表示）取得
        if ($messageType == AppConst::MSG_TYPE_DEPO_REQ) {
            // 休業等申請画面からの遷移の場合
            // パラメータからリストを作成する
            $depoCalInfoListParam = $request->depoCalInfoList ? json_decode($request->depoCalInfoList) : [];
            $factory = new MessageDuplicationFactory();
            foreach ($depoCalInfoListParam as $depoCalInfo) {
                $depoCalInfoList[] = $factory->makeDepoCalInfoFromParamMessageDuplication($depoCalInfo);
            }
            // 変更理由（表示）レコードから、日付、曜日、祝日ステータスを取得
            // 日付、曜日、祝日ステータスをパラメータに設定（上書き）
            $deliveryDateList = collect($depoCalInfoList)->map(function ($model) {
                return $model->deliveryDate;
            })->unique()->all();
            $dayOfWeekList = collect($depoCalInfoList)->map(function ($model) {
                return $model->dayofweek;
            })->filter(function ($dayofweek) {
                return $dayofweek != null;
            })->unique()->all();
            $publicHolidayStatusList = collect($depoCalInfoList)->map(function ($model) {
                return $model->publicHolidayStatus;
            })->filter(function ($publicHolidayStatus) {
                return $publicHolidayStatus != null;
            })->unique()->all();
        } else {
            // イレギュラー設定の場合
            // デポの特定
            if (!$depoCdList) {
                // デポが存在しなかった場合は住所、商品情報からデポを特定する
                $depoAddressCdList = [];
                $depoItemCdList = [];
                if ($addressList) {
                    // 住所
                    $depoAddressCdList = $depoAddressUseCase->findSimilarAddressDepo($addressList);
                } 
                if ($itemList) {
                    // 商品
                    $depoItemCdList = $depoItemUseCase->findSimilarItemDepo($itemList);
                }

                if($depoAddressCdList && $depoItemCdList) {
                    $depoCdList = array_intersect_key($depoAddressCdList,$depoItemCdList);
                } else if($depoAddressCdList) {
                    $depoCdList = $depoAddressCdList;
                } else if($depoItemCdList) {
                    $depoCdList = $depoItemCdList;
                }
            }

            // デポ、対象年月から、対象の変更理由（表示）情報を取得
            $from = null;
            $to = null;
            if ($deliveryDateType == AppConst::DELIVERY_DATE_TYPE['DAY']) {
                $from = $deliveryDate;
                $to = $deliveryDate;
            } elseif ($deliveryDateType == AppConst::DELIVERY_DATE_TYPE['PERIOD']) {
                $from = $deliveryDateFrom;
                $to = $deliveryDateTo;
            }
            // 検索条件が何かしらある場合はのみ検索
            if ($depoCdList || $from || $to || $dayOfWeekList || $publicHolidayStatusList) {
                $depoCalInfoList = $depoCalAprInfoUseCase->findAnnoDispMessageList($depoCdList, $from, $to, $dayOfWeekList, $publicHolidayStatusList);
            }

            // 日付データを配列化
            if ($deliveryDate) {
                $deliveryDateList[] = $deliveryDate;
            }
        }

        $searchEntity = new MessageSearchEntity();
        $searchEntity->messageType = $messageType;
        $searchEntity->depoCdList = $depoCdList;
        $searchEntity->itemList = $itemList;
        $searchEntity->addressList = $addressList;
        $searchEntity->deliveryDateType = $deliveryDateType;
        $searchEntity->deliveryDate     = $deliveryDate;
        $searchEntity->deliveryDateList     = $deliveryDateList;
        $searchEntity->deliveryDateFrom = $deliveryDateFrom;
        $searchEntity->deliveryDateTo = $deliveryDateTo;
        $searchEntity->dayOfWeekList = $dayOfWeekList;
        $searchEntity->publicHolidayStatusList = $publicHolidayStatusList;


        // イレギュラー設定検索
        $irregularList = $irregularUseCase->findAnnoMessageList($searchEntity);

        // メッセージマージ
        $tmpList = array_merge($depoCalInfoList, $irregularList);
        $messageList = collect($tmpList)->sortBy(function ($message) {
            return $message->sort;
        })->values()->all();

        // 返却値設定
        if ($searchEntity->deliveryDate) {
            $deliveryDate = Carbon::parse($searchEntity->deliveryDate)->format('Y/n/j');
        }
        if ($searchEntity->deliveryDateFrom && $searchEntity->deliveryDateTo) {
            $from = Carbon::parse($searchEntity->deliveryDateFrom)->format('Y/n/j');
            $to = Carbon::parse($searchEntity->deliveryDateTo)->format('Y/n/j');
            $deliveryPeriod = $from . '〜' . $to;
        }
        // 商品
        if($searchEntity->itemList) {
            $itemCollect = collect($searchEntity->itemList);
            $itemCategoryLargeCdNameList = $itemCollect->unique('itemCategoryLargeCd')->map(function($item){
                return '【' . $item->itemCategoryLargeCd . '】' . $item->itemCategoryLargeName;
            });
            $itemCategoryMediumCdNameList = $itemCollect->unique('itemCategoryMediumCd')->map(function($item){
                return '【' . $item->itemCategoryMediumCd . '】' . $item->itemCategoryMediumName;
            });
            $itemCdNameList = $itemCollect->unique('itemCd')->map(function($item){
                return '【' . $item->itemCd . '】' . $item->itemName;
            });
        }
        // 住所
        if($searchEntity->addressList) {
            $addressCollect = collect($searchEntity->addressList);
            $prefCdNameList = $addressCollect->unique('pref')->map(function($address){
                return '【' . $address->pref . '】' . $address->prefName;
            });
            $sikuList = $addressCollect->unique('siku')->map(function($address){
                return $address->siku;
            });
            $tyouList = $addressCollect->unique('tyou')->map(function($address){
                return $address->tyou;
            });
        }
        if ($messageType == AppConst::MSG_TYPE_IRREGULAR) {
            foreach ($dayOfWeekList as $dayOfWeek) {
                $deliveryDayofweekList[] = AppUtility::getWeekStr($dayOfWeek);
            }
            foreach ($publicHolidayStatusList as $holiday) {
                $deliveryDayofweekList[] = AppUtility::getHolidayStr($holiday);
            }
        }


        return view('C_L56', compact(
            'messageList',
            'depoNameList',
            'itemCategoryLargeCdNameList',
            'itemCategoryMediumCdNameList',
            'itemCdNameList',
            'prefCdNameList',
            'sikuList',
            'tyouList',
            'deliveryDate',
            'deliveryPeriod',
            'deliveryDayofweekList',
        ));
    }
}
