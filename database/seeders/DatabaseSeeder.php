<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\productRefund;
use App\Models\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            ClientSeeder::class,
            UsersStateSeeder::class
        ]);
       // $this->call([TestSeeder::class]);
    }
}
