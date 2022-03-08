<?php
/**
 * 事業所マスタのシーダー
 *
 * @author Fumio Mochizuki
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offices')->insert([
            [
                'office_name' => 'アップル梅田',
                'en_office_name' => 'apple',
                'url' => 'https://apple-osaka.com/',
                'sort' => 10,
                'priority' => 10,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'office_name' => 'ミント大阪',
                'en_office_name' => 'mint',
                'url' => 'https://mint-osaka.jp/',
                'sort' => 20,
                'priority' => 20,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'office_name' => 'メープル関西',
                'en_office_name' => 'maple',
                'url' => 'https://maple-osaka.jp/',
                'sort' => 30,
                'priority' => 30,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
        ]);
    }
}
