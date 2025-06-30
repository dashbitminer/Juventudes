<?php

namespace App\Enums;

enum CategoriaNivelEducativo: string
{
    case Primaria = 'primaria';
    case Basica = 'basica';
    case Bachillerato = 'bachillerato';

    public function label()
    {
        return match ($this) {
            static::Primaria => 'Primaria',
            static::Basica => 'Básica',
            static::Bachillerato => 'Bachillerato',
        };
    }

}
