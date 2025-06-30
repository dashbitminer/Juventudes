<?php

namespace App\Livewire\Resultadocuatro\Gestor\Visualizador\Forms;

use App\Livewire\Resultadotres\Gestor\Visualizador\Enums\Formularios;
use App\Models\EstadoRegistroAprendizajeServicio;
use App\Models\EstadoRegistroFichaEmpleo;
use App\Models\EstadoRegistroFichaEmprendimiento;
use App\Models\EstadoRegistroFichaFormacion;
use App\Models\EstadoRegistroFichaVoluntariado;
use App\Models\EstadoRegistroPracticaEmpleabilidad;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\ServicioComunitarioHistorico;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\EstadoRegistro;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados as ServicioComunitarioEstados;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    #[Validate('required', message: 'El campo estado es requerido')]
    public $estadoId;

    public $comentario;
    public $enableForm = false;

    public $showSuccessIndicator = false;

    public Model $model;

    public $modeloRelacionado;

    public $modelo_campo;

    public function mount(Pais $pais, Proyecto $proyecto)
    {
        $this->pais = $pais;
        $this->proyecto = $proyecto;

        [$this->modeloRelacionado, $this->modelo_campo] = match (get_class($this->model)) {
            \App\Models\FichaVoluntario::class => [EstadoRegistroFichaVoluntariado::class, 'ficha_voluntario_id'],
            \App\Models\AprendizajeServicio::class => [EstadoRegistroAprendizajeServicio::class, 'aprendizaje_servicio_id'],
            \App\Models\FichaEmpleo::class => [EstadoRegistroFichaEmpleo::class, 'ficha_empleo_id'],
            \App\Models\FichaEmprendimiento::class => [EstadoRegistroFichaEmprendimiento::class, 'ficha_emprendimiento_id'],
            \App\Models\FichaFormacion::class => [EstadoRegistroFichaFormacion::class, 'ficha_formacion_id'],
            \App\Models\PracticaEmpleabilidad::class => [EstadoRegistroPracticaEmpleabilidad::class, 'practica_empleabilidad_id'],
            \App\Models\ServicioComunitario::class => [ServicioComunitarioHistorico::class, 'servicio_comunitario_id'],
            default => throw new \Exception('Modelo no soportado.'),
        };

    }

    public function render()
    {
        if($this->modeloRelacionado == ServicioComunitarioHistorico::class){
            $estados = collect(ServicioComunitarioEstados::cases())->map(function ($estado) {
                return [
                    'id' => $estado->value,
                    'nombre' => $estado->label(),
                ];
            })->pluck('nombre', 'id');
        }else{
            $estados = EstadoRegistro::whereNotIn('id', [EstadoRegistro::PENDIENTE_REVISION, EstadoRegistro::DOCUMENTACION_PENDIENTE])
                ->pluck('nombre', 'id');
        }

        return view('livewire.resultadocuatro.gestor.visualizador.forms.comentario', [
            'estados' => $estados,
        ]);
    }

    public function save()
    {
        $this->validateOnly('estadoId');

        if($this->modeloRelacionado == ServicioComunitarioHistorico::class){
            $created = [
                $this->modelo_campo => $this->model->id,
                'estado' => $this->estadoId,
                'created_by' => auth()->user()->id,
            ];
        }else{
            $created = [
                $this->modelo_campo => $this->model->id,
                'estado_registro_id' => $this->estadoId,
                'created_by' => auth()->user()->id,
            ];
        }
        if (!empty($this->comentario)) {
            $created['comentario'] = $this->comentario;
        }

        $this->modeloRelacionado::create($created);


        $this->reset('estadoId', 'comentario');
        $this->showSuccessIndicator = true;
        $this->dispatch('refresh-estadoregistro');

        return redirect()->route('visualizador.resultadocuatro.index', [
            'pais' => $this->pais,
            'proyecto' => $this->proyecto
        ]);
    }

}
