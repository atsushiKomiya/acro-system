<?php
namespace App\Domain\Entities;

use JsonSerializable;

class ViewDepoEntity implements JsonSerializable
{
    // ViewDepo
    private $depocd;
    private $deponame;
    private $displayGroupType;
    private $depoType;
    private $depoPref;
    private $depoAddr;
    private $startAt;
    private $endAt;
    private $stop;

    // LeadtimeDisplayGroup
    private $displayGroupId;
    private $displayGroupName;
    private $displayType;
    private $rearStandFlg;

    public function __construct(
        $depocd,
        $deponame,
        $displayGroupType = null,
        $depoType = null,
        $depoPref = null,
        $depoAddr = null,
        $startAt = null,
        $endAt = null,
        $stop = null,
        $displayGroupId = null,
        $displayGroupName = null,
        $displayType = null,
        $rearStandFlg = null
    ) {
        $this->depocd = $depocd;
        $this->deponame = $deponame;
        $this->displayGroupType = $displayGroupType;
        $this->depoType = $depoType;
        $this->depoPref = $depoPref;
        $this->depoAddr = $depoAddr;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->stop = $stop;
        $this->displayGroupId = $displayGroupId;
        $this->displayGroupName = $displayGroupName;
        $this->displayType = $displayType;
        $this->rearStandFlg = $rearStandFlg;
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
            'depocd' => $this->depocd,
            'deponame' => $this->deponame,
            'displayGroupType' => $this->displayGroupType,
            'depoType' => $this->depoType,
            'depoPref' => $this->depoPref,
            'depoAddr' => $this->depoAddr,
            'startAt' => $this->startAt,
            'endAt' => $this->endAt,
            'stop' => $this->stop,
            'displayGroupId' => $this->displayGroupId,
            'displayGroupName' => $this->displayGroupName,
            'displayType' => $this->displayType,
            'rearStandFlg' => $this->rearStandFlg,
        ];

        return $result;
    }
}
