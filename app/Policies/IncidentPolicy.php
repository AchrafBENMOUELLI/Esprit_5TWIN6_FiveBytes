<?php

namespace App\Policies;

use App\Enums\IncidentStatut;
use App\Enums\UserRole;
use App\Models\Incident\Incident;
use App\Models\User;

class IncidentPolicy
{
    /**
     * Determine whether the user can view any incidents.
     */
    public function viewAny(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent voir la liste
        return true;
    }

    /**
     * Determine whether the user can view the incident.
     */
    public function view(User $user, Incident $incident): bool
    {
        // Admin et Gestionnaire peuvent voir tous les incidents
        if (in_array($user->role, [UserRole::Admin, UserRole::Gestionnaire])) {
            return true;
        }

        // Un citoyen peut voir uniquement ses propres incidents
        return $user->id === $incident->citoyen_id;
    }

    /**
     * Determine whether the user can create incidents.
     */
    public function create(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent créer un incident
        return true;
    }

    /**
     * Determine whether the user can update the incident.
     */
    public function update(User $user, Incident $incident): bool
    {
        // Admin peut tout modifier
        if ($user->role === UserRole::Admin) {
            return true;
        }

        // Gestionnaire peut tout modifier
        if ($user->role === UserRole::Gestionnaire) {
            return true;
        }

        // Un citoyen peut modifier uniquement ses propres incidents au statut "nouveau"
        if ($user->role === UserRole::Citoyen) {
            return $user->id === $incident->citoyen_id 
                && $incident->statut === IncidentStatut::Nouveau;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the incident.
     */
    public function delete(User $user, Incident $incident): bool
    {
        // Admin peut tout supprimer
        if ($user->role === UserRole::Admin) {
            return true;
        }

        // Gestionnaire peut tout supprimer
        if ($user->role === UserRole::Gestionnaire) {
            return true;
        }

        // Un citoyen peut supprimer uniquement ses propres incidents au statut "nouveau"
        if ($user->role === UserRole::Citoyen) {
            return $user->id === $incident->citoyen_id 
                && $incident->statut === IncidentStatut::Nouveau;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the incident.
     */
    public function restore(User $user, Incident $incident): bool
    {
        // Seuls Admin et Gestionnaire peuvent restaurer
        return in_array($user->role, [UserRole::Admin, UserRole::Gestionnaire]);
    }

    /**
     * Determine whether the user can permanently delete the incident.
     */
    public function forceDelete(User $user, Incident $incident): bool
    {
        // Seul l'Admin peut supprimer définitivement
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can assign a technician to the incident.
     */
    public function assignTechnician(User $user, Incident $incident): bool
    {
        // Seuls Gestionnaire et Admin peuvent affecter un technicien
        return in_array($user->role, [UserRole::Admin, UserRole::Gestionnaire]);
    }

    /**
     * Determine whether the user can change the status of the incident.
     */
    public function changeStatus(User $user, Incident $incident): bool
    {
        // Seuls Gestionnaire et Admin peuvent changer le statut
        return in_array($user->role, [UserRole::Admin, UserRole::Gestionnaire]);
    }
}
