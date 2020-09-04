<?php

namespace App\Application\Utilities;

use Log;

class BatchLog
{
    const CHANNEL = 'batchlog';

    /**
     * debugメッセージをログ出力
     *
     * @param  $message
     */
    public static function debug($message)
    {
        Log::channel('batchlog')->debug($message);
    }

    /**
     * infoメッセージをログ出力
     *
     * @param  $message
     */
    public static function info($message)
    {
        Log::channel('batchlog')->info($message);
    }

    /**
     * Noticeメッセージをログ出力
     *
     * @param  $message
     */
    public static function notice($message)
    {
        Log::channel('batchlog')->notice($message);
    }

    /**
     * warningメッセージをログ出力
     *
     * @param  $message
     */
    public static function warning($message)
    {
        Log::channel('batchlog')->warning($message);
    }

    /**
     * errorメッセージをログ出力
     *
     * @param  $message
     */
    public static function error($message)
    {
        Log::channel('batchlog')->error($message);
    }

    /**
     * criticalメッセージをログ出力
     *
     * @param  $message
     */
    public static function critical($message)
    {
        Log::channel('batchlog')->critical($message);
    }

    /**
     * emergencyメッセージをログ出力
     *
     * @param  $message
     */
    public static function emergency($message)
    {
        Log::channel('batchlog')->emergency($message);
    }
}
