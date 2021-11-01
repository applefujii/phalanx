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
                'sort' => 10,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'office_name' => 'ミント大阪',
                'sort' => 20,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'office_name' => 'メープル関西',
                'sort' => 30,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
        ]);
    }
}
