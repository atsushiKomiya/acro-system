<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\IrregularDayofweekEntity;
use App\Domain\Factories\IrregularDayofweekFactory;
use App\Domain\Models\IrregularDayofweek;
use App\Domain\Repositories\IrregularDayofweekRepositoryInterface;

class EloquentIrregularDayofweekRepository implements IrregularDayofweekRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param Irregular $irregular
     */
    public function __construct(IrregularDayofweek $irregularDayofweek, IrregularDayofweekFactory $factory)
    {
        $this->eloquent = $irregularDayofweek;
        $this->factory = $factory;
    }

    /**
     * イレギュラー設定の取得
     *
     * @return array
     */
    public function findIrregularDayofweek($irregularId): array
    {
        $irregularDayofweekFactory = $this->factory;
        $result = $this->eloquent::select(
            'irregular_dayofweek_id',
            'irregular_id',
            'date_type',
            'dayofweek',
            'public_holiday_status',
            'created_id',
            'created_at',
            'updated_id',
            'updated_at'
        )
    ->where('irregular_id', $irregularId)
    ->get()
    ->map(function ($item) use ($irregularDayofweekFactory) {
        return $irregularDayofweekFactory->make($item);
    })->all();

        return $result;
    }

    /**
     * イレギュラー曜日登録
     *
     * @param IrregularDayofweekEntity $entity
     * @return void
     */
    public function save(IrregularDayofweekEntity $entity)
    {
        $irregularDayofweek = $this->eloquent::find($entity->irregularDayofweekId);

        if (is_null($irregularDayofweek)) {
            $irregularDayofweek = new irregularDayofweek();
        }

        $irregularDayofweek->irregular_id = $entity->irregularId;
        $irregularDayofweek->date_type = $entity->dateType;
        $irregularDayofweek->dayofweek = $entity->dayofweek;
        $irregularDayofweek->public_holiday_status = $entity->publicHolidayStatus;
        $irregularDayofweek->save();
    }

    /**
     * イレギュラー曜日物理削除
     *
     * @param [type] $irregularId
     * @param integer|null $dateYpe
     * @return void
     */
    public function forceDeleteByIrregularId($irregularId, ?int $dateType = null)
    {
        $query = $this->eloquent::where('irregular_id', $irregularId);

        if ($dateType) {
            $query->where('date_type', '=', $dateType);
        }

        $result = $query->forceDelete();

        return $result;
    }
}
