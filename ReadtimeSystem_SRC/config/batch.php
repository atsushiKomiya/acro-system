<?php

return [
    // バッチ更新ユーザ
    'batch_user_id' => env('BATCH_USER_ID', 99999),
    // 更新適用月数
    'calendarDepoMonth' => "7",

    // リードタイムマスタチェックバッチ適用月数値
    'readTimeCheckMonth' => "7",

    // クリーンアップバッチ削除基準月
    'cleanUpMonth' => "3",
];
