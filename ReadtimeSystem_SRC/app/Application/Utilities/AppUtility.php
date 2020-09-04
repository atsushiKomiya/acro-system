<?php

namespace App\Application\Utilities;

use App\Consts\AppConst;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class AppUtility
{
    /**
     * 遷移元を判定し何の権限を持って遷移したかを判定する
     *
     * @param  $url
     * @return $authCls
     */
    public static function getTransitionAuthCls($url)
    {
        $authCls = AppConst::AUTH_CLS['shain'];
        if (strpos($url, '/logi/') !== false) {
            // デポ画面から遷移
            $authCls = AppConst::AUTH_CLS['depo'];
        }
        return $authCls;
    }

    /**
     * ログイン失敗時に遷移するURLを取得する
     *
     * @param  $authCls
     * @return $url
     */
    public static function getLoginErrorRedirectUrl($authCls)
    {
        // リダイレクト先をログイン情報により変更する
        $key = 'url.shain_redirect_url';
        if ($authCls == AppConst::AUTH_CLS['depo']) {
            $key = 'url.depo_redirect_url';
        }
        $url = Config::get($key);
        return $url;
    }
    
    /**
     * ダウンロードファイル名を生成する
     *
     * @param [type] $screenId
     * @return string
     */
    public static function createFileName(string $screenId): string
    {
        return $screenId . '_' . \Carbon\Carbon::now()->format('YmdHis') . '.csv';
    }

    /**
     * 日付文字列を取得します。
     */
    public static function getDateString($dateValue, $stringFormat)
    {
        // 値未設定の場合はNULLを返す
        // ※補足：Modelクラス側でDateTime型に変換していると（Model->$datesを設定していると）、
        //   本タイミングでは「-0001-11-30 00:00:00.000000」のような値が入っているのでこれを考慮する必要がある
        $year = $dateValue->year;
        $minYear = 0;
        if ($year < $minYear) {
            return null;
        }

        // 文字列変換
        $dateString = $dateValue->format($stringFormat);
        return $dateString;
    }

    /**
     * 対象月のymdリストを取得する
     *
     * @param [type] $ym
     * @return array
     */
    public static function getTargetYmdList($ym): array
    {
        // カーソル取得
        $ymdList = array();
        $lastDay = Carbon::createFromFormat('Ym', $ym)->lastOfMonth()->day;
        for ($i =0;$i < $lastDay;$i++) {
            $day = $i + 1;
            $ymdList[] = $ym . sprintf('%02d', $day);
        }

        return $ymdList;
    }

    /**
     * 締め時間、記号判定
     *
     * @param [type] $deadlineFlg
     * @param [type] $deadlineLimitTime
     * @return void
     */
    public static function getLimitTime($deadlineFlg, $deadlineLimitTime)
    {
        $result = "";
        if ($deadlineFlg == 0) {
            // 不可
            $result = "×";
        } elseif ($deadlineFlg == 1) {
            // 可能
            $result = "○";
        } elseif ($deadlineFlg == 2) {
            // 時間指定
            $deadlineTimeList = Config::get('delivery.deadline_time_list');
            $result = $deadlineTimeList[$deadlineLimitTime];
        } else {
            $result = "";
        }
        return $result;
    }

    /**
     * 曜日番号から曜日文字列を取得する
     *
     * @param [type] $weekNo
     * @return void
     */
    public static function getWeekStr($weekNo) {
        $result = '';
        if(isset(AppConst::DAYOFWEEK_STR[$weekNo])) {
            $result = AppConst::DAYOFWEEK_STR[$weekNo];
        }
        return $result;
    }


    /**
     * 祝日ステータス区分から祝日文字列を取得する
     *
     * @param [type] $holidayNo
     * @return void
     */
    public static function getHolidayStr($holidayNo) {
        $result = '';
        if(isset(AppConst::PUBLIC_HOLIDAY_STATUS_STR[$holidayNo])) {
            $result = AppConst::PUBLIC_HOLIDAY_STATUS_STR[$holidayNo];
        }
        return $result;
    }
}
