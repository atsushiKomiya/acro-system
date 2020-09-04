<?php
namespace App\Domain\Entities;

use JsonSerializable;

class ViewLeadtimeMessageEntity implements JsonSerializable
{
    private $messageId;
    private $depocd;
    private $message;
    private $viewLimit;
    private $registAt;

    public function __construct(
        $messageId,
        $depocd,
        $message,
        $viewLimit,
        $registAt
    )
    {
        $this->messageId = $messageId;
        $this->depocd = $depocd;
        $this->message = $message;
        $this->viewLimit = $viewLimit;
        $this->registAt = $registAt;
    }

    /**
     * Getter.
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Setter.
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
 
    /**
     * JsonSerializable
     *
     * @return void
     */
    public function jsonSerialize()
    {
        $result = [
            'messageId' => $this->messageId,
            'depocd' => $this->depocd,
            'message' => $this->message,
            'viewLimit' => $this->viewLimit,
            'registAt' => $this->registAt,
        ];

        return $result;
    }
}
