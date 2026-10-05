<?php

namespace App\Models\Quality;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaterParameter extends Model
{
    protected $fillable = [
        'water_sample_id',
        'threshold_id',
        'valeur',
        'depasse_seuil',
    ];

    protected function casts(): array
    {
        return [
            'valeur' => 'decimal:3',
            'depasse_seuil' => 'boolean',
        ];
    }

    public function sample(): BelongsTo
    {
        return $this->belongsTo(WaterSample::class, 'water_sample_id');
    }

    public function threshold(): BelongsTo
    {
        return $this->belongsTo(Threshold::class);
    }
}
