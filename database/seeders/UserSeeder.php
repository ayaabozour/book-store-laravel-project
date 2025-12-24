<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole    = Role::where('name', 'admin')->firstOrFail();
        $authorRole   = Role::where('name', 'author')->firstOrFail();
        $customerRole = Role::where('name', 'customer')->firstOrFail();
        
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id'  => $adminRole->id,
        ]);

        User::create([
            'name'     => 'Author',
            'email'    => 'author@example.com',
            'password' => Hash::make('password123'),
            'role_id'  => $authorRole->id,
        ]);

        User::create([
            'name'     => 'Customer',
            'email'    => 'customer@example.com',
            'password' => Hash::make('password123'),
            'role_id'  => $customerRole->id,
        ]);

        User::factory()
            ->count(15)
            ->create([
                'role_id' => $authorRole->id,
            ]);

        User::factory()
            ->count(10)
            ->create([
                'role_id' => $customerRole->id,
            ]);
    }
}
