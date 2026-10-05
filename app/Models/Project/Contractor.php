<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'specialite',
        'email',
        'telephone',
        'adresse',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email' => 'string',
        ];
    }

    /**
     * Set the email attribute to lowercase.
     *
     * @param string $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * Validate email format.
     *
     * @return bool
     */
    public function isValidEmail(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Get the project phases for this contractor.
     */
    public function projectPhases()
    {
        return $this->hasMany(ProjectPhase::class, 'contractor_id');
    }

    /**
     * Get the projects count for this contractor.
     */
    public function getProjectsCountAttribute(): int
    {
        return $this->projectPhases()->distinct('project_id')->count('project_id');
    }
}
