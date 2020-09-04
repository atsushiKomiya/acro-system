<?php
namespace App\Domain\Entities;

/**
 * デポ稼働日確認画面用のEntity
 */
class CalendarConfirmEntity extends BaseEntity
{
    private $depoCd;
    private $deponame;
    private $displayGroupType;
    private $prefCd;
    private $prefName;
    private $approvalDate;
    private $approvalId;
    private $approvalName;
    private $confirmFlg;
    private $beforeDeadlineFlg1;
    private $todayDeliveryFlg1;
    private $beforeDeadlineLimitTime1;
    private $todayDeadlineLimitTime1;
    private $dayofweek1;
    private $publicHolidayStatus1;
    private $beforeDeadlineFlg2;
    private $todayDeliveryFlg2;
    private $beforeDeadlineLimitTime2;
    private $todayDeadlineLimitTime2;
    private $dayofweek2;
    private $publicHolidayStatus2;
    private $beforeDeadlineFlg3;
    private $todayDeliveryFlg3;
    private $beforeDeadlineLimitTime3;
    private $todayDeadlineLimitTime3;
    private $dayofweek3;
    private $publicHolidayStatus3;
    private $beforeDeadlineFlg4;
    private $todayDeliveryFlg4;
    private $beforeDeadlineLimitTime4;
    private $todayDeadlineLimitTime4;
    private $dayofweek4;
    private $publicHolidayStatus4;
    private $beforeDeadlineFlg5;
    private $todayDeliveryFlg5;
    private $beforeDeadlineLimitTime5;
    private $todayDeadlineLimitTime5;
    private $dayofweek5;
    private $publicHolidayStatus5;
    private $beforeDeadlineFlg6;
    private $todayDeliveryFlg6;
    private $beforeDeadlineLimitTime6;
    private $todayDeadlineLimitTime6;
    private $dayofweek6;
    private $publicHolidayStatus6;
    private $beforeDeadlineFlg7;
    private $todayDeliveryFlg7;
    private $beforeDeadlineLimitTime7;
    private $todayDeadlineLimitTime7;
    private $dayofweek7;
    private $publicHolidayStatus7;
    private $beforeDeadlineFlg8;
    private $todayDeliveryFlg8;
    private $beforeDeadlineLimitTime8;
    private $todayDeadlineLimitTime8;
    private $dayofweek8;
    private $publicHolidayStatus8;
    private $beforeDeadlineFlg9;
    private $todayDeliveryFlg9;
    private $beforeDeadlineLimitTime9;
    private $todayDeadlineLimitTime9;
    private $dayofweek9;
    private $publicHolidayStatus9;
    private $beforeDeadlineFlg10;
    private $todayDeliveryFlg10;
    private $beforeDeadlineLimitTime10;
    private $todayDeadlineLimitTime10;
    private $dayofweek10;
    private $publicHolidayStatus10;
    private $beforeDeadlineFlg11;
    private $todayDeliveryFlg11;
    private $beforeDeadlineLimitTime11;
    private $todayDeadlineLimitTime11;
    private $dayofweek11;
    private $publicHolidayStatus11;
    private $beforeDeadlineFlg12;
    private $todayDeliveryFlg12;
    private $beforeDeadlineLimitTime12;
    private $todayDeadlineLimitTime12;
    private $dayofweek12;
    private $publicHolidayStatus12;
    private $beforeDeadlineFlg13;
    private $todayDeliveryFlg13;
    private $beforeDeadlineLimitTime13;
    private $todayDeadlineLimitTime13;
    private $dayofweek13;
    private $publicHolidayStatus13;
    private $beforeDeadlineFlg14;
    private $todayDeliveryFlg14;
    private $beforeDeadlineLimitTime14;
    private $todayDeadlineLimitTime14;
    private $dayofweek14;
    private $publicHolidayStatus14;
    private $beforeDeadlineFlg15;
    private $todayDeliveryFlg15;
    private $beforeDeadlineLimitTime15;
    private $todayDeadlineLimitTime15;
    private $dayofweek15;
    private $publicHolidayStatus15;
    private $beforeDeadlineFlg16;
    private $todayDeliveryFlg16;
    private $beforeDeadlineLimitTime16;
    private $todayDeadlineLimitTime16;
    private $dayofweek16;
    private $publicHolidayStatus16;
    private $beforeDeadlineFlg17;
    private $todayDeliveryFlg17;
    private $beforeDeadlineLimitTime17;
    private $todayDeadlineLimitTime17;
    private $dayofweek17;
    private $publicHolidayStatus17;
    private $beforeDeadlineFlg18;
    private $todayDeliveryFlg18;
    private $beforeDeadlineLimitTime18;
    private $todayDeadlineLimitTime18;
    private $dayofweek18;
    private $publicHolidayStatus18;
    private $beforeDeadlineFlg19;
    private $todayDeliveryFlg19;
    private $beforeDeadlineLimitTime19;
    private $todayDeadlineLimitTime19;
    private $dayofweek19;
    private $publicHolidayStatus19;
    private $beforeDeadlineFlg20;
    private $todayDeliveryFlg20;
    private $beforeDeadlineLimitTime20;
    private $todayDeadlineLimitTime20;
    private $dayofweek20;
    private $publicHolidayStatus20;
    private $beforeDeadlineFlg21;
    private $todayDeliveryFlg21;
    private $beforeDeadlineLimitTime21;
    private $todayDeadlineLimitTime21;
    private $dayofweek21;
    private $publicHolidayStatus21;
    private $beforeDeadlineFlg22;
    private $todayDeliveryFlg22;
    private $beforeDeadlineLimitTime22;
    private $todayDeadlineLimitTime22;
    private $dayofweek22;
    private $publicHolidayStatus22;
    private $beforeDeadlineFlg23;
    private $todayDeliveryFlg23;
    private $beforeDeadlineLimitTime23;
    private $todayDeadlineLimitTime23;
    private $dayofweek23;
    private $publicHolidayStatus23;
    private $beforeDeadlineFlg24;
    private $todayDeliveryFlg24;
    private $beforeDeadlineLimitTime24;
    private $todayDeadlineLimitTime24;
    private $dayofweek24;
    private $publicHolidayStatus24;
    private $beforeDeadlineFlg25;
    private $todayDeliveryFlg25;
    private $beforeDeadlineLimitTime25;
    private $todayDeadlineLimitTime25;
    private $dayofweek25;
    private $publicHolidayStatus25;
    private $beforeDeadlineFlg26;
    private $todayDeliveryFlg26;
    private $beforeDeadlineLimitTime26;
    private $todayDeadlineLimitTime26;
    private $dayofweek26;
    private $publicHolidayStatus26;
    private $beforeDeadlineFlg27;
    private $todayDeliveryFlg27;
    private $beforeDeadlineLimitTime27;
    private $todayDeadlineLimitTime27;
    private $dayofweek27;
    private $publicHolidayStatus27;
    private $beforeDeadlineFlg28;
    private $todayDeliveryFlg28;
    private $beforeDeadlineLimitTime28;
    private $todayDeadlineLimitTime28;
    private $dayofweek28;
    private $publicHolidayStatus28;
    private $beforeDeadlineFlg29;
    private $todayDeliveryFlg29;
    private $beforeDeadlineLimitTime29;
    private $todayDeadlineLimitTime29;
    private $dayofweek29;
    private $publicHolidayStatus29;
    private $beforeDeadlineFlg30;
    private $todayDeliveryFlg30;
    private $beforeDeadlineLimitTime30;
    private $todayDeadlineLimitTime30;
    private $dayofweek30;
    private $publicHolidayStatus30;
    private $beforeDeadlineFlg31;
    private $todayDeliveryFlg31;
    private $beforeDeadlineLimitTime31;
    private $todayDeadlineLimitTime31;
    private $dayofweek31;
    private $publicHolidayStatus31;

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
}
