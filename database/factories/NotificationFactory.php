<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Model;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dateTime = $this->faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now')->format('Y-m-d');
        
        return [
            'content' => $this->faker->realText(50),
            'start_at' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 week'),
            'end_at' => $this->faker->dateTimeBetween($startDate = '+1 week', $endDate = '+2 week'),
            'is_all_day' => true,
            'create_user_id' => 1,
            'update_user_id' => 1,
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ];
    }
}
