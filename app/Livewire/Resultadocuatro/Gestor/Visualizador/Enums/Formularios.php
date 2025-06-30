<?php

namespace App\Livewire\Resultadocuatro\Gestor\Visualizador\Enums;

enum Formularios: string
{
    case Voluntariado = "1";
    case Empleabilidad = "2";
    case Empleo = "3";
    case Formacion = "4";
    case Emprendimiento = "5";
    case Aprendizaje = "6";
    case Comunitario = "7";

    public function label()
    {
        return match ($this) {
            static::Voluntariado => 'Ficha de voluntariado',
            static::Empleabilidad => 'Práctica para empleabilidad',
            static::Empleo => 'Ficha de Empleo',
            static::Formacion => 'Ficha de Formación',
            static::Emprendimiento => 'Ficha de Emprendimiento',
            static::Aprendizaje => 'Aprendizaje de servicio',
            static::Comunitario => 'Servicio comunitario',
        };
    }

    public function icon()
    {
        return match ($this) {
            static::Voluntariado => 'icon.check',
            static::Empleabilidad => 'icon.clock',
            static::Empleo => 'icon.x-mark',
            static::Formacion => 'icon.arrow-uturn-left',
            static::Emprendimiento => 'icon.arrow-uturn-left',
            static::Aprendizaje => 'icon.arrow-uturn-left',
            static::Comunitario => 'icon.arrow-uturn-left',
        };
    }

    public function color()
    {
        return match ($this) {
            static::Voluntariado => 'green',
            static::Empleabilidad => 'teal',
            static::Empleo => 'fuchsia',
            static::Formacion => 'purple',
            static::Emprendimiento => 'amber',
            static::Aprendizaje => 'cyan',
            static::Comunitario => 'indigo',
        };
    }
}
