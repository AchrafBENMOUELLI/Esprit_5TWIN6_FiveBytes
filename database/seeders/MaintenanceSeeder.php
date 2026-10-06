<?php

namespace Database\Seeders;

use App\Models\Infrastructure\Maintenance;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    public function run(): void
    {
        Maintenance::factory()->count(30)->create();
    }
}
