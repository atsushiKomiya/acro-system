<?php

namespace App\Application\UseCases;

use App\Domain\Entities\ViewDepoEntity;
use App\Domain\Repositories\LeadtimeDisplayGroupRepositoryInterface;
use App\Domain\Repositories\ViewDepoRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class DepoUseCase
{
    // 住所情報View
    private $iLeadtimeDisplayGroupRepository;
    // デポView
    private $iViewDepoRepository;

    /**
     * コンストラクタ
     *
     * @param LeadtimeDisplayGroupRepositoryInterface $iViewDepoRepository
     */
    public function __construct(
        LeadtimeDisplayGroupRepositoryInterface $iLeadtimeDisplayGroupRepository,
        ViewDepoRepositoryInterface $iViewDepoRepository
    ) {
        $this->iLeadtimeDisplayGroupRepository = $iLeadtimeDisplayGroupRepository;
        $this->iViewDepoRepository = $iViewDepoRepository;
    }

    /**
     * デポ取得
     *
     * @param int $depocd
     * @return ViewDepoEntity
     */
    public function findDepo(int $depocd): ViewDepoEntity
    {
        $depo = $this->iViewDepoRepository->findDepo($depocd);
        if ($depo === null) {
            throw new Exception;
        } else {
            return $depo;
        }
    }

    /**
     * 表示グループの一覧を取得する
     *
     * @return integer
     */
    public function findDisplayGroupList(): Collection
    {
        // 表示グループ一覧取得
        $displayGroupList = $this->iLeadtimeDisplayGroupRepository->findDisplayGroupList();

        // key - valueに変換
        $prefCollect = collect($displayGroupList)->mapWithKeys(function ($item) {
            return [$item->displayGroupType => $item->displayGroupName];
        });

        return $prefCollect;
    }

    /**
     * 有効デポ情報取得
     *
     * @return integer
     */
    public function getStartAtViewDepo()
    {
        // 有効デポ情報取得
        $depoData = $this->iViewDepoRepository->getStartAtViewDepo();

        return $depoData;
    }

    /**
     * 有効デポ情報取得（適用デポCDリスト使用）
     *
     * @return integer
     */
    public function getStartAtViewDepoWithDepolist($depoList)
    {
        // 有効デポ情報取得
        $depoData = $this->iViewDepoRepository->getStartAtViewDepoWithDepolist($depoList);

        return $depoData;
    }

    /**
     * カレンダー更新対象デポリスト取得
     *
     * @return array
     */
    public function getUpdateTaisyoDepoList($ym)
    {
        $parentymd = date("Ym01");
        $checkMonth = date("Ym", strtotime($parentymd . "+". $ym ." month"));
        $checkMonth = strtotime($checkMonth);
        $currentYm = strtotime(now());
        // 有効デポ情報取得
        $depoData = $this->iViewDepoRepository->getUpdateTaisyoDepoList($currentYm, $checkMonth);

        return $depoData;
    }
}
