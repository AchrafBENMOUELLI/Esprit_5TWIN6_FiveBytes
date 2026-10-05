<?php

namespace App\Enums;

enum IncidentStatut: string
{
    case Nouveau = 'nouveau';
    case Assigne = 'assigne';
    case EnCours = 'en_cours';
    case Resolu = 'resolu';
    case Rejete = 'rejete';
    case Doublon = 'doublon';
    case Ferme = 'ferme';

    /**
     * Retourne le label en français pour le statut
     */
    public function label(): string
    {
        return match($this) {
            self::Nouveau => 'Nouveau',
            self::Assigne => 'Assigné',
            self::EnCours => 'En cours',
            self::Resolu => 'Résolu',
            self::Rejete => 'Rejeté',
            self::Doublon => 'Doublon',
            self::Ferme => 'Fermé',
        };
    }

    /**
     * Retourne la classe TailwindCSS pour le badge
     */
    public function color(): string
    {
        return match($this) {
            self::Nouveau => 'bg-blue-100 text-blue-800 border-blue-200',
            self::Assigne => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            self::EnCours => 'bg-purple-100 text-purple-800 border-purple-200',
            self::Resolu => 'bg-green-100 text-green-800 border-green-200',
            self::Rejete => 'bg-red-100 text-red-800 border-red-200',
            self::Doublon => 'bg-orange-100 text-orange-800 border-orange-200',
            self::Ferme => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
