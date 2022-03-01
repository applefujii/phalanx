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
            // 生活面
            [
                'question' => '生活リズムを整えたい',
                'sort' => 10,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => 'コミュニケーションを向上させたい',
                'sort' => 20,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '社会に出るために学びたい',
                'sort' => 30,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            // 社会面
            [
                'question' => 'PCを基礎から学びたい',
                'sort' => 40,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => 'Microsoft Officeをできるようになりたい',
                'sort' => 50,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '働くための体力や集中力を身につけたい',
                'sort' => 60,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => 'ビジネスマナーや敬語がわからない',
                'sort' => 70,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '体を動かすことがしたい',
                'sort' => 80,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '客や人とかかわることがしたい',
                'sort' => 90,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => 'お金をもらいながら働く準備がしたい',
                'sort' => 100,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            // 就職面
            [
                'question' => '仕事のイメージができない',
                'sort' => 110,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => 'どんな仕事があるのか、自分にできる仕事があるのかわからない',
                'sort' => 120,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '一人での就職活動が難しい',
                'sort' => 130,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => 'PCを使ったモノづくりがしたい',
                'sort' => 140,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => 'IT業界に興味がある',
                'sort' => 150,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '大阪の緑の多いところへ行きたい',
                'sort' => 160,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '2年以内での就職は難しそう',
                'sort' => 170,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '農業に興味がある',
                'sort' => 180,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '軽作業に興味がある',
                'sort' => 190,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
            [
                'question' => '大阪市内が良い',
                'sort' => 200,
                'create_user_id' => 1,
                'update_user_id' => 1,
                'updated_at' => '2021-04-01 12:34:56',
                'created_at' => '2021-04-01 12:34:56',
            ],
        ]);
    }
}
