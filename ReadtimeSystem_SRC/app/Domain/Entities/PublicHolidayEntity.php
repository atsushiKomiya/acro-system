<?php
namespace App\Domain\Entities;

use JsonSerializable;

class PublicHolidayEntity implements JsonSerializable
{
    // PublicHoliday
    public $date;
    public $createdId;
    public $createdAt;
    public $updatedId;
    public $updatedAt;
    public $deletedId;
    public $deletedAt;

    public function __construct(
        $date,
        $createdId,
        $createdAt,
        $updatedId,
        $updatedAt,
        $deletedId,
        $deletedAt
    ) {
        $this->date = $date;
        $this->createdId = $createdId;
        $this->createdAt = $createdAt;
        $this->updatedId = $updatedId;
        $this->updatedAt = $updatedAt;
        $this->deletedId = $deletedId;
        $this->deletedAt = $deletedAt;
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
            'date' => $this->date,
            'createdId' => $this->createdId,
            'createdAt' => $this->createdAt,
            'updatedId' => $this->updatedId,
            'updatedAt' => $this->updatedAt,
            'deletedId' => $this->deletedId,
            'deletedAt' => $this->deletedAt,
        ];

        return $result;
    }
}
