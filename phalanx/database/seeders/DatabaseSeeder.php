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
        // //---- テスト用
        // // \App\Models\User::factory(10)->create();
        // $this->call(OfficesSeeder::class);// 事業所マスタ
        // \App\Models\TrialApplication::factory(50)->create();// 体験・見学申込
        // $this->call(AptitudeQuestionsSeeder::class);// 適性診断質問
        // $this->call(UserTypesSeeder::class);
        // $this->call(NotificationsSeeder::class);// 予定通知テーブル
        // $this->call(TestUsersSeeder::class);// ログインテスト用ユーザー
        // $this->call(ChatRoomsSeeder::class);// チャットルーム
        // \App\Models\ChatText::factory(1000)->create();// チャットテキスト
        // foreach ([3, 2, 1] as $office_id) { // テスト用
        //     \App\Models\User::factory(20)->create([
        //         'user_type_id' => 2,
        //         'office_id' => $office_id,
        //     ]); // 通所者
        //     \App\Models\User::factory(6)->create([
        //         'user_type_id' => 1,
        //         'office_id' => $office_id,
        //     ]); // 職員
        //     \App\Models\User::factory(2)->create([
        //         'user_type_id' => 3,
        //         'office_id' => $office_id,
        //     ]); // 体験者
        // }


        //---- 運用用
        $this->call(OfficesSeeder::class);// 事業所マスタ
        // \App\Models\TrialApplication::factory(50)->create();// 体験・見学申込
        $this->call(AptitudeQuestionsSeeder::class);// 適性診断質問
        $this->call(UserTypesSeeder::class);
        // $this->call(NotificationsSeeder::class);// 予定通知テーブル
        // $this->call(TestUsersSeeder::class);// ログインテスト用ユーザー
        $this->call(ChatRoomsSeeder::class);// チャットルーム
        // \App\Models\ChatText::factory(1000)->create();// チャットテキスト
        $this->call(SuperUsersSeeder::class);
        $this->call(ScoresSeeder::class);// 適性診断の点数
    }
}
