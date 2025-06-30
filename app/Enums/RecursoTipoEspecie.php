<?php

namespace App\Enums;

enum RecursoTipoEspecie:int
{
    case Nuevo = 1;
    case Usado = 2;

    public function label(){
        return match ($this) {
            static::Nuevo => "Nuevo",
            static::Usado => "Usado",
        };
    }
}