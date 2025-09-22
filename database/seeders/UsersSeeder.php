<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@local.test',
            'password' => Hash::make('secret123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Usuario',
            'email' => 'user@local.test',
            'password' => Hash::make('secret123'),
            'role' => 'user'
        ]);
    }
}
