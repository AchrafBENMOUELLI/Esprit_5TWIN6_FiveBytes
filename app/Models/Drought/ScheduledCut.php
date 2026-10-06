<?php

namespace App\Models\Drought;

use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledCut extends Model
{
    protected $fillable = [
        'restriction_id',
        'zone_id',
        'debut',
        'fin',
        'motif',
    ];

    protected function casts(): array
    {
        return [
            'debut' => 'datetime',
            'fin' => 'datetime',
        ];
    }

    public function restriction(): BelongsTo
    {
        return $this->belongsTo(Restriction::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }
}
