<?php

Route::group(['middleware' => ['api']], function () {
    // 共通
    Route::get('/common/depoPrefList', 'CommonApiController@depoPrefList');

    // デポ休業等申請画面
    Route::post('/C_L11/confirm', 'DepoRequestApiController@confirm');
    Route::post('/C_L11/application', 'DepoRequestApiController@application');
    Route::post('/C_L11/approval', 'DepoRequestApiController@approval');

    // デフォルト設定画面（カレンダーデフォルト情報）
    Route::get('/C_L10/search', 'CalendarConfirmApiController@search');
    Route::get('/C_L10/count', 'CalendarConfirmApiController@count');
    Route::post('/C_L10/download', 'CalendarConfirmApiController@download');
    Route::post('/C_L10/approval', 'CalendarConfirmApiController@approval');

    // デフォルト一覧画面
    Route::post('/C_L20/download', 'DefaultListApiController@download');
    Route::get('/C_L20/search', 'DefaultListApiController@search');
    Route::get('/C_L20/count', 'DefaultListApiController@count');

    // デフォルト設定画面（カレンダーデフォルト情報）
    Route::get('/C_L21/calendar/search', 'DefaultCalendarApiController@search');
    Route::post('/C_L21/calendar/save', 'DefaultCalendarApiController@save');
    Route::post('/C_L21/calendar/reflect', 'DefaultCalendarApiController@reflect');

    // デフォルト設定画面（リードタイム情報）
    Route::get('/C_L21/leadtime/leadtimeList', 'DefaultLeadtimeApiController@search');
    Route::post('/C_L21/leadtime/download', 'DefaultLeadtimeApiController@download');
    Route::post('/C_L21/leadtime/save', 'DefaultLeadtimeApiController@save');
    Route::post('/C_L21/leadtime/upload', 'DefaultLeadtimeApiController@upload');

    // デフォルト設定画面（デポ商品コード紐付情報）
    Route::get('/C_L21/depoitem/depoItemList', 'DefaultDepoItemApiController@depoItemList');
    Route::post('/C_L21/depoitem/save', 'DefaultDepoItemApiController@save');
    Route::post('/C_L21/depoitem/download', 'DefaultDepoItemApiController@download');
    Route::post('/C_L21/depoitem/upload', 'DefaultDepoItemApiController@upload');

    // デフォルト設定画面（デポ住所コード紐付情報）
    Route::get('/C_L21/depoaddress/addressList', 'DefaultDepoAddressApiController@addressList');
    Route::get('/C_L21/depoaddress/depoAddressList', 'DefaultDepoAddressApiController@depoAddressList');
    Route::post('/C_L21/depoaddress/save', 'DefaultDepoAddressApiController@save');
    Route::post('/C_L21/depoaddress/download', 'DefaultDepoAddressApiController@download');
    Route::post('/C_L21/depoaddress/upload', 'DefaultDepoAddressApiController@upload');

    //イレギュラー設定画面（登録/更新）
    Route::post('/C_L31/irregular/reflect', 'IrregularApiController@reflect');

    //イレギュラー設定画面（削除）
    Route::post('/C_L31/irregular/delete', 'IrregularApiController@delete');

    // イレギュラー一覧画面
    Route::get('/C_L30/search', 'IrregularListApiController@search');
    Route::post('/C_L30/download', 'IrregularListApiController@download');
    Route::get('/C_L30/count', 'IrregularListApiController@count');

    // 地域選択子画面
    Route::get('/C_L55/addressList', 'AreaSelectApiController@index');

    // リードタイムAPIフロントAPI
    Route::post('/C_LI_01/leadtime', 'LeadTimeFrontApiController@index');
    // リードタイムAPIサーバーAPI
    Route::post('/C_LI_02/leadtime', 'LeadTimeServerApiController@index');
});
