<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\DepoCalAprInfoRepositoryInterface;
use App\Domain\Repositories\ViewLeadtimeMessageRepositoryInterface;

class TopUseCase
{
    // デポカレンダー承認情報
    private $iDepoCalAprInfoRepository;
    // リードタイムメッセージ
    private $iViewLeadtimeMessageRepository;

    /**
     * コンストラクタ
     *
     * @param DepoCalAprInfoRepositoryInterface $iDepoCalAprInfoRepository
     * @param ViewLeadtimeMessageRepositoryInterface $iViewLeadtimeMessageRepository
     */
    public function __construct(
        DepoCalAprInfoRepositoryInterface $iDepoCalAprInfoRepository,
        ViewLeadtimeMessageRepositoryInterface $iViewLeadtimeMessageRepository
    ) {
        $this->iDepoCalAprInfoRepository = $iDepoCalAprInfoRepository;
        $this->iViewLeadtimeMessageRepository = $iViewLeadtimeMessageRepository;
    }

    /**
     * 未承認情報取得
     *
     * @return integer
     */
    public function findUnapproved(): int
    {
        // 未承認情報取得処理
        $result = $this->iDepoCalAprInfoRepository->findUnapprovedCount();
        return $result;
    }

    /**
     * リードタイムメッセージリスト取得
     *
     * @return array
     */
    public function findInfoMessage(): array
    {
        // システム日付取得
        $date = date('Y-m-d');
        // 文言通知取得
        $result = $this->iViewLeadtimeMessageRepository->findInfoMessageList($date);
        return $result;
    }
}
