<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id'=>Categories::all()->random()->id,
            'user_id'=>User::all()->random()->id,
            // 'image'=>$this->faker->imageUrl(),
            'name'=>$this->faker->title(),
            'description'=>$this->faker->word(15),
            'price'=>$this->faker->numberBetween(100,500)
        ];
    }
}
