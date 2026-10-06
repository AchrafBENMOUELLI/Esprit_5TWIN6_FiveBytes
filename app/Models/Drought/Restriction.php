<?php

namespace App\Models\Drought;

use App\Models\Infrastructure\Zone;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restriction extends Model
{
    protected $fillable = [
        'titre',
        'niveau',
        'description',
        'date_debut',
        'date_fin',
        'zone_id',
        'cree_par',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'datetime',
            'date_fin' => 'datetime',
        ];
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function cuts(): HasMany
    {
        return $this->hasMany(ScheduledCut::class);
    }
}
