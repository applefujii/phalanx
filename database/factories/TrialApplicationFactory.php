<?php

namespace Database\Factories;

use App\Models\TrialApplication;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TrialApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrialApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dateTime = $this->faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now')->format('Y-m-d');
        return [
            'name' => $this->faker->name,
            'name_kana' => $this->faker->kanaName,
            'office_id' => $this->faker->randomElement($array = [1,2,3]),
            'desired_date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+2 months')->format('Y-m-d'),
            'is_checked' => $this->faker->randomElement($array = [true, false]),
            'email' => $this->faker->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ];
    }
}
