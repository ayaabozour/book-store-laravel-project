<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $roles = Role::all();

       foreach(['admin','author','customer'] as $roleName){
        $role = $roles->where('name',$roleName)->first();

        User::create([
            'name'=> ucfirst($roleName),
            'email'=> $roleName.'@example.com',
            'password'=>bcrypt('password123'),
            'role_id'=>$role->id,
        ]);
       }

    }
}
