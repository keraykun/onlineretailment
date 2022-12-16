<?php

namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Role::whereIn('name',['client'])->get() as $role){
            User::create([
                'name'=>'Client Account',
                'email'=>'client@gmail.com',
                'email_verified_at'=>null,
                'role_id'=>$role->id,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'verification_code'=>null,
                'is_verified'=>0
            ]);
       }
    }
}
