<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@aquasecure.com',
            'password' => 'password123',
            'role' => UserRole::Admin,
        ]);

        // 2. Gestionnaire User
        User::factory()->create([
            'name' => 'Gestionnaire User',
            'email' => 'gestionnaire@aquasecure.com',
            'password' => 'password123',
            'role' => UserRole::Gestionnaire,
        ]);

        // 3. Citoyen User
        User::factory()->create([
            'name' => 'Citoyen User',
            'email' => 'citoyen@aquasecure.com',
            'password' => 'password123',
            'role' => UserRole::Citoyen,
        ]);
    }
}