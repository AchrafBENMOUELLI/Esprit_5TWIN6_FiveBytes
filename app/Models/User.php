<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
    ];
}

    /**
     * Relation avec les incidents créés par cet utilisateur (en tant que citoyen)
     */
    public function incidentsSignales()
    {
        return $this->hasMany(\App\Models\Incident\Incident::class, 'citoyen_id');
    }

    /**
     * Relation avec les incidents affectés à cet utilisateur (en tant que technicien)
     */
    public function incidentsAffectes()
    {
        return $this->hasMany(\App\Models\Incident\Incident::class, 'technicien_id');
    }
}
