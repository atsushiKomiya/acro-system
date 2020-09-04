<?php

use App\Domain\Models\ItemCategoryLarge;
use Illuminate\Database\Seeder;

class ItemCategoryLargeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemCategoryLarge::truncate();
        // 本番データがきたら記載を変更
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 10], ['category_large_cd' => '10','category_large_name' => 'カード商品']);
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 20], ['category_large_cd' => '20','category_large_name' => 'エンタメ商品']);
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 30], ['category_large_cd' => '30','category_large_name' => 'レ点商品']);
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 40], ['category_large_cd' => '40','category_large_name' => 'フラワーギフト']);
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 50], ['category_large_cd' => '50','category_large_name' => 'キャンペーン商品(郵便)']);
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 60], ['category_large_cd' => '60','category_large_name' => 'キャンペーン商品（エンタメ）']);
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 70], ['category_large_cd' => '70','category_large_name' => 'ジャイアントフラワー']);
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 80], ['category_large_cd' => '80','category_large_name' => 'みつぼしブランド']);
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 90], ['category_large_cd' => '90','category_large_name' => 'バルーンギフト']);
        ItemCategoryLarge::firstOrCreate(['category_large_cd' => 100], ['category_large_cd' => '100','category_large_name' => 'カタログギフト']);
    }
}
