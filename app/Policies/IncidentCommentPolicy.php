<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Incident\IncidentComment;
use App\Models\User;

class IncidentCommentPolicy
{
    /**
     * Determine whether the user can create comments.
     * Un utilisateur peut commenter s'il peut voir l'incident parent.
     */
    public function create(User $user): bool
    {
        // Tous les utilisateurs authentifiés peuvent créer des commentaires
        return true;
    }

    /**
     * Determine whether the user can delete the comment.
     * On peut supprimer son propre commentaire, l'Admin peut tout supprimer.
     */
    public function delete(User $user, IncidentComment $comment): bool
    {
        // L'Admin peut supprimer n'importe quel commentaire
        if ($user->role === UserRole::Admin) {
            return true;
        }

        // Un utilisateur peut supprimer son propre commentaire
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can view internal comments.
     */
    public function viewInternal(User $user): bool
    {
        return in_array($user->role, [UserRole::Gestionnaire, UserRole::Admin]);
    }

    /**
     * Determine whether the user can create internal comments.
     */
    public function createInternal(User $user): bool
    {
        return in_array($user->role, [UserRole::Gestionnaire, UserRole::Admin]);
    }
}
