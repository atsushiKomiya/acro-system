<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\ViewDepoRepositoryInterface;
use Illuminate\Support\Collection;

class DepoListUseCase
{
    // 住所情報View
    private $iViewDepoRepository;

    /**
     * コンストラクタ
     *
     * @param ViewDepoRepositoryInterface $iViewDepoRepository
     */
    public function __construct(
        ViewDepoRepositoryInterface $iViewDepoRepository
    ) {
        $this->iViewDepoRepository = $iViewDepoRepository;
    }

    /**
     * デポ一覧全件取得
     *
     * @return Collection
     */
    public function findDepoListAll(): Collection
    {
        $depoList = $this->iViewDepoRepository->findDepoListAll();
        return collect($depoList);
    }
}
