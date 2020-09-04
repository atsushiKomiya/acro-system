<?php
namespace App\Domain\Entities;

/**
 * 受注データ更新CSV出力用のEntity
 */
class ChgDepoInfoEntity extends BaseEntity
{
    // デポCD
    private $depoCd;
    // 都道府県CD
    private $prefCd;
    // 市区郡
    private $siku;
    // 町名
    private $tyou;
    // 商品CD
    private $itemCd;
    // 期間FROM
    private $ymdFrom;
    // 期間TO
    private $ymdTo;

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
