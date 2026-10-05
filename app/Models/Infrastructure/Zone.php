<?php

namespace App\Models\Infrastructure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Infrastructure\Infrastructure;

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
        return $this->hasMany(infrastructure::class);
    }
}
