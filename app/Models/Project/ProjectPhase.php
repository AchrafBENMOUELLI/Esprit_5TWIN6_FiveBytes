<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPhase extends Model
{
    use HasFactory;

    /**
     * The name of the factory that should be used for this model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\ProjectPhaseFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'contractor_id',
        'nom',
        'date_debut',
        'date_fin',
        'cout',
        'avancement',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cout' => 'decimal:2',
            'avancement' => 'integer',
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    /**
     * Get the project that owns the phase.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Get the contractor assigned to the phase.
     */
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    /**
     * Get the duration of the phase in days.
     *
     * @return int
     */
    public function getDurationInDays(): int
    {
        if (!$this->date_debut || !$this->date_fin) {
            return 0;
        }
        return $this->date_debut->diffInDays($this->date_fin);
    }

    /**
     * Check if the phase is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->avancement >= 100;
    }

    /**
     * Check if the phase is overdue.
     *
     * @return bool
     */
    public function isOverdue(): bool
    {
        return !$this->isCompleted() && $this->date_fin && $this->date_fin->isPast();
    }
}
