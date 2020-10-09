<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\PublicHolidayEntity;
use App\Domain\Factories\PublicHolidayFactory;
use App\Domain\Models\PublicHoliday;
use App\Domain\Repositories\PublicHolidayRepositoryInterface;

class EloquentPublicHolidayRepository implements PublicHolidayRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param PublicHoliday $publicHoliday
     * @param PublicHolidayFactory $publicHolidayFactory
     */
    public function __construct(PublicHoliday $publicHoliday, PublicHolidayFactory $publicHolidayFactory)
    {
        $this->eloquent = $publicHoliday;
        $this->factory = $publicHolidayFactory;
    }

    /**
     * 祝日リスト削除
     *
     * @return PublicHolidayEntity
     */
    public function deletePublicHolidayList()
    {
        // ロックが取得できない場合はエラーにする
        $this->eloquent::withTrashed()->lock('for update nowait')->get();
        $result = $this->eloquent::truncate();

        return $result;
    }

    /**
     * 祝日リスト登録
     *
     * @return array
     */
    public function inputPublicHolidayList($publicHolidayList)
    {
        foreach ($publicHolidayList as $publicHolidayDate) {
            $publicHolidayModel = $this->eloquent::insert(
                [
                    'date' => $publicHolidayDate
                ],
            );
        }
    }

    /**
     * 祝日リスト取得
     *
     * @return array
     */
    public function getPublicHolidayList()
    {
        $publicHolidayFactory = $this->factory;
        $result = $this->eloquent::orderBy('date')
        ->get()
        ->map(function ($item) use ($publicHolidayFactory) {
            return $publicHolidayFactory->make($item);
        })->all();
        return $result;
    }
}
