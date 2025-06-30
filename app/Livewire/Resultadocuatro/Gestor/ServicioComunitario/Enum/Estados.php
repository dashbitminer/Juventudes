<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum;

enum Estados:int
{
    case EnTiempo = 1;
    case Atrasado = 2;
    case Observado = 3;
    case Completado = 4;

    public function label(){
        return match ($this) {
            static::EnTiempo => "En Tiempo",
            static::Atrasado => "Atrasado",
            static::Observado => "Observado",
            static::Completado => "Completado",
        };
    }

    public function color()
    {
        return match ($this) {
            static::Completado => 'green',
            static::Observado => 'gray',
            static::Atrasado => 'red',
            static::EnTiempo => 'purple',
        };
    }
    public function icon()
    {
        return match ($this) {
            static::Completado => 'icon.check',
            static::Observado => 'icon.arrow-uturn-left',
            static::Atrasado => 'icon.pencil-square',
            static::EnTiempo => 'icon.clock',
        };
    }

    public static function getInfo($estado): array
    {
        return match ($estado) {
            static::EnTiempo->value => [
                'label' => static::EnTiempo->label(),
                'color' => static::EnTiempo->color(),
                'icon' => static::EnTiempo->icon(),
            ],
            static::Atrasado->value => [
                'label' => static::Atrasado->label(),
                'color' => static::Atrasado->color(),
                'icon' => static::Atrasado->icon(),
            ],
            static::Observado->value => [
                'label' => static::Observado->label(),
                'color' => static::Observado->color(),
                'icon' => static::Observado->icon(),
            ],
            static::Completado->value => [
                'label' => static::Completado->label(),
                'color' => static::Completado->color(),
                'icon' => static::Completado->icon(),
            ],
            default => [
                'label' => 'Desconocido',
                'color' => 'gray',
                'icon' => 'icon.question',
            ],
        };
    }
}





