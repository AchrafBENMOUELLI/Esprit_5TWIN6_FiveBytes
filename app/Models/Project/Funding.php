<?php

namespace App\Models\Project;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funding extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'source',
        'donateur_id',
        'montant',
        'date_versement',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'montant' => 'decimal:2',
            'date_versement' => 'date',
        ];
    }

    /**
     * Get the project that owns the funding.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Get the donor user (nullable).
     */
    public function donateur()
    {
        return $this->belongsTo(User::class, 'donateur_id');
    }

    /**
     * Check if the funding is from a donation.
     *
     * @return bool
     */
    public function isDonation(): bool
    {
        return $this->source === 'don';
    }

    /**
     * Check if the funding is from a public source.
     *
     * @return bool
     */
    public function isPublicFunding(): bool
    {
        return in_array($this->source, ['municipal', 'régional', 'fédéral', 'européen']);
    }

    /**
     * Get the source label in French.
     *
     * @return string
     */
    public function getSourceLabel(): string
    {
        $labels = [
            'municipal' => 'Municipal',
            'régional' => 'Régional',
            'fédéral' => 'Fédéral',
            'européen' => 'Européen',
            'privé' => 'Privé',
            'don' => 'Don',
        ];

        return $labels[$this->source] ?? $this->source;
    }
}
