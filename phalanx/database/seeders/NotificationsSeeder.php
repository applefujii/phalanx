<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("Notifications")->insert([
            [
                "content" => "通知本文です。終日の予定ではありません。",
                "start_at" => "2021-04-01 12:34:56",
                "end_at" => "2022-04-01 12:34:56",
                "is_all_day" => false,
                "create_user_id" => 1,
                "update_user_id" => 1,
                "created_at" => "2021-04-01 12:34:56",
                "updated_at" => "2021-04-01 12:34:56"
            ],
            [
                "content" => "2つ目の通知本文です。終日の予定です。",
                "start_at" => "2021-04-01 12:34:56",
                "end_at" => "2022-04-01 12:34:56",
                "is_all_day" => true,
                "create_user_id" => 1,
                "update_user_id" => 1,
                "created_at" => "2021-04-01 12:34:56",
                "updated_at" => "2021-04-01 12:34:56"
            ]
        ]);
    }
}
