<?php

namespace App\Enums;

enum DepartmentCodes: string
{
    case ADMIN = 'ADMIN'; // Reparto amministrativo
    case COMM = 'COMM'; // Reparto commerciale
    case TECH = 'TECH'; // Reparto tech

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
