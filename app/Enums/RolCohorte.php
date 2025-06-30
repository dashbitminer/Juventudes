<?php

namespace App\Enums;

enum RolCohorte:string
{
    //case Primaria = 'primaria';
    case Gestor = 'gestor';
    case Coordinador = 'coordinador';

    public function label()
    {
        return match ($this) {
            static::Gestor => 'Gestor / Personal de Campo',
            static::Coordinador => 'Coordinador',
        };
    }
}
