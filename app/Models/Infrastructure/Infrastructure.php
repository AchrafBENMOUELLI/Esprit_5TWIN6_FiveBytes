<?php

namespace App\Models\Infrastructure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Infrastructure extends Model
{
    protected $fillable = [
        'nom',
        'type',
        'materiau',
        'date_installation',
        'capacite',
        'latitude',
        'longitude',
        'statut',
        'score_risque',
        'zone_id',
    ];

    protected function casts(): array
    {
        return [
            'date_installation' => 'date',
            'capacite' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'score_risque' => 'decimal:2',
        ];
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Relation avec les incidents liés à cette infrastructure
     */
    public function incidents(): HasMany
    {
        return $this->hasMany(\App\Models\Incident\Incident::class);
    }
}