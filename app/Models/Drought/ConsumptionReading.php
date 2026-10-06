<?php

namespace App\Models\Drought;

use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsumptionReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'volume_m3',
        'periode_debut',
        'periode_fin',
        'prevision_ia',
    ];

    protected function casts(): array
    {
        return [
            'periode_debut' => 'datetime',
            'periode_fin' => 'datetime',
            'volume_m3' => 'decimal:2',
        ];
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }
}
