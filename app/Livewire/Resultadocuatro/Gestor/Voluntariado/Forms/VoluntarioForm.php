<?php

namespace App\Livewire\Resultadocuatro\Gestor\Voluntariado\Forms;

use Livewire\Form;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Participante;
use Livewire\WithFileUploads;
use App\Models\FichaVoluntario;
use App\Models\VinculadoDebido;
use Illuminate\Validation\Rule;
use App\Models\AreaIntervencion;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\Directorio;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class VoluntarioForm extends Form
{

    use WithFileUploads;

    public Pais $pais;

    public Proyecto $proyecto;

    public Participante $participante;

    public FichaVoluntario $voluntario;

    public Directorio $directorio;

    public Cohorte $cohorte;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $minDate;

    public $maxDate;

    public $medioVidaSelected;

    public $medioVidaSelectedPivot;

    public $directorioSelected;

    public $tipoinstitucionnombre;

    public $tipoinsitucionid;

    public $tipoinsitucionotro;

    public $directorioSelectedPivot;

    public $vinculadoDebidoSelected;

    public $vinculadoDebidoSelectedPivot;

    public $vinculadoDebidoOtro;

    public $fecha_inicio_voluntariado;


    public $areaIntervencionSelected;
    public $areaIntervencionSelectedPivot;
    public $areaIntervencionNombre;
    public $otraAreaIntervencion;

    // $this->areaIntervencionSelected = $this->directorio->area_intervencion_id;
    // $this->areaIntervencionNombre = $this->directorio->areaIntervencion->nombre;
    // $this->otraAreaIntervencion = $this->directorio->area_intervencion_otros;




    public $promedio_horas;

    public $serviciosDesarrollarSelected = [];

    public $medioVerificacionSelected;

    public $medioVerificacionSelectedPivot;

    public $file_documento_medio_verificacion_upload;

    public $informacionAdicionalJoven;

    public $temp_file;

    public $mode;

    public $showValidationErrorIndicator = false;
    public $showSuccessIndicator = false;
    public $showCoberturaWarning = false;

    public $servicio_otro;





    public function boot()
    {
        $this->withValidator(function ($validator) {

            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    public function rules()
    {
        return [
            'medioVidaSelected' => [
                'required'
            ],
            'directorioSelected' => [
                'required'
            ],
            'vinculadoDebidoSelected' => [
                'required'
            ],
            'vinculadoDebidoOtro' => [
                'required_if:vinculadoDebidoSelected,' . VinculadoDebido::OTRO
            ],
            'fecha_inicio_voluntariado' => [
                'required', 'date'
            ],
            'areaIntervencionSelected' => [
                'required'
            ],
            'otraAreaIntervencion' => [
                'required_if:areaIntervencionSelected,' . AreaIntervencion::OTRA
            ],
            'promedio_horas' => [
                'required', 'numeric'
            ],
            'serviciosDesarrollarSelected' => [
                'required'
            ],
            'medioVerificacionSelected' => [
                'required'
            ],
            'file_documento_medio_verificacion_upload' => [
                Rule::when($this->mode != 'edit', [
                    'required',
                    File::types(['pdf','jpeg', 'png', 'gif', 'jpg', 'svg'])
                        ->min('1kb')
                        ->max('2mb'),
                ]),
            ],
            'servicio_otro' => Rule::requiredIf(
                $this->pais->serviciosDesarrollar()
                    ->whereIn('pais_servicio_desarrollar.id', $this->serviciosDesarrollarSelected)
                    ->where('servicios_desarrollar.slug', 'otros-servicios')
                    ->count()
            ),
        ];
    }


    public function init($pais, $proyecto, $participante, $cohorte, $cohortePaisProyecto)
    {
        $this->pais = $pais;
        $this->proyecto = $proyecto;
        $this->participante = $participante;
        $this->cohorte = $cohorte;
        $this->cohortePaisProyecto = $cohortePaisProyecto;

        $this->minDate = $this->cohorte->fecha_inicio;
        $this->maxDate = $this->cohorte->fecha_fin;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function setDirectorio($directorio)
    {
        $this->directorio = Directorio::find($directorio);
        $this->directorio->load('tipoInstitucion:id,nombre');

        $this->tipoinstitucionnombre = $this->directorio->tipoInstitucion->nombre ?? null;
        $this->tipoinsitucionid = $this->directorio->tipoInstitucion->id ?? null;
        $this->tipoinsitucionotro = $this->directorio->tipo_institucion_otros;

        $this->areaIntervencionSelected = $this->directorio->area_intervencion_id;
        $this->areaIntervencionNombre = $this->directorio->areaIntervencion->nombre ?? "";
        $this->otraAreaIntervencion = $this->directorio->area_intervencion_otros;
    }


    public function setFichaVoluntario(FichaVoluntario $voluntario)
    {
        $voluntario->load([
            'paisServicioDesarrollar:id',
            'paisMedioVida:id,medio_vida_id',
            'paisMedioVida.medioVida:id,nombre',
            'paisVinculadoDebido:id,vinculado_debido_id',
            'paisVinculadoDebido.vinculadoDebido:id,nombre',
            'paisMedioVerificacionVoluntario:id,medio_verificacion_voluntario_id',
            'paisMedioVerificacionVoluntario.medioVerificacionVoluntario:id,nombre',
            'paisAreaIntervencion:id,area_intervencion_id',
            'paisAreaIntervencion.areaIntervencion:id,nombre',
        ]);


        $this->voluntario = $voluntario;

        $this->medioVidaSelected = $voluntario->paisMedioVida->medioVida->id ?? null;
        $this->medioVidaSelectedPivot = $voluntario->pais_medio_vida_id;

        $this->directorioSelected = $voluntario->directorio_id;
        $this->fecha_inicio_voluntariado = $voluntario->fecha_inicio_voluntariado;
        $this->promedio_horas = $voluntario->promedio_horas;
        $this->informacionAdicionalJoven = $voluntario->informacion_adicional;

        $this->vinculadoDebidoSelected = $voluntario->paisVinculadoDebido->vinculadoDebido->id ?? null;
        $this->vinculadoDebidoSelectedPivot = $voluntario->pais_vinculado_debido_id;
        $this->vinculadoDebidoOtro = $voluntario->vinculado_otro;

        $this->medioVerificacionSelected = $voluntario->paisMedioVerificacionVoluntario->medioVerificacionVoluntario->id ?? null;
        $this->medioVerificacionSelectedPivot = $voluntario->pais_medio_verificacion_voluntario_id;

        $this->areaIntervencionSelected = $voluntario->paisAreaIntervencion->areaIntervencion->id ?? null;
        $this->areaIntervencionSelectedPivot = $voluntario->area_intervencion_id;
        $this->otraAreaIntervencion = $voluntario->otra_area_intervencion;

        $this->temp_file = $voluntario->medio_verificacion_file;

        $this->serviciosDesarrollarSelected = $voluntario->paisServicioDesarrollar->pluck('id')->toArray();

        $this->servicio_otro = $voluntario->servicio_otro;

        $this->setDirectorio($voluntario->directorio_id);
    }

    public function save(?FichaVoluntario $voluntario = null): void
    {

        if ($voluntario){
            $this->voluntario = $voluntario;
        }

        //$this->validate();
        DB::transaction(function () {

            $this->validate();

            $cohorteParticipanteProyecto = \App\Models\CohorteParticipanteProyecto::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->where('participante_id', $this->participante->id)
                ->first();

            $this->voluntario->cohorte_participante_proyecto_id = $cohorteParticipanteProyecto->id;

            $this->voluntario->pais_medio_vida_id = $this->medioVerificacionSelectedPivot;
            $this->voluntario->directorio_id = $this->directorioSelected;
            $this->voluntario->fecha_inicio_voluntariado = $this->fecha_inicio_voluntariado;
            $this->voluntario->promedio_horas = $this->promedio_horas;

            $this->voluntario->pais_vinculado_debido_id = $this->vinculadoDebidoSelectedPivot;

            $this->voluntario->vinculado_otro = $this->vinculadoDebidoOtro;
            $this->voluntario->servicio_otro = $this->servicio_otro;

            $this->voluntario->pais_medio_verificacion_voluntario_id = $this->medioVerificacionSelectedPivot;
            if ($this->file_documento_medio_verificacion_upload) {
                $this->voluntario->medio_verificacion_file = $this->file_documento_medio_verificacion_upload->store("resultadocuatro/{$this->voluntario->cohorte_participante_proyecto_id}/fichas/{$this->participante->id}/medio_verificacion_formaciones", "s3");
            }


            $this->voluntario->informacion_adicional = $this->informacionAdicionalJoven;
            $this->voluntario->active_at = now();
            $this->voluntario->save();

            $this->voluntario->paisServicioDesarrollar()->sync($this->serviciosDesarrollarSelected);
        });

    }

}
