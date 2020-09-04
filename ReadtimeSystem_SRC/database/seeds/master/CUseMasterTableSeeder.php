<?php

use App\Domain\Models\CUse;
use Illuminate\Database\Seeder;

class CUseMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 全削除
        CUse::truncate();

        // 通常
        CUse::firstOrCreate(['c_use' => 10], ['c_use' => '1','keicho_type' => '1','c_use_name' => '結婚']);
        CUse::firstOrCreate(['c_use' => 68], ['c_use' => '1','keicho_type' => '1','c_use_name' => '結婚（ご子息・ご令嬢）']);
        CUse::firstOrCreate(['c_use' => 55], ['c_use' => '1','keicho_type' => '1','c_use_name' => '結婚（英文）']);
        CUse::firstOrCreate(['c_use' => 16], ['c_use' => '1','keicho_type' => '1','c_use_name' => '結婚記念日']);
        CUse::firstOrCreate(['c_use' => 22], ['c_use' => '1','keicho_type' => '1','c_use_name' => '人事（就任）']);
        CUse::firstOrCreate(['c_use' => 47], ['c_use' => '1','keicho_type' => '1','c_use_name' => '人事（昇進・栄転・その他）']);
        CUse::firstOrCreate(['c_use' => 63], ['c_use' => '1','keicho_type' => '1','c_use_name' => '創立・設立']);
        CUse::firstOrCreate(['c_use' => 23], ['c_use' => '1','keicho_type' => '1','c_use_name' => '開店・竣工・起工']);
        CUse::firstOrCreate(['c_use' => 67], ['c_use' => '1','keicho_type' => '1','c_use_name' => '引越し・移転']);
        CUse::firstOrCreate(['c_use' => 61], ['c_use' => '1','keicho_type' => '1','c_use_name' => '開催祝']);
        CUse::firstOrCreate(['c_use' => 49], ['c_use' => '1','keicho_type' => '1','c_use_name' => '上場']);
        CUse::firstOrCreate(['c_use' => 69], ['c_use' => '1','keicho_type' => '1','c_use_name' => '勤続']);
        CUse::firstOrCreate(['c_use' => 70], ['c_use' => '1','keicho_type' => '1','c_use_name' => '定年・退職・転職']);
        CUse::firstOrCreate(['c_use' => 20], ['c_use' => '1','keicho_type' => '1','c_use_name' => '受章・叙勲・褒章']);
        CUse::firstOrCreate(['c_use' => 48], ['c_use' => '1','keicho_type' => '1','c_use_name' => '選挙（当選）']);
        CUse::firstOrCreate(['c_use' => 57], ['c_use' => '1','keicho_type' => '1','c_use_name' => '選挙（出馬・事務所開設）']);
        CUse::firstOrCreate(['c_use' => 58], ['c_use' => '1','keicho_type' => '1','c_use_name' => '選挙（陣中見舞い・激励）']);
        CUse::firstOrCreate(['c_use' => 64], ['c_use' => '1','keicho_type' => '1','c_use_name' => '新商品発売']);
        CUse::firstOrCreate(['c_use' => 75], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'おもてなし（英文）']);
        CUse::firstOrCreate(['c_use' => 84], ['c_use' => '1','keicho_type' => '1','c_use_name' => '周年記念（ビジネス）']);
        CUse::firstOrCreate(['c_use' => 13], ['c_use' => '1','keicho_type' => '1','c_use_name' => '入学・就職']);
        CUse::firstOrCreate(['c_use' => 78], ['c_use' => '1','keicho_type' => '1','c_use_name' => '入試・入社試験（激励）']);
        CUse::firstOrCreate(['c_use' => 14], ['c_use' => '1','keicho_type' => '1','c_use_name' => '卒業']);
        CUse::firstOrCreate(['c_use' => 11], ['c_use' => '1','keicho_type' => '1','c_use_name' => '誕生日']);
        CUse::firstOrCreate(['c_use' => 15], ['c_use' => '1','keicho_type' => '1','c_use_name' => '成人']);
        CUse::firstOrCreate(['c_use' => 12], ['c_use' => '1','keicho_type' => '1','c_use_name' => '出産']);
        CUse::firstOrCreate(['c_use' => 19], ['c_use' => '1','keicho_type' => '1','c_use_name' => '長寿（還暦等）']);
        CUse::firstOrCreate(['c_use' => 17], ['c_use' => '1','keicho_type' => '1','c_use_name' => '父の日']);
        CUse::firstOrCreate(['c_use' => 18], ['c_use' => '1','keicho_type' => '1','c_use_name' => '母の日']);
        CUse::firstOrCreate(['c_use' => 50], ['c_use' => '1','keicho_type' => '1','c_use_name' => '幸福の日']);
        CUse::firstOrCreate(['c_use' => 51], ['c_use' => '1','keicho_type' => '1','c_use_name' => '七夕']);
        CUse::firstOrCreate(['c_use' => 73], ['c_use' => '1','keicho_type' => '1','c_use_name' => '年末年始']);
        CUse::firstOrCreate(['c_use' => 74], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'スポーツ・大会']);
        CUse::firstOrCreate(['c_use' => 65], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'クリスマス']);
        CUse::firstOrCreate(['c_use' => 76], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'バレンタインデー']);
        CUse::firstOrCreate(['c_use' => 77], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'ホワイトデー']);
        CUse::firstOrCreate(['c_use' => 87], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'ひなまつり']);
        CUse::firstOrCreate(['c_use' => 88], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'ハロウィン']);
        CUse::firstOrCreate(['c_use' => 82], ['c_use' => '1','keicho_type' => '1','c_use_name' => '七五三']);
        CUse::firstOrCreate(['c_use' => 83], ['c_use' => '1','keicho_type' => '1','c_use_name' => '周年記念（人生）']);
        CUse::firstOrCreate(['c_use' => 81], ['c_use' => '1','keicho_type' => '1','c_use_name' => '新築（人生）']);
        CUse::firstOrCreate(['c_use' => 89], ['c_use' => '1','keicho_type' => '1','c_use_name' => '敬老の日']);
        CUse::firstOrCreate(['c_use' => 90], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'こどもの日']);
        CUse::firstOrCreate(['c_use' => 59], ['c_use' => '1','keicho_type' => '1','c_use_name' => '暑中見舞い']);
        CUse::firstOrCreate(['c_use' => 60], ['c_use' => '1','keicho_type' => '1','c_use_name' => '残暑見舞い']);
        CUse::firstOrCreate(['c_use' => 71], ['c_use' => '1','keicho_type' => '1','c_use_name' => '新盆見舞い']);
        CUse::firstOrCreate(['c_use' => 72], ['c_use' => '1','keicho_type' => '1','c_use_name' => '寒中見舞い']);
        CUse::firstOrCreate(['c_use' => 62], ['c_use' => '1','keicho_type' => '1','c_use_name' => '災害見舞い']);
        CUse::firstOrCreate(['c_use' => 80], ['c_use' => '1','keicho_type' => '1','c_use_name' => '入院']);
        CUse::firstOrCreate(['c_use' => 21], ['c_use' => '1','keicho_type' => '1','c_use_name' => '退院・全快']);
        CUse::firstOrCreate(['c_use' => 66], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'お礼']);
        CUse::firstOrCreate(['c_use' => 85], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'お中元・お歳暮']);
        CUse::firstOrCreate(['c_use' => 86], ['c_use' => '1','keicho_type' => '1','c_use_name' => 'お見舞い返し・快気祝い']);
        CUse::firstOrCreate(['c_use' => 30], ['c_use' => '2','keicho_type' => '2','c_use_name' => '一般']);
        CUse::firstOrCreate(['c_use' => 31], ['c_use' => '2','keicho_type' => '2','c_use_name' => 'ご尊父・お父様']);
        CUse::firstOrCreate(['c_use' => 32], ['c_use' => '2','keicho_type' => '2','c_use_name' => 'ご母堂・お母様']);
        CUse::firstOrCreate(['c_use' => 52], ['c_use' => '2','keicho_type' => '2','c_use_name' => 'ご岳父']);
        CUse::firstOrCreate(['c_use' => 53], ['c_use' => '2','keicho_type' => '2','c_use_name' => 'ご丈母・ご岳母']);
        CUse::firstOrCreate(['c_use' => 33], ['c_use' => '2','keicho_type' => '2','c_use_name' => 'ご主人・奥様']);
        CUse::firstOrCreate(['c_use' => 34], ['c_use' => '2','keicho_type' => '2','c_use_name' => 'ご子息・ご令嬢・お孫']);
        CUse::firstOrCreate(['c_use' => 92], ['c_use' => '2','keicho_type' => '2','c_use_name' => 'ご祖父']);
        CUse::firstOrCreate(['c_use' => 91], ['c_use' => '2','keicho_type' => '2','c_use_name' => 'ご祖母']);
        CUse::firstOrCreate(['c_use' => 35], ['c_use' => '2','keicho_type' => '2','c_use_name' => '社長・会長']);
        CUse::firstOrCreate(['c_use' => 79], ['c_use' => '2','keicho_type' => '2','c_use_name' => '社葬']);
        CUse::firstOrCreate(['c_use' => 54], ['c_use' => '2','keicho_type' => '2','c_use_name' => 'キリスト教式']);
        CUse::firstOrCreate(['c_use' => 56], ['c_use' => '2','keicho_type' => '2','c_use_name' => '英文']);
        CUse::firstOrCreate(['c_use' => 36], ['c_use' => '2','keicho_type' => '2','c_use_name' => '法要・慰霊祭']);
    }
}
