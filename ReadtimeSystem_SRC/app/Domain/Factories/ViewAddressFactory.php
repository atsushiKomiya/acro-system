<?php
namespace App\Domain\Factories;

use App\Domain\Entities\ViewAddressEntity;
use App\Domain\Models\ViewAddress;

class ViewAddressFactory
{

    /**
     * 都道府県Entity作成
     *
     * @param ViewAddress $viewAddress
     * @return ViewAddressEntity
     */
    public function makePref(ViewAddress $viewAddress): ViewAddressEntity
    {
        return new ViewAddressEntity(
            null,
            null,
            null,
            $viewAddress->pref,
            $viewAddress->pref_name,
            null,
            null
        );
    }

    /**
     * 市区郡Entity作成
     *
     * @param ViewAddress $viewAddress
     * @return ViewAddressEntity
     */
    public function makeCity(ViewAddress $viewAddress): ViewAddressEntity
    {
        return new ViewAddressEntity(
            null,
            $viewAddress->jiscode,
            null,
            $viewAddress->pref,
            $viewAddress->pref_name,
            $viewAddress->siku,
            null
        );
    }

    /**
     * 町村Entity作成
     *
     * @param ViewAddress $viewAddress
     * @return ViewAddressEntity
     */
    public function makeAddress(ViewAddress $viewAddress): ViewAddressEntity
    {
        return new ViewAddressEntity(
            $viewAddress->addrcd,
            $viewAddress->jiscode,
            $viewAddress->zipcode,
            $viewAddress->pref,
            $viewAddress->pref_name,
            $viewAddress->siku,
            $viewAddress->tyou
        );
    }

    /**
     * メール用のEntityを作成する
     *
     * @param integer $pref
     * @param string $prefName
     * @param string $siku
     * @param string $tyou
     * @return ViewAddressEntity
     */
    public function makeAddressMinimum(int $pref, string $prefName, string $siku, string $tyou): ViewAddressEntity
    {
        return new ViewAddressEntity(
            null,
            null,
            null,
            $pref,
            $prefName,
            $siku,
            $tyou
        );
    }
}
