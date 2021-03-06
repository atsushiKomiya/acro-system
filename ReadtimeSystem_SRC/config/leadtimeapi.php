<?php

return [

    // 翌日時間指定リスト ※時間 → 時間
    'time2time_next_day_time_type' => [
        '0'    => '0',
        '1000' => '1030',
        '1030' => '1100',
        '1100' => '1130',
        '1130' => '1200',
        '1200' => '1230',
        '1230' => '1300',
        '1259' => '1259', // 午前中
        '1300' => '1330',
        '1330' => '1400',
        '1400' => '1430',
        '1430' => '1500',
        '1500' => '1530',
        '1530' => '1600',
        '1600' => '1630',
        '1630' => '1700',
        '1700' => '1730',
        '1730' => '1800',
        '1800' => '1830',
        '1830' => '1900',
        '1900' => '1930', // 時間指定不可
        '9999' => '9999', // その日中
    ],

    // 翌日時間指定リスト ※時間 → 文字列
    'time2str_next_day_time_type' => [
        '0'    => '--',
        '1000' => '10:00まで',
        '1030' => '10:30まで',
        '1100' => '11:00まで',
        '1130' => '11:30まで',
        '1200' => '12:00まで',
        '1230' => '12:30まで',
        '1259' => '午前中',
        '1300' => '13:00まで',
        '1330' => '13:30まで',
        '1400' => '14:00まで',
        '1430' => '14:30まで',
        '1500' => '15:00まで',
        '1530' => '15:30まで',
        '1600' => '16:00まで',
        '1630' => '16:30まで',
        '1700' => '17:00まで',
        '1730' => '17:30まで',
        '1800' => '18:00まで',
        '1830' => '18:30まで',
        '1900' => '19:00まで',
        '1930' => '時間指定不可',
        '9999' => 'その日中',
    ],


];
