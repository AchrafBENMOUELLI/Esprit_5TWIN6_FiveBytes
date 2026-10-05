<?php

namespace App\Enums\Quality;

enum ResultatGlobal: string
{
    case Conforme = 'conforme';
    case NonConforme = 'non_conforme';

    public function label(): string
    {
        return match ($this) {
            self::Conforme => 'Conforme',
            self::NonConforme => 'Non conforme',
        };
    }
}
