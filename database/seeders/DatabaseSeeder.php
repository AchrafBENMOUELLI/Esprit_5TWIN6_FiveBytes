<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        User::factory()->create([
            'name' => 'Manager Test',
            'email' => 'manager@test.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Gestionnaire,
        ]);

        User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
        ]);

        User::factory()->create([
            'name' => 'Citizen Test',
            'email' => 'citizen@test.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Citoyen,
        ]);

        // Call the DroughtSeeder
        $this->call(DroughtSeeder::class);
    }
}
