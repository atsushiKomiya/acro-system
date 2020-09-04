<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Factories\LeadtimeDisplayGroupFactory;
use App\Domain\Models\LeadtimeDisplayGroup;
use App\Domain\Repositories\LeadtimeDisplayGroupRepositoryInterface;

class EloquentLeadtimeDisplayGroupRepository implements LeadtimeDisplayGroupRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param ViewDepo $viewDepo
     */
    public function __construct(LeadtimeDisplayGroup $leadtimeDisplayGroup, LeadtimeDisplayGroupFactory $factory)
    {
        $this->eloquent = $leadtimeDisplayGroup;
        $this->factory = $factory;
    }

    /**
     * 表示グループ区分リストの取得
     *
     * @return array
     */
    public function findDisplayGroupList(): array
    {
        $displayGroupFactory = $this->factory;
        $result = $this->eloquent::select(
            'display_group_type',
            'display_group_name',
        )
        ->distinct()
        ->orderBy('display_group_type')
        ->get()
        ->map(function ($item) use ($displayGroupFactory) {
            return $displayGroupFactory->makeDisplayGroup($item);
        })->all();
        return $result;
    }
}
