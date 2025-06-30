<?php

namespace App\Livewire\Resultadotres\Gestor\Visualizador\Forms;

use App\Livewire\Resultadotres\Gestor\Visualizador\Enums\Formularios;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\EstadoRegistro;
use App\Models\EstadoRegistroAlianza;
use App\Models\EstadoRegistroApalancamiento;
use App\Models\EstadoRegistroCostShare;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Component
{

    #[Validate('required', message: 'El campo estado es requerido')]
    public $estadoId;

    public $comentario;

    public $enableForm = false;

    public $showSuccessIndicator = false;

    public Model $model;

    public $modeloRelacionado;

    public $modelo_campo;

    public function mount()
    {
        [$this->modeloRelacionado, $this->modelo_campo] = match (get_class($this->model)) {
            \App\Models\Alianza::class => [EstadoRegistroAlianza::class, 'alianza_id'],
            \App\Models\Apalancamiento::class => [EstadoRegistroApalancamiento::class, 'apalancamiento_id'],   
            \App\Models\CostShare::class => [EstadoRegistroCostShare::class, 'cost_share_id'],
            default => throw new \Exception('Modelo no soportado.'),
        };

        $ultimoEstado = $this->model->lastEstado->estado_registro->slug;
        
        //$this->enableForm = $ultimoEstado === 'validado';
    }

    public function render()
    {
        $estados = EstadoRegistro::whereNotIn('id', [EstadoRegistro::PENDIENTE_REVISION, EstadoRegistro::DOCUMENTACION_PENDIENTE])
            ->pluck('nombre', 'id');

        return view('livewire.resultadotres.gestor.visualizador.forms.comentario', [
            'estados' => $estados,
        ]);
    }

    public function save()
    {
        $this->validateOnly('estadoId');

        $created = [
            $this->modelo_campo => $this->model->id,
            'estado_registro_id' => $this->estadoId,
            'created_by' => auth()->user()->id, 
        ];

        if (!empty($this->comentario)) {
            $created['comentario'] = $this->comentario;
        }

        $this->modeloRelacionado::create($created);

        $ultimoEstado = $this->model->lastEstado->estado_registro->slug;
        $this->enableForm = $ultimoEstado === 'validado';


        $this->reset('estadoId', 'comentario');
        $this->showSuccessIndicator = true;
        $this->dispatch('refresh-estadoregistro');
    }

}
