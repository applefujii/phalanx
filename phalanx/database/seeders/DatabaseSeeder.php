<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(OfficesSeeder::class);// 事業所マスタ
        $this->call(NotificationsSeeder::class);// 通知テーブル
        \App\Models\TrialApplication::factory(50)->create();
    }
}
