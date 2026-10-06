<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name'     => 'mariem',
            'email'    => 'mariem@aquasecure.dz',
            'password' => Hash::make('password'),
            'role'     => UserRole::Admin,
        ]);

        // Technicien
        User::factory()->create([
            'name'     => 'Karim Benali',
            'email'    => 'karim@aquasecure.dz',
            'password' => Hash::make('password'),
            'role'     => UserRole::Gestionnaire,
        ]);

        // Données infrastructure (ordre important : zones → infras → maintenances)
        $this->call([
            ZoneSeeder::class,
            InfrastructureSeeder::class,
            MaintenanceSeeder::class,
        ]);
    }
}
