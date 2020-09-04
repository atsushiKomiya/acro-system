<?php

namespace App\Application\Utilities;

class StringUtility
{
    /**
     * 配列から指定のkeyアイテムを参照し、存在していれば返却する
     * 存在しなければNULL値を返却する
     *
     * @param array $list
     * @param string $key
     * @return string
     */
    public static function getFromArrayIssetItem(array $list, string $key)
    {
        return isset($list[$key]) ? $list[$key] : null;
    }
}