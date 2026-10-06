<?php

namespace App\Models\Drought;

use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaterLevel extends Model
{
    protected $fillable = [
        'zone_id',
        'source',
        'niveau_pourcentage',
        'volume_m3',
        'date_releve',
    ];

    protected function casts(): array
    {
        return [
            'date_releve' => 'datetime',
            'niveau_pourcentage' => 'decimal:2',
            'volume_m3' => 'decimal:2',
        ];
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }
}
