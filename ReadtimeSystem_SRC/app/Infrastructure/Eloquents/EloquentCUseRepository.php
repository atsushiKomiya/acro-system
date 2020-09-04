<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Factories\CUseFactory;
use App\Domain\Models\CUse;
use App\Domain\Repositories\CUseRepositoryInterface;

class EloquentCUseRepository implements CUseRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param CUse $cUse
     */
    public function __construct(CUse $cUse, CUseFactory $factory)
    {
        $this->eloquent = $cUse;
        $this->factory = $factory;
    }

    /**
     * 用途一覧の取得
     *
     * @return array
     */
    public function findCUseList(): array
    {
        $cUseFactory = $this->factory;
        $result = $this->eloquent::select(
            'c_use',
            'keicho_type',
            'c_use_name'
        )
        ->get()
        ->map(function ($item) use ($cUseFactory) {
            return $cUseFactory->makeCUse($item);
        })->all();
        return $result;
    }
}
