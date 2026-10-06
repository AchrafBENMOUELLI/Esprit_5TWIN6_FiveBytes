<?php

namespace App\Models\Incident;

use App\Enums\IncidentStatut;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncidentStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'incident_status_history';

    protected $fillable = [
        'incident_id',
        'ancien_statut',
        'nouveau_statut',
        'modifie_par',
        'date_changement',
    ];

    /**
     * Définit les casts pour les attributs
     */
    protected function casts(): array
    {
        return [
            'ancien_statut' => IncidentStatut::class,
            'nouveau_statut' => IncidentStatut::class,
            'date_changement' => 'datetime',
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
     * Relation avec l'utilisateur qui a modifié le statut
     */
    public function modificateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modifie_par');
    }

    /**
     * Alias pour la relation modificateur
     */
    public function user(): BelongsTo
    {
        return $this->modificateur();
    }
}
