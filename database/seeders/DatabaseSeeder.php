<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@asakaryaalam.com',
            'role' => 'admin',
            'field' => 'admin',
            'password' => bcrypt('password123')
        ]);

        User::factory()->create([
            'name' => 'Tim Lapangan',
            'email' => 'tim@asakaryaalam.com',
            'role' => 'tim_lapangan',
            'field' => 'tim_lapangan',
            'password' => bcrypt('password123')
        ]);
    }
}
