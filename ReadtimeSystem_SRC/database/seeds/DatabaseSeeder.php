<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CUseMasterTableSeeder::class);
        $this->call(LeadtimeDisplayGroupTableSeeder::class);
        $this->call(ItemCategoryLargeTableSeeder::class);
        $this->call(ItemCategoryMediumTableSeeder::class);
        $this->call(ItemCategoryRelationTableSeeder::class);
        $this->call(PublicHolidayMasterTableSeeder::class);
    }
}
