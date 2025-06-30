<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum;

enum TipoPoblacion:int
{
    case Directa = 1;
    case Indirecta = 0;
    case DirectaIndirecta = 2;

    public function label(){
        return match ($this) {
            static::Directa => "Directa",
            static::Indirecta => "Indirecta",
            static::DirectaIndirecta => "Directa e Indirecta"
        };
    }
}