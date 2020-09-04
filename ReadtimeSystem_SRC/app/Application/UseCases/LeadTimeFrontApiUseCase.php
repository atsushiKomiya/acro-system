<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\DepoCalInfoRepositoryInterface;
use App\Domain\Repositories\ItemCategoryRelationRepositoryInterface;
use App\Domain\Repositories\IrregularRepositoryInterface;
use App\Domain\Repositories\DepoDefaultRepositoryInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Consts\AppConst;

/**
 * 【C_LI_01_リードタイムAPIフロント】ユースケースクラス
 */
class LeadTimeFrontApiUseCase extends LeadTimeApiUseCase
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
    public $wk; // 結果配列
    public $sysid = AppConst::API_SYSTEM_ID['FRONT']; // 機能ID

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
        parent::__construct(
            $iDepoCalInfoRepository,
            $iItemCategoryRelationRepository,
            $iIrregularRepository,
            $iDepoDefaultRepositoryInterface,
            $request
        );
        /** 変数初期化 */
        $this->wk = [
            'status'                 => AppConst::API_STATUS['SUCCESS'],
            'trans_depo_cd'          => null,
            'today_depo_cd'          => null,
            'next_day_depo_cd'       => null,
            'today_delivery_kbn'     => null,
            'today_time_deadline1'   => null,
            'today_time_deadline2'   => null,
            'next_day_delivery_kbn'  => null,
            'next_day_time_deadline' => null,
            'next_day_time_type'     => null,
            'short_delivery_days'    => null,
            'short_delivery_date'    => null,
            'sp_flg'                 => false,
            'anno_trans'             => [],
            'anno_addr'              => [],
            'anno_period'            => [],
            'error_messages'         => [],
        ];
    }

    /**
     * 4．イレギュラー振替先チェック処理
     */
    public function irTransferCheck()
    {
        // [1] 配列初期化
        $this->logger->info("##[1] 配列初期化", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $this->res_ir_trans_list = [];
        $trans_depo_cd = null;
        // [2] イレギュラー振替先チェック
        $this->logger->info("##[2] イレギュラー振替先チェック", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($this->ir_transfer_list as $data) {
            if (
                $data->order_date_type == null
                || ($data->order_date_type == AppConst::ORDER_DATE_TYPE['DAY'] && $data->order_date == $this->api_date['Y-m-d'])
                || ($data->order_date_type == AppConst::ORDER_DATE_TYPE['PERIOD'] && $data->order_date_from <= $this->api_date['Y-m-d'] && $data->order_date_to >= $this->api_date['Y-m-d'])
                || ($data->order_date_type == AppConst::ORDER_DATE_TYPE['WEEK'] && $data->date_type == AppConst::DATE_TYPE['ORDER_DATE'] && isset($this->order_date_week[$this->api_date['Ymd']]) && $data->public_holiday_status == $this->order_date_week[$this->api_date['Ymd']]->public_holiday_status)
            ) {
                if ($this->request->input('procKbn') == AppConst::PROCKBN['TIME_TABLE'] && empty($data->delivery_date_type)) {
                    $trans_depo_cd = $data->trans_depo_cd;
                    $this->res_ir_trans_list[] = $data;
                    break;
                } elseif (
                        $this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK']
                        && (
                            $data->delivery_date_type == null
                            || ($data->delivery_date_type == AppConst::DELIVERY_DATE_TYPE['DAY'] && $data->delivery_date == $this->request->input('aDate'))
                            || ($data->delivery_date_type == AppConst::DELIVERY_DATE_TYPE['PERIOD'] && $data->delivery_date_from <= $this->request->input('aDate') && $data->delivery_date_to >= $this->request->input('aDate'))
                            || ($data->delivery_date_type == AppConst::DELIVERY_DATE_TYPE['WEEK'] && $data->date_type == AppConst::DATE_TYPE['DELIVERY_DATE'] && isset($this->delivery_date_week[$this->api_date['Ymd']]) && $data->public_holiday_status == $this->delivery_date_week[$this->api_date['Ymd']]->public_holiday_status)
                        )
                    ) {
                    $trans_depo_cd = $data->trans_depo_cd;
                    $this->res_ir_trans_list[] = $data;
                    break;
                }
            }
        }

        // [3] イレギュラー振替先結果リストの件数判定
        $this->logger->info("##[3] イレギュラー振替先結果リストの件数判定", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $trans_depo_cd]);
        $this->wk['trans_depo_cd'] = $trans_depo_cd;
        return ($trans_depo_cd) ? true : false;
    }

    /**
     * 5．住所・商品紐づけ情報検索
     */
    public function findAddressItemRelation()
    {
        $count = $this->getAddressItemRelation();
        if ($count == 0) {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT_ALWAYS'];
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['NOT'];
            $this->wk['anno_addr'][] = '指定された住所への配達は行っておりません。';
        }
        return ($count == 0) ? true : false;
    }

    /**
     * 6．当日配送デポ引き当て処理
     */
    public function todayDeliveryDepoAllocation()
    {
        // [1] 配列初期化
        $this->logger->info("##[1] 配列初期化", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $area_delivery_depo = [];
        $depo_cds = [];
        $displays = [];
        // [2] 有効デポリスト
        $this->logger->info("##[2] 有効デポリスト", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => count($this->use_depo_list)."件"]);
        foreach ($this->use_depo_list as $items) {
            // デフォルト有効デポ情報のエリア当配可否が可能ならエリア当日配送可能デポリストにデフォルト有効デポ情報を追加
            if ($items->is_area_today_delivery_flg === true) {
                $area_delivery_depo[$items->depo_cd] = $items;
                $depo_cds[] = $items->depo_cd;
                $displays[$items->depo_cd] = $items->display_type;
            }
        }

        // エリア当日配送可能デポリスト件数チェック ※0件なら終了
        if (count($area_delivery_depo) > 0) {

            // [3] 6.通常デポカレンダー引き当て情報取得
            $this->logger->info("##[3] 6.通常デポカレンダー引き当て情報取得", ['file' => basename(__FILE__), 'line' => __LINE__]);
            $cond = [
                'depo_cd'  => $depo_cds,
                'api_date' => $this->api_date['Ymd'],
            ];
            $use_today_cal_list = $this->_getNormalDepoCalAllocation((object)$cond, $this->sysid);
            // 当日カレンダー可能デポCDリスト件数チェック ※0件なら終了
            if (count($use_today_cal_list) == 0) {
                $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT'];
                return true;
            }

            $use_today_cal_list_tmp = [];
            foreach ($use_today_cal_list as $key => $datas) {
                // [5]←確認用配列
                $use_today_cal_list_tmp[] = $datas->depo_cd;

                switch ($datas->today_delivery_flg) {
                    case AppConst::TODAY_DELIVERY_FLG['YES']:
                        $this->res_depo_cal_transfer_list[] = $datas;
                        if ($displays[$datas->depo_cd] == AppConst::DISPLAY_TYPE['SP']) {
                            $this->wk['sp_flg'] = true;
                        }
                        break;
                    case AppConst::TODAY_DELIVERY_FLG['TIME']:
                        if (isset($area_delivery_depo[$datas->depo_cd])) {
                            // 当日配送締め時間上書き
                            $area_delivery_depo[$datas->depo_cd]->today_time_deadline1 = $datas->today_deadline_limit_time;
                        }
                        $this->res_depo_cal_transfer_list[] = $datas;
                        if ($displays[$datas->depo_cd] == AppConst::DISPLAY_TYPE['SP']) {
                            $this->wk['sp_flg'] = true;
                        }
                        break;
                    default:
                        $this->res_depo_cal_transfer_list[] = $datas;
                        unset($use_today_cal_list[$key], $use_today_cal_list_tmp[$key]);
                        break;
                }
            }
        } else {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT_ALWAYS'];
            return true;
        }
        // [4] 当配デポ候補リスト
        $this->logger->info("##[4] 当配デポ候補リスト", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $candidate_list = [];
        // [5] 当配デポ候補リスト作成
        $this->logger->info("##[5] 当配デポ候補リスト作成", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($area_delivery_depo as $datas) {
            if (!in_array($datas->depo_cd, $use_today_cal_list_tmp)
                || ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && ($this->api_time > $datas->today_time_deadline1 || $this->api_time > $datas->today_time_deadline2))
            ) {
                continue;
            }
            $candidate_list[] = $datas;
        }
        // [6] 当配デポ候補リスト件数チェック
        $this->logger->info("##[6] 当配デポ候補リスト件数チェック", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if (count($candidate_list) == 0) {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT'];
            return true;
        }
        // [7] 当配デポ候補リストを当配締切の遅い順にソート
        $this->logger->info("##[7] 当配デポ候補リストを当配締切の遅い順にソート", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($candidate_list as $datas) {
            $display_group_type_array[] = $datas->display_group_type;
            $today_time_deadline1_array[] = $datas->today_time_deadline1;
            $today_time_deadline2_array[] = $datas->today_time_deadline2;
        }
        array_multisort(
            $display_group_type_array,
            SORT_ASC,
            SORT_NUMERIC,
            $today_time_deadline1_array,
            SORT_DESC,
            SORT_NATURAL,
            $today_time_deadline2_array,
            SORT_DESC,
            SORT_NATURAL,
            $candidate_list
        );
        // [8] 確定当日デポ情報にNULLを設定
        // $confirm_today_depo = null;
        // [9] 受注可能デポリスト
        $this->logger->info("##[9] 受注可能デポリスト", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $this->use_order_depo_list = [];
        // [10] 受注可能デポリスト作成
        $this->logger->info("##[10] 受注可能デポリスト作成", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($candidate_list as $datas) {
            // 12．イレギュラー_受注不可チェック処理
            list(
                $res_flg,
                $res_time_select,
                $res_is_personal_delivery_flg,
                $res_is_today_deadline_undeliv_flg
            ) = $this->irNotOrderCheck($datas->depo_cd, $this->api_date['Y-m-d']);

            // 受注不可エラーフラグが不可の場合次へ
            if ($res_flg === true) {
                continue;
            }
            // 個人宅フラグが不可の場合
            if ($res_is_personal_delivery_flg === true) {
                if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('phFlg') === true) {
                    continue;
                }
                $datas->private_home_flg = false;
            }
            // 受注可能デポリストに格納
            $this->use_order_depo_list[] = $datas;
        }
        // [11] 受注可能デポリストの件数チェック
        $this->logger->info("##[11] 受注可能デポリストの件数チェック", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if (count($this->use_order_depo_list) == 0) {
            // 当配不可
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT'];
            return true;
        }
        // [12] 候補当日デポ・確定当日デポ作成
        $this->logger->info("##[12] 候補当日デポ・確定当日デポ作成", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($this->use_order_depo_list as $datas) {
            // 振替先郵便デポCD確認用
            $transfer_post_depo_cds[] = $datas->transfer_post_depo_cd;
        }
        // 候補当日デポ・確定当日デポ
        $candidate_day_depo = "";
        $comp_day_depo = "";
        foreach ($this->use_order_depo_list as $datas) {
            // 13．イレギュラー_配送不可チェック処理
            list(
                $res_flg,
                $res_is_before_deadline_undeliv_flg,
                $res_is_today_deadline_undeliv_flg,
                $res_is_time_select_undeliv_flg,
                $res_is_personal_delivery_flg
            ) = $this->irNotDeliveryCheck($datas->depo_cd, $this->api_date['Y-m-d']);

            // 配送不可フラグが不可の場合次へ
            if ($res_flg === true) {
                continue;
            }
            // 個人宅不可フラグが不可の場合
            if ($res_is_personal_delivery_flg === true) {
                // 既に候補当日デポ＋確定当日デポが設定済みなら処理しない
                if ($candidate_day_depo && $comp_day_depo) {
                    continue;
                }

                if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('phFlg') === true) {
                    continue;
                }
                if ($datas->display_type == AppConst::DISPLAY_TYPE['SP']) {
                    $this->wk['sp_flg'] = true;
                    continue;
                }
                // 処理中デポCDが振替先郵便デポCDに含まれている場合
                if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                    // 候補当日デポ
                    if (empty($candidate_day_depo)) {
                        $candidate_day_depo = $datas;
                    }
                    continue;
                } else {
                    // 確定当日デポ
                    if (empty($comp_day_depo)) {
                        $comp_day_depo = $datas;
                    }
                    continue;
                }
            } else {
                if ($datas->display_type == AppConst::DISPLAY_TYPE['SP']) {
                    $this->wk['sp_flg'] = true;
                    continue;
                } else {
                    // 既に候補当日デポ＋確定当日デポが設定済みなら処理しない
                    if ($candidate_day_depo && $comp_day_depo) {
                        continue;
                    }

                    // 処理中デポCDが振替先郵便デポCDに含まれている場合
                    if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                        // 候補当日デポ
                        if (empty($candidate_day_depo)) {
                            $candidate_day_depo = $datas;
                        }
                        continue;
                    } else {
                        // 確定当日デポ
                        if (empty($comp_day_depo)) {
                            $comp_day_depo = $datas;
                        }
                        continue;
                    }
                }
            }
        }
        // [13] 確定当日デポおよび候補当日デポを判定
        $this->logger->info("##[13] 確定当日デポおよび候補当日デポを判定", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if (empty($candidate_day_depo) && empty($comp_day_depo)) {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT'];
        } elseif ($comp_day_depo) {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['YES'];
            $this->wk['today_time_deadline1'] = $comp_day_depo->today_time_deadline1;
            $this->wk['today_time_deadline2'] = $comp_day_depo->today_time_deadline2;
            $this->wk['today_depo_cd'] = $comp_day_depo->depo_cd;
        } else {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['YES'];
            $this->wk['today_time_deadline1'] = $candidate_day_depo->today_time_deadline1;
            $this->wk['today_time_deadline2'] = $candidate_day_depo->today_time_deadline2;
            $this->wk['today_depo_cd'] = $candidate_day_depo->depo_cd;
        }

        return true;
    }

    /**
     * 7．翌日配送デポ引き当て処理
     */
    public function nextDayDeliveryDepoAllocation()
    {
        // [1]  7.通常デポ翌日カレンダー引き当て情報取得
        $this->logger->info("##[1]  7.通常デポ翌日カレンダー引き当て情報取得", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($this->use_depo_list as $items) {
            // デフォルト有効デポ
            $depo_cds[] = $items->depo_cd;
            $tmp_before_delivery_depo_list[$items->depo_cd] = $items;
        }
        $cond = [
            'depo_cds'  => $depo_cds,
            'delivery_date' => $this->api_date_nextday['Ymd'],
        ];
        // 翌日カレンダー可能デポCDリスト 7.通常デポ翌日カレンダー引き当て情報取得
        $use_nextday_cal_list = $this->_getNormalDepoNextCalAllocation((object)$cond, $this->sysid);

        // [2] 翌日カレンダー可能デポCDリスト件数判定
        $this->logger->info("##[2] 翌日カレンダー可能デポCDリスト件数判定", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $before_candidate_list = [];
        if (count($use_nextday_cal_list) == 0) {
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['NOT'];
        } else {
            foreach ($use_nextday_cal_list as $datas) {
                switch ($datas->before_deadline_flg) {
                    case AppConst::BEFORE_DEADLINE_FLG['YES']:
                        // 前日配送候補デポリスト
                        if (isset($tmp_before_delivery_depo_list[$datas->depo_cd])) {
                            $before_candidate_list[] = $tmp_before_delivery_depo_list[$datas->depo_cd];
                        }
                        $this->res_depo_cal_transfer_list[] = $datas;
                        break;
                    case AppConst::BEFORE_DEADLINE_FLG['TIME']:
                        if (isset($tmp_before_delivery_depo_list[$datas->depo_cd])) {
                            $tmp_before_delivery_depo_list[$datas->depo_cd]->next_day_time_deadline = $datas->before_deadline_limit_time;
                            $before_candidate_list[] = $tmp_before_delivery_depo_list[$datas->depo_cd];
                        }
                        $this->res_depo_cal_transfer_list[] = $datas;
                        break;
                    default:
                        $this->res_depo_cal_transfer_list[] = $datas;
                        break;
                }
            }

            // 前日配送候補デポリスト件数チェック
            $this->logger->info("##前日配送候補デポリスト件数チェック", ['file' => basename(__FILE__), 'line' => __LINE__]);
            if (count($before_candidate_list) == 0) {
                $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT'];
                return true;
            }
            // 前日配送候補デポリストを翌日配送締切時間の遅い順にソート
            $this->logger->info("##前日配送候補デポリストを翌日配送締切時間の遅い順にソート", ['file' => basename(__FILE__), 'line' => __LINE__]);
            foreach ($before_candidate_list as $datas) {
                $next_day_time_deadline_array[] = $datas->next_day_time_deadline;
            }
            array_multisort(
                $next_day_time_deadline_array,
                SORT_DESC,
                SORT_NUMERIC,
                $before_candidate_list
            );
            // 翌日確定デポ情報
            // $confirm_nextday_depo = [];
            //
            // 翌日時間指定リスト
            $this->logger->info("##翌日時間指定リスト作成", ['file' => basename(__FILE__), 'line' => __LINE__]);
            $time2time = Config::get('leadtimeapi.time2time_next_day_time_type');
            $time2str_next_day_time_type = Config::get('leadtimeapi.time2str_next_day_time_type');
            foreach ($before_candidate_list as $key => $datas) {
                // 12．イレギュラー_受注不可チェック処理
                list(
                    $res_flg,
                    $res_time_select,
                    $res_is_personal_delivery_flg,
                    $res_is_today_deadline_undeliv_flg
                ) = $this->irNotOrderCheck($datas->depo_cd, $this->api_date_nextday['Y-m-d']);
                // 受注不可エラーフラグが不可の場合
                if ($res_flg === true) {
                    // 時間指定
                    if (!empty($res_time_select)) {
                        // 翌日時間指定上書き変換
                        $datas->next_day_time_type = $time2time[$datas->next_day_time_type];
                        $datas->next_day_time_type_str = $time2str_next_day_time_type[$datas->next_day_time_type];
                    }
                    // 個人宅不可フラグ
                    if ($res_is_personal_delivery_flg === true) {
                        if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('phFlg') == true) {
                            continue;
                        }
                        // 受注可能デポリスト 前日配送候補デポ情報の個人宅可フラグをfalse: 不可に設定
                        $datas->is_personal_delivery = false;
                        $this->use_order_depo_list[] = $datas;
                    } else {
                        // 受注可能デポリスト
                        $this->use_order_depo_list[] = $datas;
                    }
                } else {
                    // 受注可能デポリスト
                    $this->use_order_depo_list[] = $datas;
                }
            }
            // 受注可能デポリスト処理
            $this->logger->info("##受注可能デポリスト処理", ['file' => basename(__FILE__), 'line' => __LINE__]);
            foreach ($this->use_order_depo_list as $datas) {
                // 振替先郵便デポCD確認用
                $transfer_post_depo_cds[] = $datas->transfer_post_depo_cd;
            }
            // 候補翌日デポ・確定翌日デポ
            $candidate_nextday_depo = [];
            $comp_nextday_depo = [];
            foreach ($this->use_order_depo_list as $datas) {
                // 13．イレギュラー_配送不可チェック処理
                list(
                    $res_flg,
                    $res_is_before_deadline_undeliv_flg,
                    $res_is_today_deadline_undeliv_flg,
                    $res_is_time_select_undeliv_flg,
                    $res_is_personal_delivery_flg
                ) = $this->irNotDeliveryCheck($datas->depo_cd, $this->api_date_nextday['Y-m-d']);
                // 配送不可エラーフラグがtrueの場合
                if ($res_flg === true) {
                    // 前日締切不可フラグが不可の場合
                    if ($res_is_before_deadline_undeliv_flg === true) {
                        continue;
                    }
                    // 時間指定不可フラグが不可かつ個人宅不可フラグ可の場合
                    if ($res_is_time_select_undeliv_flg === true && $res_is_personal_delivery_flg === false) {
                        if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('aTime') != 'その日中') {
                            continue;
                        }
                        // 対象のデポCDが受注可能デポリスト内の振替先郵便デポCDに存在する場合
                        if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                            // 候補翌日デポ
                            if (empty($candidate_nextday_depo)) {
                                $datas->next_day_time_deadline = 'その日中';
                                $candidate_nextday_depo[] = $datas;
                            }
                        } else {
                            // 確定翌日デポ
                            $datas->next_day_time_deadline = 'その日中';
                            $comp_nextday_depo[] = $datas;
                        }
                        continue;
                    }
                    // 時間指定不可フラグが不可かつ個人宅不可フラグが不可の場合
                    if ($res_is_time_select_undeliv_flg === true && $res_is_personal_delivery_flg === true) {
                        if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && ($this->request->input('aTime') != 'その日中' || $this->request->input('phFlg') === true)) {
                            continue;
                        } else {
                            // 対象のデポCDが受注可能デポリスト内の振替先郵便デポCDに存在する場合
                            if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                                // 候補翌日デポ
                                if (empty($candidate_nextday_depo)) {
                                    $datas->next_day_time_deadline = 'その日中';
                                    $datas->private_home_flg = false;
                                    $candidate_nextday_depo[] = $datas;
                                }
                            } else {
                                // 確定翌日デポ
                                $datas->next_day_time_deadline = 'その日中';
                                $datas->private_home_flg = false;
                                $comp_nextday_depo[] = $datas;
                            }
                            continue;
                        }
                    }
                    // 時間指定不可フラグ = false” かつ、”個人宅不可フラグ = true:不可”の場合
                    elseif ($res_is_time_select_undeliv_flg === false && $res_is_personal_delivery_flg === true) {
                        if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('phFlg') === true) {
                            continue;
                        } else {
                            // 対象のデポCDが受注可能デポリスト内の振替先郵便デポCDに存在する場合
                            if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                                // 候補翌日デポ
                                if (empty($candidate_nextday_depo)) {
                                    $datas->next_day_time_deadline = 'その日中';
                                    $datas->private_home_flg = false;
                                    $candidate_nextday_depo[] = $datas;
                                }
                            } else {
                                // 確定翌日デポ
                                $datas->next_day_time_deadline = 'その日中';
                                $datas->private_home_flg = false;
                                $comp_nextday_depo[] = $datas;
                            }
                            continue;
                        }
                    } else {
                        // 対象のデポCDが受注可能デポリスト内の振替先郵便デポCDに存在する場合
                        if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                            // 候補翌日デポ
                            if (empty($candidate_nextday_depo)) {
                                $candidate_nextday_depo[] = $datas;
                            }
                        } else {
                            // 確定翌日デポ
                            $comp_nextday_depo[] = $datas;
                        }
                        continue;
                    }
                }
                // 配送不可エラーフラグがfalse かつ、変数：確定翌日デポが空の場合
                if ($res_flg === false && count($comp_nextday_depo) == 0) {
                    // 対象のデポCDが受注可能デポリスト内の振替先郵便デポCDに存在する場合
                    if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                        // 候補翌日デポ
                        if (empty($candidate_nextday_depo)) {
                            $candidate_nextday_depo[] = $datas;
                        }
                    } else {
                        // 確定翌日デポ
                        $comp_nextday_depo[] = $datas;
                    }
                    continue;
                }
            }
            // リクエストパラメーター_処理区分 = 2の場合、確定翌日デポおよび候補翌日デポの翌日時間指定チェック
            $this->logger->info("##リクエストパラメーター_処理区分 = 2の場合、確定翌日デポおよび候補翌日デポの翌日時間指定チェック", ['file' => basename(__FILE__), 'line' => __LINE__]);
            if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK']) {
                // 候補翌日デポチェック
                if (count($candidate_nextday_depo) > 0) {
                    $candidate_nextday_depo = $this->checkNextDayTimes($candidate_nextday_depo);
                }
                // 確定翌日デポチェック
                if (count($comp_nextday_depo) > 0) {
                    $comp_nextday_depo = $this->checkNextDayTimes($comp_nextday_depo);
                }
            }
            // 候補翌日デポおよび確定翌日デポを判定
            $this->logger->info("##候補翌日デポおよび確定翌日デポを判定", ['file' => basename(__FILE__), 'line' => __LINE__]);
            if (empty($candidate_nextday_depo) && empty($comp_nextday_depo)) {
                $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['NOT'];
                $this->wk['error_messages'] = 'お届け希望時間指定ができません。（ご希望の日時までのお届けは出来ません）';
            } elseif ($comp_nextday_depo) {
                $comp_nextday_depo = current($comp_nextday_depo);
                $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['YES'];
                $this->wk['next_day_time_deadline'] = $comp_nextday_depo->next_day_time_deadline;
                $this->wk['next_day_time_type'] = $comp_nextday_depo->next_day_time_type;
                $this->wk['next_day_depo_cd'] = $comp_nextday_depo->depo_cd;
            } else {
                $candidate_nextday_depo = current($candidate_nextday_depo);
                $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['YES'];
                $this->wk['next_day_time_deadline'] = $candidate_nextday_depo->next_day_time_deadline;
                $this->wk['next_day_time_type'] = $candidate_nextday_depo->next_day_time_type;
                $this->wk['next_day_depo_cd'] = $candidate_nextday_depo->depo_cd;
            }
        }

        return true;
    }

    /**
     * 8．サプライズデポカレンダー確認処理
     */
    public function spDepoCalender()
    {
        // [1] 8.サプライズデポカレンダー引き当て情報取得＿１
        $this->logger->info("##[1] 8.サプライズデポカレンダー引き当て情報取得＿１", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($this->use_depo_list as $items) {
            $tmp_use_sp_delivery_list[$items->depo_cd] = $items;
            $depo_cds[] = $items->depo_cd;
        }
        $cond = [
            'depo_cds'      => $depo_cds,
            'pref_cd'       => $this->request->input('aPref'),
            'siku'          => $this->request->input('aSiku'),
            'tyou'          => $this->request->input('aTyou'),
            'delivery_date' => $this->api_date['Ymd'],
        ];
        // 当日配送可能リスト作成
        $use_today_delivery = $this->_getSpDepoNextCalAllocation((object)$cond, $this->sysid);
        // [2] 当日配送可能リスト件数チェック
        $this->logger->info("##[2] 当日配送可能リスト件数チェック", ['file' => basename(__FILE__), 'line' => __LINE__]);
        // サプライズ配送可能デポリスト
        $use_sp_delivery_list = [];
        if (count($use_today_delivery) == 0) {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT'];
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['YES'];
        } else {
            foreach ($use_today_delivery as $datas) {
                if (
                    (
                        $datas->today_delivery_flg == AppConst::TODAY_DELIVERY_FLG['YES']
                        && ($datas->today_time_deadline1 > $this->api_date['Y-m-d'] || $datas->today_time_deadline2 > $this->api_date['Y-m-d'])
                    )
                    || ($datas->today_delivery_flg == AppConst::TODAY_DELIVERY_FLG['TIME'] && $datas->today_deadline_limit_time > $this->api_date['Y-m-d'])
                ) {
                    switch ($datas->today_delivery_flg) {
                        case AppConst::TODAY_DELIVERY_FLG['YES']:
                            if (isset($tmp_use_sp_delivery_list[$datas->depo_cd])) {
                                $use_sp_delivery_list[] = $tmp_use_sp_delivery_list[$datas->depo_cd];
                            }
                            $this->res_depo_cal_transfer_list[] = $datas;
                            break;
                        case AppConst::TODAY_DELIVERY_FLG['TIME']:
                            if (isset($tmp_use_sp_delivery_list[$datas->depo_cd])) {
                                $tmp_use_sp_delivery_list[$datas->depo_cd]->today_time_deadline1 = $datas->today_deadline_limit_time;
                                $use_sp_delivery_list[] = $tmp_use_sp_delivery_list[$datas->depo_cd];
                            }
                            $this->res_depo_cal_transfer_list[] = $datas;
                            break;
                        default:
                            $this->res_depo_cal_transfer_list[] = $datas;
                            break;
                    }
                } else {
                    // 既に翌日配送可能リストがあれば次のデータへ
                    if (isset($use_nextday_delivery)) {
                        continue;
                    }
                    // 9.サプライズデポカレンダー引き当て情報取得＿２
                    $cond = [
                        'depo_cd'       => $datas->depo_cd,
                        'delivery_date'     => $this->api_date_nextday['Ymd'],
                    ];
                    // 翌日配送可能リスト
                    $use_nextday_delivery = $this->_getSpDepoNextCalAllocation2((object)$cond, $this->sysid);
                    // 翌日配送可能リスト件数チェック
                    if (count($use_nextday_delivery) == 0) {
                        continue;
                    } else {
                        // サプライズ配送可能デポリストに設定
                        if (isset($tmp_use_sp_delivery_list[$datas->depo_cd])) {
                            $use_sp_delivery_list[] = $tmp_use_sp_delivery_list[$datas->depo_cd];
                        }
                        $this->res_depo_cal_transfer_list[] = $datas;
                    }
                }
            }
        }
        // [3] サプライズ配送可能デポリストの件数判定
        $this->logger->info("##[3] サプライズ配送可能デポリストの件数判定", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if (count($use_sp_delivery_list) == 0) {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT'];
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['YES'];
        }
        $today_time_deadline1_array = [];
        // [4] サプライズ配送可能デポリストを当日配達締め時間１が遅い順にソート
        $this->logger->info("##[4] サプライズ配送可能デポリストを当日配達締め時間１が遅い順にソート", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($use_sp_delivery_list as $datas) {
            $today_time_deadline1_array[] = $datas->today_time_deadline1;
        }
        array_multisort(
            $today_time_deadline1_array,
            SORT_DESC,
            $use_sp_delivery_list
        );
        // [5] 確定サプライズデポ情報を空の配列で初期化

        // [6] サプライズ配送可能デポリスト処理
        $this->logger->info("##[6] サプライズ配送可能デポリスト処理", ['file' => basename(__FILE__), 'line' => __LINE__]);
        // 受注可能デポリスト
        $this->use_order_depo_list = [];
        foreach ($use_sp_delivery_list as $datas) {
            // 12．イレギュラー_受注不可チェック処理
            list(
                $res_flg,
                $res_time_select,
                $res_is_personal_delivery_flg,
                $res_is_today_deadline_undeliv_flg
            ) = $this->irNotOrderCheck($datas->depo_cd, $this->api_date['Y-m-d']);
            // 受注不可エラーフラグがTRUEの場合
            if ($res_flg === true) {
                // 当日配送不可フラグ = true:不可 の場合
                if ($res_is_today_deadline_undeliv_flg === true) {
                    continue;
                }
                // 個人宅不可フラグ = trueの場合
                if ($res_is_personal_delivery_flg === true) {
                    if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('phFlg') === true) {
                        continue;
                    } else {
                        // 受注可能デポリスト
                        $datas->is_personal_delivery = false;
                        $this->use_order_depo_list[] = $datas;
                    }
                } else {
                    // 受注可能デポリスト
                    $this->use_order_depo_list[] = $datas;
                }
            } else {
                // 受注可能デポリスト
                $this->use_order_depo_list[] = $datas;
            }
        }

        // [7] 受注可能デポリスト処理
        $this->logger->info("##[7] 受注可能デポリスト処理", ['file' => basename(__FILE__), 'line' => __LINE__]);
        // 候補サプライズデポ情報・確定サプライズデポ情報
        $candidate_sp_depo = [];
        $comp_sp_depo = [];
        // 受注可能デポリスト処理
        foreach ($this->use_order_depo_list as $datas) {
            // 振替先郵便デポCD確認用
            $transfer_post_depo_cds[] = $datas->transfer_post_depo_cd;
        }

        foreach ($this->use_order_depo_list as $datas) {
            // 13．イレギュラー_配送不可チェック処理
            list(
                $res_flg,
                $res_is_before_deadline_undeliv_flg,
                $res_is_today_deadline_undeliv_flg,
                $res_is_time_select_undeliv_flg,
                $res_is_personal_delivery_flg
            ) = $this->irNotDeliveryCheck($datas->depo_cd, $this->request->input('aDate'));
            // 配送不可エラーフラグがtrue の場合

            if ($res_flg === true) {
                // 当日配送不可フラグ = true:不可 の場合
                if ($res_is_today_deadline_undeliv_flg === true) {
                    continue;
                }
                // 個人宅不可フラグ” = true:不可 かつ、変数：確定サプライズデポ情報が空の場合
                if ($res_is_personal_delivery_flg === true && count($comp_sp_depo) == 0) {
                    if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('phFlg') === true) {
                        continue;
                    } else {
                        // 対象のデポCDが受注可能デポリスト内の振替先郵便デポCDに存在する場合
                        if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                            // 候補サプライズデポ
                            if (empty($candidate_sp_depo)) {
                                $datas->private_home_flg = false;
                                $candidate_sp_depo = $datas;
                            }
                        } else {
                            // 確定サプライズデポ
                            $datas->private_home_flg = false;
                            $comp_sp_depo = $datas;
                            break;
                        }
                    }
                } else {
                    // 対象のデポCDが受注可能デポリスト内の振替先郵便デポCDに存在する場合
                    if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                        // 候補サプライズデポ
                        if (empty($candidate_sp_depo)) {
                            $candidate_sp_depo = $datas;
                        }
                    } else {
                        // 確定サプライズデポ
                        $comp_sp_depo = $datas;
                        break;
                    }
                }
            }
            // 個人宅不可フラグ” = false かつ、変数：確定サプライズデポ情報がNULLの場合
            if ($res_is_personal_delivery_flg === false && count($comp_sp_depo) == 0) {
                // 対象のデポCDが受注可能デポリスト内の振替先郵便デポCDに存在する場合
                if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                    // 候補サプライズデポ
                    if (empty($candidate_sp_depo)) {
                        $candidate_sp_depo = $datas;
                    }
                } else {
                    // 確定サプライズデポ
                    $comp_sp_depo = $datas;
                    break;
                }
            }
        }

        // [8] 確定サプライズデポ情報と候補サプライズデポ情報を判定
        $this->logger->info("##[8] 確定サプライズデポ情報と候補サプライズデポ情報を判定", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if (empty($candidate_sp_depo) && empty($comp_sp_depo)) {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['NOT'];
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['YES'];
        } elseif ($comp_sp_depo) {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['3_HOURS'];
            $this->wk['today_time_deadline1'] = $comp_sp_depo->today_time_deadline1;
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['YES'];
            $this->wk['today_depo_cd'] = $comp_sp_depo->depo_cd;
        } else {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['3_HOURS'];
            $this->wk['today_time_deadline1'] = $candidate_sp_depo->today_time_deadline1;
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['YES'];
            $this->wk['today_depo_cd'] = $candidate_sp_depo->depo_cd;
        }
    }

    /**
     * 9．エンタメデポカレンダー確認処理
     */
    public function etmDepoCalender()
    {
        // [1] 有効デポリスト処理
        $this->logger->info("##[1] 有効デポリスト処理", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($this->use_depo_list as $key => $datas) {
            // 最短届日
            $this->use_depo_list[$key]->short_delivery_date = date('Y-m-d');
            // 10.エンタメデポカレンダー最短作業日取得
            $cond = [
                'depo_cd'  => $datas->depo_cd,
                'api_date' => $this->api_date['Ymd'],
                'api_date_nextday' => $this->api_date_nextday['Ymd']
            ];
            $depos = $this->_getEtmDepoCalWorkDay((object)$cond, $this->sysid);
            foreach ($depos as $data) {
                // 取得した日付を判定し有効デポ情報に設定
                if (
                    $data->delivery_date == $this->api_date['Ymd']
                    && (
                        ($data->before_deadline_flg == AppConst::BEFORE_DEADLINE_FLG['YES'] && $data->before_deadline_limit_time > $this->api_time)
                        || ($data->before_deadline_flg == AppConst::BEFORE_DEADLINE_FLG['TIME'] && $data->before_deadline_limit_time > $this->api_time)
                    )
                ) {
                    // デポカレンダー期間注釈リストに”申込画面表示注釈（表示）”の値を設定
                    $this->res_depo_cal_transfer_list[] = $data;
                    continue;
                } else {
                    switch ($data->before_deadline_flg) {
                        case AppConst::BEFORE_DEADLINE_FLG['YES']:
                            // 取得した日付を最短可能作業日として有効デポ情報に設定
                            $this->use_depo_list[$key]->short_work_date = $data->delivery_date;
                            // 最短可能作業日に有効デポ情報のデポリードタイムを足した日付を最短届日として有効デポ情報に設定
                            $leadtime = $this->use_depo_list[$key]->depo_lead_time;
                            $this->use_depo_list[$key]->short_delivery_date = date('Y-m-d', strtotime("+{$leadtime} day", strtotime($this->use_depo_list[$key]->short_work_date)));
                            // デポカレンダー期間注釈リストに”申込画面表示注釈（表示）”の値を設定
                            $this->res_depo_cal_transfer_list[] = $data;
                            break;
                        case AppConst::BEFORE_DEADLINE_FLG['TIME']:
                            // 取得した日付を最短可能作業日として有効デポ情報に設定
                            $this->use_depo_list[$key]->short_delivery_days = $data->delivery_date;
                            // 最短可能作業日に有効デポ情報のデポリードタイムを足した日付を最短届日として有効デポ情報に設定
                            $leadtime = $this->use_depo_list[$key]->depo_lead_time;
                            $this->use_depo_list[$key]->short_delivery_date = date('Y-m-d', strtotime("+{$leadtime} day", strtotime($this->use_depo_list[$key]->short_work_date)));
                            // 取得した”前日締切締め時間”で有効デポ情報の”翌日配送締切時間を上書
                            $this->use_depo_list[$key]->next_day_time_deadline = $data->before_deadline_limit_time;
                            // デポカレンダー期間注釈リストに”申込画面表示注釈（表示）”の値を設定
                            $this->res_depo_cal_transfer_list[] = $data;
                            break;
                        default:
                            // デポカレンダー期間注釈リストに”申込画面表示注釈（表示）”の値を設定
                            $this->res_depo_cal_transfer_list[] = $data;
                            break;
                    }
                    // 次のデポデータへ
                    break;
                }
            }
        }
        // [2] 最短届日が早い順にソート
        $this->logger->info("##[2] 最短届日が早い順にソート", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($this->use_depo_list as $datas) {
            $short_delivery_date[] = $datas->short_delivery_date;
        }
        array_multisort(
            $short_delivery_date,
            SORT_ASC,
            SORT_NUMERIC,
            $this->use_depo_list
        );

        // 最短届日 > リクエストパラメーター_お届け希望日”のデータは破棄
        foreach ($this->use_depo_list as $key => $datas) {
            if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $datas->short_delivery_date > $this->request->input('aDate')) {
                unset($this->use_depo_list[$key]);
            }
        }
        // [3] 候補エンタメデポ情報・確定エンタメデポ情報

        // [4]
        $this->logger->info("##候補エンタメデポ情報・確定エンタメデポ情報作成", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $time2time = Config::get('leadtimeapi.time2time_next_day_time_type');
        $time2str_next_day_time_type = Config::get('leadtimeapi.time2str_next_day_time_type');
        foreach ($this->use_depo_list as $datas) {
            $date = date('Y-m-d', strtotime($datas->short_delivery_date));
            // リクエストパラメーター_処理区分 = 2”の場合はデポCDとリクエストパラメータ_お届け希望日をパラメータで実行
            if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK']) {
                $date = $this->request->input('aDate');
            }
            // 12．イレギュラー_受注不可チェック処理
            list(
                $res_flg,
                $res_time_select,
                $res_is_personal_delivery_flg,
                $res_is_today_deadline_undeliv_flg
            ) = $this->irNotOrderCheck($datas->depo_cd, $date);
            // 受注不可エラーフラグがTRUEの場合
            if ($res_flg === true) {
                // 時間指定
                if (!empty($res_time_select)) {
                    // 翌日時間指定上書き変換
                    $datas->next_day_time_type = $time2time[$datas->next_day_time_type];
                    $datas->next_day_time_type_str = $time2str_next_day_time_type[$datas->next_day_time_type];
                }
                // 個人宅不可フラグ
                if ($res_is_personal_delivery_flg === true) {
                    if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('phFlg') == true) {
                        continue;
                    }
                    // 受注可能デポリスト 前日配送候補デポ情報の個人宅可フラグをfalse: 不可に設定
                    $datas->is_personal_delivery = false;
                    $this->use_order_depo_list[] = $datas;
                } else {
                    // 受注可能デポリスト
                    $this->use_order_depo_list[] = $datas;
                }
            } else {
                // 受注可能デポリスト
                $this->use_order_depo_list[] = $datas;
            }
        }
        // [5] 受注可能デポリスト処理
        $this->logger->info("##[5] 受注可能デポリスト処理", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($this->use_order_depo_list as $datas) {
            // 振替先郵便デポCD確認用
            $transfer_post_depo_cds[] = $datas->transfer_post_depo_cd;
        }
        // 候補翌日デポ・確定翌日デポ
        $candidate_etm_depo = [];
        $comp_etm_depo = [];
        foreach ($this->use_order_depo_list as $datas) {
            $date = date('Y-m-d', strtotime($datas->short_delivery_date));
            // リクエストパラメーター_処理区分 = 2”の場合はデポCDとリクエストパラメータ_お届け希望日をパラメータで実行
            if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK']) {
                $date = $this->request->input('aDate');
            }
            // 13．イレギュラー_配送不可チェック処理
            list(
                $res_flg,
                $res_is_before_deadline_undeliv_flg,
                $res_is_today_deadline_undeliv_flg,
                $res_is_time_select_undeliv_flg,
                $res_is_personal_delivery_flg
            ) = $this->irNotDeliveryCheck($datas->depo_cd, $date);
            // 配送不可エラーフラグがtrue かつ、変数：確定エンタメデポが空の場合
            if ($res_flg === true && count($comp_etm_depo) == 0) {
                // 前日締切不可フラグが不可の場合
                if ($res_is_before_deadline_undeliv_flg === true) {
                    continue;
                }
                // 時間指定不可フラグが不可かつ個人宅不可フラグ可の場合
                if ($res_is_time_select_undeliv_flg === true && $res_is_personal_delivery_flg === false) {
                    if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('aTime') != 'その日中') {
                        continue;
                    }
                    // 対象のデポCDが受注可能デポリスト内の振替先郵便デポCDに存在する場合
                    if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                        // 候補エンタメデポ
                        if (empty($candidate_nextday_depo)) {
                            $datas->next_day_time_deadline = 'その日中';
                            $candidate_etm_depo[] = $datas;
                        }
                    } else {
                        // 確定エンタメデポ
                        $datas->next_day_time_deadline = 'その日中';
                        $comp_etm_depo[] = $datas;
                    }
                    continue;
                }
                // 時間指定不可フラグが不可かつ個人宅不可フラグが不可の場合
                if ($res_is_time_select_undeliv_flg === true && $res_is_personal_delivery_flg === true) {
                    if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && ($this->request->input('aTime') != 'その日中' || $this->request->input('phFlg') === true)) {
                        continue;
                    } else {
                        // 候補エンタメデポ
                        if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                            if (empty($candidate_etm_depo)) {
                                $datas->next_day_time_deadline = 'その日中';
                                $datas->private_home_flg = false;
                                $candidate_etm_depo[] = $datas;
                            }
                        } else {
                            // 確定エンタメデポ
                            $datas->next_day_time_deadline = 'その日中';
                            $datas->private_home_flg = false;
                            $comp_etm_depo[] = $datas;
                        }
                        continue;
                    }
                }
                // 時間指定不可フラグ = false” かつ、”個人宅不可フラグ = true:不可”の場合
                if ($res_is_time_select_undeliv_flg === false && $res_is_personal_delivery_flg === true) {
                    if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK'] && $this->request->input('phFlg') === true) {
                        continue;
                    } else {
                        if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                            // 候補エンタメデポ
                            if (empty($candidate_etm_depo)) {
                                $datas->private_home_flg = false;
                                $candidate_etm_depo[] = $datas;
                            }
                        } else {
                            // 確定エンタメデポ
                            $datas->private_home_flg = false;
                            $comp_etm_depo[] = $datas;
                        }
                        continue;
                    }
                }
            } else {
                if (in_array($datas->depo_cd, $transfer_post_depo_cds)) {
                    // 候補エンタメデポ
                    if (empty($candidate_etm_depo)) {
                        $candidate_etm_depo[] = $datas;
                    }
                } else {
                    // 確定エンタメデポ
                    $comp_etm_depo[] = $datas;
                }
                continue;
            }
        }
        // [6] リクエストパラメーター_処理区分 = 2の場合、確定エンタメデポおよび候補エンタメデポの翌日時間指定チェック
        $this->logger->info("##[6] リクエストパラメーター_処理区分 = 2の場合、確定エンタメデポおよび候補エンタメデポの翌日時間指定チェック", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if ($this->request->input('procKbn') == AppConst::PROCKBN['ORDER_CHECK']) {
            // 候補翌日デポチェック
            if (count($candidate_etm_depo) > 0) {
                $candidate_etm_depo = $this->checkNextDayTimes($candidate_etm_depo);
            }
            // 確定翌日デポチェック
            if (count($comp_etm_depo) > 0) {
                $comp_etm_depo = $this->checkNextDayTimes($comp_etm_depo);
            }
        }
        // [7] 候補エンタメデポおよび確定エンタメデポを判定
        $this->logger->info("##[7] 候補エンタメデポおよび確定エンタメデポを判定", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if (empty($candidate_etm_depo) && empty($comp_etm_depo)) {
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['YES'];
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['NOT'];
            $this->wk['error_messages'] = 'お届け希望時間指定ができません。（ご希望の日時までのお届けは出来ません）';
        } elseif ($comp_etm_depo) {
            $comp_etm_depo = current($comp_etm_depo);
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['YES'];
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['YES'];
            $this->wk['next_day_time_deadline'] = $comp_etm_depo->next_day_time_deadline;
            $this->wk['next_day_time_type'] = $comp_etm_depo->next_day_time_type;
            $this->wk['short_delivery_date'] = $comp_etm_depo->short_delivery_date;
            $this->wk['short_delivery_days'] = $this->dayDiff($this->api_date['Y-m-d'], $comp_etm_depo->short_delivery_date);
            $this->wk['next_day_depo_cd'] = $comp_etm_depo->depo_cd;
        } else {
            $candidate_etm_depo = current($candidate_etm_depo);
            $this->wk['today_delivery_kbn'] = AppConst::TODAY_DELIVERY_KBN['YES'];
            $this->wk['next_day_delivery_kbn'] = AppConst::NEXT_DAY_DELIVERY_KBN['YES'];
            $this->wk['next_day_time_deadline'] = $candidate_etm_depo->next_day_time_deadline;
            $this->wk['next_day_time_type'] = $candidate_etm_depo->next_day_time_type;
            $this->wk['short_delivery_date'] = $candidate_etm_depo->short_delivery_date;
            $this->wk['short_delivery_days'] = $this->dayDiff($this->api_date['Y-m-d'], $candidate_etm_depo->short_delivery_date);
            $this->wk['next_day_depo_cd'] = $candidate_etm_depo->depo_cd;
        }
        return true;
    }

    /**
     * 10．注釈・エラーメッセージ設定処理
     */
    public function setMessages()
    {
        // [1] イレギュラー振替先結果リストの件数確認
        $this->logger->info("##[1] イレギュラー振替先結果リストの件数確認", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => count($this->res_ir_trans_list)."件"]);
        if (count($this->res_ir_trans_list) > 0) {
            // 振替注釈リストにイレギュラー振替先結果情報のイレギュラーIDと振替注釈を設定
            foreach ($this->res_ir_trans_list as $item) {
                $this->wk['anno_trans'][] = ['irregular_id' => $item->irregular_id, 'anno_trans'   => $item->anno_trans];
            }
        }
        // [2] イレギュラー受注不可結果リストの件数確認
        $this->logger->info("##[2] イレギュラー受注不可結果リストの件数確認", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => count($this->res_ir_order_list)."件"]);
        if (count($this->res_ir_order_list) > 0) {
            foreach ($this->res_ir_order_list as $item) {
                // 赤字表示開始日および赤字表示終了日がどちらもNULL以外で赤字表示開始日<= API起動日 <= 赤字表示終了日 の場合
                if (
                    (!empty($item->anno_from) && !empty($item->anno_to))
                    && ($item->anno_from <= $this->api_date['Y-m-d'] && $this->api_date['Y-m-d'] <= $item->anno_to)
                ) {
                    $this->wk['anno_period'][]    = ['irregular_id' => $item->irregular_id, 'anno_period'    => $item->anno_period];
                    $this->wk['anno_addr'][]      = ['irregular_id' => $item->irregular_id, 'anno_addr'      => $item->anno_addr];
                    $this->wk['error_messages'][] = ['irregular_id' => $item->irregular_id, 'error_messages' => $item->error_message];
                }
            }
        }
        // [3] イレギュラー配送不可結果リストの件数確認
        $this->logger->info("##[3] イレギュラー配送不可結果リストの件数確認", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => count($this->res_ir_delivery_list)."件"]);
        if (count($this->res_ir_delivery_list) > 0) {
            foreach ($this->res_ir_delivery_list as $item) {
                // 赤字表示開始日および赤字表示終了日がどちらもNULL以外で赤字表示開始日<= API起動日 <= 赤字表示終了日 の場合
                if (
                    (!empty($item->anno_from) && !empty($item->anno_to))
                    && ($item->anno_from <= $this->api_date['Y-m-d'] && $this->api_date['Y-m-d'] <= $item->anno_to)
                ) {
                    $this->wk['anno_period'][]    = ['irregular_id' => $item->irregular_id, 'anno_period'    => $item->anno_period];
                    $this->wk['anno_addr'][]      = ['irregular_id' => $item->irregular_id, 'anno_addr'      => $item->anno_addr];
                    $this->wk['error_messages'][] = ['irregular_id' => $item->irregular_id, 'error_messages' => $item->error_message];
                }
            }
        }
        // [4] デポカレンダー期間注釈リストの件数確認
        $this->logger->info("##[4] デポカレンダー期間注釈リストの件数確認", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => count($this->res_depo_cal_transfer_list)."件"]);
        $anno_periods = [];
        if (count($this->res_depo_cal_transfer_list) > 0) {
            foreach ($this->res_depo_cal_transfer_list as $item) {
                $anno_periods[] = $item->annotation_disp;
            }
        }

        // [5] イレギュラーID重複削除 ※IDなければ文言で重複削除
        $this->logger->info("##[5] イレギュラーID重複削除 ※IDなければ文言で重複削除", ['file' => basename(__FILE__), 'line' => __LINE__]);
        foreach ($this->wk as $key => $datas) {
            switch ($key) {
                case 'anno_trans':
                case 'anno_period':
                case 'anno_addr':
                case 'error_messages':
                    $res = [];
                    $unique_id = [];
                    // データなければ終了
                    if (empty($datas)) {
                        break;
                    }
                    foreach ($datas as $items) {
                        // イレギュラーIDが既に存在すれば次へ
                        if (!isset($items['irregular_id']) || in_array($items['irregular_id'], $unique_id)) {
                            continue;
                        }
                        $unique_id[] = $items['irregular_id'];
                        $res[] = $items[$key];
                    }
                    // イレギュラーID昇順にソート
                    array_multisort(
                        $unique_id,
                        SORT_ASC,
                        SORT_NUMERIC,
                        $res
                    );
                    // デポカレンダー期間注釈リストがあれば文字列で重複チェック
                    if ($key == 'anno_period' && count($anno_periods) > 0) {
                        foreach ($anno_periods as $str) {
                            // 重複していないものだけ格納
                            if (!in_array($str, $res)) {
                                $res[] = $str;
                            }
                        }
                    }
                    // 格納
                    $this->wk[$key] = $res;
                    break;
                default:
                    break;
            }
        }

        return true;
    }
}
