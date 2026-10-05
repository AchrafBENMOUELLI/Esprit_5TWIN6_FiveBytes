<?php

namespace App\Enums;

enum IncidentUrgence: string
{
    case Faible = 'faible';
    case Moyenne = 'moyenne';
    case Haute = 'haute';
    case Critique = 'critique';

    /**
     * Retourne le label en français pour l'urgence
     */
    public function label(): string
    {
        return match($this) {
            self::Faible => 'Faible',
            self::Moyenne => 'Moyenne',
            self::Haute => 'Haute',
            self::Critique => 'Critique',
        };
    }

    /**
     * Retourne la classe TailwindCSS pour le badge
     */
    public function color(): string
    {
        return match($this) {
            self::Faible => 'bg-green-100 text-green-800 border-green-200',
            self::Moyenne => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            self::Haute => 'bg-orange-100 text-orange-800 border-orange-200',
            self::Critique => 'bg-red-100 text-red-800 border-red-200',
        };
    }
}
