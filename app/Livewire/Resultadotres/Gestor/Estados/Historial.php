<?php
namespace App\Livewire\Resultadotres\Gestor\Estados;

use App\Models\EstadoRegistroAlianza;
use App\Models\EstadoRegistroApalancamiento;
use App\Models\EstadoRegistroCostShare;
use Livewire\Attributes\On;
use Livewire\Component;

class Historial extends Component
{
     public $openDrawer = false;

     public $estados;

    #[On('openEstadoHistorial')]
    public function mostrarEstadoHistorial($id, $model)
    {
        $this->openDrawer = true;

        [$modeloRelacionado, $modelo_campo] = match ($model) {
            'alianza'         => [EstadoRegistroAlianza::class, 'alianza_id'],
            'apalancamiento'  => [EstadoRegistroApalancamiento::class, 'apalancamiento_id'],
            'cost-share'      => [EstadoRegistroCostShare::class, 'cost_share_id'],
            default           => throw new \Exception("Tipo '{$model}' no soportado."),
        };

        
        $this->estados = $modeloRelacionado::with([
            'estado_registro:id,nombre,color,icon',
            'coordinador:id,name,email'
            ])
            ->where($modelo_campo, $id)
            ->where('estado_registro_id', '!=', 1)
            ->orderBy('id', 'DESC')
            ->get();
    }
}