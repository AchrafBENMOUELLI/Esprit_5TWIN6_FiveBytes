<?php

namespace App\Models\Quality;

use App\Enums\Quality\AlertLevel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QualityAlert extends Model
{
    protected $fillable = [
        'water_sample_id',
        'niveau',
        'message',
        'publiee',
        'date_resolution',
    ];

    protected function casts(): array
    {
        return [
            'niveau' => AlertLevel::class,
            'publiee' => 'boolean',
            'date_resolution' => 'datetime',
        ];
    }

    public function sample(): BelongsTo
    {
        return $this->belongsTo(WaterSample::class, 'water_sample_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('publiee', true);
    }
}
