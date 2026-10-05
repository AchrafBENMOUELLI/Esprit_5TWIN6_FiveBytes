<?php

namespace App\Enums;

enum UserRole: string
{
    case Citoyen = 'citoyen';
    case Gestionnaire = 'gestionnaire';
    case Admin = 'admin';
}
