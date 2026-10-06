<?php

namespace Database\Seeders;

use App\Models\Drought\ConsumptionReading;
use App\Models\Drought\Restriction;
use App\Models\Drought\ScheduledCut;
use App\Models\Drought\Subscription;
use App\Models\Drought\WaterLevel;
use App\Models\Infrastructure\Zone;
use App\Models\User;
use Illuminate\Database\Seeder;

class DroughtSeeder extends Seeder
{
    public function run(): void
    {
        // Create all 24 Tunisian regions
        if (Zone::count() == 0) {
            Zone::factory(24)->create();
        }

        // Get all zones (includes all 24 regions)
        $allZones = Zone::all();

        // Get or create users
        $manager = User::whereRole('gestionnaire')->first() ?? User::factory()->create(['role' => 'gestionnaire']);
        $users = User::all();

        // Get only Tunis and Bizerte for demo purposes
        $demoZones = $allZones->whereIn('nom', ['Tunis', 'Bizerte']);

        // Create water levels for demo zones only
        foreach ($demoZones as $zone) {
            WaterLevel::factory(5)
                ->for($zone)
                ->create();
        }

        // Create restrictions for demo zones only
        $restrictions = Restriction::factory(5)
            ->for($demoZones->random())
            ->for($manager, 'createur')
            ->create();

        // Create scheduled cuts for each restriction
        foreach ($restrictions as $restriction) {
            ScheduledCut::factory(2)
                ->for($restriction)
                ->for($restriction->zone)
                ->create();
        }

        // Create consumption readings for demo zones only
        foreach ($demoZones as $zone) {
            ConsumptionReading::factory(10)
                ->for($zone)
                ->create();
        }

        // Create subscriptions for citizens with demo zones only
        $citizens = $users->filter(fn($u) => $u->role === 'citoyen')->take(5);
        foreach ($citizens as $citizen) {
            Subscription::factory(2)
                ->for($citizen)
                ->for($demoZones->random())
                ->create();
        }
    }
}
