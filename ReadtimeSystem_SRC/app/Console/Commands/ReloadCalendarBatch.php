<?php

namespace App\Console\Commands;

use App\Application\Utilities\BatchLog;
use App\Application\UseCases\DepoUseCase;
use App\Application\UseCases\PublicHolidayUseCase;
use App\Application\UseCases\DepoCalAprInfoUseCase;
use App\Application\UseCases\DepoDefaultUseCase;
use App\Application\UseCases\DepoCalInfoUseCase;
use App\Application\UseCases\DepoCalInfoTmpUseCase;
use App\Consts\AppConst;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class ReloadCalendarBatch extends Command
{
    const CHANNEL = 'batchlog';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:reloadcalendar {mode?} {date?} {depolist?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'カレンダーデータ更新バッチ';

    /**
     * Create a new command instance.
     * @param DepoUseCase $depoUC
     * @param PublicHolidayUseCase $publicHolidayUC
     * @param DepoCalAprInfoUseCase $depoCalAprInfoUC
     * @param DepoDefaultUseCase $depoDefaultUC
     * @param DepoCalInfoUseCase $depoCalInfoUC
     * @param DepoCalInfoTmpUseCase $depoCalInfoTmpUC
     * @return void
     */
    public function __construct(DepoUseCase $depoUC, PublicHolidayUseCase $publicHolidayUC, DepoCalAprInfoUseCase $depoCalAprInfoUC, DepoDefaultUseCase $depoDefaultUC, DepoCalInfoUseCase $depoCalInfoUC, DepoCalInfoTmpUsecase $depoCalInfoTmpUC)
    {
        parent::__construct();
        $this->depoUC = $depoUC;
        $this->publicHolidayUC = $publicHolidayUC;
        $this->depoCalAprInfoUC = $depoCalAprInfoUC;
        $this->depoDefaultUC = $depoDefaultUC;
        $this->depoCalInfoUC = $depoCalInfoUC;
        $this->depoCalInfoTmpUC = $depoCalInfoTmpUC;
    }

    /**
     * Execute the console command.
     * @param string $mode 処理モード
     * @param string $date 適用開始日
     * @param int $depolist 適用デポリスト
     *
     * @return mixed
     */
    public function handle()
    {
        $mode = $this->argument('mode');
        $date = $this->argument('date');
        $depolist = $this->argument('depolist');
        $batchUserId = Config::get('batch.batch_user_id', '99999');

        try {
            // [1]	開始ログ「パラメータ取得処理を開始」を出力する
            BatchLog::info('パラメータ取得処理を開始');

            // [2]	起動パラメータ情報「起動パラメータ　mode＝？ date=? depolist=?」をログ出力する
            BatchLog::info('起動パラメータ　mode＝'.$mode.' date='.$date.' depolist='.$depolist);
            // [3]	処理モードを取得する。
            // [4]	処理モードが未指定の場合は「処理モードが未指定です」をエラーログ出力し、エラー終了する。
            // [5]	処理モードが半角数字1,2以外の場合、「処理モードに半角数字1，2以外が指定されています」をエラーログ出力し、エラー終了する。
            if (empty($mode)) {
                BatchLog::error('処理モードが未指定です');
                throw new Exception('処理モードが未指定です');
            } elseif ($mode != 1 && $mode != 2) {
                BatchLog::error('処理モードに半角数字1,2以外が指定されています');
                throw new Exception('処理モードに半角数字1,2以外が指定されています');
            }

            // [6]	適用開始日を取得する。
            // [7]	適用開始日が未指定の場合は起動日を8桁の半角数字【yyyymmdd】で適用開始日に設定する。
            // [8]	適用開始日が8桁の半角数字以外の場合は、「適用開始日が半角数字8桁以外で指定されています」をエラーログ出力し、エラー終了する。
            if (empty($date)|| $date == "　") {
                $date = Carbon::now()->format("Ymd");
            } elseif (strlen($date) != "8" || preg_match("/^[0-9]+$/", $date) != 1) {
                BatchLog::error('適用開始日が半角数字8桁以外で指定されています');
                throw new Exception('適用開始日が半角数字8桁以外で指定されています');
            } else {
                $date = $date;
            }

            // [9]	適用デポCDリストを取得する
            // [10]	適用デポCDリストが未指定か判定
            // 	a）適用デポCDリストが未指定の場合、適用デポCDリストにNULLを設定する
            // 	b）適用デポCDリストが指定されていた場合、適用デポCDリストのデポCDを配列に格納し、適用デポCDリストに再設定する
            if (empty($depolist)) {
                $depolist = null;
            } else {
                $depolist = explode(',', $depolist);
            }
            // [11]	終了ログ「パラメータ取得処理を終了」を出力する
            BatchLog::info('パラメータ取得処理を終了');

            // ２.カレンダー適用デポリスト生成処理
            // [1]	開始ログ「カレンダー適用デポリスト生成処理開始」を出力する
            BatchLog::info('カレンダー適用デポリスト生成処理開始');
            // [2]	1.で取得した適用デポCDリストがNULL（未指定）か判定
            // 	a）適用デポCDリストがNULLの場合
            // 		[2-a]配送デポ情報マスタから有効区分が稼働となっているデポのデポCDと稼働開始日を取得しカレンダー適用デポリストに格納する
            // 			「シート[DB] - 1. 有効デポ情報取得」を実行する
            // 	b）適用デポCDリストがNULL以外の場合
            // 		[2-b]適用デポCDリストのデポで配送デポ情報マスタに有効区分が稼働となっているデポのデポCDと稼働開始日を取得しカレンダー適用デポリストに格納する
            // 			「シート[DB] - 2. 有効デポ情報取得（適用デポCDリスト使用）」を実行する
            if ($depolist == null) {
                $calendarDepoList = $this->depoUC->getStartAtViewDepo();
            } else {
                $calendarDepoList = $this->depoUC->getStartAtViewDepoWithDepolist($depolist);
            }

            // [3]	終了ログ「カレンダー適用デポリスト生成処理終了」を出力する
            BatchLog::info('カレンダー適用デポリスト生成処理終了');

            //  3.祝日判定用配列生成処理
            // 【処理概要】
            // 	祝日CSVを読み込み、祝日判定用配列を生成する。CSVがない場合DBから取得し祝日判定用配列を生成する。
            // 【処理内容】
            // 	[1]	開始ログ「祝日判定用配列生成処理開始」を出力する
            BatchLog::info('祝日判定用配列生成生成処理開始');
            // 	[2]	作業ディレクトリに祝日CSVが存在するか判定
            // 		a）祝日CSVが存在した場合
            // 			[2-a]祝日CSVを読み込み、祝日判定用配列を生成する。
            // 			[2-b]トランザクションを開始する
            // 			[2-c]祝日テーブルのデータ全件削除する
            // 				「シート[DB] -10. 祝日情報削除処理」を実行する
            // 			[2-d]祝日テーブルに祝日判定用配列のデータを登録する
            // 				「シート[DB] -11. 祝日情報登録処理」を実行する
            // 			[2-e]祝日CSVを完了ディレクトリに移動する
            // 			[2-f]トランザクションを終了する
            // 		b）祝日CSVが存在しなかった場合
            // 			[2-ｇ]祝日テーブルから祝日データを取得する
            // 				「シート[DB] -12. 祝日情報取得処理」を実行する
            // 			[2-h]取得した祝日データが1件以上あるか判定
            // 				a）取得した祝日データが１件以上の場合
            // 					[2-h-1]取得した祝日データから祝日判定用配列を生成する
            // 				b）取得した祝日データが０件の場合
            // 					[2-h-2]エラーログ「祝日データがCSV、DBに存在しません」を出力し、エラー終了する。
            $publicHolidayList  = array();
            try {
                $csvDir = Config::get('csvexp.file_dir.public_holiday');
                $csvDirBk = Config::get('csvexp.file_dir.public_holiday_bk');
                $fileName = Config::get('csvexp.file_name.public_holiday');
                $fullName = $csvDir . $fileName;
                $fullBkName = $csvDirBk . $fileName;
                if (file_exists($fullName)) {
                    // 存在する場合
                    $fp   = fopen($fullName, "r");
                    while (($data = fgetcsv($fp, 0, ",")) !== false) {
                        $publicHolidayList = $data;
                    }
                    fclose($fp);
    
                    DB::beginTransaction();
                    $this->publicHolidayUC->deletePublicHolidayList();
                    $this->publicHolidayUC->inputPublicHolidayList($publicHolidayList);
                    rename($fullName, $fullBkName);
                    DB::commit();
                } else {
                    // 存在しない場合
                    $holidayList = $this->publicHolidayUC->getPublicHolidayList();
                    if (count($holidayList) > 0) {
                        $publicHolidayList = array_column($holidayList, 'date');
                    } else {
                        BatchLog::error('祝日データがCSV、DBに存在しません');
                        throw new Exception('祝日データがCSV、DBに存在しません');
                    }
                }
            } catch (Exception $exf) {
                BatchLog::error('祝日判定用配列生成処理に失敗しました。');
                DB::rollBack();
            }
            // 	[3]	終了ログ「祝日判定用配列生成処理終了」を出力する
            BatchLog::info('祝日判定用配列生成処理終了');

            // 4.カレンダー適用処理
            // 【処理概要】
            // 	項番5から10をカレンダー適用デポリスト分繰り返す
            // 	繰り返し処理終了後、項番12の処理を実行する
            // 【処理内容】
            // 	[1]	開始ログ「カレンダー適用処理開始」を出力する
            BatchLog::info('カレンダー適用処理開始');
            // 	[2]	以下の処理をカレンダー適用デポリスト分繰り返す
            // 		[2-a]	トランザクションを開始する
            foreach ($calendarDepoList as $calendarDepo) {
                try {
                    DB::beginTransaction();
                    // 		[2-b]	項番5から項番10を実行する
                    // 5.適用日付データ配列生成処理
                    // 【処理概要】
                    // 	カレンダー適用する対象の日付データを生成し配列に格納する
                    // 【処理内容】
                    // 	[1]	開始ログ「適用日付データ配列生成処理開始　デポCD[XXXX]」を出力する
                    BatchLog::info('カレンダー適用処理開始　デポCD['. $calendarDepo->depocd .']');
                    // 	[2]	1.パラメータ取得処理で取得した適用開始日より適用するデポの稼働開始日が未来の場合、適用開始日を稼働開始日とする
                    $cDate = Carbon::parse($date);
                    $depoStartDate = Carbon::parse($calendarDepo->startAt);
                    $startDate = $depoStartDate->gt($cDate) ? $depoStartDate->format('Ymd') : $cDate->format('Ymd');
                    // 	[3]	1.パラメータ取得処理で取得した処理モードが追加モードの場合
                    // 		[3-a]デポカレンダー承認情報テーブルでテーブル項目の年月が最大のデータを取得する
                    //          [3-a‐1]最新承認年月が取得できた場合、最新承認年月の次の月の1日が適用開始日となる
                    if ($mode == 1) {
                        $maxApprovalYm = $this->depoCalAprInfoUC->getMaxDate($calendarDepo->depocd);
                        $maxApprovalYmFirst = Carbon::parse($maxApprovalYm . '01');
                        $startDate = $maxApprovalYmFirst->addMonth()->format('Y-m-01');
                    }

                    // 	[4]	適用開始日～システム日付からｎヶ月後の末日までのカレンダ日付オブジェクトを生成し適用日付データ配列に格納する（※ｎは定義ファイルより取得）
                    $dateDataArray = array();
                    $calendarDataArray = array();
                    $startDate = Carbon::parse($startDate)->format('Ymd');
                    $n = Config::get('batch.calendarDepoMonth');
                    $endDate = Carbon::parse($startDate)->addMonth($n)->endOfMonth()->format('Ymd');
                    //祝日:１　祝前:２　祝後:3　それ以外:4
                    $publicHolidayCollect = collect($publicHolidayList);
                    for ($i = $startDate; $i <= $endDate; $i = Carbon::parse($i)->addDay()->format('Ymd')) {
                        $tomorrowDate = Carbon::parse($i)->addDay()->format('Ymd');
                        $yesterdayDate = Carbon::parse($i)->subDay()->format('Ymd');
                        if ($publicHolidayCollect->contains($i)) {
                            $syukuStatus = AppConst::PUBLIC_HOLIDAY_STATUS['today'];
                        } elseif ($publicHolidayCollect->contains($tomorrowDate)) {
                            $syukuStatus = AppConst::PUBLIC_HOLIDAY_STATUS['tomorrow'];
                        } elseif ($publicHolidayCollect->contains($yesterdayDate)) {
                            $syukuStatus = AppConst::PUBLIC_HOLIDAY_STATUS['yesterday'];
                        } else {
                            $syukuStatus = null;
                        }
                        $targetDate = Carbon::parse($i);
                        $date = $targetDate->dayOfWeek;
                        $dateDataArray["date"] = $i;
                        $dateDataArray["depoCd"] = $calendarDepo->depocd;
                        $dateDataArray["syukuStatus"] = $syukuStatus;
                        $dateDataArray["day"] = $date;
                        $calendarDataArray[] = $dateDataArray;
                    }

                    // 	[5]	終了ログ「適用日付データ配列生成処理終了　デポCD[XXXX]」を出力する
                    BatchLog::info('適用日付データ配列生成処理終了　デポCD['. $calendarDepo->depocd .']');

                    // 6.デポカレンダーデフォルト情報配列生成処理
                    // 【処理概要】
                    // 	デポカレンダーデフォルト情報テーブルから突合せ用に配列を作成する
                    // 【処理内容】
                    // 	[1]	開始ログ「デポカレンダーデフォルト情報配列生成処理　デポCD[XXXX]」を出力する
                    BatchLog::info('デポカレンダーデフォルト　デポCD['. $calendarDepo->depocd.']');
                    // 	[2]	デポカレンダーデフォルト情報テーブルから該当デポのデータを取得する
                    // 		「シート[DB] - 4. デポカレンダーデフォルト情報取得」を実行する
                    $depoDefaultCalData = $this->depoDefaultUC->findDepoDefault($calendarDepo->depocd);
                    // 	[3]	[2]の処理でデポカレンダーデフォルトデータが取得できたか判定
                    // 		a）取得できた場合
                    // 			[3-a]以下の図のような配列を生成する
                    //     b）取得できなかった場合
                    //     [3-b]トランザクションをロールバックし、エラーログを「デポカレンダーデフォルト情報取得失敗 デポCD[XXXX]　スキップします」を出力し、項番4.の2-c. a）の処理に移る
                    $depoDefaultCalDataArray = array();
                    $depoDefaultSetCalDataArray = array();
                    $depoDefaultDateDataArray = array('mon','tue','wed','thu','fri','sat','sun','holiBefore','holi','holiAfter');
                    $holi = 'holi';
                    if (!empty($depoDefaultCalData)) {
                        foreach ($depoDefaultDateDataArray as $val) {
                            if (0 === strpos($val, $holi)) {
                                $beforeDeadlineFlgName = $val.'DeadlineFlg';
                            } else {
                                $beforeDeadlineFlgName = $val.'BeforeDeadlineFlg';
                            }
                            $todayDeliveryFlgName = $val.'TodayDeliveryFlg';
                            $depoDefaultSetCalDataArray["beforeDeadlineFlg"] = $depoDefaultCalData->$beforeDeadlineFlgName;
                            ;
                            $depoDefaultSetCalDataArray["todayDeliveryFlg"] = $depoDefaultCalData->$todayDeliveryFlgName;
                            $depoDefaultCalDataArray[$val] = $depoDefaultSetCalDataArray;
                        }
                    } else {
                        BatchLog::error('デポカレンダーデフォルト情報取得失敗　デポCD['. $calendarDepo->depocd.']スキップします');
                        throw new Exception('デポカレンダーデフォルト情報取得失敗　デポCD['. $calendarDepo->depocd.']スキップします');
                    }
                    // [4]	終了ログ「デポカレンダーデフォルト情報配列生成処理終了　デポCD[XXXX]」を出力する
                    BatchLog::info('デポカレンダーデフォルト情報配列処理終了　デポCD['. $calendarDepo->depocd.']');
                    // 		処理モードが上書きの時、適用開始日以降の存在するカレンダーデータを削除する
                    // 	【処理内容】
                    // 		[1]	開始ログ「不要カレンダー日付データ削除処理開始　デポCD[XXXX]」を出力する
                    BatchLog::info('不要カレンダー日付データ削除処理開始　デポCD['. $calendarDepo->depocd .']');
                    // 		[2]	処理モードが上書きの時のみ、適用開始日以降のカレンダー日付データを削除する
                    // 			「シート[DB] - 5. 不要カレンダーデータ削除処理」を実行する
                    if ($mode == "2") {
                        $this->depoCalInfoUC->deleteDepoCalInfo($calendarDepo->depocd, $startDate);
                    }
                    // 		[3]	終了ログ「不要カレンダー日付データ削除処理終了　デポCD[XXXX]」を出力する
                    BatchLog::info('不要カレンダー日付データ削除処理開始　デポCD['. $calendarDepo->depocd .']');

                    // 8．デポカレンダー情報データ登録処理
                    // 	【処理概要】
                    // 		適用開始日以降のカレンダーデータを登録する
                    // 	【処理内容】
                    // 		[1]	開始ログ「デポカレンダー情報データ登録処理開始　デポCD[XXXX]」を出力する
                    BatchLog::info('デポカレンダー情報データ登録処理開始　デポCD['. $calendarDepo->depocd .']');
                    // 		[2]	項番5と6でつくった配列を突き合わせて、デポカレンダー情報を登録する（適用日付データ配列分繰り返し登録する）
                    // 			「シート[DB] -６. デポカレンダー情報登録処理」を実行する
                    //配列を使用し、要素順に(日:0〜土:6)を設定する
                    $week = [
                        'sun', //0
                        'mon', //1
                        'tue', //2
                        'wed', //3
                        'thu', //4
                        'fri', //5
                        'sat', //6
                    ];
                    $depoCalInputInfo = array();
                    //祝日:１　祝前:２　祝後:3　それ以外:4
                    foreach ($calendarDataArray as $calendarData) {
                        $depoCalInputInfo['depocd'] = $calendarData['depoCd'];
                        $depoCalInputInfo['date'] = $calendarData['date'];
                        $depoCalInputInfo['day'] = $calendarData['day'];
                        $depoCalInputInfo['syukuStatus'] = $calendarData['syukuStatus'];
                        if ($calendarData['syukuStatus'] == 1) {
                            $depoCalInputInfo['beforeDeadlineFlg'] = $depoDefaultCalDataArray['holi']['beforeDeadlineFlg'];
                            $depoCalInputInfo['todayDeliveryFlg'] = $depoDefaultCalDataArray['holi']['todayDeliveryFlg'];
                        } elseif ($calendarData['syukuStatus'] == 2) {
                            $depoCalInputInfo['beforeDeadlineFlg'] = $depoDefaultCalDataArray['holiBefore']['beforeDeadlineFlg'];
                            $depoCalInputInfo['todayDeliveryFlg'] = $depoDefaultCalDataArray['holiBefore']['todayDeliveryFlg'];
                        } elseif ($calendarData['syukuStatus'] == 3) {
                            $depoCalInputInfo['beforeDeadlineFlg'] = $depoDefaultCalDataArray['holiAfter']['beforeDeadlineFlg'];
                            $depoCalInputInfo['todayDeliveryFlg'] = $depoDefaultCalDataArray['holiAfter']['todayDeliveryFlg'];
                        } else {
                            $day = $calendarData['day'];
                            $dayText = $week[$day];
                            $depoCalInputInfo['beforeDeadlineFlg'] = $depoDefaultCalDataArray[$dayText]['beforeDeadlineFlg'];
                            $depoCalInputInfo['todayDeliveryFlg'] = $depoDefaultCalDataArray[$dayText]['todayDeliveryFlg'];
                        }
                        $this->depoCalInfoUC->inputDepoCalInfo($depoCalInputInfo);
                    }
                    // 		[3]	終了ログ「デポカレンダー情報データ登録処理終了　デポCD[XXXX]」を出力する
                    BatchLog::info('デポカレンダー情報データ登録処理終了　デポCD['. $calendarDepo->depocd .']');

                    // 9．デポカレンダー承認情報データ削除登録処理
                    // 	【処理概要】
                    // 		適用開始月以降のデポカレンダーデータを一度削除し再登録する
                    // 	【処理内容】
                    // 		[1]	開始ログ「デポカレンダー承認情報データ削除登録処理開始　デポCD[XXXX]」を出力する
                    BatchLog::info('デポカレンダー承認情報データ削除登録処理開始　デポCD['. $calendarDepo->depocd .']');
                    // 		[2]	適用開始月以降のデポカレンダー承認情報データを論理削除する
                    // 			「シート[DB] -7. デポカレンダー承認情報論理削除処理」を実行する
                    $this->depoCalAprInfoUC->deleteDepoCalAprInfo($calendarDepo->depocd, Carbon::parse($startDate)->format('Ym'));
                    // 		[3]	適用開始月から適用終了月までのデポカレンダー承認情報データを登録する
                    // 			「シート[DB] -８. デポカレンダー承認情報登録処理」を実行する
                    // 			適用開始月から適用終了月まで繰り返す
                    for ($i = Carbon::parse($startDate)->format('Ym'); $i <= Carbon::parse($endDate)->format('Ym'); $i = Carbon::parse($i . '01')->addMonth()->format('Ym')) {
                        $depoCalAprInfoArray["depocd"] = $calendarDepo->depocd;
                        $depoCalAprInfoArray["dateYm"] = $i;
                        $depoCalAprInfoArray["approvalDate"] = Carbon::now()->format('Y-m-d H:i:s');
                        $depoCalAprInfoArray["approvalId"] = $batchUserId;
                        $depoCalAprInfoArray["approvalFlg"] = 0;
                        $this->depoCalAprInfoUC->inputDepoCalAprInfo($depoCalAprInfoArray);
                    }
                    // 		[4]	終了ログ「デポカレンダー承認情報データ削除登録処理終了　デポCD[XXXX]」を出力する
                    BatchLog::info('デポカレンダー承認情報データ削除登録処理終了　デポCD['. $calendarDepo->depocd .']');

                    // １０．デポカレンダー情報‐TMP削除処理
                    // 	【処理概要】
                    // 		カレンダー適用開始日以降で論理削除されていないデポカレンダー情報‐tmpデータを論理削除する
                    // 	【処理内容】
                    // 		[1]	開始ログ「デポカレンダー情報-TMP削除処理開始　デポCD[XXXX]」を出力する
                    BatchLog::info('デポカレンダー情報ーTMP削除処理開始　デポCD['. $calendarDepo->depocd .']');
                    // 		[2]	カレンダー適用開始日以降のデポカレンダー情報‐tmpデータを削除する
                    // 			「シート[DB] -9. デポカレンダー情報‐tmp論理削除処理」を実行する
                    $this->depoCalInfoTmpUC->deleteDepoCalInfoTmp($calendarDepo->depocd, $startDate, $batchUserId);
                    // 		[3]	終了ログ「デポカレンダー情報-TMP削除処理終了　デポCD[XXXX]」を出力する
                    BatchLog::info('デポカレンダー情報ーTMP削除処理終了　デポCD['. $calendarDepo->depocd .']');
                    // 		[2-c]	トランザクションを終了する
                    // 			a）正常終了した場合
                    // 				コミットを実行し、終了ログ「カレンダー適用処理終了 デポCD[XXXX]」を出力する
                    DB::commit();
                    BatchLog::info('カレンダー適用処理終了 デポCD['.$calendarDepo->depocd.']');
                    continue;
                } catch (Exception $e) {
                    // 			b）異常終了した場合
                    // 				ロールバックを実行し、エラーログ「【処理名】でエラーが発生しました デポCD[XXXX]」を出力する
                    DB::rollBack();
                    BatchLog::error('カレンダー適用処理でエラーが発生しました　デポCD['.$calendarDepo->depocd.']');
                    throw $e;
                }
            }

            // 11．処理結果出力処理
            // 	【処理概要】
            // 		バッチの処理結果を出力する
            // 	【処理内容】
            // 		[1]	異常終了の場合はエラーメッセージを標準出力する。
            // 		[2]	正常終了の場合、「カレンダーデータ更新バッチ正常終了」、異常終了の場合「カレンダーデータ更新バッチ異常終了」をログ出力する。
            // 		[3]	正常終了の場合:0　異常終了の場合:１を処理結果として返す。
            DB::commit();
            BatchLog::info('カレンダーデータ更新バッチ正常終了');
            return 0;
        } catch (Exception $e) {
            BatchLog::error($e->getMessage());
            DB::rollBack();
            BatchLog::info('カレンダーデータ更新バッチ異常終了');
            return 1;
        }
    }
}
