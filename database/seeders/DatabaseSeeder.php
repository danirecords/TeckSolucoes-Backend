<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         */
        public function run()
        {
            $this->call([
                UsersSeeder::class,
                FundosSeeder::class,
            ]);
        }

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    }
}
