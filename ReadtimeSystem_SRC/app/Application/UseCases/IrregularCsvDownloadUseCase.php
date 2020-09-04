<?php

namespace App\Application\UseCases;

use App\Domain\Entities\IrregularListSearchEntity;
use App\Domain\Repositories\IrregularRepositoryInterface;
use Illuminate\Support\Facades\Config;

use Carbon\Carbon;

class IrregularCsvDownloadUseCase extends BaseCsvExportUseCase
{

    // イレギュラーリスト
    private $iIrregularRepository;

    /**
     * コンストラクタ
     *
     * @param IrregularRepositoryInterface $iIrregularRepository
     */
    public function __construct(
        IrregularRepositoryInterface $iIrregularRepository
    ) {
        $this->iIrregularRepository = $iIrregularRepository;
    }

    /**
     * イレギュラー一覧検索CSV出力
     *
     * @param IrregularListSearchEntity $searchCondition
     * @return void
     */
    public function irregularListCsv(IrregularListSearchEntity $searchCondition)
    {
        // イレギュラー情報一覧取得
        $cursor = $this->iIrregularRepository->findIrregularList($searchCondition);
        // 時間指定変換
        $deliveryDateList = Config::get('delivery.time_select_list');
        // イレギュラー設定区分
        $irregularConfigClassificationList = Config::get('delivery.irregular_config_classification_list');

        // CSV出力時の１業単位の加工内容
        $func = function ($cursor) use($irregularConfigClassificationList, $deliveryDateList) {
            try {
                $returnRow = clone $cursor;

                // イレギュラー設定区分
                $irregularTypeKey = $cursor['irregular_type'];
                $returnRow['irregular_type'] = $irregularConfigClassificationList[$irregularTypeKey];

                // 不可フラグ文字列
                $notFlg = '不可';
                // 前日締切不可フラグ
                $returnRow['is_before_deadline_undeliv'] = $cursor['is_before_deadline_undeliv'] ? $notFlg : '';
                // 当日配送不可フラグ
                $returnRow['is_today_deadline_undeliv'] = $cursor['is_today_deadline_undeliv'] ? $notFlg : '';
                // 時間指定不可フラグ
                $returnRow['is_time_select_undeliv'] = $cursor['is_time_select_undeliv'] ? $notFlg : '';
                // 時間指定
                $timeSelectKey = $cursor['time_select'];
                $returnRow['time_select'] = isset($deliveryDateList[$timeSelectKey]) ? $deliveryDateList[$timeSelectKey] : '';
                // 個人宅不可フラグ
                $returnRow['is_personal_delivery'] = $cursor['is_personal_delivery'] ? $notFlg : '';
                // 地域区分
                $returnRow['is_area'] = $cursor['is_area'] ? '一部の地域' : '全地域';

                // 期間・曜日区分変換
                if ($cursor['delivery_date_type'] === 1) {
                    $returnRow['delivery_date_type'] = '日付';
                }
                if ($cursor['delivery_date_type'] === 2) {
                    $returnRow['delivery_date_type'] = '期間';
                }
                if ($cursor['delivery_date_type'] === 3) {
                    $returnRow['delivery_date_type'] = '曜日';
                }
                if ($cursor['order_date_type'] === 1) {
                    $returnRow['order_date_type'] = '日付';
                }
                if ($cursor['order_date_type'] === 2) {
                    $returnRow['order_date_type'] = '期間';
                }
                if ($cursor['order_date_type'] === 3) {
                    $returnRow['order_date_type'] = '曜日';
                }
                // 日付
                $returnRow['delivery_date'] = $cursor['delivery_date'] ? Carbon::parse($cursor['delivery_date'])->format('Y/m/d') : '';
                $returnRow['order_date'] = $cursor['order_date'] ? Carbon::parse($cursor['order_date'])->format('Y/m/d') : '';
                // 期間
                $returnRow['delivery_date_from'] = $cursor['delivery_date_from'] ? Carbon::parse($cursor['delivery_date_from'])->format('Y/m/d') : '';
                $returnRow['delivery_date_to'] = $cursor['delivery_date_to'] ? Carbon::parse($cursor['delivery_date_to'])->format('Y/m/d') : '';
                $returnRow['order_date_from'] = $cursor['order_date_from'] ? Carbon::parse($cursor['order_date_from'])->format('Y/m/d') : '';
                $returnRow['order_date_to'] = $cursor['order_date_to'] ? Carbon::parse($cursor['order_date_to'])->format('Y/m/d') : '';
                // 曜日
                if($cursor['delivery_week_holiday_list']) {
                    $deliveryWeekList = explode(",", $cursor['delivery_week_holiday_list']);

                    $returnRow['delivery_mon']         = in_array("月", $deliveryWeekList, true) ? 1 : '';
                    $returnRow['delivery_tue']         = in_array("火", $deliveryWeekList, true) ? 1 : '';
                    $returnRow['delivery_web']         = in_array("水", $deliveryWeekList, true) ? 1 : '';
                    $returnRow['delivery_thu']         = in_array("木", $deliveryWeekList, true) ? 1 : '';
                    $returnRow['delivery_fri']         = in_array("金", $deliveryWeekList, true) ? 1 : '';
                    $returnRow['delivery_sat']         = in_array("土", $deliveryWeekList, true) ? 1 : '';
                    $returnRow['delivery_sun']         = in_array("日", $deliveryWeekList, true) ? 1 : '';
                    $returnRow['delivery_holi_before'] = in_array("祝前", $deliveryWeekList, true) ? 1 : '';
                    $returnRow['delivery_holi']        = in_array("祝日", $deliveryWeekList, true) ? 1 : '';
                    $returnRow['delivery_holi_after']  = in_array("祝後", $deliveryWeekList, true) ? 1 : '';
                }
                if($cursor['order_week_holiday_list']) {
                    $orderWeekList = explode(",", $cursor['order_week_holiday_list']);

                    $returnRow['order_mon']         = in_array("月", $orderWeekList, true) ? 1 : '';
                    $returnRow['order_tue']         = in_array("火", $orderWeekList, true) ? 1 : '';
                    $returnRow['order_web']         = in_array("水", $orderWeekList, true) ? 1 : '';
                    $returnRow['order_thu']         = in_array("木", $orderWeekList, true) ? 1 : '';
                    $returnRow['order_fri']         = in_array("金", $orderWeekList, true) ? 1 : '';
                    $returnRow['order_sat']         = in_array("土", $orderWeekList, true) ? 1 : '';
                    $returnRow['order_sun']         = in_array("日", $orderWeekList, true) ? 1 : '';
                    $returnRow['order_holi_before'] = in_array("祝前", $orderWeekList, true) ? 1 : '';
                    $returnRow['order_holi']        = in_array("祝日", $orderWeekList, true) ? 1 : '';
                    $returnRow['order_holi_after']  = in_array("祝後", $orderWeekList, true) ? 1 : '';            
                }
                
                $returnRow['type_disable'] = Carbon::parse($returnRow['updated_at'])->format('Y-m-d');

                return $returnRow;
            } catch (\Exception $e) {
                throw $e;
            }
        };
        // CSV作成
        $this->makeStreamCSV('irregular_list', $cursor, null, $func);
    }
}
