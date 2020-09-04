<?php
namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;
use ReflectionClass;

/**
 * Base
 */
class BaseEntity implements JsonSerializable
{
    // ユーザ
    protected $userId;
    // 登録者ID
    protected $createdId;
    // 登録日時
    protected $createdAt;
    // 更新者ID
    protected $updatedId;
    // 更新日時
    protected $updatedAt;
    // 削除者ID
    protected $deletedId;
    // 削除日時
    protected $deletedAt;
    
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
     * 登録・更新・削除に関する日時、IDを設定する
     *
     * @param Model $model
     * @return void
     */
    public function setActionLog(Model $model)
    {
        $this->createdId = $model['created_id'];
        $this->createdAt = $model['created_at'];
        $this->updatedId = $model['updated_id'];
        $this->updatedAt = $model['updated_at'];
        $this->deletedId = $model['deleted_id'];
        $this->deletedAt = $model['deleted_at'];
    }

    /**
     * JsonSerializable
     *
     * @return void
     */
    public function jsonSerialize()
    {
        $reflect = new ReflectionClass($this);
        $props   = $reflect->getProperties();
        $result = [];
        foreach ($props as $prop) {
            $propName = $prop->getName();
            $result[$propName ] = $this->$propName;
        }
        return $result;
    }
}
