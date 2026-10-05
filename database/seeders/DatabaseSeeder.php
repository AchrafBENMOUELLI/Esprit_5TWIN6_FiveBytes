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
        $this->command->info('🌱 Starting AquaSecure Database Seeding...');
        $this->command->info('');
        
        // ========================================
        // 1. USERS - Création des utilisateurs de base
        // ========================================
        $this->command->info('👥 Seeding Users...');
        
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
        
        // Créer des users supplémentaires pour les tests
        User::factory()->count(5)->create(['role' => UserRole::Gestionnaire]);
        User::factory()->count(10)->create(['role' => UserRole::Citoyen]);
        
        $this->command->info('✅ Users seeded successfully');
        $this->command->info('');
        
        // ========================================
        // 2. GESTION 1 - Infrastructures et Zones (Prérequis)
        // ========================================
        $this->command->info('🗺️  Seeding Gestion 1 - Infrastructures et Zones...');
        $this->call(InfrastructureModuleSeeder::class);
        $this->command->info('');
        
        // ========================================
        // 3. GESTION 5 - Projets de Rénovation et Financement
        // ========================================
        $this->command->info('🚧 Seeding Gestion 5 - Projets de Rénovation et Financement...');
        $this->call(ProjectModuleSeeder::class);
        $this->command->info('');
        
        // ========================================
        // Autres modules peuvent être ajoutés ici
        // ========================================
        // $this->call(InfrastructureModuleSeeder::class);
        // $this->call(IncidentModuleSeeder::class);
        // $this->call(QualityModuleSeeder::class);
        // $this->call(DroughtModuleSeeder::class);
        
        $this->command->info('');
        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('📝 Default credentials:');
        $this->command->info('   Admin: admin@aquasecure.com / password123');
        $this->command->info('   Gestionnaire: gestionnaire@aquasecure.com / password123');
        $this->command->info('   Citoyen: citoyen@aquasecure.com / password123');
        $this->command->info('');
    }
}