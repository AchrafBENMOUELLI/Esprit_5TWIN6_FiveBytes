<?php

namespace App\Enums\Quality;

enum QualityParameter: string
{
    case pH = 'ph';
    case Turbidite = 'turbidite';
    case ChlorLibre = 'chlore_libre';
    case Temperature = 'temperature';
    case Nitrates = 'nitrates';
    case Nitrites = 'nitrites';
    case Ammonium = 'ammonium';
    case Conductivite = 'conductivite';
    case ColiformesTotaux = 'coliformes_totaux';
    case EscherichiaColi = 'escherichia_coli';
    case Plomb = 'plomb';
    case Cuivre = 'cuivre';
    case Fer = 'fer';
    case Manganese = 'manganese';

    public function label(): string
    {
        return match ($this) {
            self::pH => 'pH',
            self::Turbidite => 'Turbidité',
            self::ChlorLibre => 'Chlore libre',
            self::Temperature => 'Température',
            self::Nitrates => 'Nitrates',
            self::Nitrites => 'Nitrites',
            self::Ammonium => 'Ammonium',
            self::Conductivite => 'Conductivité',
            self::ColiformesTotaux => 'Coliformes totaux',
            self::EscherichiaColi => 'Escherichia coli',
            self::Plomb => 'Plomb',
            self::Cuivre => 'Cuivre',
            self::Fer => 'Fer',
            self::Manganese => 'Manganèse',
        };
    }

    public function unite(): string
    {
        return match ($this) {
            self::pH => 'pH',
            self::Turbidite => 'NTU',
            self::ChlorLibre => 'mg/L',
            self::Temperature => '°C',
            self::Nitrates, self::Nitrites, self::Ammonium => 'mg/L',
            self::Conductivite => 'µS/cm',
            self::ColiformesTotaux, self::EscherichiaColi => 'UFC/100mL',
            self::Plomb, self::Cuivre, self::Fer, self::Manganese => 'µg/L',
        };
    }
}
