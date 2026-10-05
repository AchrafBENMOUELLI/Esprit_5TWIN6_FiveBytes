<?php

namespace App\Enums\Quality;

enum AlertLevel: string
{
    case Faible = 'faible';
    case Moyen = 'moyen';
    case Eleve = 'eleve';
    case Critique = 'critique';

    public function label(): string
    {
        return match ($this) {
            self::Faible => 'Faible',
            self::Moyen => 'Moyen',
            self::Eleve => 'Élevé',
            self::Critique => 'Critique',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Faible => 'blue',
            self::Moyen => 'yellow',
            self::Eleve => 'orange',
            self::Critique => 'red',
        };
    }
}
