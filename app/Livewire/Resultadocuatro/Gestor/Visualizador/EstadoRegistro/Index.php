<?php

namespace App\Livewire\Resultadocuatro\Gestor\Visualizador\EstadoRegistro;

use App\Models\EstadoRegistroAlianza;
use App\Models\EstadoRegistroApalancamiento;
use App\Models\EstadoRegistroAprendizajeServicio;
use App\Models\EstadoRegistroCostShare;
use App\Models\EstadoRegistroFichaEmpleo;
use App\Models\EstadoRegistroFichaEmprendimiento;
use App\Models\EstadoRegistroFichaFormacion;
use App\Models\EstadoRegistroFichaVoluntariado;
use App\Models\EstadoRegistroPracticaEmpleabilidad;
use App\Models\ServicioComunitarioHistorico;
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
            \App\Models\FichaVoluntario::class => [EstadoRegistroFichaVoluntariado::class, 'ficha_voluntario_id'],
            \App\Models\AprendizajeServicio::class => [EstadoRegistroAprendizajeServicio::class, 'aprendizaje_servicio_id'],
            \App\Models\FichaEmpleo::class => [EstadoRegistroFichaEmpleo::class, 'ficha_empleo_id'],
            \App\Models\FichaEmprendimiento::class => [EstadoRegistroFichaEmprendimiento::class, 'ficha_emprendimiento_id'],
            \App\Models\FichaFormacion::class => [EstadoRegistroFichaFormacion::class, 'ficha_formacion_id'],
            \App\Models\PracticaEmpleabilidad::class => [EstadoRegistroPracticaEmpleabilidad::class, 'practica_empleabilidad_id'],
            \App\Models\ServicioComunitario::class => [ServicioComunitarioHistorico::class, 'servicio_comunitario_id'],
            default => throw new \Exception('Modelo no soportado.'),
        };

        $vistaEstado = 'index';

        if($modeloRelacionado == ServicioComunitarioHistorico::class){
            $vistaEstado = 'sc-index';

            $estados = $modeloRelacionado::with([
                    'creador:id,name,email'
                ])
                ->where('servicio_comunitario_id', $this->model->id)
                ->orderBy('id', 'DESC')
                ->get();
        }else{
            $estados = $modeloRelacionado::with([
                'estado_registro:id,nombre,color,icon',
                'coordinador:id,name,email'
                ])
                ->where($modelo_campo, $this->model->id)
                ->where('estado_registro_id', '!=', 1)
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('livewire.resultadocuatro.gestor.visualizador.estado-registro.'. $vistaEstado, [
            'estados' => $estados,
        ]);
    }
}
