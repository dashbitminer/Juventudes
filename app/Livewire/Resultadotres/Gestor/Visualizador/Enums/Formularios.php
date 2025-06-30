<?php

namespace App\Livewire\Resultadotres\Gestor\Visualizador\Enums;

enum Formularios: string
{
    case Alianzas = '1';
    case Apalancamiento = '2';
    case CostoCompartido = '3';

    public function label(): string
    {
        return match($this) {
            self::Alianzas => 'Alianzas',
            self::Apalancamiento => 'Apalancamiento',
            self::CostoCompartido => 'Costo Compartido',
        };
    }
}