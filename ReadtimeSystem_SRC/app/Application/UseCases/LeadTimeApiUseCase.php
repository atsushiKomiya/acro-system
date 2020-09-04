<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\DepoCalInfoRepositoryInterface;
use App\Domain\Repositories\ItemCategoryRelationRepositoryInterface;
use App\Domain\Repositories\IrregularRepositoryInterface;
use App\Domain\Repositories\DepoDefaultRepositoryInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Consts\AppConst;

/**
 * 【C_LI_01_リードタイムAPIフロント】
 * 【C_LI_02_リードタイムAPIサーバー】
 *  共通ユースケースクラス
 */
class LeadTimeApiUseCase
{
    // デポカレンダー情報
    protected $iDepoCalInfoRepository;
    // 商品カテゴリ紐づきマスタ
    protected $iItemCategoryRelationRepository;
    // イレギュラー設定
    protected $iIrregularRepository;
    // デポデフォルト
    protected $iDepoDefaultRepositoryInterface;

    /** メンバ変数 */
    protected $order_date_week;            // 受注日曜日配列
    protected $delivery_date_week;         // お届け希望日曜日配列
    protected $ir_transfer_list;           // イレギュラー振替先チェックリスト
    protected $ir_order_list;              // イレギュラー受注不可チェックリスト
    protected $ir_delivery_list;           // イレギュラー配送不可チェックリスト
    protected $res_ir_trans_list;          // イレギュラー振替先結果リスト
    protected $res_ir_order_list;          // イレギュラー受注不可結果リスト
    protected $res_ir_delivery_list;       // イレギュラー配送不可結果リスト
    protected $res_depo_cal_transfer_list; // デポカレンダー期間注釈リスト
    protected $use_depo_list;              // 有効デポリスト
    protected $api_date;                   // API起動日
    protected $api_date_nextday;           // API起動日+1日
    protected $api_time;                   // API起動時刻
    protected $use_order_depo_list;        // 受注可能デポリスト



    /**
     * コンストラクタ
     */
    public function __construct(
        DepoCalInfoRepositoryInterface $iDepoCalInfoRepository,
        ItemCategoryRelationRepositoryInterface $iItemCategoryRelationRepository,
        IrregularRepositoryInterface $iIrregularRepository,
        DepoDefaultRepositoryInterface $iDepoDefaultRepositoryInterface,
        Request $request
    ) {
        $this->iDepoCalInfoRepository = $iDepoCalInfoRepository;
        $this->iItemCategoryRelationRepository = $iItemCategoryRelationRepository;
        $this->iIrregularRepository = $iIrregularRepository;
        $this->iDepoDefaultRepositoryInterface = $iDepoDefaultRepositoryInterface;
        $this->request = $request;
        $this->logger = Log::channel('apilog')->getLogger();

        $this->order_date_week[date('Ymd')] = [];
        $this->delivery_date_week[date('Ymd', strtotime($this->request->input('aDate')))] = [];
        $this->api_date = [
            'Y-m-d' => date('Y-m-d'),
            'Ymd'   => date('Ymd')
        ];
        $this->api_date_nextday = [
            'Y-m-d' => date('Y-m-d', strtotime('+1 day', strtotime($this->api_date['Y-m-d']))),
            'Ymd'   => date('Ymd', strtotime('+1 day', strtotime($this->api_date['Ymd'])))
        ];
        $this->api_time = date('Hi');
        $this->aDate = [
            'Ymd'   => date('Ymd', strtotime($this->request->input('aDate')))
        ];
    }

    /**
     * 曜日祝日区分取得
     *
     * @param string $date 届日（日付）
     * @return array
     */
    public function getWeekHolidayType($date)
    {
        // API起動日 + 届日（日付）を格納
        $cond   = [];
        $cond[] = date('Ymd');
        if (!empty($date)) {
            $cond[] = $date;
        }
        return $this->iDepoCalInfoRepository->getDepoCalInfoWeekHolidayType($cond);
    }

    /**
     * 商品カテゴリ情報取得
     *
     * @param string $productCd 商品コード
     * @return array
     */
    public function _getItemCategory($productCd)
    {
        return $this->iItemCategoryRelationRepository->getItemCategoryRelationInfo($productCd);
    }

    /**
     * イレギュラー情報取得
     *
     * @param string $cond 検索条件
     * @return array
     */
    public function _getIrregular($cond)
    {
        return $this->iIrregularRepository->getIrregularInfo($cond);
    }

    /**
     * 住所・商品紐づきデポ情報取得
     *
     * @param string $cond 検索条件
     * @return array
     */
    public function _getAddressItemRelation($cond)
    {
        return $this->iDepoDefaultRepositoryInterface->getAddressItemRelationInfo($cond);
    }

    /**
     * 通常デポカレンダー引き当て情報取得
     *
     * @param string $cond 検索条件
     * @return array
     */
    public function _getNormalDepoCalAllocation($cond, $sysid)
    {
        return $this->iDepoCalInfoRepository->getNormalDepoCalAllocationInfo($cond, $sysid);
    }

    /**
     * 通常デポ翌日カレンダー引き当て情報取得
     *
     * @param string $cond 検索条件
     * @return array
     */
    public function _getNormalDepoNextCalAllocation($cond, $sysid)
    {
        return $this->iDepoCalInfoRepository->getNormalDepoNextCalAllocationInfo($cond, $sysid);
    }

    /**
     * サプライズデポカレンダー引き当て情報取得＿１
     *
     * @param string $cond 検索条件
     * @return array
     */
    public function _getSpDepoNextCalAllocation($cond, $sysid)
    {
        return $this->iDepoCalInfoRepository->getSpDepoNextCalAllocationInfo($cond, $sysid);
    }

    /**
     * サプライズデポカレンダー引き当て情報取得＿２
     *
     * @param string $cond 検索条件
     * @return array
     */
    public function _getSpDepoNextCalAllocation2($cond)
    {
        return $this->iDepoCalInfoRepository->getSpDepoNextCalAllocationInfo2($cond);
    }

    /**
     * エンタメデポカレンダー最短作業日取得
     *
     * @param string $cond 検索条件
     * @return array
     */
    public function _getEtmDepoCalWorkDay($cond, $sysid)
    {
        return $this->iDepoCalInfoRepository->getEtmDepoCalWorkDayInfo($cond, $sysid);
    }

    /**
     * 曜日祝日区分を内部配列に格納
     *
     * @param array $order_date_week 受注日曜日
     * @param array $delivery_date_week お届け日曜日
     * @param array $week_holiday_types getWeekHolidayType()の結果セット
     * @return array [$order, $delivery] 内部配列
     */
    public function setArrayWeekHolidayType($order_date_week, $delivery_date_week, $week_holiday_types)
    {
        $order = [];
        $delivery = [];
        // API起動日と同一なら受注日曜日 & リクエストお届け希望日と同一ならお届け希望日曜日
        // ※複数取得できた場合count最大のものを採用
        foreach ($week_holiday_types as $type) {
            if (isset($order_date_week[$type->delivery_date])) {
                // 上書き
                if (isset($order[$type->delivery_date]) && $order[$type->delivery_date]->count < $type->count) {
                    $order[$type->delivery_date] = $type;
                }
                // 初回格納
                if (!isset($order[$type->delivery_date])) {
                    $order[$type->delivery_date] = $type;
                }
            }
            if (isset($delivery_date_week[$type->delivery_date])) {
                // 上書き
                if (isset($delivery[$type->delivery_date]) && $delivery[$type->delivery_date]->count < $type->count) {
                    $delivery[$type->delivery_date] = $type;
                }
                // 初回格納
                if (!isset($delivery[$type->delivery_date])) {
                    $delivery[$type->delivery_date] = $type;
                }
            }
        }

        return [$order, $delivery];
    }

    /**
     * 有効デポリストに表示タイプ:1が存在するか確認
     *
     * @return boolean 存在すればtrueを返却
     */
    public function checkDisplayType()
    {
        foreach ($this->use_depo_list as $item) {
            if ($item->display_type == AppConst::DISPLAY_TYPE['NORMAL']) {
                return true;
            }
        }
        return false;
    }

    /**
     * 日数差分
     *
     * @param string $date1 日時
     * @param string $date2 日時
     * @return integer $daydiff 日数差分
     */
    public function dayDiff($date1, $date2)
    {
        $timestamp1 = strtotime($date1);
        $timestamp2 = strtotime($date2);
        $seconddiff = abs($timestamp2 - $timestamp1);
        // 日数に変換
        $daydiff = $seconddiff / (60 * 60 * 24);

        // 戻り値
        return $daydiff;
    }

    /**
     * 翌日時間指定チェック
     * ※フロント
     *
     * @param array $datas チェック情報
     * @return boolean 存在すればtrueを返却
     */
    public function checkNextDayTimes($datas)
    {
        foreach ($datas as $key => $data) {
            if (
                ($this->request->input('aDate') == $this->api_date_nextday['Y-m-d'] && $this->api_time > $data->next_day_time_deadline)
                || (
                    preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])まで$/u', $data->next_day_time_type_str)
                    && preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])まで$/u', $this->request->input('aTime'), $match)
                    && $match[1].$match[2] < $data->next_day_time_type
                )
                || (
                    preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])まで$/u', $data->next_day_time_type_str)
                    && ($this->request->input('aTime') == '午前中' || $data->next_day_time_type >= 1230)
                )
                || (
                    $data->next_day_time_type_str == 'その日中'
                    && (preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])まで$/u', $this->request->input('aTime')) || $this->request->input('aTime') == '午前中')
                )
                || (
                    $data->next_day_time_type_str == '午前中' && $this->request->input('aTime') != '午前中'
                )
                || (
                    $data->next_day_time_type_str == '時間指定不可' && $this->request->input('aTime') != 'その日中'
                )
            ) {
                // 該当翌日デポ削除
                unset($datas[$key]);
            }
        }

        return $datas;
    }

    /**
     * 翌日時間指定チェック
     * ※サーバー
     *
     * @param array $datas チェック情報
     * @return array $nextday_depo チェック後情報
     * @return array $time_delivery_flg 指定時刻配送可否の可能が存在するか
     */
    public function checkNextDayTimes2($datas)
    {
        $time_delivery_flg = false;
        $nextday_depo = [];
        foreach ($datas as $key => $data) {
            // ”API起動日+1日 =お届け希望日”かつ、”API起動時間 > 翌日配送締切時間”の場合
            if ($this->request->input('aDate') == $this->api_date_nextday['Y-m-d'] && $this->api_time > $data->next_day_time_deadline) {
                // 該当翌日デポ削除
                unset($datas[$key]);
            }
            if (
                (
                    preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])まで$/u', $data->next_day_time_type_str)
                    && preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])まで$/u', $this->request->input('aTime'), $match)
                    && $match[1].$match[2] < $data->next_day_time_type
                )
                || (
                    preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])まで$/u', $data->next_day_time_type_str)
                    && ($this->request->input('aTime') == '午前中' || $data->next_day_time_type >= 1230)
                )
                || (
                    $data->next_day_time_type_str == 'その日中'
                    && (preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])まで$/u', $this->request->input('aTime')) || $this->request->input('aTime') == '午前中')
                )
                || (
                    $data->next_day_time_type_str == '午前中' && $this->request->input('aTime') != '午前中'
                )
                || (
                    $data->next_day_time_type_str == '時間指定不可' && $this->request->input('aTime') != 'その日中'
                )
            ) {
                // 指定時刻配送可否 不可
                $datas[$key]->time_delivery_flg = false;
                // キーが若いほうが返却対象
                if (empty($nextday_depo)) {
                    $nextday_depo = $data;
                }
            } else {
                // 指定時刻配送可否 可能
                $datas[$key]->time_delivery_flg = true;
                $nextday_depo = $data;
                $time_delivery_flg = true;
                // 指定時刻配送可否 可能があれば終了
                break;
            }
        }

        return [$nextday_depo, $time_delivery_flg];
    }

    /**
     * 2．初期設定処理
     */
    public function initSet()
    {
        // [1] 曜日祝日区分取得
        $this->logger->info("##[1] 曜日祝日区分取得", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $week_holiday_types = $this->getWeekHolidayType($this->aDate['Ymd']);
        // [2] 内部配列に格納 (受注日曜日配列, お届け希望日曜日配列)
        $this->logger->info("##[2] 内部配列に格納 (受注日曜日配列, お届け希望日曜日配列)", ['file' => basename(__FILE__), 'line' => __LINE__]);
        list(
            $this->order_date_week,
            $this->delivery_date_week
            ) = $this->setArrayWeekHolidayType($this->order_date_week, $this->delivery_date_week, $week_holiday_types);
        // [3] 商品カテゴリ情報取得
        $this->logger->info("##[3] 商品カテゴリ情報取得", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $items = $this->_getItemCategory($this->request->input('productCd'));
        if (count($items) == 0) {
            $this->logger->info("##商品カテゴリ情報が取得できませんでした", ['file' => basename(__FILE__), 'line' => __LINE__]);
            return false;
        }
        $this->logger->info("###商品カテゴリ", ['param' => $items]);
        // [4] イレギュラー情報取得
        $this->logger->info("##[4] イレギュラー情報取得", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $cond = [
            'procKbn' => $this->request->input('procKbn'),
            'item_cd' => $this->request->input('productCd'),
            'lcat_cd' => $items[0]->category_large_cd,
            'mcat_cd' => $items[0]->category_medium_cd,
            'pref_cd' => $this->request->input('aPref'),
            'siku'    => $this->request->input('aSiku'),
            'tyou'    => $this->request->input('aTyou'),
            'c_use'   => (!empty($this->request->input('c_use'))) ? $this->request->input('c_use') : null,
        ];
        $irregulars = $this->_getIrregular((object)$cond);
        if (count($irregulars) == 0) {
            $this->logger->info("##イレギュラー情報が取得できませんでした", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => "0件"]);
        }

        // [5] 配列初期化 (イレギュラー振替先チェックリスト, イレギュラー受注不可チェックリスト, イレギュラー配送不可チェックリスト) + 各結果配列
        $this->logger->info("##[5] 配列初期化", ['file' => basename(__FILE__), 'line' => __LINE__]);

        $this->ir_transfer_list           = [];
        $this->ir_order_list              = [];
        $this->ir_delivery_list           = [];
        $this->res_ir_trans_list          = [];
        $this->res_ir_order_list          = [];
        $this->res_ir_delivery_list       = [];
        $this->res_depo_cal_transfer_list = [];
        // [6] 配列格納
        foreach ($irregulars as $data) {
            switch ($data->irregular_type) {
                case 1:
                    $this->ir_transfer_list[] = $data;
                    break;
                case 2:
                    $this->ir_order_list[] = $data;
                    break;
                case 3:
                    $this->ir_delivery_list[] = $data;
                    break;
            }
        }
        $this->logger->info("###イレギュラー振替先チェックリスト", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $this->ir_transfer_list]);
        $this->logger->info("###イレギュラー受注不可チェックリスト", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $this->ir_order_list]);
        $this->logger->info("###イレギュラー配送不可チェックリスト", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $this->ir_delivery_list]);
        return true;
    }


    /**
     * 5．住所・商品紐づけ情報取得
     */
    public function getAddressItemRelation()
    {
        // [1] ５. 住所・商品紐づきデポ情報取得
        $this->logger->info("##[1] ５. 住所・商品紐づきデポ情報取得", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $cond = [
            'item_cd'     => $this->request->input('productCd'),
            'pref_cd'     => $this->request->input('aPref'),
            'siku'        => $this->request->input('aSiku'),
            'tyou'        => $this->request->input('aTyou'),
            'handing_flg' => $this->request->input('handing'),
            'huda'        => $this->request->input('huda'),
            'spFlg'       => $this->request->input('spFlg'),
        ];
        $items = $this->_getAddressItemRelation((object)$cond);
        // [2] 件数判定
        $this->logger->info("##[2] 件数判定", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $count = count($items);
        $this->use_depo_list = [];
        if ($count > 0) {
            // 有効デポリスト格納
            $this->use_depo_list = $items;
        }
        $this->logger->info("##有効デポリスト", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $this->use_depo_list]);
        return $count;
    }

    /**
     * 11．レスポンス設定処理
     */
    public function setResponse($list)
    {
        $res = [];
        foreach ($this->wk as $key => $val) {
            if (array_key_exists($key, $list)) {
                switch ($key) {
                    case 'short_delivery_days':
                        if ($val == null) {
                            $this->logger->info("##最短お届け日数設定", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $this->wk]);
                            // 最短お届け日数設定
                            if ($this->wk['today_depo_cd'] != null && ($this->wk['today_time_deadline1'] > $this->api_time || $this->wk['today_time_deadline2'] > $this->api_time)) {
                                $val = 0;
                            } elseif ($this->wk['next_day_depo_cd'] != null) {
                                $val = 1;
                            } else {
                                $val = null;
                            }
                        }
                        break;
                    case 'short_delivery_date':
                        if ($val == null) {
                            $this->logger->info("##最短お届け日設定", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $this->wk]);
                            // 最短お届け日設定
                            if ($this->wk['today_depo_cd'] != null && ($this->wk['today_time_deadline1'] > $this->api_time || $this->wk['today_time_deadline2'] > $this->api_time)) {
                                $val = $this->api_date['Y-m-d'];
                            } elseif ($this->wk['next_day_depo_cd'] != null) {
                                $val = $this->api_date_nextday['Y-m-d'];
                            } else {
                                $val = null;
                            }
                        }
                        break;
                    default:
                        break;
                }
                $res[$key] = $val;
            }
        }
        return $res;
    }

    /**
     * 12．イレギュラー_受注不可チェック処理
     */
    public function irNotOrderCheck($depo_cd, $search_date)
    {
        // [1] 受注不可エラーフラグ ※返却フラグ初期値
        $this->logger->info("##[1] 受注不可エラーフラグ ※返却フラグ初期値", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $res_flg = false;
        $res_time_select = 0;
        $res_is_personal_delivery_flg = false;
        $res_is_today_deadline_undeliv_flg = false;

        // [2] 判定
        $this->logger->info("##[2] 判定", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if (count($this->ir_order_list) == 0) {
            return $res_flg;
        }

        foreach ($this->ir_order_list as $key => $items) {
            if ($items->is_depo === false || $items->depo_cd == $depo_cd) {
                if (empty($items->delivery_date_type)
                    || ($items->delivery_date_type == AppConst::DELIVERY_DATE_TYPE['DAY'] && $items->delivery_date == $search_date)
                    || ($items->delivery_date_type == AppConst::DELIVERY_DATE_TYPE['PERIOD'] && $items->delivery_date_from <= $search_date && $items->delivery_date_to >= $search_date)
                    || ($items->delivery_date_type == AppConst::DELIVERY_DATE_TYPE['WEEK'] && $items->date_type == AppConst::DATE_TYPE['DELIVERY_DATE'] && $items->dayofweek == date('w', strtotime($search_date)))
                    || ((!is_null($items->anno_from) && !is_null($items->anno_to)) && $items->anno_from <= $this->api_date['Y-m-d'] && $items->anno_to >= $this->api_date['Y-m-d'])
                ) {

                    // 返却変数の受注不可エラーフラグをTRUE、”時間指定”、”個人宅不可フラグ”、”当日配送不可フラグ”に設定
                    if ($items->time_select == null) {
                        $items->time_select = 0;
                    }
                    $res_flg = true;
                    $res_time_select                   = ($res_time_select < $items->time_select) ? $items->time_select : $res_time_select;
                    $res_is_personal_delivery_flg      = ($res_is_personal_delivery_flg === true) ? true : $items->is_personal_delivery;
                    $res_is_today_deadline_undeliv_flg = ($res_is_today_deadline_undeliv_flg === true) ? true : $items->is_today_deadline_undeliv;

                    // 受注不可結果リスト
                    $this->res_ir_order_list[] = $items;
                }
            }
        }

        return [
            $res_flg,
            $res_time_select,
            $res_is_personal_delivery_flg,
            $res_is_today_deadline_undeliv_flg
        ];
    }

    /**
     * 13．イレギュラー_配送不可チェック処理
     */
    public function irNotDeliveryCheck($depo_cd, $a_date)
    {
        // [1] 配送不可エラーフラグ ※返却フラグ初期値
        $this->logger->info("##[1] 配送不可エラーフラグ ※返却フラグ初期値", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $res_flg = false;
        $res_is_before_deadline_undeliv_flg = false;
        $res_is_today_deadline_undeliv_flg = false;
        $res_is_time_select_undeliv_flg = false;
        $res_is_personal_delivery_flg = false;
        // [2] 判定
        $this->logger->info("##[2] 判定", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($this->ir_delivery_list as $key => $items) {
            if ($items->is_depo === false || $items->depo_cd == $depo_cd) {
                if (empty($items->delivery_date_type)
                    || ($items->delivery_date_type == AppConst::DELIVERY_DATE_TYPE['DAY'] && $items->delivery_date == $a_date)
                    || ($items->delivery_date_type == AppConst::DELIVERY_DATE_TYPE['PERIOD'] && $items->delivery_date_from <= $a_date && $items->delivery_date_to >= $a_date)
                    || ($items->delivery_date_type == AppConst::DELIVERY_DATE_TYPE['WEEK'] && $items->date_type == AppConst::DATE_TYPE['DELIVERY_DATE'] && $items->dayofweek == date('w', strtotime($a_date)))
                    || ((!is_null($items->anno_from) && !is_null($items->anno_to)) && $items->anno_from <= $this->api_date['Y-m-d'] && $items->anno_to >= $this->api_date['Y-m-d'])
                ) {
                    // 返却変数の配送不可エラーフラグをTRUE、”前日締切不可フラグ”、”当日配送不可フラグ”、”時間指定不可フラグ”、”個人宅不可フラグ”に設定
                    $res_flg = true;
                    $res_is_before_deadline_undeliv_flg = ($res_is_before_deadline_undeliv_flg === true) ? true : $items->is_before_deadline_undeliv;
                    $res_is_today_deadline_undeliv_flg  = ($res_is_today_deadline_undeliv_flg === true) ? true : $items->is_today_deadline_undeliv;
                    $res_is_time_select_undeliv_flg     = ($res_is_time_select_undeliv_flg === true) ? true : $items->is_time_select_undeliv;
                    $res_is_personal_delivery_flg       = ($res_is_personal_delivery_flg === true) ? true : $items->is_personal_delivery;

                    // 配送不可結果リスト
                    $this->res_ir_delivery_list[] = $items;
                }
            }
        }

        return [
            $res_flg,
            $res_is_before_deadline_undeliv_flg,
            $res_is_today_deadline_undeliv_flg,
            $res_is_time_select_undeliv_flg,
            $res_is_personal_delivery_flg
        ];
    }
}
