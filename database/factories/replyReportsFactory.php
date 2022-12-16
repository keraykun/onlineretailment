<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\userReports;
use App\Models\productReports;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\admiNReplyReports>
 */
class replyReportsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           // 'model'=>'App\Models\usersReport',
            'model'=>'App\Models\productReports',
            'model_id'=>productReports::all()->random()->id,
            'user_id'=>User::all()->random()->id,
            'description'=>$this->faker->sentence(),
            'notification'=>1
        ];
    }
}
