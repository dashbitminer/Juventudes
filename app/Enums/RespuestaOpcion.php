<?php

namespace App\Enums;

enum RespuestaOpcion:int
{
    case Si = 1;
    case No = 2;
    case PrefieroNoResponder = 3;

    public function label(){
        return match ($this) {
            static::Si => "Si",
            static::No => "No",
            static::PrefieroNoResponder => "Prefiero no responder",
        };
    }
}