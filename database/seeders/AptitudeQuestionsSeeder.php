<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AptitudeQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aptitude_questions')->insert([
            [
                'category' => 1,
                'question' => '生活リズムを整えたい',
                'sort' => 10,
                'score_apple' => 100,
                'score_mint' => 100,
                'score_maple' => 100,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'category' => 2,
                'question' => 'PCを基礎から学びたい',
                'sort' => 10,
                'score_apple' => 100,
                'score_mint' => 100,
                'score_maple' => 50,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'category' => 3,
                'question' => '仕事のイメージができない',
                'sort' => 10,
                'score_apple' => 100,
                'score_mint' => 50,
                'score_maple' => 50,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
        ]);
    }
}
