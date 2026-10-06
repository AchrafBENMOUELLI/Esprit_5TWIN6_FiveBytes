<?php

namespace Database\Factories\Drought;

use App\Models\Drought\Subscription;
use App\Models\Infrastructure\Zone;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'zone_id' => Zone::factory(),
            'canal' => $this->faker->randomElement(['email', 'sms', 'app']),
            'actif' => true,
        ];
    }
}
