<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\CalendarConfirmEntity;
use App\Domain\Entities\DepoCalAprInfoEntity;
use App\Domain\Entities\DepoCalInfoEntity;
use App\Domain\Entities\DepoChangeRequestCalendarEntity;
use App\Domain\Entities\DepoChangeRequestCalendarListEntity;
use App\Domain\Models\DepoCalAprInfo;
use App\Domain\Repositories\DepoCalAprInfoRepositoryInterface;
use App\Domain\Factories\BaseFactory;
use App\Domain\Factories\DepoCalAprInfoFactory;
use App\Domain\Factories\MessageDuplicationFactory;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class EloquentDepoCalAprInfoRepository implements DepoCalAprInfoRepositoryInterface
{
    // Model
    private $eloquent;
    // ファクトリを格納するプロパティ
    private $factory;
    private $depoCalAprInfoFactory;

    /**
     * コンストラクタ
     *
     * @param DepoCalAprInfo $depoCalAprInfo
     */
    public function __construct(DepoCalAprInfo $depoCalAprInfo, BaseFactory $factory, DepoCalAprInfoFactory $depoCalAprInfoFactory)
    {
        $this->eloquent = $depoCalAprInfo;
        $this->factory = $factory;
        $this->depoCalAprInfoFactory = $depoCalAprInfoFactory;
    }

    /**
     * 未承認カレンダー件数取得
     *
     * @return integer
     */
    public function findUnapprovedCount(): int
    {
        $resultCnt = $this->eloquent::whereNull('approval_date')->count();
        return $resultCnt;
    }

    /**
     * 対象デポの最新の承認日を取得
     *
     * @param [type] $depoCd
     * @return void
     */
    public function getMaxDate($depoCd)
    {
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->orderBy('depo_cal_apr_id')
        ->max('date_ym');

        return $result;
    }

    /**
     * 指定年月以降の承認情報を論理削除する
     *
     * @param [type] $depocd
     * @param [type] $deliveryDate
     * @return void
     */
    public function deleteDepoCalAprInfo($depocd, $deliveryDate)
    {
        $result = $this->eloquent::where('depo_cd', $depocd)
        ->whereRaw("cast(date_ym as integer) >= " . $deliveryDate)
        ->delete();

        return $result;
    }

    /**
     * 承認情報を登録する
     *
     * @param [type] $depoCalAprInfoArray
     * @return void
     */
    public function inputDepoCalAprInfo($depoCalAprInfoArray)
    {
        $result = "";
        $depoDefaultModel = $this->eloquent::insert(
            [
                'depo_cd' => $depoCalAprInfoArray["depocd"],
                'date_ym' => $depoCalAprInfoArray["dateYm"],
                'approval_date' => $depoCalAprInfoArray["approvalDate"],
                'approval_id' => $depoCalAprInfoArray["approvalId"],
                'confirm_flg' => $depoCalAprInfoArray["approvalFlg"],
            ]
        );

        return $result;
    }

    /**
     * 指定のデポの対象年月の承認情報を取得する
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @return DepoCalAprInfoEntity
     */
    public function getDepoCalAprInfo(int $depoCd, string $dateYm): ?DepoCalAprInfoEntity
    {
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->where('date_ym', $dateYm)
        ->first();

        if ($result != null) {
            $result = $this->factory->makeEntityByModel($result, DepoCalAprInfoEntity::class);
        }

        return $result;
    }

    /**
     * デポ休業等申請情報取得
     *
     * @param integer $depoCd
     * @param string $targetYm
     * @return DepoChangeRequestCalendarEntity
     */
    public function findChangeRequestCalendar(int $depoCd, string $targetYm): ?DepoChangeRequestCalendarEntity
    {
        $cursors = $this->eloquent::select(
            'depo_cal_apr_info.depo_cal_apr_id',
            'depo_cal_apr_info.depo_cd',
            'depo_cal_apr_info.date_ym',
            'depo_cal_apr_info.approval_date',
            'depo_cal_apr_info.approval_id',
            'depo_cal_apr_info.confirm_flg',
            'depo_cal_info.depo_cal_id',
            'depo_cal_info_tmp.depo_cal_tmp_id',
            'depo_cal_info.before_deadline_flg AS old_before_deadline_flg',
            'depo_cal_info.today_delivery_flg AS old_today_delivery_flg',
            'depo_cal_info.before_deadline_limit_time AS old_before_deadline_limit_time',
            'depo_cal_info.today_deadline_limit_time AS old_today_deadline_limit_time',
            DB::raw("CASE WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL THEN depo_cal_info.delivery_date ELSE depo_cal_info_tmp.delivery_date END delivery_date"),
            DB::raw("CASE WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL THEN depo_cal_info.before_deadline_flg ELSE depo_cal_info_tmp.before_deadline_flg END before_deadline_flg"),
            DB::raw("CASE WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL THEN depo_cal_info.today_delivery_flg ELSE depo_cal_info_tmp.today_delivery_flg END today_delivery_flg"),
            DB::raw("CASE WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL THEN depo_cal_info.before_deadline_limit_time ELSE depo_cal_info_tmp.before_deadline_limit_time END before_deadline_limit_time"),
            DB::raw("CASE WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL THEN depo_cal_info.today_deadline_limit_time ELSE depo_cal_info_tmp.today_deadline_limit_time END today_deadline_limit_time"),
            DB::raw("CASE WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL THEN depo_cal_info.dayofweek ELSE depo_cal_info_tmp.dayofweek END dayofweek"),
            DB::raw("CASE WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL THEN depo_cal_info.public_holiday_status ELSE depo_cal_info_tmp.public_holiday_status END public_holiday_status"),
            DB::raw("CASE WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL THEN depo_cal_info.annotation_depo ELSE depo_cal_info_tmp.annotation_depo END annotation_depo"),
            DB::raw("CASE WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL THEN depo_cal_info.annotation_disp ELSE depo_cal_info_tmp.annotation_disp END annotation_disp"),
            'depo_cal_info_tmp.approval_flg',
            DB::raw('(
                CASE
                    WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL
                        THEN false 
                    WHEN (depo_cal_info.before_deadline_flg = depo_cal_info_tmp.before_deadline_flg) AND
                         (depo_cal_info.before_deadline_limit_time = depo_cal_info_tmp.before_deadline_limit_time) 
                        THEN false 
                    ELSE true
                END
            ) AS is_change_before'),
            DB::raw('(
                CASE
                    WHEN depo_cal_info_tmp.depo_cal_tmp_id IS NULL
                        THEN false 
                    WHEN (depo_cal_info.today_delivery_flg = depo_cal_info_tmp.today_delivery_flg) AND
                         (depo_cal_info.today_deadline_limit_time = depo_cal_info_tmp.today_deadline_limit_time) 
                        THEN false 
                    ELSE true
                END
            ) AS is_change_today'),
        )->join('depo_cal_info', function ($join) use ($targetYm) {
            $join->on('depo_cal_info.depo_cd', '=', 'depo_cal_apr_info.depo_cd');
            $join->where('depo_cal_info.delivery_date', 'LIKE', $targetYm.'%');
        })->leftJoin('depo_cal_info_tmp', function ($join) {
            $join->on('depo_cal_info_tmp.depo_cd', '=', 'depo_cal_apr_info.depo_cd');
            $join->on('depo_cal_info_tmp.delivery_date', '=', 'depo_cal_info.delivery_date');
            $join->where(function ($query) {
                $query->orWhere('depo_cal_info_tmp.approval_flg', '=', '0');
                $query->orWhereNull('depo_cal_info_tmp.approval_flg');
            });
        })->where(
            'depo_cal_apr_info.date_ym',
            '=',
            $targetYm
        )->where(
            'depo_cal_apr_info.depo_cd',
            '=',
            $depoCd
        )->orderBy('delivery_date', 'asc')
        ->cursor();

        $result = null;
        $list = array();
        if ($cursors->count() != 0) {
            $result = new DepoChangeRequestCalendarEntity();
            $model = $cursors->first();
            $result = $this->factory->makeEntityByModel($model, DepoChangeRequestCalendarEntity::class);
            foreach ($cursors as $cursor) {
                $list[$cursor->delivery_date] = $this->factory->makeEntityByModel($cursor, DepoChangeRequestCalendarListEntity::class);
            }
            
    
            $result->calendarList = $list;
        }

        return $result;
    }

    /**
     * デポカレンダー一覧取得
     *
     * @param string $ym
     * @param integer $pref
     * @param boolean $isNotApproval
     * @param boolean $isNotConfirm
     * @param integer $displayType
     * @param array $ymdList
     * @return array
     */
    public function findDepoCalendarList(string $ym, ?int $pref, bool $isNotApproval, bool $isNotConfirm, int $displayType, array $ymdList): array
    {
        $resultList = array();

        $query = $this->queryFindDepoCalendarList($ym, $pref, $isNotApproval, $isNotConfirm, $displayType, $ymdList);

        // カーソル取得取得
        foreach ($query->cursor() as $depoCalInfo) {
            $resultList[] = $this->factory->makeEntityByModel($depoCalInfo, CalendarConfirmEntity::class) ;
        }

        return $resultList;
    }

    /**
     * デポカレンダー一覧CSV取得用
     *
     * @param string $ym
     * @param integer $pref
     * @param boolean $isNotApproval
     * @param boolean $isNotConfirm
     * @param integer $displayType
     * @param array $ymdList
     * @return LazyCollection
     */
    public function findDepoCalendarListCsv(string $ym, ?int $pref, bool $isNotApproval, bool $isNotConfirm, int $displayType, array $ymdList): LazyCollection
    {
        $query = $this->queryFindDepoCalendarList($ym, $pref, $isNotApproval, $isNotConfirm, $displayType, $ymdList);
        // CSVクラスで処理するため、カーソルで返却する
        $cursor = $query->cursor();

        return $cursor;
    }

    /**
     * デポカレンダー一覧取得用のqueryを作成する
     *
     * @param string $ym
     * @param integer $pref
     * @param boolean $isNotApproval
     * @param boolean $isNotConfirm
     * @param integer $displayType
     * @param array $ymdList
     * @return void
     */
    private function queryFindDepoCalendarList(string $ym, ?int $pref, bool $isNotApproval, bool $isNotConfirm, int $displayType, array $ymdList): Builder
    {

        // 都道府県一時テーブル query
        $prefQuery = DB::table('view_address')->select(
            DB::raw("to_number(pref,'99') AS pref"),
            'pref_name'
        )->distinct(
            'pref'
        );

        // カレンダー情報一時テーブル カラム
        $columnList = array(
            'depo_cal_info.depo_cd',
        );
        foreach ($ymdList as $ymd) {
            $day = Carbon::createFromFormat('Ymd', $ymd)->day;
            $columnList[] = DB::raw(
                "MAX(CASE depo_cal_info.delivery_date WHEN '" . $ymd . "' THEN COALESCE(depo_cal_info_tmp.before_deadline_flg,depo_cal_info.before_deadline_flg) ELSE null END) AS \"before_deadline_flg" . $day . "\""
            );
            $columnList[] = DB::raw(
                "MAX(CASE depo_cal_info.delivery_date WHEN '" . $ymd . "' THEN COALESCE(depo_cal_info_tmp.today_delivery_flg,depo_cal_info.today_delivery_flg) ELSE null END) AS \"today_delivery_flg" . $day . "\""
            );
            $columnList[] = DB::raw(
                "MAX(CASE depo_cal_info.delivery_date WHEN '" . $ymd . "' THEN COALESCE(depo_cal_info_tmp.before_deadline_limit_time,depo_cal_info.before_deadline_limit_time) ELSE null END) AS \"before_deadline_limit_time" . $day . "\""
            );
            $columnList[] = DB::raw(
                "MAX(CASE depo_cal_info.delivery_date WHEN '" . $ymd . "' THEN COALESCE(depo_cal_info_tmp.today_deadline_limit_time,depo_cal_info.today_deadline_limit_time) ELSE null END) AS \"today_deadline_limit_time" . $day . "\""
            );
            $columnList[] = DB::raw(
                "MAX(CASE depo_cal_info.delivery_date WHEN '" . $ymd . "' THEN COALESCE(depo_cal_info_tmp.dayofweek,depo_cal_info.dayofweek) ELSE null END) AS \"dayofweek" . $day . "\""
            );
            $columnList[] = DB::raw(
                "MAX(CASE depo_cal_info.delivery_date WHEN '" . $ymd . "' THEN COALESCE(depo_cal_info_tmp.public_holiday_status,depo_cal_info.public_holiday_status) ELSE null END) AS \"public_holiday_status" . $day . "\""
            );
            $columnList[] = DB::raw(
                "MAX(CASE depo_cal_info.delivery_date WHEN '" . $ymd . "' THEN COALESCE(depo_cal_info_tmp.annotation_depo,depo_cal_info.annotation_depo) ELSE null END) AS \"annotation_depo" . $day . "\""
            );
            $columnList[] = DB::raw(
                "MAX(CASE depo_cal_info.delivery_date WHEN '" . $ymd . "' THEN COALESCE(depo_cal_info_tmp.annotation_disp,depo_cal_info.annotation_disp) ELSE null END) AS \"annotation_disp" . $day . "\""
            );
        }

        // カレンダー情報一時テーブル query
        $depoCalInfoQuery = DB::table('depo_cal_info')->select(
            $columnList
        )->leftJoin('depo_cal_info_tmp', function ($join) {
            $join->on('depo_cal_info_tmp.depo_cd', '=', 'depo_cal_info.depo_cd');
            $join->on('depo_cal_info_tmp.delivery_date', '=', 'depo_cal_info.delivery_date');
        })->where(
            'depo_cal_info.delivery_date',
            'LIKE',
            "$ym%"
        )->groupBy(
            'depo_cal_info.depo_cd'
        );

        // 社員テーブル query
        $shainQuery = DB::table('view_shain')->select(
            'e_code',
            DB::raw("concat(name1,name2) AS name"),
        )->distinct(
            'e_code'
        );

        // -------------- main query --------------
        $query = $this->eloquent::select(
            'depo_cal_apr_info.depo_cd',
            'view_depo.deponame',
            'view_depo.display_group_type',
            'view_depo.depo_pref AS pref_cd',
            'view_address.pref_name',
            DB::raw("to_char(depo_cal_apr_info.approval_date,'yyyy/MM/dd') AS approval_date"),
            'depo_cal_apr_info.approval_id',
            'shain.name AS approval_name',
            'depo_cal_apr_info.confirm_flg',
            'depo_cal_info.*',
        )->join('view_depo', function ($join) {
            $join->on('view_depo.depocd', '=', 'depo_cal_apr_info.depo_cd');
        })->leftJoinSub($prefQuery, 'view_address', function ($join) {
            $join->on('view_address.pref', '=', 'view_depo.depo_pref');
        })->joinSub($depoCalInfoQuery, 'depo_cal_info', function ($join) {
            $join->on('depo_cal_info.depo_cd', '=', 'depo_cal_apr_info.depo_cd');
        })->leftJoinSub($shainQuery, 'shain', function ($join) {
            $join->on('shain.e_code', '=', 'depo_cal_apr_info.approval_id');
        })->where(
            'depo_cal_apr_info.date_ym',
            '=',
            $ym
        )->orderBy('view_depo.depo_pref', 'asc');

        // -------------- 検索条件 --------------
        // 都道府県
        if (!empty($pref) || $pref === 0) {
            $query = $query->where('view_depo.depo_pref', '=', $pref);
        }

        // 表示グループ
        if (!empty($displayType)) {
            $query = $query->where('view_depo.display_group_type', '=', $displayType);
        }

        // 未承認データのみ表示
        if ($isNotApproval) {
            $query = $query->whereNull('depo_cal_apr_info.approval_date');
        }

        // 未確認データのみ表示
        if ($isNotConfirm) {
            $query = $query->where(function ($subQuery) {
                $subQuery->orWhere('depo_cal_apr_info.confirm_flg', '=', '0');
                $subQuery->orWhereNull('depo_cal_apr_info.confirm_flg');
            });
        }

        return $query;
    }

    /**
     * デポカレンダー承認
     *
     * @param string $dateYm
     * @param integer $depoCd
     * @param string $userId
     * @return int
     */
    public function approval(string $dateYm, int $depoCd, string $userId): bool
    {
        $model = $this->eloquent::where('date_ym', $dateYm)->where('depo_cd', $depoCd)->first();
        if (!is_null($model)) {
            $model->approval_date = now();
            $model->approval_id = $userId;
            $model->save();
        } else {
            throw new Exception("承認情報が存在しません");
        }

        return true;
    }

    /**
     * カレンダー承認情報削除
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @param integer $userId
     * @return void
     */
    public function deleteDepoCalAprInfoApi(int $depoCd, string $dateYm, int $userId)
    {
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->where('date_ym', '=', $dateYm)
        ->update(
            [
                'deleted_id' => $userId,
                'deleted_at' => now()
            ]
        );

        return $result;
    }

    /**
     * デポカレンダー承認情報登録
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @return void
     */
    public function saveDepoCalAprInfoApi(int $depoCd, string $dateYm)
    {
        $model = $this->eloquent::where('depo_cd', $depoCd)
        ->where('date_ym', '=', $dateYm)->first();
        if (is_null($model)) {
            $model = new DepoCalAprInfo();
        }
        $model->depo_cd = $depoCd;
        $model->date_ym = $dateYm;
        $result = $model->save();
        return $result;
    }

    /**
     * デポカレンダー承認情報確認処理
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @return void
     */
    public function confirmDepoCalAprInfoApi(int $depoCd, string $dateYm)
    {
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->where('date_ym', '=', $dateYm)
        ->update(
            [
                'confirm_flg' => true
            ]
        );

        return $result;
    }

    /**
     * 有効な対象年月一覧の取得
     *
     * @return array
     */
    public function findMonthList($depoCd): array
    {
        $query = $this->eloquent::select(
            'date_ym as dateYm'
        );

        if (!empty($depoCd)) {
            $query = $query->where('depo_cd', '=', $depoCd);
        }
        $result = $query->distinct()
        ->orderBy('date_ym')
        ->get()
        ->all();
        
        return $result;
    }

    /**
     * デポ承認情報不要データ論理削除
     *
     * @param array $unnecessaryDepoList
     */
    public function deleteDepoCalAprUnnecessary($unnecessaryDepoList)
    {
        foreach ($unnecessaryDepoList as $value) {
            $result = $this->eloquent::whereNull('deleted_at')
            ->where('depo_cd', $value)
            ->delete();
        }
    }
    
    /**
     * 【C_LB_03】CreanUPバッチ
     * デポカレンダ－承認情報論理削除
     * @return void
     */
    public function deleteDepoCalAprInfoCreanUp($criterionDate, $userId)
    {
        $query = $this->eloquent::query();
        $query->where('date_ym', '<', $criterionDate)
        ->whereNull('deleted_at')
        ->update(
            [
                'deleted_id' => $userId,
                'deleted_at' => now()
            ]
        );
    }

    /**
     * 申込画面表示注釈（表示）一覧取得
     *
     * @param [type] $depoCdList
     * @param [type] $dateFrom
     * @param [type] $dateTo
     * @param [type] $dayofweekList
     * @param [type] $publicHolidayStatusList
     * @return array
     */
    public function findAnnoDispMessageList($depoCdList, $dateFrom, $dateTo, $dayofweekList, $publicHolidayStatusList): array
    {
        $result = [];

        $query = $this->eloquent::select(
            DB::raw("'1' AS message_type"),
            'depo_cal_apr_info.depo_cd',
            'depo_cal_apr_info.date_ym',
            'depo_cal_info.depo_cal_id',
            'depo_cal_info.delivery_date',
            'depo_cal_info.dayofweek',
            'depo_cal_info.public_holiday_status',
            'depo_cal_info.annotation_depo',
            'depo_cal_info.annotation_disp',
        )->join('depo_cal_info', function ($join) {
            $join->on('depo_cal_info.depo_cd', '=', 'depo_cal_apr_info.depo_cd');
            $join->whereRaw("depo_cal_info.delivery_date LIKE depo_cal_apr_info.date_ym || '%'");
        });

        // メッセージが登録されているデータのみ
        $query->where(function($query){
            $query->whereNotNull('depo_cal_info.annotation_disp');
        });

        // デポ
        if($depoCdList) {
            $query->whereIn('depo_cal_info.depo_cd', $depoCdList);
        }

        // 対象年月日　FROM　〜　TO
        if($dateFrom && $dateTo) {
            $query->where('depo_cal_info.delivery_date', '>=', $dateFrom);
            $query->where('depo_cal_info.delivery_date', '<=', $dateTo);

        }

        // 曜日
        if($dayofweekList) {
            $query->whereIn('depo_cal_info.dayofweek', $dayofweekList);
        }

        // 祝日ステータス
        if($publicHolidayStatusList) {
            $query->whereIn('depo_cal_info.public_holiday_status', $publicHolidayStatusList);
        }

        $query->groupBy(
            'message_type',
            'depo_cal_apr_info.depo_cd',
            'depo_cal_apr_info.date_ym',
            'depo_cal_info.depo_cal_id',
            'depo_cal_info.dayofweek',
            'depo_cal_info.public_holiday_status',
            'depo_cal_info.annotation_depo',
            'depo_cal_info.annotation_disp',
        );
        

        $factory = new MessageDuplicationFactory();
        foreach($query->cursor() as $cursor) {
            $result[] = $factory->makeDepoCalInfoMessageDuplication($cursor);
        }

        return $result;
    }

}
