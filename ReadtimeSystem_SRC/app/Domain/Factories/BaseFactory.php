<?php

namespace App\Domain\Factories;

use App\Domain\Utilities\LoginUser;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Utilities\StrConv;

class BaseFactory
{
    /**
     * ModelからEntityインスタンスを生成してデータセットしたものを返す
     */
    public function makeEntityByModel(?Model $model, string $entityClassName) : ?Object
    {
        if ($model == null) {
            return null;
        }
        $entity = new $entityClassName();

        $entityRefl = new \ReflectionClass($entity);
        $entityProps = $entityRefl->getProperties();

        foreach ($entityProps as $entityProp) {
            $camlName = $entityProp->getName();
            $snkName = StrConv::underscore($camlName);

            $entity->$camlName = $model->$snkName;
        }

        return $entity;
    }

    /**
     * EntityからModelインスタンスにデータセット
     */
    public function modelByEntity(Model $model, $entity, bool $exclId = false, array $excludes = [])
    {
        $entityRefl = new \ReflectionClass($entity);
        $entityProps = $entityRefl->getProperties();

        foreach ($entityProps as $entityProp) {
            $isExclude = false;
            $camlName = $entityProp->getName();
            if (strpos($camlName, "__") !== false) {
                // フィールド名が [__] で始まるものは除外
                $isExclude = true;
            } elseif ($camlName == "checked") {
                // フィールド名が[checked]は除外
                $isExclude = true;
            } elseif ($camlName == "id" && $exclId) {
                $isExclude = true;
            } else {
                foreach ($excludes as $exc) {
                    if ($exc == $camlName) {
                        $isExclude = true;
                        break;
                    }
                }
            }

            if ($isExclude == false) {
                $snkName = StrConv::underscore($camlName);
                $model->$snkName = $entity->$camlName;
            }
        }
    }

    public function makeEntityByArray(array $data, string $entityClassName): ?Object
    {
        if ($data == null) {
            return null;
        }
        $entity = new $entityClassName();

        $keys = array_keys($data);

        foreach ($keys as $key) {
            $entity->$key = $data[$key];
        }
        /*
        $entityRefl = new \ReflectionClass($entity);
        $entityProps = $entityRefl->getProperties();

        foreach ($entityProps as $entityProp) {
            $camlName = $entityProp->getName();
            $snkName = StrConv::underscore($camlName);

            $entity->$camlName = $model->$snkName;
        }
        */

        return $entity;
    }
    
    public function setRegisterData(Model $model)
    {
        $user = LoginUser::loginUser();
        $model["created_id"] = $user->userId;
    }

    public function setUpdateData(Model $model)
    {
        $user = LoginUser::loginUser();
        $model["updated_id"] = $user->userId;
        $cnt = $model["update_cnt"] ?? 0;
        $cnt++;
        $model["update_cnt"] = $cnt;
    }
}
