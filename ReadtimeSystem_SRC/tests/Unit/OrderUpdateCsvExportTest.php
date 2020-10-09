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

        $itemList = [
            [
                'itemCategoryLargeCd' => 10,
                'itemCategoryMediumCd' => 1010,
                'itemCd' => '2222',
            ],
            [
                'itemCategoryLargeCd' => 10,
                'itemCategoryMediumCd' => 1010,
                'itemCd' => '4444',
            ],
        ];

        $from = '20200701';
        $to = '20200731';

        $dayofweekList = [
            [
                'dayofweek' => 0,
                'publicHolidayStatus' => 2
            ],
        ];

        // 実行
        $usecase->chgDepoInfoCsv(
            $depoCdList,
            $addressList,
            $itemList,
            $from,
            $to,
            $dayofweekList,
        );
    }
}
