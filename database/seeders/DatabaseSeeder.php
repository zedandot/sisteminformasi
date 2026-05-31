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
        // Gunakan updateOrCreate agar tidak crash saat redeploy
        // jika user sudah ada di database (duplicate entry)
        User::updateOrCreate(
            ['email' => 'admin@asakaryaalam.com'],
            [
                'name' => 'Admin Utama',
                'role' => 'admin',
                'field' => 'admin',
                'password' => bcrypt('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'tim@asakaryaalam.com'],
            [
                'name' => 'Tim Lapangan',
                'role' => 'tim_lapangan',
                'field' => 'tim_lapangan',
                'password' => bcrypt('password123'),
            ]
        );
    }
}
