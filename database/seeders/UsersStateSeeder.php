<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\usersState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(User::all() as $user){
            usersState::create(['user_id'=>$user->id,'status'=>'active']);
        }
    }
}
