<?php

namespace App\Models\Infrastructure;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $fillable = [
        'infrastructure_id',
        'technicien_id',
        'type',
        'description',
        'date_intervention',
        'cout',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_intervention' => 'date',
            'cout' => 'decimal:2',
        ];
    }

    public function infrastructure(): BelongsTo
    {
        return $this->belongsTo(Infrastructure::class);
    }

    public function technicien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }
}
