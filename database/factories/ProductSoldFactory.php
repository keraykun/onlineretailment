<?php

namespace Database\Factories;

use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\productSolds>
 */
class ProductSoldFactory extends Factory
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
            'order_id'=>Str::random(24);
            'price'=>$this->faker->numberBetween(200,1000),
            'quantity'=>rand(1,10),
            'status' => $this->faker->randomElement(['delivered', 'refund','cancelled']),
            'created_at'=>$this->faker->dateTimeBetween('now', '+7 months')
        ];
    }
}
