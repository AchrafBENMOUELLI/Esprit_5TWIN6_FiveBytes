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
        // Get or create zones
        $zones = Zone::all();
        if ($zones->isEmpty()) {
            $zones = Zone::factory(3)->create();
        }

        // Get or create users
        $manager = User::whereRole('gestionnaire')->first() ?? User::factory()->create(['role' => 'gestionnaire']);
        $users = User::all();

        // Create water levels for each zone
        foreach ($zones as $zone) {
            WaterLevel::factory(5)
                ->for($zone)
                ->create();
        }

        // Create restrictions
        $restrictions = Restriction::factory(5)
            ->for(Zone::inRandomOrder()->first())
            ->for($manager, 'createur')
            ->create();

        // Create scheduled cuts for each restriction
        foreach ($restrictions as $restriction) {
            ScheduledCut::factory(2)
                ->for($restriction)
                ->for($restriction->zone)
                ->create();
        }

        // Create consumption readings
        foreach ($zones as $zone) {
            ConsumptionReading::factory(10)
                ->for($zone)
                ->create();
        }

        // Create subscriptions for citizens
        $citizens = $users->filter(fn($u) => $u->role === 'citoyen')->take(5);
        foreach ($citizens as $citizen) {
            Subscription::factory(2)
                ->for($citizen)
                ->for(Zone::inRandomOrder()->first())
                ->create();
        }
    }
}
