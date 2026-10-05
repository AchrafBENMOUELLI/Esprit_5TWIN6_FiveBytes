<?php

namespace App\Enums;

enum IncidentType: string
{
    case Fuite = 'fuite';
    case Contamination = 'contamination';
    case Coupure = 'coupure';
    case Autre = 'autre';

    /**
     * Retourne le label en français pour le type d'incident
     */
    public function label(): string
    {
        return match($this) {
            self::Fuite => 'Fuite d\'eau',
            self::Contamination => 'Contamination',
            self::Coupure => 'Coupure d\'eau',
            self::Autre => 'Autre',
        };
    }
}
