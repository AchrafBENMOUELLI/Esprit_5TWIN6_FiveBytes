<?php

namespace App\Models\Incident;

use App\Enums\IncidentStatut;
use App\Enums\IncidentType;
use App\Enums\IncidentUrgence;
use App\Enums\UserRole;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'type',
        'description',
        'latitude',
        'longitude',
        'urgence',
        'statut',
        'citoyen_id',
        'technicien_id',
        'infrastructure_id',
        'incident_parent_id',
        'date_resolution',
    ];

    /**
     * Boot du modèle pour gérer la génération automatique de la référence
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($incident) {
            if (empty($incident->reference)) {
                $incident->reference = self::generateReference();
            }
        });
    }

    /**
     * Génère automatiquement une référence unique au format INC-2026-0001
     */
    private static function generateReference(): string
    {
        $year = now()->year;
        $prefix = "INC-{$year}-";
        
        // Récupère le dernier incident de l'année
        $lastIncident = self::where('reference', 'LIKE', $prefix . '%')
            ->orderBy('reference', 'desc')
            ->first();
        
        if ($lastIncident) {
            // Extrait le numéro de la dernière référence
            $lastNumber = (int) substr($lastIncident->reference, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        // Formate avec 4 chiffres (0001, 0002, etc.)
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Définit les casts pour les attributs
     */
    protected function casts(): array
    {
        return [
            'urgence' => IncidentUrgence::class,
            'statut' => IncidentStatut::class,
            'type' => IncidentType::class,
            'date_resolution' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    /**
     * Relation avec l'utilisateur qui a créé l'incident (citoyen)
     */
    public function citoyen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'citoyen_id');
    }

    /**
     * Relation avec le technicien affecté à l'incident
     */
    public function technicien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    /**
     * Relation avec l'infrastructure concernée
     */
    public function infrastructure(): BelongsTo
    {
        return $this->belongsTo(Infrastructure::class);
    }

    /**
     * Relation avec l'incident parent (pour les doublons)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Incident::class, 'incident_parent_id');
    }

    /**
     * Relation avec les incidents enfants (doublons de cet incident)
     */
    public function doublons(): HasMany
    {
        return $this->hasMany(Incident::class, 'incident_parent_id');
    }

    /**
     * Relation avec les photos de l'incident
     */
    public function photos(): HasMany
    {
        return $this->hasMany(IncidentPhoto::class);
    }

    /**
     * Relation avec les commentaires de l'incident
     */
    public function comments(): HasMany
    {
        return $this->hasMany(IncidentComment::class);
    }

    /**
     * Relation avec l'historique des changements de statut
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(IncidentStatusHistory::class)
                    ->orderBy('date_changement', 'desc');
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeParStatut(Builder $query, string|IncidentStatut $statut): Builder
    {
        return $query->where('statut', $statut);
    }

    /**
     * Scope pour filtrer par urgence
     */
    public function scopeParUrgence(Builder $query, string|IncidentUrgence $urgence): Builder
    {
        return $query->where('urgence', $urgence);
    }

    /**
     * Scope pour rechercher dans les incidents
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search) {
            $q->where('reference', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('type', 'LIKE', "%{$search}%")
              ->orWhereHas('citoyen', function (Builder $query) use ($search) {
                  $query->where('name', 'LIKE', "%{$search}%");
              });
        });
    }

    /**
     * Récupère les commentaires visibles pour un utilisateur donné
     * Les commentaires internes ne sont visibles que par les Gestionnaires et Admins
     */
    public function visibleComments(User $user): Collection
    {
        $query = $this->comments()->with('auteur');

        // Si l'utilisateur est un Gestionnaire ou Admin, il voit tous les commentaires
        if (in_array($user->role, [UserRole::Gestionnaire, UserRole::Admin])) {
            return $query->orderBy('created_at', 'desc')->get();
        }

        // Sinon, ne montrer que les commentaires publics
        return $query->where('interne', false)
                     ->orderBy('created_at', 'desc')
                     ->get();
    }
}
