<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("user_types")->insert([
            [
                "alias" => "職員",
                "create_user_id" => 1,
                "update_user_id" => 1,
                "updated_at" => "2021-04-01 12:34:56",
                "created_at" => "2021-04-01 12:34:56",
            ],
            [
                "alias" => "通所者",
                "create_user_id" => 1,
                "update_user_id" => 1,
                "updated_at" => "2021-04-01 12:34:56",
                "created_at" => "2021-04-01 12:34:56",
            ],
            [
                "alias" => "体験者",
                "create_user_id" => 1,
                "update_user_id" => 1,
                "updated_at" => "2021-04-01 12:34:56",
                "created_at" => "2021-04-01 12:34:56",
            ],
            [
                "alias" => "スーパーアカウント",
                "create_user_id" => 1,
                "update_user_id" => 1,
                "updated_at" => "2021-04-01 12:34:56",
                "created_at" => "2021-04-01 12:34:56",
            ],
        ]);
    }
}
