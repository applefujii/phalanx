<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatRoom__UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chat_room__user')->insert([
            [
                "chat_room_id" => 1,
                "user_id" => 1,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56'
            ],
            [
                "chat_room_id" => 1,
                "user_id" => 2,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56'
            ],
            [
                "chat_room_id" => 1,
                "user_id" => 3,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56'
            ],
            [
                "chat_room_id" => 1,
                "user_id" => 4,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56'
            ],
            [
                "chat_room_id" => 1,
                "user_id" => 5,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56'
            ],
            [
                "chat_room_id" => 1,
                "user_id" => 6,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56'
            ],
            [
                "chat_room_id" => 1,
                "user_id" => 7,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56'
            ],
            [
                "chat_room_id" => 1,
                "user_id" => 8,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56'
            ],
            [
                "chat_room_id" => 1,
                "user_id" => 9,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56'
            ]
        ]);
    }
}
