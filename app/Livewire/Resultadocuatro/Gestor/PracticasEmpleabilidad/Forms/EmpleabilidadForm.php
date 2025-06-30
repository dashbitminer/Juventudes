<?php

namespace App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Forms;

use Livewire\Form;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\Directorio;
use App\Models\Participante;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\CohortePaisProyecto;
use App\Models\HabilidadesAdquirir;
use App\Models\ServiciosDesarrollar;
use App\Models\PracticaEmpleabilidad;

class EmpleabilidadForm extends Form
{

    public Pais $pais;

    public Proyecto $proyecto;

    public Participante $participante;

    public Directorio $directorio;

    public CohortePaisProyecto $cohortePaisProyecto;

    public PracticaEmpleabilidad $practica;

    public Cohorte $cohorte;

    public $directorioSelected;

    public $cambiar_organizacion;

    public $motivo_cambio;

    public $motivoCambioSelected;

    public $motivoCambioSelectedPivot;

    public $areaintervencion;

    public $tipoinstitucion;

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

    public $descripciones;
    public $otros_conocimientos;

    public $nombre_nueva_organizacion;
    public $primerRegistro;

    public function rules()
    {
        return [

            'departamentoSelected'           => ['required'],
            'ciudad_id'                      => ['required'],
            'cambiar_organizacion' => [
                Rule::requiredIf(function () {
                    return !$this->primerRegistro;
                }),
            ],
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
            'descripcion_otros_servicios_desarrollar' => [
                Rule::requiredIf(function () {
                    return in_array(ServiciosDesarrollar::OTROS_SERVICIOS, $this->serviciosDesarrollarSelectedBase);
                }),
            ],

            'motivoCambioSelected' => [
                Rule::requiredIf(function () {
                    return !$this->primerRegistro && $this->cambiar_organizacion == 1;
                }),
            ],
           // 'motivoCambioSelected'           => ['required_if:cambiar_organizacion,1'],
            'serviciosDesarrollarSelected'   => ['required'],
            'programa_proyecto'              => ['required'],
            'motivo_cambio'                  => ['required_if:motivoCambioSelected,' . \App\Models\MotivosCambioOrganizacion::MOTIVO_OTRO],
        ];
    }


    public function init($pais, $proyecto, $participante, $cohorte, $cohortePaisProyecto, $primerRegistro)
    {
        $this->pais = $pais;
        $this->proyecto = $proyecto;
        $this->participante = $participante;
        $this->cohorte = $cohorte;
        $this->cohortePaisProyecto = $cohortePaisProyecto;
        $this->primerRegistro = $primerRegistro;
    }

    public function setDepartamento($departamento) : void {
        $this->departamentoSelected = $departamento;
    }

    public function setPractica($practica)
    {
        $this->practica = $practica->load([
            "paisServicioDesarrollar",
            "paisHabilidadesAdquirir",
            "paisMotivoCambioOrganizacion:id,motivo_cambio_organizacion_id",
            "directorio:id,tipo_institucion_id,area_intervencion_id,nombre",
            "directorio.tipoInstitucion:id,nombre",
            "directorio.areaIntervencion:id,nombre",
        ]);

        $this->cambiar_organizacion = $practica->cambiar_organizacion;
        //$this->nombre_nueva_organizacion = $practica->nombre_nueva_organizacion;
        //$this->cohorte_id = $practica->cohorte_id;

        $this->motivoCambioSelectedPivot = $practica->pais_motivo_cambio_organizacion_id;

        if ($practica->paisMotivoCambioOrganizacion()->count()) {
            $this->motivoCambioSelected = $practica->paisMotivoCambioOrganizacion->motivo_cambio_organizacion_id;
        }


        $this->motivo_cambio = $practica->motivo_cambio;
        $this->directorioSelected = $practica->directorio_id;
        $this->tipoinstitucion = $practica->directorio->tipoInstitucion->nombre;
        $this->areaintervencion = $practica->directorio->areaIntervencion->nombre;

        $this->programa_proyecto = $practica->programa_proyecto;
        $this->ciudad_id = $practica->ciudad_id;
        $this->comunidad = $practica->comunidad;

        $this->fecha_inicio_prevista = $practica->fecha_inicio_prevista->toDateString();
        $this->fecha_fin_prevista = $practica->fecha_fin_prevista->toDateString();

        $this->otros_conocimientos = $practica->otros_conocimientos;
        $this->descripciones = $practica->descripciones;

        $this->serviciosDesarrollarSelected = $practica->paisServicioDesarrollar->pluck('id')->toArray();
        $this->serviciosDesarrollarSelectedBase = $practica->paisServicioDesarrollar->pluck('servicio_desarrollar_id')->toArray();

        $this->habilidadSelected = $practica->paisHabilidadesAdquirir->pluck('id')->toArray();
        $this->habilidadSelectedBase = $practica->paisHabilidadesAdquirir->pluck('habilidad_adquirir_id')->toArray();

        if (in_array(HabilidadesAdquirir::OTRAS_HABILIDADES, $this->habilidadSelectedBase)) {
            $this->descripcion_habilidad_adquirir = $practica->paisHabilidadesAdquirir->where('habilidad_adquirir_id', HabilidadesAdquirir::OTRAS_HABILIDADES)->first()->pivot->descripcion_otras_habilidades;
        }

        if (in_array(ServiciosDesarrollar::OTROS_SERVICIOS, $this->serviciosDesarrollarSelectedBase)) {
            $this->descripcion_otros_servicios_desarrollar = $practica->paisServicioDesarrollar->where('servicio_desarrollar_id', ServiciosDesarrollar::OTROS_SERVICIOS)->first()->pivot->descripcion_otros_servicios_desarrollar;
        }

    }


    public function save(?PracticaEmpleabilidad $practica = null)
    {
       // $this->validate();

        if ($practica) {
            $this->practica = $practica;
        }

        DB::transaction(function () {

            $this->validate();

            $cohorteParticipanteProyecto = \App\Models\CohorteParticipanteProyecto::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->where('participante_id', $this->participante->id)
                ->first();

            $this->practica->cambiar_organizacion = $this->cambiar_organizacion ?? 0;
           // $this->practica->nombre_nueva_organizacion = $this->nombre_nueva_organizacion;
            $this->practica->pais_motivo_cambio_organizacion_id = $this->motivoCambioSelectedPivot;
            $this->practica->motivo_cambio = $this->motivo_cambio;
            //$this->practica->participante_id = $this->participante->id;
            //$this->practica->cohorte_id = $this->cohorte->id;
            //$this->practica->pais_id = $this->pais->id;
            $this->practica->directorio_id = $this->directorioSelected;
            $this->practica->programa_proyecto = $this->programa_proyecto;
            $this->practica->ciudad_id = $this->ciudad_id;
            $this->practica->comunidad = $this->comunidad;
            $this->practica->fecha_inicio_prevista = $this->fecha_inicio_prevista;
            $this->practica->fecha_fin_prevista = $this->fecha_fin_prevista;
            $this->practica->otros_conocimientos = $this->otros_conocimientos;
            $this->practica->descripciones = $this->descripciones;
            $this->practica->cohorte_participante_proyecto_id = $cohorteParticipanteProyecto->id;
            $this->practica->active_at = now();
            $this->practica->save();

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
            $this->practica->paisServicioDesarrollar()->sync($data);

            $data = [];
            foreach ($this->habilidadSelected as $key => $habilidadId) {
                $data[$habilidadId] = [];
                $data[$habilidadId]['active_at'] = now();
                if (isset($this->habilidadSelectedBase[$key]) && $this->habilidadSelectedBase[$key] == \App\Models\HabilidadesAdquirir::OTRAS_HABILIDADES) {
                    $data[$habilidadId]['descripcion_otras_habilidades'] = $this->descripcion_habilidad_adquirir;
                }
            }

            // Sync the data with the pivot table
            $this->practica->paisHabilidadesAdquirir()->sync($data);

        });
    }

    function setDirectorio($id): void
    {
        $this->directorio = Directorio::with([
            "tipoInstitucion:id,nombre",
            "areaIntervencion:id,nombre"
        ])->find($id);

        $this->tipoinstitucion = $this->directorio->tipoInstitucion->nombre;
        $this->areaintervencion = $this->directorio->areaIntervencion->nombre;
    }
}
