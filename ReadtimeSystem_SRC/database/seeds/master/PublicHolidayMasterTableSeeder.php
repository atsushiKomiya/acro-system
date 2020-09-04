<?php

use App\Domain\Models\PublicHoliday;
use Illuminate\Database\Seeder;

class PublicHolidayMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 全削除
        PublicHoliday::truncate();

        // 登録 2020〜2025
        PublicHoliday::firstOrCreate(['date' => '20200101'], ['date' => '20200101']);
        PublicHoliday::firstOrCreate(['date' => '20200113'], ['date' => '20200113']);
        PublicHoliday::firstOrCreate(['date' => '20200211'], ['date' => '20200211']);
        PublicHoliday::firstOrCreate(['date' => '20200223'], ['date' => '20200223']);
        PublicHoliday::firstOrCreate(['date' => '20200224'], ['date' => '20200224']);
        PublicHoliday::firstOrCreate(['date' => '20200320'], ['date' => '20200320']);
        PublicHoliday::firstOrCreate(['date' => '20200429'], ['date' => '20200429']);
        PublicHoliday::firstOrCreate(['date' => '20200503'], ['date' => '20200503']);
        PublicHoliday::firstOrCreate(['date' => '20200504'], ['date' => '20200504']);
        PublicHoliday::firstOrCreate(['date' => '20200505'], ['date' => '20200505']);
        PublicHoliday::firstOrCreate(['date' => '20200506'], ['date' => '20200506']);
        PublicHoliday::firstOrCreate(['date' => '20200723'], ['date' => '20200723']);
        PublicHoliday::firstOrCreate(['date' => '20200724'], ['date' => '20200724']);
        PublicHoliday::firstOrCreate(['date' => '20200810'], ['date' => '20200810']);
        PublicHoliday::firstOrCreate(['date' => '20200921'], ['date' => '20200921']);
        PublicHoliday::firstOrCreate(['date' => '20200922'], ['date' => '20200922']);
        PublicHoliday::firstOrCreate(['date' => '20201103'], ['date' => '20201103']);
        PublicHoliday::firstOrCreate(['date' => '20201123'], ['date' => '20201123']);
        PublicHoliday::firstOrCreate(['date' => '20210101'], ['date' => '20210101']);
        PublicHoliday::firstOrCreate(['date' => '20210111'], ['date' => '20210111']);
        PublicHoliday::firstOrCreate(['date' => '20210211'], ['date' => '20210211']);
        PublicHoliday::firstOrCreate(['date' => '20210223'], ['date' => '20210223']);
        PublicHoliday::firstOrCreate(['date' => '20210320'], ['date' => '20210320']);
        PublicHoliday::firstOrCreate(['date' => '20210429'], ['date' => '20210429']);
        PublicHoliday::firstOrCreate(['date' => '20210503'], ['date' => '20210503']);
        PublicHoliday::firstOrCreate(['date' => '20210504'], ['date' => '20210504']);
        PublicHoliday::firstOrCreate(['date' => '20210505'], ['date' => '20210505']);
        PublicHoliday::firstOrCreate(['date' => '20210719'], ['date' => '20210719']);
        PublicHoliday::firstOrCreate(['date' => '20210811'], ['date' => '20210811']);
        PublicHoliday::firstOrCreate(['date' => '20210920'], ['date' => '20210920']);
        PublicHoliday::firstOrCreate(['date' => '20210923'], ['date' => '20210923']);
        PublicHoliday::firstOrCreate(['date' => '20211011'], ['date' => '20211011']);
        PublicHoliday::firstOrCreate(['date' => '20211103'], ['date' => '20211103']);
        PublicHoliday::firstOrCreate(['date' => '20211123'], ['date' => '20211123']);
        PublicHoliday::firstOrCreate(['date' => '20220101'], ['date' => '20220101']);
        PublicHoliday::firstOrCreate(['date' => '20220110'], ['date' => '20220110']);
        PublicHoliday::firstOrCreate(['date' => '20220211'], ['date' => '20220211']);
        PublicHoliday::firstOrCreate(['date' => '20220223'], ['date' => '20220223']);
        PublicHoliday::firstOrCreate(['date' => '20220321'], ['date' => '20220321']);
        PublicHoliday::firstOrCreate(['date' => '20220429'], ['date' => '20220429']);
        PublicHoliday::firstOrCreate(['date' => '20220503'], ['date' => '20220503']);
        PublicHoliday::firstOrCreate(['date' => '20220504'], ['date' => '20220504']);
        PublicHoliday::firstOrCreate(['date' => '20220505'], ['date' => '20220505']);
        PublicHoliday::firstOrCreate(['date' => '20220718'], ['date' => '20220718']);
        PublicHoliday::firstOrCreate(['date' => '20220811'], ['date' => '20220811']);
        PublicHoliday::firstOrCreate(['date' => '20220919'], ['date' => '20220919']);
        PublicHoliday::firstOrCreate(['date' => '20220923'], ['date' => '20220923']);
        PublicHoliday::firstOrCreate(['date' => '20221010'], ['date' => '20221010']);
        PublicHoliday::firstOrCreate(['date' => '20221103'], ['date' => '20221103']);
        PublicHoliday::firstOrCreate(['date' => '20221123'], ['date' => '20221123']);
        PublicHoliday::firstOrCreate(['date' => '20230101'], ['date' => '20230101']);
        PublicHoliday::firstOrCreate(['date' => '20230102'], ['date' => '20230102']);
        PublicHoliday::firstOrCreate(['date' => '20230109'], ['date' => '20230109']);
        PublicHoliday::firstOrCreate(['date' => '20230211'], ['date' => '20230211']);
        PublicHoliday::firstOrCreate(['date' => '20230223'], ['date' => '20230223']);
        PublicHoliday::firstOrCreate(['date' => '20230321'], ['date' => '20230321']);
        PublicHoliday::firstOrCreate(['date' => '20230429'], ['date' => '20230429']);
        PublicHoliday::firstOrCreate(['date' => '20230503'], ['date' => '20230503']);
        PublicHoliday::firstOrCreate(['date' => '20230504'], ['date' => '20230504']);
        PublicHoliday::firstOrCreate(['date' => '20230505'], ['date' => '20230505']);
        PublicHoliday::firstOrCreate(['date' => '20230717'], ['date' => '20230717']);
        PublicHoliday::firstOrCreate(['date' => '20230811'], ['date' => '20230811']);
        PublicHoliday::firstOrCreate(['date' => '20230918'], ['date' => '20230918']);
        PublicHoliday::firstOrCreate(['date' => '20230923'], ['date' => '20230923']);
        PublicHoliday::firstOrCreate(['date' => '20231009'], ['date' => '20231009']);
        PublicHoliday::firstOrCreate(['date' => '20231103'], ['date' => '20231103']);
        PublicHoliday::firstOrCreate(['date' => '20231123'], ['date' => '20231123']);
        PublicHoliday::firstOrCreate(['date' => '20240101'], ['date' => '20240101']);
        PublicHoliday::firstOrCreate(['date' => '20240108'], ['date' => '20240108']);
        PublicHoliday::firstOrCreate(['date' => '20240211'], ['date' => '20240211']);
        PublicHoliday::firstOrCreate(['date' => '20240212'], ['date' => '20240212']);
        PublicHoliday::firstOrCreate(['date' => '20240223'], ['date' => '20240223']);
        PublicHoliday::firstOrCreate(['date' => '20240320'], ['date' => '20240320']);
        PublicHoliday::firstOrCreate(['date' => '20240429'], ['date' => '20240429']);
        PublicHoliday::firstOrCreate(['date' => '20240503'], ['date' => '20240503']);
        PublicHoliday::firstOrCreate(['date' => '20240504'], ['date' => '20240504']);
        PublicHoliday::firstOrCreate(['date' => '20240505'], ['date' => '20240505']);
        PublicHoliday::firstOrCreate(['date' => '20240506'], ['date' => '20240506']);
        PublicHoliday::firstOrCreate(['date' => '20240715'], ['date' => '20240715']);
        PublicHoliday::firstOrCreate(['date' => '20240811'], ['date' => '20240811']);
        PublicHoliday::firstOrCreate(['date' => '20240812'], ['date' => '20240812']);
        PublicHoliday::firstOrCreate(['date' => '20240916'], ['date' => '20240916']);
        PublicHoliday::firstOrCreate(['date' => '20240922'], ['date' => '20240922']);
        PublicHoliday::firstOrCreate(['date' => '20240923'], ['date' => '20240923']);
        PublicHoliday::firstOrCreate(['date' => '20241014'], ['date' => '20241014']);
        PublicHoliday::firstOrCreate(['date' => '20241103'], ['date' => '20241103']);
        PublicHoliday::firstOrCreate(['date' => '20241104'], ['date' => '20241104']);
        PublicHoliday::firstOrCreate(['date' => '20241123'], ['date' => '20241123']);
        PublicHoliday::firstOrCreate(['date' => '20250101'], ['date' => '20250101']);
        PublicHoliday::firstOrCreate(['date' => '20250113'], ['date' => '20250113']);
        PublicHoliday::firstOrCreate(['date' => '20250211'], ['date' => '20250211']);
        PublicHoliday::firstOrCreate(['date' => '20250223'], ['date' => '20250223']);
        PublicHoliday::firstOrCreate(['date' => '20250224'], ['date' => '20250224']);
        PublicHoliday::firstOrCreate(['date' => '20250320'], ['date' => '20250320']);
        PublicHoliday::firstOrCreate(['date' => '20250429'], ['date' => '20250429']);
        PublicHoliday::firstOrCreate(['date' => '20250503'], ['date' => '20250503']);
        PublicHoliday::firstOrCreate(['date' => '20250504'], ['date' => '20250504']);
        PublicHoliday::firstOrCreate(['date' => '20250505'], ['date' => '20250505']);
        PublicHoliday::firstOrCreate(['date' => '20250506'], ['date' => '20250506']);
        PublicHoliday::firstOrCreate(['date' => '20250721'], ['date' => '20250721']);
        PublicHoliday::firstOrCreate(['date' => '20250811'], ['date' => '20250811']);
        PublicHoliday::firstOrCreate(['date' => '20250915'], ['date' => '20250915']);
        PublicHoliday::firstOrCreate(['date' => '20250923'], ['date' => '20250923']);
        PublicHoliday::firstOrCreate(['date' => '20251013'], ['date' => '20251013']);
        PublicHoliday::firstOrCreate(['date' => '20251103'], ['date' => '20251103']);
        PublicHoliday::firstOrCreate(['date' => '20251123'], ['date' => '20251123']);
        PublicHoliday::firstOrCreate(['date' => '20251124'], ['date' => '20251124']);
    }
}
