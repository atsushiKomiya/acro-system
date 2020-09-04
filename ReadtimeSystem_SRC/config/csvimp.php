<?php

return [
    // C_L21
    // リードタイム情報
    'lead_time' => [
        ['デポ名','depoCd'],
        ['デポ名','depoName'],
        ['住所CD','addrcd'],
        ['JIS市区町村','jiscode'],
        ['郵便番号','zipCd'],
        ['都道府県CD','prefCd'],
        ['市区郡','siku'],
        ['町名','tyou'],
        ['翌日時間指定','monTodayDelivery'],
        ['エリア当日配送可否','isAreaTodayDeliveryFlg'],
        ['翌日配送締切時間','nextDayTimeDeadline'],
        ['当日配送締切時間１','todayTimeDeadline1'],
        ['当日配送締切時間２','todayTimeDeadline2'],
    ],
    // デポ商品コード紐付情報
    'depo_item' => [
        ['デポCD','depoCd'],
        ['デポ名','depoName'],
        ['商品CD','itemCd'],
        ['商品名','itemName'],
    ],
    // デポ住所コード紐付情報
    'depo_address' => [
        ['デポCD','depoCd'],
        ['デポ名','depoName'],
        ['JIS市区町村','jiscode'],
        ['郵便番号','zipCd'],
        ['都道府県CD','prefCd'],
        ['市区郡','siku'],
        ['町名','tyou'],
    ],

];
