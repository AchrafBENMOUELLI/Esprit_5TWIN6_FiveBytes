<?php

namespace App\Models\Quality;

use App\Enums\Quality\AlertLevel;
use App\Enums\Quality\QualityParameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Threshold extends Model
{
    protected $fillable = [
        'parametre',
        'unite',
        'valeur_min',
        'valeur_max',
        'niveau_alerte',
    ];

    protected function casts(): array
    {
        return [
            'parametre' => QualityParameter::class,
            'niveau_alerte' => AlertLevel::class,
            'valeur_min' => 'decimal:3',
            'valeur_max' => 'decimal:3',
        ];
    }

    public function parameters(): HasMany
    {
        return $this->hasMany(WaterParameter::class);
    }
}
