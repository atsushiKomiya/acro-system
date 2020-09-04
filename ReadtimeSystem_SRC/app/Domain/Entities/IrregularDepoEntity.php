<?php
namespace App\Domain\Entities;

class IrregularDepoEntity extends BaseEntity
{
    private $irregularDepoId;
    private $irregularId;
    private $depoCd;
    private $depoName;

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
            'irregularDepoId' => $this->irregularDepoId,
            'irregularId' => $this->irregularId,
            // ※重要　ViewDepoに合わせているため、小文字
            'depocd' => $this->depoCd,
            'deponame' => $this->depoName,
        ];

        return $result;
    }
}
