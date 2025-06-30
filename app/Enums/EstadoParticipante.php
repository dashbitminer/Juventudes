<?php

namespace App\Enums;

enum EstadoParticipante: string
{
    case Activo = "1";
    case Inactivo = "2";
    case Pausa = "3";
    case Reingreso = "4";
    case Desertado = "5";
    case Graduado = "6";

    public function label()
    {
        return match ($this) {
            static::Activo => 'Activo',
            static::Inactivo => 'Inactivo',
            static::Pausa => 'Pausa',
            static::Reingreso => 'Reingreso',
            static::Desertado => 'Desertado',
            static::Graduado => 'Graduado',
        };
    }

    public function icon()
    {
        return match ($this) {
            static::Activo => 'icon.check',
            static::Inactivo => 'icon.clock',
            static::Pausa => 'icon.x-mark',
            static::Reingreso => 'icon.arrow-uturn-left',
            static::Desertado => 'icon.arrow-uturn-left',
            static::Graduado => 'icon.arrow-uturn-left',
        };
    }

    public function color()
    {
        return match ($this) {
            static::Activo => 'green',
            static::Inactivo => 'gray',
            static::Pausa => 'red',
            static::Reingreso => 'purple',
            static::Desertado => 'purple',
            static::Graduado => 'purple',
        };
    }
}
