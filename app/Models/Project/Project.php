<?php

namespace App\Models\Project;

use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Zone;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titre',
        'type',
        'description',
        'budget_prevu',
        'date_debut',
        'date_fin_prevue',
        'statut',
        'avancement_pourcentage',
        'zone_id',
        'infrastructure_id',
        'responsable_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'budget_prevu' => 'decimal:2',
            'avancement_pourcentage' => 'integer',
            'date_debut' => 'date',
            'date_fin_prevue' => 'date',
        ];
    }

    /**
     * Get the zone that owns the project.
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    /**
     * Get the infrastructure associated with the project (nullable).
     */
    public function infrastructure()
    {
        return $this->belongsTo(Infrastructure::class, 'infrastructure_id');
    }

    /**
     * Get the user responsible for the project.
     */
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * Get the phases for the project.
     */
    public function projectPhases()
    {
        return $this->hasMany(ProjectPhase::class, 'project_id');
    }

    /**
     * Get the fundings for the project.
     */
    public function fundings()
    {
        return $this->hasMany(Funding::class, 'project_id');
    }

    /**
     * Get the documents for the project.
     */
    public function projectDocuments()
    {
        return $this->hasMany(ProjectDocument::class, 'project_id');
    }

    /**
     * Calculate the total budget from all project phases.
     *
     * @return float
     */
    public function budgetTotal(): float
    {
        return (float) $this->projectPhases()->sum('cout');
    }

    /**
     * Calculate the total funding received.
     *
     * @return float
     */
    public function fundingTotal(): float
    {
        return (float) $this->fundings()->sum('montant');
    }

    /**
     * Calculate the remaining budget (funding - phases cost).
     *
     * @return float
     */
    public function budgetRemaining(): float
    {
        return $this->fundingTotal() - $this->budgetTotal();
    }

    /**
     * Get the budget deficit or surplus.
     *
     * @return float
     */
    public function budgetDifference(): float
    {
        return $this->fundingTotal() - (float) $this->budget_prevu;
    }

    /**
     * Check if the project is over budget.
     *
     * @return bool
     */
    public function isOverBudget(): bool
    {
        return $this->budgetTotal() > (float) $this->budget_prevu;
    }

    /**
     * Check if the project is fully funded.
     *
     * @return bool
     */
    public function isFullyFunded(): bool
    {
        return $this->fundingTotal() >= (float) $this->budget_prevu;
    }
}
