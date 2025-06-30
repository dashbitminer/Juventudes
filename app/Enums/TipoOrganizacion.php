<?php

namespace App\Enums;

enum TipoOrganizacion:int
{
    case Nueva = 1;
    case Existente = 2;

    public function label(){
        return match ($this) {
            static::Nueva => "Nueva",
            static::Existente => "Existente",
        };
    }
}