<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// 誰でもアクセスできる
// Sample
Route::get('sample', 'SampleController@index');
Route::post('sample/test', 'SampleController@test');

//ログイン
Route::get('login', 'LoginController@login')->name('login');
Route::post('login', 'LoginController@login');

// TOP
Route::get('', 'TopController@index')->name('C_L01');

// デポ休業等申請画面
Route::get('C_L11', 'DepoRequestController@index')->name('C_L11');
Route::get('C_L11/search', 'DepoRequestController@search')->name('C_L11.search');

// デポ稼働日確認画面
Route::get('C_L10', 'CalendarConfirmController@index')->name('C_L10');

// デフォルト設定画面（共通）
Route::get('C_L21', 'DepoDefaultController@index')->name('C_L21');
Route::get('C_L21/search', 'DepoDefaultController@search')->name('C_L21.search');

// デフォルト一覧画面
Route::get('C_L20', 'DepoDefaultController@list')->name('C_L20');

// イレギュラー設定画面
Route::get('C_L31', 'IrregularController@index')->name('C_L31');
// イレギュラー設定画面（複製処理）
Route::get('C_L31/remake', 'IrregularController@remake')->name('C_L31.remake');

// イレギュラー一覧画面
Route::get('C_L30', 'IrregularListController@index')->name('C_L30');

// 子画面
// デポ選択子画面
Route::get('C_L50', 'DepoSelectController@index')->name('C_L50');
// デポ複数選択子画面
Route::get('C_L51', 'DepoSelectController@multiple')->name('C_L51');

// 商品カテゴリ選択子画面
Route::get('C_L52', 'ItemSelectController@index')->name('C_L52');
// 商品カテゴリ複数選択子画面
Route::get('C_L53', 'ItemSelectController@multiple')->name('C_L53');

// 日付選択子画面
Route::get('C_L54', 'DateSelectController@index')->name('C_L54');

// 地域選択子画面
Route::get('C_L55', 'AreaSelectController@index')->name('C_L55');

// メッセージ重複確認子画面
Route::post('C_L56/search', 'MessageDuplicationController@index')->name('C_L56');

// ログアウト
Route::post('logout', 'LoginController@logout');


// エラー画面
Route::post('error', 'ErrorController@index');
