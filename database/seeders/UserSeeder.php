<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin principal
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@aquasecure.tn',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        // Gestionnaires
        User::create([
            'name' => 'Mohamed Teknik',
            'email' => 'gestionnaire@aquasecure.tn',
            'password' => Hash::make('password'),
            'role' => UserRole::Gestionnaire,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Fatma Maintenance',
            'email' => 'fatma.m@aquasecure.tn',
            'password' => Hash::make('password'),
            'role' => UserRole::Gestionnaire,
            'email_verified_at' => now(),
        ]);

        // Citoyens
        $citoyens = [
            ['name' => 'Ahmed Ben Ali', 'email' => 'ahmed.benali@gmail.com'],
            ['name' => 'Salma Trabelsi', 'email' => 'salma.trabelsi@gmail.com'],
            ['name' => 'Karim Hamdi', 'email' => 'karim.hamdi@gmail.com'],
            ['name' => 'Leila Mansouri', 'email' => 'leila.mansouri@gmail.com'],
            ['name' => 'Youssef Gharbi', 'email' => 'youssef.gharbi@gmail.com'],
            ['name' => 'Nadia Bouazizi', 'email' => 'nadia.bouazizi@gmail.com'],
            ['name' => 'Mehdi Jebali', 'email' => 'mehdi.jebali@gmail.com'],
            ['name' => 'Rim Sassi', 'email' => 'rim.sassi@gmail.com'],
        ];

        foreach ($citoyens as $citoyen) {
            User::create([
                'name' => $citoyen['name'],
                'email' => $citoyen['email'],
                'password' => Hash::make('password'),
                'role' => UserRole::Citoyen,
                'email_verified_at' => now(),
            ]);
        }

        $this->command->info('✅ Users créés: 1 Admin, 2 Gestionnaires, 8 Citoyens');
        $this->command->info('📧 Email de test: admin@aquasecure.tn / gestionnaire@aquasecure.tn / ahmed.benali@gmail.com');
        $this->command->info('🔑 Mot de passe pour tous: password');
    }
}
