<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
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
                'name' => 'アップル梅田　職員',
                'name_katakana' => 'アップルウメダ　ショクイン',
                'login_name' => 'apple_staff',
                'password' => Hash::make('password'), // password
                'remember_token' => null,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => "2021-04-01 12:34:56",
                'created_at' => "2021-04-01 12:34:56",
            ],
            [
                'user_type_id' => 1,
                'office_id' => 2,
                'name' => 'ミント大阪　職員',
                'name_katakana' => 'ミントオオサカ　ショクイン',
                'login_name' => 'mint_staff',
                'password' => Hash::make('password'), // password
                'remember_token' => null,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => "2021-04-01 12:34:56",
                'created_at' => "2021-04-01 12:34:56",
            ],
            [
                'user_type_id' => 1,
                'office_id' => 3,
                'name' => 'メープル関西　職員',
                'name_katakana' => 'メープルカンサイ　ショクイン',
                'login_name' => 'maple_staff',
                'password' => Hash::make('password'), // password
                'remember_token' => null,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => "2021-04-01 12:34:56",
                'created_at' => "2021-04-01 12:34:56",
            ],
            [
                'user_type_id' => 2,
                'office_id' => 1,
                'name' => 'アップル梅田　通所者',
                'name_katakana' => 'アップルウメダ　ツウショシャ',
                'login_name' => 'apple_user',
                'password' => Hash::make('password'), // password
                'remember_token' => null,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => "2021-04-01 12:34:56",
                'created_at' => "2021-04-01 12:34:56",
            ],
            [
                'user_type_id' => 2,
                'office_id' => 2,
                'name' => 'ミント大阪　通所者員',
                'name_katakana' => 'ミントオオサカ　通所者',
                'login_name' => 'mint_user',
                'password' => Hash::make('password'), // password
                'remember_token' => null,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => "2021-04-01 12:34:56",
                'created_at' => "2021-04-01 12:34:56",
            ],
            [
                'user_type_id' => 2,
                'office_id' => 3,
                'name' => 'メープル関西　通所者',
                'name_katakana' => 'メープルカンサイ　ツウショシャ',
                'login_name' => 'maple_user',
                'password' => Hash::make('password'), // password
                'remember_token' => null,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => "2021-04-01 12:34:56",
                'created_at' => "2021-04-01 12:34:56",
            ],
            [
                'user_type_id' => 3,
                'office_id' => 1,
                'name' => 'アップル梅田　体験者',
                'name_katakana' => 'アップルウメダ　タイケンシャ',
                'login_name' => 'apple_ex',
                'password' => Hash::make('password'), // password
                'remember_token' => null,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => "2021-04-01 12:34:56",
                'created_at' => "2021-04-01 12:34:56",
            ],
            [
                'user_type_id' => 3,
                'office_id' => 2,
                'name' => 'ミント大阪　体験者',
                'name_katakana' => 'ミントオオサカ　タイケンシャ',
                'login_name' => 'mint_ex',
                'password' => Hash::make('password'), // password
                'remember_token' => null,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => "2021-04-01 12:34:56",
                'created_at' => "2021-04-01 12:34:56",
            ],
            [
                'user_type_id' => 3,
                'office_id' => 3,
                'name' => 'メープル関西　体験者',
                'name_katakana' => 'メープルカンサイ　タイケンシャ',
                'login_name' => 'maple_ex',
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
