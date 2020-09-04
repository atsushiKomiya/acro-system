<?php

use App\Domain\Models\ItemCategoryMedium;
use Illuminate\Database\Seeder;

class ItemCategoryMediumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemCategoryMedium::truncate();
        // 本番データがきたら記載を変更
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 1010], ['category_medium_cd' => '1010','category_medium_name' => '企業オリジナルカード','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 2010], ['category_medium_cd' => '2010','category_medium_name' => 'ぬいぐるみ電報','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 3010], ['category_medium_cd' => '3010','category_medium_name' => 'レ点商品','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 1020], ['category_medium_cd' => '1020','category_medium_name' => 'オンデマンド台紙デポ','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 4010], ['category_medium_cd' => '4010','category_medium_name' => '手渡しアレンジメント','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 5010], ['category_medium_cd' => '5010','category_medium_name' => '敬老の日オリジナル商品','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 5020], ['category_medium_cd' => '5020','category_medium_name' => '母の日オリジナル商品','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 6010], ['category_medium_cd' => '6010','category_medium_name' => '母の日オリジナル商品','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 7010], ['category_medium_cd' => '7010','category_medium_name' => 'ジャイアントフラワー','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 2020], ['category_medium_cd' => '2020','category_medium_name' => 'ソープフラワー','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 8010], ['category_medium_cd' => '8010','category_medium_name' => 'みつぼしブランド','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 9010], ['category_medium_cd' => '9010','category_medium_name' => 'バルーンギフト','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 10010], ['category_medium_cd' => '10010','category_medium_name' => 'カタログギフト','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 4020], ['category_medium_cd' => '4020','category_medium_name' => '観葉植物（ヤマト）','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 4030], ['category_medium_cd' => '4030','category_medium_name' => '観葉植物（佐川）','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 2030], ['category_medium_cd' => '2030','category_medium_name' => 'みつぼしプリザーブド','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 1030], ['category_medium_cd' => '1030','category_medium_name' => '西陣織電報','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 2040], ['category_medium_cd' => '2040','category_medium_name' => 'ボトルフラワー','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 2050], ['category_medium_cd' => '2050','category_medium_name' => 'うるし電報','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 1040], ['category_medium_cd' => '1040','category_medium_name' => '香電','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 1050], ['category_medium_cd' => '1050','category_medium_name' => 'デコレーション','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 1060], ['category_medium_cd' => '1060','category_medium_name' => 'VeryVIPCard','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 1070], ['category_medium_cd' => '1070','category_medium_name' => '押花・刺繍カード','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 4040], ['category_medium_cd' => '4040','category_medium_name' => 'スタンド花','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 4050], ['category_medium_cd' => '4050','category_medium_name' => '本格胡蝶蘭','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 4060], ['category_medium_cd' => '4060','category_medium_name' => '本格胡蝶蘭（ヤマト）','rear_stand_flg' => true]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 4070], ['category_medium_cd' => '4070','category_medium_name' => '本格胡蝶蘭（佐川）','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 4080], ['category_medium_cd' => '4080','category_medium_name' => 'アレンジメントフラワー','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 2060], ['category_medium_cd' => '2060','category_medium_name' => 'プリザーブドフラワー電報','rear_stand_flg' => false]);
        ItemCategoryMedium::firstOrCreate(['category_medium_cd' => 1080], ['category_medium_cd' => '1080','category_medium_name' => 'VeryCard','rear_stand_flg' => false]);
    }
}
