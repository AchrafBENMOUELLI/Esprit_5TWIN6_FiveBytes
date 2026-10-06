<?php

namespace Database\Seeders;

use App\Models\Infrastructure\Infrastructure;
use Illuminate\Database\Seeder;

class InfrastructureSeeder extends Seeder
{
    public function run(): void
    {
        Infrastructure::factory()->count(20)->create();
    }
}
