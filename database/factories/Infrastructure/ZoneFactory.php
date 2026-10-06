<?php

namespace Database\Factories\Infrastructure;

use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZoneFactory extends Factory
{
    protected $model = Zone::class;

    private static int $regionIndex = 0;

    private static array $tunisianRegions = [
        ['nom' => 'Tunis', 'commune' => 'Tunis', 'code_postal' => '1000', 'population' => 638000, 'latitude' => 36.8065, 'longitude' => 10.1815],
        ['nom' => 'Ariana', 'commune' => 'Ariana', 'code_postal' => '2080', 'population' => 434000, 'latitude' => 36.8634, 'longitude' => 10.1867],
        ['nom' => 'Ben Arous', 'commune' => 'Ben Arous', 'code_postal' => '2000', 'population' => 546000, 'latitude' => 36.7533, 'longitude' => 10.2262],
        ['nom' => 'Manouba', 'commune' => 'Manouba', 'code_postal' => '2010', 'population' => 383000, 'latitude' => 36.8119, 'longitude' => 9.7275],
        ['nom' => 'Nabeul', 'commune' => 'Nabeul', 'code_postal' => '8000', 'population' => 335000, 'latitude' => 36.4558, 'longitude' => 10.7361],
        ['nom' => 'Zaghouan', 'commune' => 'Zaghouan', 'code_postal' => '1100', 'population' => 62000, 'latitude' => 36.4033, 'longitude' => 10.1403],
        ['nom' => 'Bizerte', 'commune' => 'Bizerte', 'code_postal' => '7000', 'population' => 234000, 'latitude' => 37.2742, 'longitude' => 9.8731],
        ['nom' => 'Béja', 'commune' => 'Béja', 'code_postal' => '9100', 'population' => 114000, 'latitude' => 36.7264, 'longitude' => 9.1823],
        ['nom' => 'Jendouba', 'commune' => 'Jendouba', 'code_postal' => '8100', 'population' => 115000, 'latitude' => 36.5022, 'longitude' => 8.7847],
        ['nom' => 'Le Kef', 'commune' => 'Le Kef', 'code_postal' => '7100', 'population' => 67000, 'latitude' => 36.1769, 'longitude' => 8.7081],
        ['nom' => 'Siliana', 'commune' => 'Siliana', 'code_postal' => '6100', 'population' => 89000, 'latitude' => 36.0283, 'longitude' => 9.3681],
        ['nom' => 'Kairouan', 'commune' => 'Kairouan', 'code_postal' => '3100', 'population' => 191000, 'latitude' => 35.6781, 'longitude' => 9.5198],
        ['nom' => 'Kasserine', 'commune' => 'Kasserine', 'code_postal' => '1200', 'population' => 172000, 'latitude' => 35.1658, 'longitude' => 8.8330],
        ['nom' => 'Sidi Bouzid', 'commune' => 'Sidi Bouzid', 'code_postal' => '9300', 'population' => 126000, 'latitude' => 35.0327, 'longitude' => 9.4833],
        ['nom' => 'Sousse', 'commune' => 'Sousse', 'code_postal' => '4000', 'population' => 468000, 'latitude' => 35.8256, 'longitude' => 10.6369],
        ['nom' => 'Monastir', 'commune' => 'Monastir', 'code_postal' => '5000', 'population' => 194000, 'latitude' => 35.7667, 'longitude' => 10.8167],
        ['nom' => 'Mahdia', 'commune' => 'Mahdia', 'code_postal' => '5100', 'population' => 97000, 'latitude' => 35.5047, 'longitude' => 11.0626],
        ['nom' => 'Sfax', 'commune' => 'Sfax', 'code_postal' => '3000', 'population' => 600000, 'latitude' => 34.7406, 'longitude' => 10.7603],
        ['nom' => 'Gabès', 'commune' => 'Gabès', 'code_postal' => '6000', 'population' => 168000, 'latitude' => 33.8869, 'longitude' => 10.0994],
        ['nom' => 'Médenine', 'commune' => 'Médenine', 'code_postal' => '3100', 'population' => 138000, 'latitude' => 33.3646, 'longitude' => 10.5047],
        ['nom' => 'Tataouine', 'commune' => 'Tataouine', 'code_postal' => '3200', 'population' => 154000, 'latitude' => 33.5631, 'longitude' => 10.4547],
        ['nom' => 'Gafsa', 'commune' => 'Gafsa', 'code_postal' => '2100', 'population' => 245000, 'latitude' => 34.4267, 'longitude' => 8.7861],
        ['nom' => 'Tozeur', 'commune' => 'Tozeur', 'code_postal' => '2200', 'population' => 76000, 'latitude' => 33.9167, 'longitude' => 8.1333],
        ['nom' => 'Kébili', 'commune' => 'Kébili', 'code_postal' => '3300', 'population' => 43000, 'latitude' => 33.7083, 'longitude' => 9.0667],
    ];

    public function definition(): array
    {
        $region = self::$tunisianRegions[self::$regionIndex % count(self::$tunisianRegions)];
        self::$regionIndex++;
        
        return $region;
    }
}
