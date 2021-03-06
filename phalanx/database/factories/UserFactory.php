<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

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
            'user_type_id' => $this->faker->randomElement($array = [1,2,3]),
            'office_id' => $this->faker->randomElement($array = [1,2,3]),
            'name' => $this->faker->name('ja_JP'),
            'name_katakana' => $this->faker->kanaName,
            'login_name' => $this->faker->unique()->lexify('??????????'),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
            'create_user_id' => 1,
            'update_user_id' => 1,
            'created_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
            'updated_at' => $now->isoFormat('YYYY-MM-DD HH:mm:ss'),
        ];
    }
}
