<?php

namespace App\Models\Incident;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncidentComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'user_id',
        'contenu',
        'interne',
    ];

    /**
     * Définit les casts pour les attributs
     */
    protected function casts(): array
    {
        return [
            'interne' => 'boolean',
        ];
    }

    /**
     * Relation avec l'incident
     */
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    /**
     * Relation avec l'utilisateur auteur du commentaire
     */
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias pour la relation auteur
     */
    public function user(): BelongsTo
    {
        return $this->auteur();
    }
}
