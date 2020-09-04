<?php

namespace Tests\Unit;

use App\Application\UseCases\OrderUpdateCsvExportUseCase;
use Tests\TestCase;

class OrderUpdateCsvExportTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOrderUpdateCsvExport()
    {
        $usecase = new OrderUpdateCsvExportUseCase();

        $depoCdList = [
            12,
            54
        ];

        $addressList = [
            [
                'prefCd' => 1,
                'siku' => '佐野市',
                'tyou' => '柿平町',
            ]
        ];

        $itemCdList = [
            '2222',
            '4444',
        ];

        $from = '20200701';
        $to = '20200731';

        // 実行
        $usecase->chgDepoInfoCsv(
            $depoCdList,
            $addressList,
            $itemCdList,
            $from,
            $to,
        );
    }
}
