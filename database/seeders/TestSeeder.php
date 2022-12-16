<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\feedbackReports;
use App\Models\Order;
use App\Models\orderInfos;
use App\Models\orderStatus;
use App\Models\productRefund;
use App\Models\productReports;
use App\Models\Products;
use App\Models\productSold;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $bytes = random_bytes(16);

        $this->faker = Faker::create();
        foreach(Products::with('image')->get() as $product){
            foreach(User::whereHas('role',function($role){
                return $role->whereIn('name',['user']);
                })->get() as $user){

                Cart::create([
                    'user_id'=>$user->id,
                    'product_id'=>$product->id,
                    'price'=>$product->price
                ]);
                Wishlist::create([
                    'user_id'=>$user->id,
                    'product_id'=>$product->id,
                    'price'=>$product->price
                ]);
                $order = Order::create([
                    'user_id'=>$user->id,
                    'seller_id'=>$product->user_id,
                    'product_id'=>$product->id,
                    'status'=>'pending',
                    'price'=>$product->price
                ]);
                orderInfos::create([
                    'user_id'=>$user->id,
                    'order_id'=>$order->_id,
                    'name'=>$user->name,
                    'contact'=>$this->faker->randomElement([
                        '09196425035',
                        '09196426666',
                        '09649305933',
                        '09183911351',
                        '09768113455'
                    ]),
                    'street'=>$this->faker->streetName(),
                    'address'=>$this->faker->address(),
                    'city'=>$this->faker->city(),
                    'province'=>$this->faker->country(),
                    'describe'=>$this->faker->address()
                ]);

                /********deliver*****/

               $deliver = productSold::create([ //delivered
                    'user_id'=>$product->user_id,
                    'product_id'=>$product->id,
                    'order_id'=>bin2hex($bytes),
                    'price'=>$product->price,
                    'quantity'=>rand(1,10),
                    'status'=>'delivered',
                    'created_at'=>$this->faker->dateTimeBetween('now', '+7 months')
                ]);

                orderInfos::create([
                    'user_id'=>$user->id,
                    'order_id'=>$deliver->order_id,
                    'name'=>$user->name,
                    'contact'=>$this->faker->randomElement([
                        '09196425035',
                        '09196426666',
                        '09649305933',
                        '09183911351',
                        '09768113455'
                    ]),
                    'street'=>$this->faker->streetName(),
                    'address'=>$this->faker->address(),
                    'city'=>$this->faker->city(),
                    'province'=>$this->faker->country(),
                    'describe'=>$this->faker->address()
                ]);

                orderStatus::create([
                    'user_id'=>$user->id,
                    'order_id'=>$deliver->order_id,
                    'product_id'=>$product->id,
                    'product_name'=>$product->name,
                    'product_image'=>$product->image->name,
                    'price'=>$product->price,
                    'status'=>'delivered'
                ]);

                feedbackReports::create([
                    'from_user_id'=>$user->id,
                    'to_user_id'=>$product->user_id,
                    'product_id'=>$product->id,
                    'title'=>$this->faker->word(),
                    'description'=>$this->faker->sentence(20),
                    'notification'=>1
                ]);


                /*******end deliver */

                /********refund*****/

                $refund = productSold::create([ //refund
                    'user_id'=>$product->user_id,
                    'product_id'=>$product->id,
                    'order_id'=>bin2hex($bytes),
                    'price'=>$product->price,
                    'quantity'=>rand(1,10),
                    'status'=>'refund',
                    'created_at'=>$this->faker->dateTimeBetween('now', '+7 months')
                ]);
                orderInfos::create([
                    'user_id'=>$user->id,
                    'order_id'=>$refund->order_id,
                    'name'=>$user->name,
                    'contact'=>$this->faker->randomElement([
                        '09196425035',
                        '09196426666',
                        '09649305933',
                        '09183911351',
                        '09768113455'
                    ]),
                    'street'=>$this->faker->streetName(),
                    'address'=>$this->faker->address(),
                    'city'=>$this->faker->city(),
                    'province'=>$this->faker->country(),
                    'describe'=>$this->faker->address()
                ]);

                orderStatus::create([
                    'user_id'=>$user->id,
                    'order_id'=>$deliver->order_id,
                    'product_id'=>$product->id,
                    'product_name'=>$product->name,
                    'product_image'=>$product->image->name,
                    'price'=>$product->price,
                    'status'=>'refund'
                ]);

                productRefund::create([
                    'from_user_id'=>$user->id,
                    'to_user_id'=>$product->user_id,
                    'product_id'=>$product->id,
                    'order_id'=>$refund->order_id,
                    'title'=>$this->faker->word(),
                    'description'=>$this->faker->sentence(20),
                ]);

                /***end refund */

                /*****cancelled*****/

               $cancelled = productSold::create([ //cancelled
                    'user_id'=>$product->user_id,
                    'product_id'=>$product->id,
                    'order_id'=>bin2hex($bytes),
                    'price'=>$product->price,
                    'quantity'=>rand(1,10),
                    'status'=>'cancelled',
                    'created_at'=>$this->faker->dateTimeBetween('now', '+7 months')
                ]);

                orderInfos::create([
                    'user_id'=>$user->id,
                    'order_id'=>$cancelled->order_id,
                    'name'=>$user->name,
                    'contact'=>$this->faker->randomElement([
                        '09196425035',
                        '09196426666',
                        '09649305933',
                        '09183911351',
                        '09768113455'
                    ]),
                    'street'=>$this->faker->streetName(),
                    'address'=>$this->faker->address(),
                    'city'=>$this->faker->city(),
                    'province'=>$this->faker->country(),
                    'describe'=>$this->faker->address()
                ]);

                orderStatus::create([
                    'user_id'=>$user->id,
                    'order_id'=>$cancelled->order_id,
                    'product_id'=>$product->id,
                    'product_name'=>$product->name,
                    'product_image'=>$product->image->name,
                    'price'=>$product->price,
                    'status'=>'cancelled'
                ]);

                productReports::create([
                    'from_user_id'=>$user->id,
                    'to_user_id'=>$product->user_id,
                    'product_id'=>$product->id,
                    'title'=>$this->faker->word(),
                    'description'=>$this->faker->sentence(20),
                    'notification'=>1
                ]);

                /******end cancelled */
            }
        }
    }
}
