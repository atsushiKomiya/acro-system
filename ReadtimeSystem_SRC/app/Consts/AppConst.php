<?php

namespace App\Consts;

class AppConst
{
    const TYPE_STR = 1;
    const NUM = 2;
    /** 社員/デポ */
    const AUTH_CLS = [
        'shain' => 1,
        'depo' => 2
    ];

    /** デポ区分 */
    // 通常
    const DEPO_DISPLAY_CLS_NOMAL = 1;
    // サプライズデポ
    const DEPO_DISPLAY_CLS_SURP = 2;
    // エンタメデポ
    const DEPO_DISPLAY_CLS_ENTERME = 3;

    /** DB定義 */
    // 曜日
    const DAYOFWEEK = [
        'sun' => 0,
        'mon' => 1,
        'tue' => 2,
        'wed' => 3,
        'thu' => 4,
        'fri' => 5,
        'sat' => 6,
    ];
    const DAYOFWEEK_STR = [
        AppConst::DAYOFWEEK['sun'] => '日',
        AppConst::DAYOFWEEK['mon'] => '月',
        AppConst::DAYOFWEEK['tue'] => '火',
        AppConst::DAYOFWEEK['wed'] => '水',
        AppConst::DAYOFWEEK['thu'] => '木',
        AppConst::DAYOFWEEK['fri'] => '金',
        AppConst::DAYOFWEEK['sat'] => '土'
    ];
    // 祝日ステータス
    const PUBLIC_HOLIDAY_STATUS = [
        'today' => 1,
        'tomorrow' => 2,
        'yesterday' => 3
    ];
    const PUBLIC_HOLIDAY_STATUS_STR = [
        AppConst::PUBLIC_HOLIDAY_STATUS['today'] => '祝日',
        AppConst::PUBLIC_HOLIDAY_STATUS['tomorrow'] => '祝前',
        AppConst::PUBLIC_HOLIDAY_STATUS['yesterday'] => '祝後'
    ];
    // 販売ステータス
    // 販売中
    const SALE_STATUS_ON = 0;
    // 販売停止
    const SALE_STATUS_STOP = 1;
    // 販売終了
    const SALE_STATUS_OFF = 2;
    /** バッチ定義 */
    // カレンダー更新バッチ処理モード
    const RELOAD_CALENDAR_MODE = [
        'ADD' => 1,
        'UPDATE' => 2
    ];


    /** API定義 */
    const API_SYSTEM_ID = [
        'FRONT'  => 'C_LI_01',
        'SERVER' => 'C_LI_02',
    ];
    // 1:成功、2:失敗、3:パラメータエラー
    const API_STATUS = [
        'SUCCESS' => 1,
        'FAILURE' => 2,
        'ERROR' => 3,
    ];
    // 当日配達区分: 1:当配不可、2:当配可、3：当日配達可（3時間以内）、99:常時不可
    const TODAY_DELIVERY_KBN = [
        'NOT'        => 1,
        'YES'        => 2,
        '3_HOURS'    => 3,
        'NOT_ALWAYS' => 99,
    ];
    // 翌日配達区分: 2：翌日配達可、999：翌日配達不可
    const NEXT_DAY_DELIVERY_KBN = [
        'YES' => 2,
        'NOT' => 999,
    ];
    // 1:タイムテーブル用 ２:受注チェック用
    const PROCKBN = [
        'TIME_TABLE'  => 1,
        'ORDER_CHECK' => 2,
    ];
    // 表示タイプ: 1：通常、2：サプライズ、3：エンタメ
    const DISPLAY_TYPE = [
        'NORMAL' => 1,
        'SP'     => 2,
        'ETM'    => 3,
    ];
    // 受注期間・曜日区分: 1:日、2:期間、3:曜日
    const ORDER_DATE_TYPE = [
        'DAY'    => 1,
        'PERIOD' => 2,
        'WEEK'   => 3,
    ];
    // お届け期間・曜日区分: 1:日、2:期間、3:曜日
    const DELIVERY_DATE_TYPE = [
        'DAY'    => 1,
        'PERIOD' => 2,
        'WEEK'   => 3,
    ];
    // 当日配送可フラグ: 0:不可 1:可能 2:時間指定
    const TODAY_DELIVERY_FLG = [
        'NOT'  => 0,
        'YES'  => 1,
        'TIME' => 2,
    ];
    // 前日締切フラグ: 0:不可 1:可能 2:時間指定
    const BEFORE_DEADLINE_FLG = [
        'NOT'  => 0,
        'YES'  => 1,
        'TIME' => 2,
    ];
    // 日付区分: 1:お届け日、2:受注日
    const DATE_TYPE = [
        'DELIVERY_DATE' => 1,
        'ORDER_DATE'    => 2,
    ];
    // 配送可能区分: 0:配送不可 1:配送可能
    const DELIVERY_CATEGORY = [
        'NOT' => 0,
        'YES' => 1,
    ];

    const APPLYING = "申請中";
    const APPROVED = "承認済み";
    const UNCONFIRMED = "未確認";
    const CONFIRMED = "確認済み";
    const NOTIFICATION_DATE = "届日";
    const SHIP_DATE = "出荷日";

    /** 一覧　追加／削除判定 */
    const LIST_ADD_MODE = 'add';
    const LIST_DEL_MODE = 'del';

    /** イレギュラー区分 */
    // 配送不可
    const IRREGULAR_CLS_NO = 1;
    // 配送制御
    const IRREGULAR_CLS_CONTROL = 2;
    // 配送振替
    const IRREGULAR_CLS_TRANSFER = 3;

    /** メッセージ区分 */
    // デポ変更申請
    const MSG_TYPE_DEPO_REQ = 1;
    // イレギュラー
    const MSG_TYPE_IRREGULAR = 2;

    /** 通年 */
    const ALL_YEAR_ROUND_FROM = 1910;
    const ALL_YEAR_ROUND_TO = 2036;
}
