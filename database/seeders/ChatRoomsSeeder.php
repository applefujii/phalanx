<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChatRoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //現在時刻の取得
        $now = Carbon::now();
        DB::table('chat_rooms')->insert([
            [
                "room_title" => '全職員',
                "distinction_number" => 0,
                'create_user_id' => 1,
                'office_id' => 1,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
                'created_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
            ],
            [
                "room_title" => "アップル梅田職員",
                "distinction_number" => 1,
                'create_user_id' => 1,
                'office_id' => 1,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
                'created_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
            ],
            [
                "room_title" => "ミント大阪職員",
                "distinction_number" => 1,
                'create_user_id' => 1,
                'office_id' => 2,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
                'created_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
            ],
            [
                "room_title" => "メープル関西職員",
                "distinction_number" => 1,
                'create_user_id' => 1,
                'office_id' => 3,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
                'created_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
            ],
        ]);
    }
}
