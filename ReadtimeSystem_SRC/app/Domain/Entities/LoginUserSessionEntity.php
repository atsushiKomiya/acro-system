<?php
namespace App\Domain\Entities;

use JsonSerializable;

class LoginUserSessionEntity implements JsonSerializable
{
    private $VIEW_LOGIN_USER_ID;
    private $AUTH_CLS;
    private $E_CD;
    private $E_NAME;
    private $D_CODE;
    private $D_NAME;
    private $DEPO_CD;
    private $DEPO_NAME;
    private $SCREEN_ID;

    /**
     * コンストラクタ
     *
     * @param integer $viewLoginUserId
     * @param integer $authCls
     * @param string|null $eCd
     * @param string|null $eName
     * @param integer|null $dCode
     * @param string|null $dName
     * @param integer|null $depoCd
     * @param string|null $depoName
     * @param [type] $screenId
     */
    public function __construct(
        int $viewLoginUserId,
        int $authCls,
        ?string $eCd,
        ?string $eName,
        ?int $dCode,
        ?string $dName,
        ?int $depoCd,
        ?string $depoName,
        $screenId
    ) {
        $this->VIEW_LOGIN_USER_ID = $viewLoginUserId;
        $this->AUTH_CLS = $authCls;
        $this->E_CD = $eCd;
        $this->E_NAME = $eName;
        $this->D_CODE = $dCode;
        $this->D_NAME = $dName;
        $this->DEPO_CD = $depoCd;
        $this->DEPO_NAME = $depoName;
        $this->SCREEN_ID = $screenId;
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
            'VIEW_LOGIN_USER_ID' => $this->VIEW_LOGIN_USER_ID,
            'AUTH_CLS' => $this->AUTH_CLS,
            'E_CD' => $this->E_CD,
            'E_NAME' => $this->E_NAME,
            'D_CODE' => $this->D_CODE,
            'D_NAME' => $this->D_NAME,
            'DEPO_CD' => $this->DEPO_CD,
            'DEPO_NAME' => $this->DEPO_NAME,
            'SCREEN_ID' => $this->SCREEN_ID,
        ];

        return $result;
    }
}
