<?php

namespace Database\Seeders;

use App\Models\Users;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users::factory(10)->create();

        Users::factory->create([
            'name' => 'Test Users',
            'email' => 'test@example.com',
        ]);
    }
}
