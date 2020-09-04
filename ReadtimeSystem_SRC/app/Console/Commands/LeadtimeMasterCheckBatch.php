<?php

namespace App\Console\Commands;

use App\Application\Utilities\BatchLog;
use App\Application\UseCases\DepoDefaultUseCase;
use App\Application\UseCases\DepoUseCase;
use App\Application\UseCases\DepoCalInfoUseCase;
use App\Application\UseCases\DepoCalInfoTmpUseCase;
use App\Application\UseCases\DepoItemUseCase;
use App\Application\UseCases\DepoAddressUseCase;
use App\Application\UseCases\DepoCalAprInfoUseCase;


use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use App\Consts\AppConst;

class LeadtimeMasterCheckBatch extends Command
{
    const CHANNEL = 'batchlog';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:leadtimemastercheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'リードタイムマスタチェックバッチ';

    /**
     * Create a new command instance.
     * @param DepoDefaultUseCase $depoDefaultUC
     * @param DepoUseCase $depoUC
     * @param DepoCalInfoUseCase $depoCalInfoUC
     * @param DepoCalInfoTmpUseCase $depoCalInfoTmpUC
     * @param DepoItemUseCase $depoItemUC
     * @param DepoAddressUseCase $depoAddressUC
     * @param DepoCalAprInfoUseCase $depoCalAprInfoUC
     * @return void
     */
    public function __construct(DepoDefaultUseCase $depoDefaultUC, DepoUseCase $depoUC, DepoCalInfoUseCase $depoCalInfoUC, DepoCalInfoTmpUsecase $depoCalInfoTmpUC, DepoItemUseCase $depoItemUC, DepoAddressUseCase $depoAddressUC, DepoCalAprInfoUseCase $depoCalAprInfoUC)
    {
        parent::__construct();
        $this->depoDefaultUC = $depoDefaultUC;
        $this->depoUC = $depoUC;
        $this->depoCalInfoUC = $depoCalInfoUC;
        $this->depoCalInfoTmpUC = $depoCalInfoTmpUC;
        $this->depoItemUC = $depoItemUC;
        $this->depoAddressUC = $depoAddressUC;
        $this->depoCalAprInfoUC = $depoCalAprInfoUC;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            BatchLog::info('リードタイムマスタチェックバッチ開始');
            //1.不要デポCDリスト取得処理
            // [1]	開始ログ「不要デポCDリスト取得処理開始」を出力する
            BatchLog::info('不要デポCDリスト取得処理開始');
            // [2]	「シート[DB] - 1. 不要デポCD情報取得」を実行する
            $unnecessaryDepo = $this->depoDefaultUC->getUnnecessaryDepo();
            // a）取得結果が0件だった場合
            //     終了ログ「不要デポCDリスト取得処理終了」を出力し、「３.カレンダー適用デポリスト生成処理」を実行する
            $unnecessaryDepoList = array();
            if (empty($unnecessaryDepo)) {
                BatchLog::info('不要デポCDリスト取得処理終了');
            // b）取得結果が上記以外の場合
            //     取得した情報から不要デポCDリスト（配列）を生成する
            //     終了ログ「不要デポCDリスト取得処理終了」を出力し、「2.不要デポ情報削除処理」を実行する
            } else {
                foreach ($unnecessaryDepo as $value) {
                    $unnecessaryDepoList[] = $value->depoCd;
                }
                BatchLog::info('不要デポCDリスト取得処理終了');

                //2.不要デポ情報削除処理
                //[1]	開始ログ「不要デポ情報削除処理開始」を出力する
                BatchLog::info('不要デポ情報削除処理開始');
                //[2]	トランザクション開始
                try {
                    // DB::beginTransaction();
                    //[3]	「シート[DB] -2. デポカレンダーデフォルト情報不要データ削除」を実行する
                    $this->depoDefaultUC->deleteDepoDefaultUnnecessary($unnecessaryDepoList);
                    //[4]	「シート[DB] -3.デポカレンダー情報不要データ削除」を実行する
                    $this->depoCalInfoUC->deleteDepoCalUnnecessary($unnecessaryDepoList);
                    //[5]	「シート[DB] -4. デポカレンダー情報‐tmp不要データ論理削除」を実行する
                    $this->depoCalInfoTmpUC->deleteDepoCalTmpUnnecessary($unnecessaryDepoList);
                    //[6]	「シート[DB] -5. デポ取扱商品不要データ削除」を実行する
                    $this->depoItemUC->deleteDepoItemUnnecessary($unnecessaryDepoList);
                    //[7]	「シート[DB] -6. デポ住所リードタイム情報不要データ削除」を実行する
                    $this->depoAddressUC->deleteDepoAddressUnnecessary($unnecessaryDepoList);
                    //[8]	「シート[DB] -7. デポ承認情報不要データ論理削除」を実行する
                    $this->depoCalAprInfoUC->deleteDepoCalAprUnnecessary($unnecessaryDepoList);
                    // [9]	トランザクション終了
                    //     a）正常終了した場合
                    //         コミットを行い、終了ログ「不要デポ情報削除処理終了」を出力し、「３.カレンダー適用デポリスト生成処理」を実行
                    DB::commit();
                    BatchLog::info('不要デポ情報削除処理終了');
                } catch (Exception $e) {
                    //     b）異常終了した場合
                    //         全件ロールバックを行い、エラーログ「【テーブル名】の削除処理でエラーが発生しました」を出力し処理終了
                    DB::rollBack();
                    BatchLog::error('【テーブル名】の削除処理でエラーが発生しました');
                    throw new Exception();
                }
            }

            //３.カレンダー適用デポリスト生成処理
            // [1]	開始ログ「カレンダー適用デポリスト生成処理開始」を出力する
            BatchLog::info('カレンダー適用デポリスト生成処理開始');
            // [2]	「シート[DB] -8. カレンダー更新対象デポリスト取得」を実行する
            $ym = Config::get('batch.readTimeCheckMonth');
            $updateTaisyoDepo = $this->depoUC->getUpdateTaisyoDepoList($ym);
            //     a）取得結果が0件だった場合
            //         終了ログ「カレンダー適用デポリスト生成処理終了」を出力し処理終了
            if (empty($updateTaisyoDepo)) {
                BatchLog::info('カレンダー適用デポリスト生成処理終了');
            //     b）取得結果が上記以外の場合
            //         取得した情報から不要デポCDリスト（配列）を生成する
            //         終了ログ「カレンダー適用デポリスト生成処理終了」を出力し、「4.カレンダーデータ更新バッチ起動処理」を実行する
            } else {
                $updateTaisyoDepoList = array();
                foreach ($updateTaisyoDepo as $value) {
                    $updateTaisyoDepoList[] = $value->depocd;
                }
                if ($unnecessaryDepoList) {
                    $updateTaisyoDepoList = array_diff($updateTaisyoDepoList, $unnecessaryDepoList);
                }
                $updateTaisyoDepoListDisp = implode(',', $updateTaisyoDepoList);
                BatchLog::info('カレンダー適用デポリスト生成処理終了');
                // 4.カレンダーデータ更新バッチ起動処理
                // [1]	開始ログ「カレンダーデータ更新バッチ起動処理開始」を出力する
                BatchLog::info('カレンダーデータ更新バッチ起動処理開始');
                // [2]	ログ「更新対象デポリスト［XXXX,XXXX,XXXX］」を出力する
                BatchLog::info('更新対象デポリスト［'.$updateTaisyoDepoListDisp.'］');
                // [3]	以下のパラメータでカレンダー更新バッチを起動する（非同期）
                // 処理モード->追加モード
                // 適用開始日->未指定
                // 適用デポCDリスト->3．で取得したカレンダー更新対象デポリスト
                // C_LB_02_カレンダーデータ更新バッチ実行
                $command = 'php "' . base_path('artisan') . '" batch:reloadcalendar ' . AppConst::RELOAD_CALENDAR_MODE['UPDATE'] .' ' . '　' .' ' . $updateTaisyoDepoListDisp;
                exec($command);
                // [4]	終了ログ「カレンダーデータ更新バッチ起動処理終了」を出力し処理終了
                BatchLog::info('カレンダーデータ更新バッチ起動処理終了');
            }

            BatchLog::info('リードタイムマスタチェックバッチ正常終了');
            DB::commit();
            return 0;
        } catch (Exception $e) {
            DB::rollBack();
            BatchLog::error('リードタイムマスタチェックバッチ異常終了');
            return 1;
        }
    }
}
