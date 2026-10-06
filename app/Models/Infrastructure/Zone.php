<?php

namespace App\Models\Infrastructure;

use App\Models\Drought\Restriction;
use App\Models\Drought\ScheduledCut;
use App\Models\Drought\WaterLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    protected $fillable = [
        'nom',
        'commune',
        'code_postal',
        'population',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'population' => 'integer',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function infrastructures(): HasMany
    {
        return $this->hasMany(Infrastructure::class);
    }

    public function waterLevels(): HasMany
    {
        return $this->hasMany(WaterLevel::class);
    }

    public function restrictions(): HasMany
    {
        return $this->hasMany(Restriction::class);
    }

    public function scheduledCuts(): HasMany
    {
        return $this->hasMany(ScheduledCut::class);
    }
}
