<?php

namespace Database\Factories;

use App\Models\ChatText;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ChatTextFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChatText::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //現在時刻の取得
        $now = Carbon::now();

        return [
            'chat_text' => $this->faker->realText(50),
            'chat_room_id' => 1,
            'user_id' => $this->faker->randomElement($array = [1,2,3]),
            'create_user_id' => 1,
            'update_user_id' => 1,
            'created_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
            'updated_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
        ];
    }
}
