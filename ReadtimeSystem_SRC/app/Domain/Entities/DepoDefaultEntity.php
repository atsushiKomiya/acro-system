<?php
namespace App\Domain\Entities;

use JsonSerializable;

class DepoDefaultEntity implements JsonSerializable
{
    private $depoDefaultId;
    private $depoCd;
    private $monBeforeDeadlineFlg;
    private $monTodayDeliveryFlg;
    private $tueBeforeDeadlineFlg;
    private $tueTodayDeliveryFlg;
    private $wedBeforeDeadlineFlg;
    private $wedTodayDeliveryFlg;
    private $thuBeforeDeadlineFlg;
    private $thuTodayDeliveryFlg;
    private $friBeforeDeadlineFlg;
    private $friTodayDeliveryFlg;
    private $satBeforeDeadlineFlg;
    private $satTodayDeliveryFlg;
    private $sunBeforeDeadlineFlg;
    private $sunTodayDeliveryFlg;
    private $holiBeforeDeadlineFlg;
    private $holiBeforeTodayDeliveryFlg;
    private $holiDeadlineFlg;
    private $holiTodayDeliveryFlg;
    private $holiAfterDeadlineFlg;
    private $holiAfterTodayDeliveryFlg;
    private $privateHomeFlg;
    private $handingFlg;
    private $congratulationKbnFlg;
    private $transferPostDepoCd;
    private $transferPostDepoName;
    private $depoLeadTime;

    public function __construct(
        $depoDefaultId = null,
        $depoCd = null,
        $monBeforeDeadlineFlg= false,
        $monTodayDeliveryFlg= false,
        $tueBeforeDeadlineFlg= false,
        $tueTodayDeliveryFlg= false,
        $wedBeforeDeadlineFlg= false,
        $wedTodayDeliveryFlg= false,
        $thuBeforeDeadlineFlg= false,
        $thuTodayDeliveryFlg= false,
        $friBeforeDeadlineFlg= false,
        $friTodayDeliveryFlg= false,
        $satBeforeDeadlineFlg= false,
        $satTodayDeliveryFlg= false,
        $sunBeforeDeadlineFlg= false,
        $sunTodayDeliveryFlg= false,
        $holiBeforeDeadlineFlg= false,
        $holiBeforeTodayDeliveryFlg= false,
        $holiDeadlineFlg= false,
        $holiTodayDeliveryFlg= false,
        $holiAfterDeadlineFlg= false,
        $holiAfterTodayDeliveryFlg= false,
        $privateHomeFlg= false,
        $handingFlg= false,
        $congratulationKbnFlg = 3,
        $transferPostDepoCd = 0,
        $transferPostDepoName = '',
        $depoLeadTime= 0
    ) {
        $this->depoDefaultId = $depoDefaultId;
        $this->depoCd = $depoCd;
        $this->monBeforeDeadlineFlg = $monBeforeDeadlineFlg;
        $this->monTodayDeliveryFlg = $monTodayDeliveryFlg;
        $this->tueBeforeDeadlineFlg = $tueBeforeDeadlineFlg;
        $this->tueTodayDeliveryFlg = $tueTodayDeliveryFlg;
        $this->wedBeforeDeadlineFlg = $wedBeforeDeadlineFlg;
        $this->wedTodayDeliveryFlg = $wedTodayDeliveryFlg;
        $this->thuBeforeDeadlineFlg = $thuBeforeDeadlineFlg;
        $this->thuTodayDeliveryFlg = $thuTodayDeliveryFlg;
        $this->friBeforeDeadlineFlg = $friBeforeDeadlineFlg;
        $this->friTodayDeliveryFlg = $friTodayDeliveryFlg;
        $this->satBeforeDeadlineFlg = $satBeforeDeadlineFlg;
        $this->satTodayDeliveryFlg = $satTodayDeliveryFlg;
        $this->sunBeforeDeadlineFlg = $sunBeforeDeadlineFlg;
        $this->sunTodayDeliveryFlg = $sunTodayDeliveryFlg;
        $this->holiBeforeDeadlineFlg = $holiBeforeDeadlineFlg;
        $this->holiBeforeTodayDeliveryFlg = $holiBeforeTodayDeliveryFlg;
        $this->holiDeadlineFlg = $holiDeadlineFlg;
        $this->holiTodayDeliveryFlg = $holiTodayDeliveryFlg;
        $this->holiAfterDeadlineFlg = $holiAfterDeadlineFlg;
        $this->holiAfterTodayDeliveryFlg = $holiAfterTodayDeliveryFlg;
        $this->privateHomeFlg = $privateHomeFlg;
        $this->handingFlg = $handingFlg;
        $this->congratulationKbnFlg = $congratulationKbnFlg;
        $this->transferPostDepoCd = $transferPostDepoCd;
        $this->transferPostDepoName = $transferPostDepoName;
        $this->depoLeadTime = $depoLeadTime;
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
     * JsonSerializable
     *
     * @return void
     */
    public function jsonSerialize()
    {
        $result = [
            'depoDefaultId' => $this->depoDefaultId,
            'depoCd' => $this->depoCd,
            'monBeforeDeadlineFlg' => $this->monBeforeDeadlineFlg,
            'monTodayDeliveryFlg' => $this->monTodayDeliveryFlg,
            'tueBeforeDeadlineFlg' => $this->tueBeforeDeadlineFlg,
            'tueTodayDeliveryFlg' => $this->tueTodayDeliveryFlg,
            'wedBeforeDeadlineFlg' => $this->wedBeforeDeadlineFlg,
            'wedTodayDeliveryFlg' => $this->wedTodayDeliveryFlg,
            'thuBeforeDeadlineFlg' => $this->thuBeforeDeadlineFlg,
            'thuTodayDeliveryFlg' => $this->thuTodayDeliveryFlg,
            'friBeforeDeadlineFlg' => $this->friBeforeDeadlineFlg,
            'friTodayDeliveryFlg' => $this->friTodayDeliveryFlg,
            'satBeforeDeadlineFlg' => $this->satBeforeDeadlineFlg,
            'satTodayDeliveryFlg' => $this->satTodayDeliveryFlg,
            'sunBeforeDeadlineFlg' => $this->sunBeforeDeadlineFlg,
            'sunTodayDeliveryFlg' => $this->sunTodayDeliveryFlg,
            'holiBeforeDeadlineFlg' => $this->holiBeforeDeadlineFlg,
            'holiBeforeTodayDeliveryFlg' => $this->holiBeforeTodayDeliveryFlg,
            'holiDeadlineFlg' => $this->holiDeadlineFlg,
            'holiTodayDeliveryFlg' => $this->holiTodayDeliveryFlg,
            'holiAfterDeadlineFlg' => $this->holiAfterDeadlineFlg,
            'holiAfterTodayDeliveryFlg' => $this->holiAfterTodayDeliveryFlg,
            'privateHomeFlg' => $this->privateHomeFlg,
            'handingFlg' => $this->handingFlg,
            'congratulationKbnFlg' => $this->congratulationKbnFlg,
            'transferPostDepoCd' => $this->transferPostDepoCd,
            'transferPostDepoName' => $this->transferPostDepoName,
            'depoLeadTime' => $this->depoLeadTime,
        ];

        return $result;
    }
}
