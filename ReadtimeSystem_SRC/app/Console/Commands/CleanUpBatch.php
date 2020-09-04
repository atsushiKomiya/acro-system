<?php

namespace App\Console\Commands;

use App\Application\Utilities\BatchLog;
use App\Application\UseCases\DepoCalInfoUseCase;
use App\Application\UseCases\DepoCalInfoTmpUseCase;
use App\Application\UseCases\DepoCalAprInfoUseCase;

use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class CleanUpBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CreanUPバッチ';

    /**
     * Create a new command instance.
     * @param DepoCalInfoUseCase $depoCalInfoUC
     * @param DepoCalInfoTmpUseCase $depoCalInfoTmpUC
     * @param DepoCalAprInfoUseCase $depoCalAprInfoUC
     * @return void
     */
    public function __construct(DepoCalInfoUseCase $depoCalInfoUC, DepoCalInfoTmpUsecase $depoCalInfoTmpUC, DepoCalAprInfoUseCase $depoCalAprInfoUC)
    {
        parent::__construct();
        $this->depoCalInfoUC = $depoCalInfoUC;
        $this->depoCalInfoTmpUC = $depoCalInfoTmpUC;
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
            BatchLog::info('CreanUPバッチ開始');
            // バッチユーザ
            $batchUserId = Config::get('batch.batch_user_id', '99999');
            // ファイル削除対象ディレクトリ取得
            $backupDir = storage_path('app/backup/');
            
            // **************************************************************************************
            //１.デポカレンダー情報不要データ削除処理
            // **************************************************************************************

            // [1]トランザクションを開始する
            DB::beginTransaction();

            //［2］開始ログ「デポカレンダー情報不要データ削除処理開始」を出力する
            BatchLog::info('デポカレンダー情報不要データ削除処理開始');

            // [3] バッチ起動日のNヶ月前の月の1日を削除基準年月日とNヶ月前の月を削除基準年月とする（シート[DB]で使用）
            $subMonth = Config::get('batch.creanUpMonth');
            $criterionDate = Carbon::now()->subMonth($subMonth)->firstOfMonth()->format('Y-m-d');
            
            //［4］「シート[DB] - 1. デポカレンダー情報削除」を実行する
            $this->depoCalInfoUC->deleteDepoCalInfoCreanUp($criterionDate);
            
            //［5］終了ログ「デポカレンダー情報不要データ削除処理終了」を出力する
            BatchLog::info('デポカレンダー情報不要データ削除処理終了');


            // **************************************************************************************
            //2.デポカレンダー情報-tmp不要データ削除処理
            // **************************************************************************************
            
            // [1] 開始ログ「デポカレンダー情報-tmp不要データ削除処理開始」を出力する
            BatchLog::info('デポカレンダー情報-tmp不要データ削除処理開始');
            
            // [2]「シート[DB] - 2. デポカレンダー情報-tmp論理削除」を実行する
            $this->depoCalInfoTmpUC->deleteDepoCalInfoTmpCreanUp($criterionDate, $batchUserId);

            // [3] 終了ログ「デポカレンダー情報-tmp不要データ削除処理終了」を出力する
            BatchLog::info('デポカレンダー情報-tmp不要データ削除処理終了');
            
            // **************************************************************************************
            //3.デポカレンダー承認情報不要データ削除処理
            // **************************************************************************************
            
            // [1]	開始ログ「デポカレンダー承認情報不要データ削除処理開始」を出力する
            BatchLog::info('デポカレンダー承認情報不要データ削除処理開始');
            
            // [2]「シート[DB] - 3. デポカレンダー承認情報論理削除」を実行する
            $this->depoCalAprInfoUC->deleteDepoCalAprInfoCreanUp($criterionDate, $batchUserId);

            // [3]	終了ログ「デポカレンダー承認情報不要データ削除処理終了」を出力する
            BatchLog::info('デポカレンダー承認情報不要データ削除処理終了');
            
            // [4] トランザクションを終了する
            DB::commit();
            
            // **************************************************************************************
            //4.不要CSVデータ削除処理
            // **************************************************************************************

            // [1]	開始ログ「不要CSVデータ削除処理開始」を出力する
            BatchLog::info('不要CSVデータ削除処理開始');

            // [2]	backupディレクトリに存在するNヶ月以前に作られたCSVのファイル名リスト取得
            $fileNameList = array();
            
            // ファイル名リスト取得
            foreach (glob($backupDir.'*.csv') as $file) {
                if (is_file($file)) {
                    $fileCreateTime = Carbon::CreateFromTimestamp(filemtime($file));
                    if ($fileCreateTime->lt($criterionDate)) {
                        $fileNameList[] = htmlspecialchars($file);
                    }
                }
            }

            // [3]	[2]で取得したファイルリストのファイルを繰り返し処理で削除する
            foreach ($fileNameList as $file) {
                unlink($file);
            }

            // [4]	終了ログ「不要CSVデータ削除処理終了」を出力する
            BatchLog::info('不要CSVデータ削除処理終了');
            
            BatchLog::info('クリーンアップバッチ正常終了');
            
            return 0;
        } catch (Exception $e) {
            DB::rollBack();
            BatchLog::error('クリーンアップバッチ異常終了');
            return 1;
        }
    }
}
