<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\LeadtimeDisplayGroupRepositoryInterface;
use App\Domain\Repositories\PublicHolidayRepositoryInterface;

class PublicHolidayUseCase
{
    // 住所情報View
    private $iLeadtimeDisplayGroupRepository;
    // 祝日マスタ
    private $iPublicHolidayRepository;

    /**
     * コンストラクタ
     *
     * @param LeadtimeDisplayGroupRepositoryInterface $iViewDepoRepository
     */
    public function __construct(
        LeadtimeDisplayGroupRepositoryInterface $iLeadtimeDisplayGroupRepository,
        PublicHolidayRepositoryInterface $iPublicHolidayRepository
    ) {
        $this->iLeadtimeDisplayGroupRepository = $iLeadtimeDisplayGroupRepository;
        $this->iPublicHolidayRepository = $iPublicHolidayRepository;
    }

    /**
     * 祝日リスト削除
     *
     * @return integer
     */
    public function deletePublicHolidayList()
    {
        // 祝日リスト削除
        $this->iPublicHolidayRepository->deletePublicHolidayList();

        return true;
    }

    /**
     * 祝日リスト登録
     *
     * @return integer
     */
    public function inputPublicHolidayList(array $publicHolidayList)
    {
        // 祝日リスト登録
        $this->iPublicHolidayRepository->inputPublicHolidayList($publicHolidayList);

        return true;
    }

    /**
     * 祝日リスト取得
     *
     * @return integer
     */
    public function getPublicHolidayList()
    {
        // 祝日リスト取得
        $publicHolidayList = $this->iPublicHolidayRepository->getPublicHolidayList();

        return $publicHolidayList;
    }
}
