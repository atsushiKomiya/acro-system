<?php

use Illuminate\Database\Seeder;

class StartApiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('item_category_relation')->truncate();
        // DB::table('item_category_large')->truncate();
        // DB::table('item_category_medium')->truncate();
        // 商品系のmaster使用
        $this->call([
            DepoCalInfoTableSeeder::class,
            ItemCategoryRelationTableSeeder::class,
            ItemCategoryLargeTableSeeder::class,
            ItemCategoryMediumTableSeeder::class,
            IrregularTableSeeder::class,
            CUseTableSeeder::class,
            DepoDefaultTableSeeder::class,
            DepoAddressLeadtimeTableSeeder::class,
        ]);
    }
}
