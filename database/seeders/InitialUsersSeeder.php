<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InitialUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            [
                'user_type_id' => 1,
                'office_id' => 1,
                'name' => '初期アカウント',
                'name_katakana' => 'ショキアカウント',
                'login_name' => 'init',
                'password' => Hash::make('password'), // password
                'remember_token' => null,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => "2021-04-01 12:34:56",
                'created_at' => "2021-04-01 12:34:56",
            ],
        ]);
    }
}
