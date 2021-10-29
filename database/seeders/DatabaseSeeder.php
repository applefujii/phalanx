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
        \App\Models\TrialApplication::factory(50)->create();// 体験・見学申込
        $this->call(AptitudeQuestionsSeeder::class);// 適性診断質問
    }
}
