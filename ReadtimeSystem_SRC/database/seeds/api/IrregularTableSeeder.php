<?php

use Illuminate\Database\Seeder;

class IrregularTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('irregular')->truncate();
        DB::table('irregular_depo')->truncate();
        DB::table('irregular_item')->truncate();
        DB::table('irregular_area')->truncate();
        DB::table('irregular_dayofweek')->truncate();

        // イレギュラー設定
        $irregular_types = [
            1,2,3
        ];
        $irregular_type = array_rand($irregular_types);
        // イレギュラー設定区分:受注制御の場合設定
        $time_select = ($irregular_type == 2) ? 1 : null;

        $delivery_date_types = [
            0,1,2,3
        ];
        $order_date_types = [
            0,1,2,3
        ];
        $trans_depo_cd = [
            0,
            399,
            907,
            7101,
            479
        ];
        $days = [
            1,2,3,4,5,6,7
        ];
        $depo_cd = [
            399,
            907,
            7101,
            479
        ];
        $item_cd = [
            'C18','C19','C20','C23','C24','C30','V02','V03','V04',
            'MA01','WP01','WP02','WP04','C21','PV01','SV01','PINK',
            'SV01','SC01','SC02','SC04','SC05','SC06','SC07','SC08',
            'QR01','LC04','WP05','ET01','FF01','ORAN','PLE1','PET1','PCH2','PRE1','POP1','ROY2'
        ];
        $address_cd = [
            261183, 261184, 260849
        ];
        $address_opt = [
            261183 => [
                'zipcode' => 5500022,
                'pref'    => 26,
                'siku'    => '大阪市西区',
                'tyou'    => '本田'
            ],
            261184 => [
                'zipcode' => 5500015,
                'pref'    => 26,
                'siku'    => '大阪市西区',
                'tyou'    => '南堀江'
            ],
            260849 => [
                'zipcode' => 5510000,
                'pref'    => 26,
                'siku'    => '大阪市大正区',
                'tyou'    => '（以下に掲載がない場合）'
            ],
        ];

        for ($i=0; $i<=50; $i++) {
            $delivery_date_type = $delivery_date_types[array_rand($delivery_date_types)];
            $day = $days[array_rand($days)];
            $delivery_date      = null;
            $delivery_date_from = null;
            $delivery_date_to   = null;
            $order_date_type    = null;
            $order_date         = null;
            $order_date_from    = null;
            $order_date_to      = null;
            switch ($delivery_date_type) {
                case 1:
                    $delivery_date = date('Ymd', strtotime("-{$day} day"));
                    break;
                case 2:
                    $delivery_date_from = date('Ymd', strtotime("-{$day} day"));
                    $delivery_date_to = date('Ymd', strtotime("+{$day} day"));
                    break;
                case 3:
                    break;
                default:
                    $order_date_type = $order_date_types[array_rand($order_date_types)];
                    switch ($order_date_type) {
                        case 1:
                            $order_date = date('Ymd', strtotime("-{$day} day"));
                            break;
                        case 2:
                            $order_date_from = date('Ymd', strtotime("-{$day} day"));
                            $order_date_to = date('Ymd', strtotime("+{$day} day"));
                            break;
                        case 3:
                        default:
                            break;
                    }
                break;
            }
            $c_use = rand(1, 99);
            DB::table('irregular')->insert([
                'title'                      => 'タイトル_'.date('Ymd'). "_" . $i,
                'irregular_type'             => $irregular_type,
                'c_use'                      => $c_use,
                'is_valid'                   => rand(0, 1),
                'is_before_deadline_undeliv' => rand(0, 1),
                'is_today_deadline_undeliv'  => rand(0, 1),
                'is_time_select_undeliv'     => rand(0, 1),
                'time_select'                => $time_select,
                'is_personal_delivery'       => rand(0, 1),
                'delivery_date_type'         => $delivery_date_type,
                'delivery_date'              => $delivery_date,
                'delivery_date_from'         => $delivery_date_from,
                'delivery_date_to'           => $delivery_date_to,
                'order_date_type'            => $order_date_type,
                'order_date'                 => $delivery_date,
                'order_date_from'            => $delivery_date_from,
                'order_date_to'              => $delivery_date_to,
                'is_depo'                    => rand(0, 1),
                'is_item'                    => rand(0, 1),
                'is_area'                    => rand(0, 1),
                'anno_from'                  => date('Ymd', strtotime("-1 day")),
                'anno_to'                    => date('Ymd', strtotime("+7 day")),
                'anno_addr'                  => '地域注釈',
                'anno_period'                => '期間注釈',
                'anno_trans'                 => '振替注釈',
                'error_message'              => 'エラーメッセージ',
                'trans_depo_cd'              => $trans_depo_cd[array_rand($trans_depo_cd)],
                'remark'                     => '備考'
            ]);
            $id = DB::getPdo()->lastInsertId();
            // イレギュラーデポ情報
            DB::table('irregular_depo')->insert([
                'irregular_id' => $id,
                'depo_cd'      => $depo_cd[array_rand($depo_cd)],
            ]);
            // イレギュラー商品情報
            DB::table('irregular_item')->insert([
                'irregular_id' => $id,
                'lcat_cd'      => rand(1, 3),
                'mcat_cd'      => rand(1, 9),
                'item_cd'      => $item_cd[array_rand($item_cd)],
            ]);
            // イレギュラー地域情報
            $addr_cd = $address_cd[array_rand($address_cd)];
            DB::table('irregular_area')->insert([
                'irregular_id' => $id,
                'addr_cd'      => $addr_cd,
                'zip_cd'       => $address_opt[$addr_cd]['zipcode'],
                'pref_cd'      => $address_opt[$addr_cd]['pref'],
                'siku'         => $address_opt[$addr_cd]['siku'],
                'tyou'         => $address_opt[$addr_cd]['tyou'],
            ]);
            // イレギュラー曜日情報
            DB::table('irregular_dayofweek')->insert([
                'irregular_id'          => $id,
                'date_type'             => rand(1, 2),
                'dayofweek'             => rand(0, 6),
                'public_holiday_status' => rand(1, 4),
            ]);

        }
    }
}
