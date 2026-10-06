<?php

namespace Database\Factories\Infrastructure;

use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZoneFactory extends Factory
{
    protected $model = Zone::class;

    // Données réalistes algériennes
    private array $wilayas = [
        ['nom' => 'Zone Nord-Alger',      'commune' => 'Alger Centre',   'code' => '16000', 'lat' => 36.7372,  'lng' => 3.0869],
        ['nom' => 'Zone Est-Alger',       'commune' => 'El Harrach',     'code' => '16040', 'lat' => 36.7200,  'lng' => 3.1500],
        ['nom' => 'Zone Ouest-Oran',      'commune' => 'Oran',           'code' => '31000', 'lat' => 35.6969,  'lng' => -0.6331],
        ['nom' => 'Zone Annaba',          'commune' => 'Annaba',         'code' => '23000', 'lat' => 36.9000,  'lng' => 7.7667],
        ['nom' => 'Zone Constantine',     'commune' => 'Constantine',    'code' => '25000', 'lat' => 36.3650,  'lng' => 6.6147],
        ['nom' => 'Zone Blida',           'commune' => 'Blida',          'code' => '09000', 'lat' => 36.4703,  'lng' => 2.8277],
        ['nom' => 'Zone Tlemcen',         'commune' => 'Tlemcen',        'code' => '13000', 'lat' => 34.8800,  'lng' => -1.3150],
        ['nom' => 'Zone Sétif',           'commune' => 'Sétif',          'code' => '19000', 'lat' => 36.1898,  'lng' => 5.4100],
        ['nom' => 'Zone Batna',           'commune' => 'Batna',          'code' => '05000', 'lat' => 35.5550,  'lng' => 6.1740],
        ['nom' => 'Zone Biskra',          'commune' => 'Biskra',         'code' => '07000', 'lat' => 34.8500,  'lng' => 5.7280],
    ];

    public function definition(): array
    {
        $wilaya = $this->faker->unique()->randomElement($this->wilayas);

        return [
            'nom'        => $wilaya['nom'],
            'commune'    => $wilaya['commune'],
            'code_postal'=> $wilaya['code'],
            'population' => $this->faker->numberBetween(30000, 200000),
            'latitude'   => $wilaya['lat'],
            'longitude'  => $wilaya['lng'],
        ];
    }
}
