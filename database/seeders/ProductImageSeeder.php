<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\productsImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
       foreach(Products::all() as $product){
         productsImage::create(['product_id'=>$product->id,'name'=>$this->faker->imageUrl()]);
       }
    }
}
