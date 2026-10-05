<?php

namespace App\Models\Quality;

use App\Enums\Quality\ResultatGlobal;
use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Zone;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WaterSample extends Model
{
    protected $fillable = [
        'zone_id',
        'infrastructure_id',
        'preleve_par',
        'date_prelevement',
        'resultat_global',
        'resume_ia',
    ];

    protected function casts(): array
    {
        return [
            'date_prelevement' => 'datetime',
            'resultat_global' => ResultatGlobal::class,
        ];
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function infrastructure(): BelongsTo
    {
        return $this->belongsTo(Infrastructure::class);
    }

    public function preleveur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'preleve_par');
    }

    public function parameters(): HasMany
    {
        return $this->hasMany(WaterParameter::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(QualityAlert::class);
    }
}
