<?php

namespace Database\Factories;

use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\productReports>
 */
class ProductReportsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=>User::all()->random()->id,
            'product_id'=>Products::all()->random()->id,
            'title'=>$this->faker->title(),
            'description'=>$this->faker->sentence(),
            'notification'=>1
        ];
    }
}
