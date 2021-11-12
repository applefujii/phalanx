<?php

namespace Database\Factories;

use App\Models\ChatText;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $dateTime = $this->faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now')->format('Y-m-d');
        
        return [
            'chat_text' => $this->faker->realText(50),
            'chat_room_id' => 1,
            'user_id' => 1,
            'create_user_id' => 1,
            'update_user_id' => 1,
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ];
    }
}
