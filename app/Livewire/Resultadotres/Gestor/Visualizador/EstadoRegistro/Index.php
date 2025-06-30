<?php

namespace App\Livewire\Resultadotres\Gestor\Visualizador\EstadoRegistro;

use App\Models\EstadoRegistroAlianza;
use App\Models\EstadoRegistroApalancamiento;
use App\Models\EstadoRegistroCostShare;
use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Database\Eloquent\Model;

class Index extends Component
{
    public Model $model;

    #[On('refresh-estadoregistro')]
    public function render()
    {
        [$modeloRelacionado, $modelo_campo] = match (get_class($this->model)) {
            \App\Models\Alianza::class => [EstadoRegistroAlianza::class, 'alianza_id'],
            \App\Models\Apalancamiento::class => [EstadoRegistroApalancamiento::class, 'apalancamiento_id'],   
            \App\Models\CostShare::class => [EstadoRegistroCostShare::class, 'cost_share_id'],
            default => throw new \Exception('Modelo no soportado.'),
        };

        $estados = $modeloRelacionado::with([
            'estado_registro:id,nombre,color,icon',
            'coordinador:id,name,email'
            ])
            ->where($modelo_campo, $this->model->id)
            ->where('estado_registro_id', '!=', 1)
            ->orderBy('id', 'DESC')
            ->get();

        return view('livewire.resultadotres.gestor.visualizador.estado-registro.index', [
            'estados' => $estados,
        ]);
    }
}
