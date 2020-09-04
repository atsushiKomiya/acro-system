<?php

namespace App\Application\Controllers\Api;

use Illuminate\Http\Request;
use Validator;
use App\Application\UseCases\LeadTimeFrontApiUseCase;
use Illuminate\Support\Facades\Log;
use App\Consts\AppConst;

/**
 * 【C_LI_01_リードタイムAPIフロント】 コントローラクラス
 */
class LeadTimeFrontApiController extends ApiController
{
    public $logger;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->logger = Log::channel('apilog')->getLogger();
        $this->middleware('UnescapeJsonResponse');
    }

    /**
     * メイン処理
     *
     * @param Request $request
     *
     * @param UseCase $usecase
     * @return json $res レスポンスJSON
     */
    public function index(Request $request, LeadTimeFrontApiUseCase $usecase)
    {
        $this->logger->info("#FRONT API START", ['file' => basename(__FILE__), 'line' => __LINE__]);

        /** 変数初期化 */
        $wk = [
            'status'                 => null,
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
            'anno_trans'             => null,
            'anno_addr'              => null,
            'anno_period'            => null,
            'error_messages'         => null,
        ];


        /**
         * 1．パラメータチェック処理
         */
        $this->logger->info("#1．パラメータチェック処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $this->logger->info("#1．パラメータチェック処理 INFO", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $request->all()]);
        $validator = Validator::make($request->all(), [
            'procKbn'   => 'required|integer',
            'aPref'     => 'required|integer',
            'aSiku'     => 'required|string',
            'aTyou'     => 'required|string',
            'productCd' => 'required|string',
            'aDate'     => 'nullable|date',
            'aTime'     => 'nullable|string',
            'cDate'     => 'nullable|date',
            'cTime'     => 'nullable|string',
            'c_use'     => 'nullable|integer',
            'handing'   => 'nullable|integer',
            'huda'      => 'nullable|integer',
            'spFlg'     => 'required|boolean',
            'phFlg'     => 'nullable|boolean',
        ]);

        // バリデーションエラー
        if ($validator->fails()) {
            // status,エラーメッセージ格納
            $wk['status'] = AppConst::API_STATUS['ERROR'];
            $wk['error_messages'] = $validator->errors()->all();

            $this->logger->info("#1．パラメータチェック処理 ERROR", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $wk]);
            return response()->json($wk);
        }
        $this->logger->info("#1．パラメータチェック処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);

        /**
         * 2．初期設定処理
         */
        $this->logger->info("#2．初期設定処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if ($usecase->initSet() === false) {
            // 終了
            $wk['status'] = AppConst::API_STATUS['FAILURE'];
            $wk['error_messages'] = "商品カテゴリ情報が取得できませんでした";
            return response()->json($wk);
        }
        $this->logger->info("#2．初期設定処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);

        /**
         * 3．デポ区分カレンダー確認
         */
        $this->logger->info("#3．デポ区分カレンダー確認 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
        // [1] 4．イレギュラー振替先チェック処理 ※振替先デポCDがNULLの場合[2]へ
        $this->logger->info("##[1] 4．イレギュラー振替先チェック処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
        if ($usecase->irTransferCheck() === false) {
            // [2] 5．住所・商品紐づけ情報取得 ※有効デポリストがある時[3]へ
            $this->logger->info("#[2] 5．住所・商品紐づけ情報取得 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
            if ($usecase->findAddressItemRelation() === false) {
                // [3] リクエストパラメータ_処理区分、リクエストパラメータ_SPフラグ、有効デポリストの表示タイプを判定
                $this->logger->info("#[3] リクエストパラメータ_処理区分、リクエストパラメータ_SPフラグ、有効デポリストの表示タイプを判定 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
                if ($request->input('spFlg')) {
                    /**
                     * 8．サプライズデポカレンダー確認処理
                     */
                    $this->logger->info("#8．サプライズデポカレンダー確認処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
                    $usecase->spDepoCalender();
                    $this->logger->info("#8．サプライズデポカレンダー確認処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
                    $this->logger->info("#[3] リクエストパラメータ_処理区分、リクエストパラメータ_SPフラグ、有効デポリストの表示タイプを判定 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
                }
                // 表示タイプ：１がある場合
                elseif ($usecase->checkDisplayType() === true) {
                    $this->logger->info("#[3] 表示タイプ：１がある場合 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
                    if ($request->input('procKbn') == AppConst::PROCKBN['TIME_TABLE']) {
                        /**
                         * 6．当日配送デポ引き当て処理
                         */
                        $this->logger->info("#6．当日配送デポ引き当て処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
                        $usecase->todayDeliveryDepoAllocation();
                        $this->logger->info("#6．当日配送デポ引き当て処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
                        /**
                         * 7．翌日配送デポ引き当て処理
                         */
                        $this->logger->info("#7．翌日配送デポ引き当て処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
                        $usecase->nextDayDeliveryDepoAllocation();
                        $this->logger->info("#7．翌日配送デポ引き当て処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
                    } else {
                        if ($request->input('aDate') == date('Y-m-d')) {
                            /**
                             * 6．当日配送デポ引き当て処理
                             */

                            $this->logger->info("#6．当日配送デポ引き当て処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
                            $usecase->todayDeliveryDepoAllocation();
                            $this->logger->info("#6．当日配送デポ引き当て処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
                        } else {
                            /**
                             * 7．翌日配送デポ引き当て処理
                             */
                            $this->logger->info("#7．翌日配送デポ引き当て処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
                            $usecase->nextDayDeliveryDepoAllocation();
                            $this->logger->info("#7．翌日配送デポ引き当て処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
                        }
                    }
                    $this->logger->info("#[3] 表示タイプ：１がある場合 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
                } else {
                    /**
                     * 9．エンタメデポカレンダー確認処理
                     */
                    $this->logger->info("#9．エンタメデポカレンダー確認処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
                    $usecase->etmDepoCalender();
                    $this->logger->info("#9．エンタメデポカレンダー確認処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
                }
            }
            $this->logger->info("#[2] 5．住所・商品紐づけ情報取得 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
        }
        $this->logger->info("#[1] 4．イレギュラー振替先チェック処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $this->logger->info("#3．デポ区分カレンダー確認 END", ['file' => basename(__FILE__), 'line' => __LINE__]);

        // [4] 10．注釈・エラーメッセージ設定処理
        $this->logger->info("#[4] 10．注釈・エラーメッセージ設定処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $usecase->setMessages();
        $this->logger->info("#[4] 10．注釈・エラーメッセージ設定処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);
        // [5] 11．レスポンス設定処理
        $this->logger->info("#[5] 11．レスポンス設定処理 START", ['file' => basename(__FILE__), 'line' => __LINE__]);
        $result = $usecase->setResponse($wk);
        $this->logger->info("#[5] 11．レスポンス設定処理 END", ['file' => basename(__FILE__), 'line' => __LINE__]);

        $this->logger->info("#レスポンスデータ", ['file' => basename(__FILE__), 'line' => __LINE__, 'param' => $result]);
        $this->logger->info("#FRONT API END", ['file' => basename(__FILE__), 'line' => __LINE__]);
        // 処理結果返却
        return response()->json($result);
    }
}
