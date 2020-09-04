<?php

namespace App\Domain\Utilities;

class StrConv
{
    public static function underscore($str)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_\0', $str)), '_');
    }

    public static function camelize($str)
    {
        return lcfirst(strtr(ucwords(strtr($str, ['_' => ' '])), [' ' => '']));
    }

    public static function adjustZip($str) : ?string
    {
        $ret = $str;
        if (\mb_strlen($str) > 0) {
            $ret = \str_replace("-", "", $str);

            if (\mb_strlen($ret) < 7) {
                $ret = \str_pad($ret, 7, 0, STR_PAD_LEFT);
            }
        }
        return $ret;
    }

    public static function adjustTel($str) : ?string
    {
        $ret = $str;
        if (\mb_strlen($ret) > 0) {
            $ret = \str_replace("-", "", $ret);
            $ret = \str_replace("(", "", $ret);
            $ret = \str_replace(")", "", $ret);
        }
        return $ret;
    }
}
