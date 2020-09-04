<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\ViewDepoEntity;
use App\Domain\Factories\ViewDepoFactory;
use App\Domain\Models\ViewDepo;
use App\Domain\Repositories\ViewDepoRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentViewDepoRepository implements ViewDepoRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param ViewDepo $viewDepo
     * @param ViewDepoFactory $viewDepoFactory
     */
    public function __construct(ViewDepo $viewDepo, ViewDepoFactory $viewDepoFactory)
    {
        $this->eloquent = $viewDepo;
        $this->factory = $viewDepoFactory;
    }

    /**
     * デポ取得
     *
     * @param int $depocd
     * @return ViewDepoEntity
     */
    public function findDepo(int $depocd): ?ViewDepoEntity
    {
        $result = null;
        
        $model = $this->eloquent::select(
            'view_depo.depocd',
            'view_depo.deponame',
            'view_depo.display_group_type',
            'view_depo.depo_type',
            'view_depo.depo_pref',
            'view_depo.depo_addr',
            'view_depo.start_at',
            'view_depo.end_at',
            'view_depo.stop',
            'leadtime_display_group.display_group_id',
            'leadtime_display_group.display_group_type',
            'leadtime_display_group.display_group_name',
            'leadtime_display_group.display_type',
            'leadtime_display_group.rear_stand_flg',
        )
        ->join('leadtime_display_group', 'view_depo.display_group_type', '=', 'leadtime_display_group.display_group_type')
        ->where('view_depo.depocd', $depocd)
        ->first();

        if (!is_null($model)) {
            $result = $this->factory->makeDepoAndGroup($model);
        }
        return $result;
    }

    /**
     * デポ取得
     *
     * @param int $depocd
     * @return ViewDepoEntity
     */
    public function findViewDepo(int $depocd): ?ViewDepoEntity
    {
        $result = null;
        
        $model = $this->eloquent::select(
            'depocd',
            'deponame',
            'display_group_type',
            'depo_type',
            'depo_pref',
            'depo_addr',
            'start_at',
            'end_at',
            'stop',
        )
        ->where('depocd', $depocd)
        ->first();

        if (!is_null($model)) {
            $result = $this->factory->make($model);
        }
        return $result;
    }

    /**
     * デポ一覧全件の取得
     *
     * @return array
     */
    public function findDepoListAll(): array
    {
        $result = array();
        $cursor = $this->eloquent::select(
            'depocd AS depocd',
            'deponame AS deponame',
            'display_group_type AS displayGroupType',
            'depo_type AS depoType',
            'depo_pref AS depoPref',
            'depo_addr AS depoAddr',
            'start_at AS startAt',
            'end_at AS endAt',
            'stop AS stop',
        )
        ->where('stop', 'false')
        ->orderBy('depocd')
        ->orderBy('depo_pref')
        ->cursor();
        foreach ($cursor as $view) {
            $result[] = $view;
        }
        return $result;
    }

    /**
     * 有効デポ情報取得
     *
     * @return array
     */
    public function getStartAtViewDepo()
    {
        $viewDepoFactory = $this->factory;
        $result = $this->eloquent::where('stop', 'false')
        ->orderBy('depocd')
        ->get()
        ->map(function ($item) use ($viewDepoFactory) {
            return $viewDepoFactory->make($item);
        })->all();
        return $result;
    }

    /**
     * 有効デポ情報取得（適用デポCDリスト使用）
     *
     * @return array
     */
    public function getStartAtViewDepoWithDepolist($depoList): array
    {
        $viewDepoFactory = $this->factory;
        $result = $this->eloquent::whereIn('depocd', $depoList)
        ->where('stop', 'false')
        ->orderBy('depocd')
        ->get()
        ->map(function ($item) use ($viewDepoFactory) {
            return $viewDepoFactory->make($item);
        })->all();
        return $result;
    }

    /**
     * カレンダー更新対象デポリスト取得
     *
     * @return array
     */
    public function getUpdateTaisyoDepoList($currentYm, $checkMonth)
    {
        $query = $this->eloquent::select(
            'view_depo.depocd'
        )
        ->leftJoin('depo_cal_apr_info', function ($join) use ($currentYm,$checkMonth) {
            $join->on('view_depo.depocd', '=', 'depo_cal_apr_info.depo_cd');
            $join->where(DB::raw("cast(date_ym as integer)"), '>=', $currentYm);
            $join->where(DB::raw("cast(date_ym as integer)"), '<=', $checkMonth);
        })
        ->whereNull('depo_cal_apr_info.depo_cd')
        ->where('stop', '=', false)->get();

        return $query;
    }
}
