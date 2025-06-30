<?php

namespace App\Livewire\Resultadocuatro\Gestor\AprendizajeServicio\Forms;

use Livewire\Form;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\Directorio;
use App\Models\TipoEstudio;
use App\Models\Participante;
use App\Models\AreaFormacion;
use Livewire\WithFileUploads;
use App\Models\FichaFormacion;
use App\Models\FichaVoluntario;
use App\Models\VinculadoDebido;
use Illuminate\Validation\Rule;
use App\Models\AreaIntervencion;
use Illuminate\Support\Facades\DB;
use App\Models\AprendizajeServicio;
use App\Models\HabilidadesAdquirir;
use App\Models\ServiciosDesarrollar;
use Illuminate\Validation\Rules\File;

class AprendizajeForm extends Form
{

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;

    public Directorio $directorio;

    public AprendizajeServicio $aprendizajeServicio;

    public $minDate;

    public $maxDate;

    public $directorioSelected;

    public $tipoinstitucion;

    public $areaintervencion;

    public $otros_conocimientos;

    public $titulo_contribucion_cambio;

    public $objetivo_contribucion_cambio;

    public $acciones_contribucion_cambio;

    public $otros_comentarios;

    public $departamentoSelected;

    public $ciudad_id;

    public $cohorte_id;

    public $comunidad;

    public $fecha_inicio_prevista;

    public $fecha_fin_prevista;

    public $programa_proyecto;

    public $serviciosDesarrollarSelected = [];
    public $serviciosDesarrollarSelectedBase = [];
    public $descripcion_otros_servicios_desarrollar;

    public $habilidadSelected = [];
    public $habilidadSelectedBase = [];
    public $descripcion_habilidad_adquirir;
    public $habilidadSelectedPivot;

    public $fecha_fin_cambio;

    public $fecha_inicio_cambio;

    public $primerRegistro;
    public $cambiar_organizacion;
    public $motivoCambioSelected;
    public $motivoCambioSelectedPivot;
    public $motivo_cambio;

    public $inclusionSocialTema = [];

    public $medioambienteTema = [];

    public $culturaTema = [];

    public $temasSelected = [];

    public $promedio_aprendizaje;


    public function rules()
    {
        return [

            'departamentoSelected'           => ['required'],
            'cambiar_organizacion' => [
                Rule::requiredIf(function () {
                    return !$this->primerRegistro;
                }),
            ],
            'motivoCambioSelected' => [
                Rule::requiredIf(function () {
                    return !$this->primerRegistro && $this->cambiar_organizacion == 1;
                }),
            ],
            'promedio_aprendizaje'           => ['required'],
            'ciudad_id'                      => ['required'],
            'directorioSelected'             => ['required'],
            'comunidad'                      => ['required'],
            'fecha_inicio_prevista'          => ['required', 'date'],
            'fecha_fin_prevista'             => ['required', 'date', 'after:fecha_inicio_prevista'],
            'habilidadSelected'              => ['required'],
            'descripcion_habilidad_adquirir' => [
                Rule::requiredIf(function () {
                    return in_array(HabilidadesAdquirir::OTRAS_HABILIDADES, $this->habilidadSelectedBase);
                })
            ],
            'temasSelected' => [
                function ($attribute, $value, $fail) {
                    if (count($this->inclusionSocialTema) == 0
                        && count($this->medioambienteTema) == 0
                        && count($this->culturaTema) == 0) {
                        return $fail('Por favor seleccione al menos un tema');
                    }
                }

            ],
            'descripcion_otros_servicios_desarrollar' => [
                Rule::requiredIf(function () {
                    return in_array(ServiciosDesarrollar::OTROS_SERVICIOS, $this->serviciosDesarrollarSelectedBase);
                }),
            ],
            // 'otros_conocimientos'            => ['required'],
            'serviciosDesarrollarSelected'   => ['required'],
            'programa_proyecto'              => ['required'],
            //'titulo_contribucion_cambio'     => ['required'],
            //'objetivo_contribucion_cambio'   => ['required'],
            'acciones_contribucion_cambio'   => ['required'],
            'fecha_inicio_cambio'            => ['required', 'date'],
            'fecha_fin_cambio'               => ['required', 'date', 'after:fecha_inicio_cambio'],
        ];
    }

    public function messages()
    {
        return [
            'departamentoSelected.required' => 'El departamento es obligatorio.',
            'cambiar_organizacion.required' => 'Debe indicar si cambia de organización.',
            'motivoCambioSelected.required' => 'Debe seleccionar un motivo de cambio de organización.',
            'promedio_aprendizaje.required' => 'El promedio de aprendizaje es obligatorio.',
            'ciudad_id.required' => 'La ciudad es obligatoria.',
            'directorioSelected.required' => 'El directorio es obligatorio.',
            'comunidad.required' => 'La comunidad es obligatoria.',
            'fecha_inicio_prevista.required' => 'La fecha de inicio prevista es obligatoria.',
            'fecha_inicio_prevista.date' => 'La fecha de inicio prevista debe ser una fecha válida.',
            'fecha_fin_prevista.required' => 'La fecha de fin prevista es obligatoria.',
            'fecha_fin_prevista.date' => 'La fecha de fin prevista debe ser una fecha válida.',
            'fecha_fin_prevista.after' => 'La fecha de fin prevista debe ser posterior a la fecha de inicio prevista.',
            'habilidadSelected.required' => 'Debe seleccionar al menos una habilidad.',
            'descripcion_habilidad_adquirir.required' => 'Debe proporcionar una descripción para las otras habilidades.',
            'temasSelected.required' => 'Debe seleccionar al menos un tema.',
            'descripcion_otros_servicios_desarrollar.required' => 'Debe proporcionar una descripción para los otros servicios a desarrollar.',
            'serviciosDesarrollarSelected.required' => 'Debe seleccionar al menos un servicio a desarrollar.',
            'programa_proyecto.required' => 'El programa del proyecto es obligatorio.',
            'acciones_contribucion_cambio.required' => 'Las acciones de contribución al cambio son obligatorias.',
            'fecha_inicio_cambio.required' => 'La fecha de inicio del cambio es obligatoria.',
            'fecha_inicio_cambio.date' => 'La fecha de inicio del cambio debe ser una fecha válida.',
            'fecha_fin_cambio.required' => 'La fecha de fin del cambio es obligatoria.',
            'fecha_fin_cambio.date' => 'La fecha de fin del cambio debe ser una fecha válida.',
            'fecha_fin_cambio.after' => 'La fecha de fin del cambio debe ser posterior a la fecha de inicio del cambio.',
        ];
    }



    public function init($pais, $proyecto, $participante, $cohorte, $primerRegistro)
    {
        $this->pais = $pais;
        $this->proyecto = $proyecto;
        $this->participante = $participante;
        $this->cohorte = $cohorte;
        $this->primerRegistro = $primerRegistro;

        $this->minDate = $this->cohorte->fecha_inicio;
        $this->maxDate = $this->cohorte->fecha_fin;
    }

    function setDirectorio($id): void
    {
        $this->directorio = Directorio::with([
            "tipoInstitucion:id,nombre",
            "areaIntervencion:id,nombre"
        ])->find($id);

        $this->tipoinstitucion = $this->directorio->tipoInstitucion->nombre ?? '';

        $this->areaintervencion = $this->directorio->areaIntervencion->nombre ?? '';

    }

    public function setAprendizajeServicio($aprendizajeServicio)
    {
        $this->aprendizajeServicio = $aprendizajeServicio->load([
            "paisServicioDesarrollar",
            "paisHabilidadesAdquirir",
            "directorio:id,tipo_institucion_id,area_intervencion_id,nombre",
            "directorio.tipoInstitucion:id,nombre",
            "directorio.areaIntervencion:id,nombre",
        ]);


        $this->cohorte_id = $aprendizajeServicio->cohorte_id;

        $this->cambiar_organizacion = $aprendizajeServicio->cambiar_organizacion;

        $this->motivoCambioSelectedPivot = $aprendizajeServicio->pais_motivo_cambio_organizacion_id;

        if ($aprendizajeServicio->paisMotivoCambioOrganizacion()->count()) {
            $this->motivoCambioSelected = $aprendizajeServicio->paisMotivoCambioOrganizacion->motivo_cambio_organizacion_id;
        }


        $this->motivo_cambio = $aprendizajeServicio->motivo_cambio;

//dd($this->aprendizajeServicio);

        $this->directorioSelected = $aprendizajeServicio->directorio_id;
        $this->tipoinstitucion = $aprendizajeServicio->directorio->tipoInstitucion->nombre ?? NULL;
        $this->areaintervencion = $aprendizajeServicio->directorio->areaIntervencion->nombre ?? NULL;
        $this->programa_proyecto = $aprendizajeServicio->programa_proyecto;
        $this->ciudad_id = $aprendizajeServicio->ciudad_id;
        $this->comunidad = $aprendizajeServicio->comunidad;
        $this->fecha_inicio_prevista = $aprendizajeServicio->fecha_inicio_prevista ? $aprendizajeServicio->fecha_inicio_prevista->toDateString() : null;
        $this->fecha_fin_prevista = $aprendizajeServicio->fecha_fin_prevista ? $aprendizajeServicio->fecha_fin_prevista->toDateString() : null;
        $this->otros_conocimientos = $aprendizajeServicio->otros_conocimientos;
        $this->fecha_inicio_cambio = $aprendizajeServicio->fecha_inicio_cambio ? $aprendizajeServicio->fecha_inicio_cambio->toDateString() : null;
        $this->fecha_fin_cambio = $aprendizajeServicio->fecha_fin_cambio ? $aprendizajeServicio->fecha_fin_cambio->toDateString() : null;
        $this->acciones_contribucion_cambio = $aprendizajeServicio->acciones_contribucion_cambio;
        $this->objetivo_contribucion_cambio = $aprendizajeServicio->objetivo_contribucion_cambio;
        $this->titulo_contribucion_cambio = $aprendizajeServicio->titulo_contribucion_cambio;
        $this->otros_comentarios = $aprendizajeServicio->otros_comentarios;

        $this->serviciosDesarrollarSelected = $aprendizajeServicio->paisServicioDesarrollar->pluck('id')->toArray();
        $this->serviciosDesarrollarSelectedBase = $aprendizajeServicio->paisServicioDesarrollar->pluck('servicio_desarrollar_id')->toArray();

        $this->habilidadSelected = $aprendizajeServicio->paisHabilidadesAdquirir->pluck('id')->toArray();
        $this->habilidadSelectedBase = $aprendizajeServicio->paisHabilidadesAdquirir->pluck('habilidad_adquirir_id')->toArray();

        if (in_array(HabilidadesAdquirir::OTRAS_HABILIDADES, $this->habilidadSelectedBase)) {
            $this->descripcion_habilidad_adquirir = $aprendizajeServicio->paisHabilidadesAdquirir->where('habilidad_adquirir_id', HabilidadesAdquirir::OTRAS_HABILIDADES)->first()->pivot->descripcion_otras_habilidades;
        }

        if (in_array(ServiciosDesarrollar::OTROS_SERVICIOS, $this->serviciosDesarrollarSelectedBase)) {
            $this->descripcion_otros_servicios_desarrollar = $aprendizajeServicio->paisServicioDesarrollar->where('servicio_desarrollar_id', ServiciosDesarrollar::OTROS_SERVICIOS)->first()->pivot->descripcion_otros_servicios_desarrollar;
        }


        $this->inclusionSocialTema =  $aprendizajeServicio->inclusionSocialTema
            ->pluck('id')
            ->toArray();

        $this->medioambienteTema =  $aprendizajeServicio->medioambienteTema
            ->pluck('id')
            ->toArray();

        $this->culturaTema =  $aprendizajeServicio->culturaTema
            ->pluck('id')
            ->toArray();

        $this->promedio_aprendizaje = $aprendizajeServicio->promedio_aprendizaje;

    }

    public function setDepartamento($departamento) : void {
        $this->departamentoSelected = $departamento;
    }

    public function save(?AprendizajeServicio $aprendizajeServicio = null)
    {
        if ($aprendizajeServicio) {
            $this->aprendizajeServicio = $aprendizajeServicio;
        }

        DB::transaction(function () {

            $this->validate();

            $cohorte_participante_proyecto_id = $this->participante
                ->cohortePaisProyecto()
                ->pluck('cohorte_participante_proyecto.id')
                ->first();

            $this->aprendizajeServicio->promedio_aprendizaje = $this->promedio_aprendizaje;

            $this->aprendizajeServicio->cohorte_participante_proyecto_id = $cohorte_participante_proyecto_id;
            // $this->aprendizajeServicio->participante_id = $this->participante->id;
            // $this->aprendizajeServicio->proyecto_id = $this->proyecto->id;

            $this->aprendizajeServicio->cambiar_organizacion = $this->cambiar_organizacion ?? 0;
            // $this->practica->nombre_nueva_organizacion = $this->nombre_nueva_organizacion;
            $this->aprendizajeServicio->pais_motivo_cambio_organizacion_id = $this->motivoCambioSelectedPivot;
            //$this->aprendizajeServicio->motivo_cambio = $this->motivo_cambio;

            $this->aprendizajeServicio->directorio_id = $this->directorioSelected;
            $this->aprendizajeServicio->programa_proyecto = $this->programa_proyecto;
            $this->aprendizajeServicio->ciudad_id = $this->ciudad_id;
            $this->aprendizajeServicio->comunidad = $this->comunidad;
            $this->aprendizajeServicio->fecha_inicio_prevista = $this->fecha_inicio_prevista;
            $this->aprendizajeServicio->fecha_fin_prevista = $this->fecha_fin_prevista;
            $this->aprendizajeServicio->otros_conocimientos = $this->otros_conocimientos;

            $this->aprendizajeServicio->titulo_contribucion_cambio = $this->titulo_contribucion_cambio;

            $this->aprendizajeServicio->objetivo_contribucion_cambio = $this->objetivo_contribucion_cambio;

            $this->aprendizajeServicio->acciones_contribucion_cambio = $this->acciones_contribucion_cambio;

            $this->aprendizajeServicio->fecha_inicio_cambio = $this->fecha_inicio_cambio;

            $this->aprendizajeServicio->fecha_fin_cambio = $this->fecha_fin_cambio;

            $this->aprendizajeServicio->otros_comentarios = $this->otros_comentarios;

            // $this->aprendizajeServicio->cohorte_id = $this->cohorte->id;
            // $this->aprendizajeServicio->pais_id = $this->pais->id;
            $this->aprendizajeServicio->active_at = now();
            $this->aprendizajeServicio->save();

            // Prepare data for syncing with the pivot table
            $data = [];
            foreach ($this->serviciosDesarrollarSelected as $key => $servicioId) {
                $data[$servicioId] = [];
                $data[$servicioId]['active_at'] = now();
                if (isset($this->serviciosDesarrollarSelectedBase[$key]) && $this->serviciosDesarrollarSelectedBase[$key] == \App\Models\ServiciosDesarrollar::OTROS_SERVICIOS) {
                    $data[$servicioId]['descripcion_otros_servicios_desarrollar'] = $this->descripcion_otros_servicios_desarrollar;
                }
            }

            // Sync the data with the pivot table
            $this->aprendizajeServicio->paisServicioDesarrollar()->sync($data);

            $data = [];
            foreach ($this->habilidadSelected as $key => $habilidadId) {
                $data[$habilidadId] = [];
                $data[$habilidadId]['active_at'] = now();
                if (isset($this->habilidadSelectedBase[$key]) && $this->habilidadSelectedBase[$key] == \App\Models\HabilidadesAdquirir::OTRAS_HABILIDADES) {
                    $data[$habilidadId]['descripcion_otras_habilidades'] = $this->descripcion_habilidad_adquirir;
                }
            }

            // Sync the data with the pivot table
            $this->aprendizajeServicio->paisHabilidadesAdquirir()->sync($data);

            $this->aprendizajeServicio->inclusionSocialTema()->detach();
            $this->aprendizajeServicio->inclusionSocialTema()->sync($this->inclusionSocialTema);

            $this->aprendizajeServicio->medioambienteTema()->detach();
            $this->aprendizajeServicio->medioambienteTema()->sync($this->medioambienteTema);

            $this->aprendizajeServicio->culturaTema()->detach();
            $this->aprendizajeServicio->culturaTema()->sync($this->culturaTema);

        });

    }
}
