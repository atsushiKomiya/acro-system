<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Entities\IrregularMailEntity;
use App\Domain\Factories\ViewAddressFactory;
use App\Domain\Factories\ViewDepoFactory;
use App\Domain\Factories\ViewItemFactory;
use App\Mail\IrregularMail;
use Illuminate\Support\Facades\Mail;

class MailTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMail()
    {
        
        $depoFactory = new ViewDepoFactory();
        $itemFactory = new ViewItemFactory();
        $addrssFactory = new ViewAddressFactory();

        $entity = new IrregularMailEntity(
            1,
            'テスト',
            1,
            1,
            true,
            true,
            true,
            true,
            1000,
            false,
            2,
            '2020/1/1',
            '2020/2/1',
            '2020/3/1',
            [],
            2,
            '2020/1/1',
            '2020/2/1',
            '2020/3/1',
            [],
            [
                $depoFactory->makeDepoMinimum(1,"test1"),
                $depoFactory->makeDepoMinimum(2,"test2"),
                $depoFactory->makeDepoMinimum(3,"test3"),
            ],
            [
                $itemFactory->makeItemMinimum('C01',"test1"),
                $itemFactory->makeItemMinimum('C02',"test2"),
                $itemFactory->makeItemMinimum('C03',"test3"),
            ],
            [
                $addrssFactory->makeAddressMinimum(1,"北海道","〇〇市","〇〇町"),
                $addrssFactory->makeAddressMinimum(2,"青森","〇〇市","〇〇町"),
                $addrssFactory->makeAddressMinimum(3,"岩手","〇〇市","〇〇町"),
            ],
            1,
            'test',
            'annoAddr',
            'annoPeriod',
            'annoTrans',
            'message',
            '2020/7/1',
            '1',
            'テスト',
            '太郎',
        );

        $res = Mail::send(new IrregularMail(IrregularMail::MODE_NEW,$entity));

        var_dump($res);
        $this->assertTrue(true);
    }
}
