<?php
namespace App\Domain\Entities;

class CsvImportResultEntity
{
    private $isSuccess;
    private $totalRowCount;
    private $successRowCount;
    private $errorRowCount;
    private $errorList;

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
