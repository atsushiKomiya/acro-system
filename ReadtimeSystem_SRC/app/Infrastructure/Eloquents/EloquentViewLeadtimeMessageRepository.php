<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Factories\ViewLeadtimeMessageFactory;
use App\Domain\Models\ViewLeadtimeMessage;
use App\Domain\Repositories\ViewLeadtimeMessageRepositoryInterface;

class EloquentViewLeadtimeMessageRepository implements ViewLeadtimeMessageRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    // private $factory;

    /**
     * コンストラクタ
     *
     * @param ViewLeadtimeMessage $viewLeadtimeMessage
     */
    public function __construct(ViewLeadtimeMessage $viewLeadtimeMessage)
    {
        $this->eloquent = $viewLeadtimeMessage;
    }

    /**
     * 文言通知取得
     *
     * @param string $date
     * @return array
     */
    public function findInfoMessageList(string $date): array
    {
        $resultList = $this->eloquent::where('view_limit', '>=', $date)
        ->get()
        ->map(function ($item) {
            return (new ViewLeadtimeMessageFactory)->make($item);
        })
        ->all();

        return $resultList;
    }
}
