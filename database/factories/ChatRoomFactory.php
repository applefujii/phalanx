<?php

namespace Database\Factories;

use App\Models\ChatRoom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ChatRoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChatRoom::class;

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
            'room_title' => $this->faker->realText(10),
            'distinction_number' => 4,
            'office_id' => $this->faker->randomElement($array = [1,2,3]),
            'create_user_id' => 1,
            'update_user_id' => 1,
            'created_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
            'updated_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
        ];
    }
}
