<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌊 Seeding base de données AquaSecure...');
        $this->command->newLine();

        // Ordre important : respecter les dépendances FK
        $this->call([
            UserSeeder::class,           // 1. Créer les utilisateurs d'abord
            ZoneSeeder::class,           // 2. Créer les zones
            InfrastructureSeeder::class, // 3. Créer les infrastructures (dépend des zones)
            IncidentSeeder::class,       // 4. Créer les incidents (dépend des users + infrastructures)
        ]);

        $this->command->newLine();
        $this->command->info('✅ Base de données complètement seedée !');
        $this->command->newLine();
        $this->command->info('📋 Récapitulatif:');
        $this->command->info('   👤 Utilisateurs: 11 (1 Admin, 2 Gestionnaires, 8 Citoyens)');
        $this->command->info('   📍 Zones: 6 zones géographiques');
        $this->command->info('   🏗️  Infrastructures: 12 (réservoirs, stations, canalisations)');
        $this->command->info('   🚨 Incidents: 15 (variés par statut et urgence)');
        $this->command->newLine();
        $this->command->info('🔐 Identifiants de connexion:');
        $this->command->table(
            ['Rôle', 'Email', 'Mot de passe'],
            [
                ['Admin', 'admin@aquasecure.tn', 'password'],
                ['Gestionnaire', 'gestionnaire@aquasecure.tn', 'password'],
                ['Citoyen', 'ahmed.benali@gmail.com', 'password'],
            ]
        );
    }
}
