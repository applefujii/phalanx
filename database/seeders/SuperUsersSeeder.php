<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SuperUsersSeeder extends Seeder
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
                'user_type_id' => 4,
                'office_id' => 0,
                'name' => 'スーパーアカウント',
                'name_katakana' => 'スーパーアカウント',
                'login_name' => 'admin',
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
