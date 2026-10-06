<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class IncidentPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'chemin_fichier',
        'legende',
    ];

    /**
     * Relation avec l'incident
     */
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    /**
     * Accessor pour l'URL de la photo
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->chemin_fichier);
    }
}
