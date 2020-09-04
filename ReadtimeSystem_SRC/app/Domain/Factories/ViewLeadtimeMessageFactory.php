<?php
namespace App\Domain\Factories;

use App\Domain\Entities\ViewLeadtimeMessageEntity;
use App\Domain\Models\ViewLeadtimeMessage;

class ViewLeadtimeMessageFactory
{
    /**
     * ViewLeadtimeMessageEntity作成
     *
     * @param ViewLeadtimeMessage $viewLeadtimeMessage
     * @return ViewLeadtimeMessageEntity
     */
    public function make(ViewLeadtimeMessage $viewLeadtimeMessage): ViewLeadtimeMessageEntity
    {
        return new ViewLeadtimeMessageEntity(
            $viewLeadtimeMessage->message_id,
            $viewLeadtimeMessage->depocd,
            $viewLeadtimeMessage->message,
            $viewLeadtimeMessage->view_limit,
            $viewLeadtimeMessage->regist_at
        );
    }
}
