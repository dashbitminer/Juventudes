<?php

namespace App\Livewire\Resultadocuatro\Gestor\Formacion\Forms;

use Livewire\Form;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\Directorio;
use App\Models\TipoEstudio;
use App\Models\Participante;
use App\Models\AreaFormacion;
use Livewire\WithFileUploads;
use App\Models\FichaVoluntario;
use App\Models\VinculadoDebido;
use Illuminate\Validation\Rule;
use App\Models\AreaIntervencion;
use App\Models\FichaFormacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class FormacionForm extends Form
{

    use WithFileUploads;

    public Pais $pais;

    public Proyecto $proyecto;

    public Participante $participante;

    public FichaFormacion $formacion;

    public Directorio $directorio;

    public Cohorte $cohorte;

    public $mode;

    public $tipoEstudioSelected;
    public $tipoEstudioSelectedPivot;
    public $otro_tipo_estudio;

    public $medioVidaSelected;
    public $medioVidaSelectedPivot;

    public $directorioSelected;

    public $totalHorasDuracion;

    public $areaFormacionSelected;
    public $areaFormacionSelectedPivot;

    public $nivelEducativoSelected;
    public $nivelEducativoSelectedPivot;

    public $curso;

    public $tipoModalidad;

    public $informacionAdicionalJoven;

    public $medio_verificacion_upload;
    public $medio_verificacion_upload_dos;
    public $medio_verificacion_upload_tres;

    public $medioVerificacionSelected;
    public $medioVerificacionSelectedPivot;

    public $medioVerificacionSelectedDos;
    public $medioVerificacionSelectedPivotDos;

    public $medioVerificacionSelectedTres;
    public $medioVerificacionSelectedPivotTres;

    public $file_documento_medio_verificacion_upload;
    public $file_documento_medio_verificacion_upload_dos;
    public $file_documento_medio_verificacion_upload_tres;

    public $showValidationErrorIndicator = false;
    public $showSuccessIndicator = false;
    public $showCoberturaWarning = false;

    public $firstFile = null;
    public $secondFile = null;
    public $thirdFile = null;



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
            'tipoEstudioSelected' => [
                'required'
            ],
            'totalHorasDuracion' => [
                'required',
                'numeric'
            ],
            'areaFormacionSelected' => [
                'required'
            ],
            'nivelEducativoSelected' => [
                'required_if:areaFormacionSelected,' . AreaFormacion::EDUCACION_BASICA
            ],
            'curso' => [
                Rule::requiredIf($this->areaFormacionSelected != AreaFormacion::EDUCACION_BASICA),
            ],
            'tipoModalidad' => [
                'required'
            ],
            'otro_tipo_estudio' => [
                'required_if:tipoEstudioSelected,' . TipoEstudio::OTRO
            ],
            'medioVerificacionSelected' => [
                Rule::when($this->mode != 'edit', ['required']),
            ],
            'file_documento_medio_verificacion_upload' => [
                Rule::when($this->mode != 'edit', [
                    'required',
                    File::types(['pdf','jpeg', 'png', 'gif', 'jpg', 'svg', 'docx', 'doc'])
                        //->min('1kb')
                        ->max('2mb'),
                ]),
            ],
        ];
    }


    public function init($pais, $proyecto, $participante, $cohorte)
    {
        $this->pais = $pais;
        $this->proyecto = $proyecto;
        $this->participante = $participante;
        $this->cohorte = $cohorte;
    }


    public function setDirectorio($directorio)
    {
        $this->directorio = Directorio::find($directorio);
        $this->directorio->load('tipoInstitucion:id,nombre');
    }


    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function setFichaFormacion($fichaFormacion)
    {
        $fichaFormacion->load([
            "paisMedioVida:id,medio_vida_id",
            "paisMedioVida.medioVida:id,nombre",
            "paisMedioVerficicacionFormacion:id,medio_verificacion_formacion_id",
            "paisTipoEstudio:id,tipo_estudio_id",
            "paisTipoEstudio.tipoEstudio:id,nombre",
            "paisAreaFormacion:id,area_formacion_id",
            "paisAreaFormacion.areaFormacion:id,nombre",
            "paisNivelEducativoFormacion:id,pais_nivel_educativo_formacion_id",
            "paisNivelEducativoFormacion.nivelEducativoFormacion:id,nombre",
            "paisMedioVerficicacionFormacion.medioVerificacionFormacion"
        ]);

        $this->formacion = $fichaFormacion;

        $this->medioVidaSelected = $fichaFormacion->paisMedioVida->medioVida->id ?? null;
        $this->medioVidaSelectedPivot = $fichaFormacion->pais_medio_vida_id;

        $this->directorioSelected = $fichaFormacion->directorio_id;

        $this->tipoEstudioSelected = $fichaFormacion->paisTipoEstudio->tipoEstudio->id ?? null;
        $this->tipoEstudioSelectedPivot = $fichaFormacion->pais_tipo_estudio_id;

        $this->otro_tipo_estudio = $fichaFormacion->otro_tipo_estudio;

        $this->totalHorasDuracion = $fichaFormacion->total_horas_duracion;

        $this->areaFormacionSelected = $fichaFormacion->paisAreaFormacion->areaFormacion->id ?? null;
        $this->areaFormacionSelectedPivot = $fichaFormacion->pais_area_formacion_id;

        $this->nivelEducativoSelected = $fichaFormacion->paisNivelEducativoFormacion->nivelEducativoFormacion->id ?? null;
        $this->nivelEducativoSelectedPivot = $fichaFormacion->pais_nivel_educativo_formacion_id;

        $this->curso = $fichaFormacion->nombre_curso;

        $this->tipoModalidad = $fichaFormacion->tipo_modalidad;

        $this->informacionAdicionalJoven = $fichaFormacion->informacion_adicional;

        $primerMedio = $fichaFormacion->paisMedioVerficicacionFormacion->firstWhere("pivot.active_at","!=", null);
        $this->medioVerificacionSelectedPivot = $primerMedio->id ?? null;
        $this->medioVerificacionSelected = $primerMedio->medioVerificacionFormacion->id ?? null;
        $this->firstFile = $primerMedio->pivot->medio_verificacion_file ?? null;

        $segundoMedio = $fichaFormacion->paisMedioVerficicacionFormacion->where("pivot.active_at","!=", null)->skip(1)->first();
        $this->medioVerificacionSelectedPivotDos = $segundoMedio->id ?? null;
        $this->medioVerificacionSelectedDos = $segundoMedio->medioVerificacionFormacion->id ?? null;
        $this->secondFile = $segundoMedio->pivot->medio_verificacion_file ?? null;

        $tercerMedio = $fichaFormacion->paisMedioVerficicacionFormacion->where("pivot.active_at","!=", null)->skip(2)->first();
        $this->medioVerificacionSelectedPivotTres = $tercerMedio->id ?? null;
        $this->medioVerificacionSelectedTres = $tercerMedio->medioVerificacionFormacion->id ?? null;
        $this->thirdFile = $tercerMedio->pivot->medio_verificacion_file ?? null;

    }


    public function save(?FichaFormacion $formacion = null): void
    {

        if ($formacion) {
            $this->formacion = $formacion;
        }

        DB::transaction(function () {

            $this->validate();

            $cohorte_participante_proyecto_id = $this->participante
                ->cohortePaisProyecto()
                ->pluck('cohorte_participante_proyecto.id')
                ->first();

            $this->formacion->cohorte_participante_proyecto_id = $cohorte_participante_proyecto_id;

            // $this->formacion->pais_id = $this->pais->id;
            // $this->formacion->proyecto_id = $this->proyecto->id;
            // $this->formacion->participante_id = $this->participante->id;
            // $this->formacion->cohorte_id = $this->cohorte->id;

            $this->formacion->pais_medio_vida_id = $this->medioVidaSelectedPivot;
            $this->formacion->directorio_id = $this->directorioSelected;
            $this->formacion->pais_tipo_estudio_id = $this->tipoEstudioSelectedPivot;
            $this->formacion->otro_tipo_estudio = $this->otro_tipo_estudio;
            $this->formacion->total_horas_duracion = $this->totalHorasDuracion;
            $this->formacion->pais_area_formacion_id = $this->areaFormacionSelectedPivot;
            $this->formacion->pais_nivel_educativo_formacion_id = $this->nivelEducativoSelectedPivot;
            $this->formacion->tipo_modalidad = $this->tipoModalidad;
            $this->formacion->informacion_adicional = $this->informacionAdicionalJoven;
            $this->formacion->nombre_curso = $this->curso;

            $this->formacion->save();

            $this->formacion->paisMedioVerficicacionFormacion()->updateExistingPivot($this->medioVerificacionSelectedPivot, [
                'active_at' => null
            ]);


            if($this->medioVerificacionSelectedPivot && $this->file_documento_medio_verificacion_upload){
                $this->formacion->paisMedioVerficicacionFormacion()->attach($this->medioVerificacionSelectedPivot, [
                        'medio_verificacion_file' => $this->file_documento_medio_verificacion_upload->store("resultadocuatro/{$this->formacion->cohorte_participante_proyecto_id}/fichas/{$this->participante->id}/formaciones/medio_verificacion_formaciones", "s3"),
                        'active_at' => now()
                ]);
            }

            // $documento = $this->achivos_verificacion[$id]
            // ->store("resultadocuatro/{$cohorte_participante_proyecto->id}/fichas/{$this->participante->id}/empleos", 's3');


            if($this->medioVerificacionSelectedPivotDos && $this->file_documento_medio_verificacion_upload_dos){

                $this->formacion->paisMedioVerficicacionFormacion()->updateExistingPivot($this->medioVerificacionSelectedPivotDos, [
                    'active_at' => null
                ]);

                $this->formacion->paisMedioVerficicacionFormacion()->attach($this->medioVerificacionSelectedPivotDos, [
                    'medio_verificacion_file' => $this->file_documento_medio_verificacion_upload_dos->store("resultadocuatro/{$this->formacion->cohorte_participante_proyecto_id}/fichas/{$this->participante->id}/formaciones/medio_verificacion_formaciones", "s3"),
                    'active_at' => now()
                ]);
            }

            if($this->medioVerificacionSelectedPivotTres && $this->file_documento_medio_verificacion_upload_tres){

                $this->formacion->paisMedioVerficicacionFormacion()->updateExistingPivot($this->medioVerificacionSelectedPivotTres, [
                    'active_at' => null
                ]);

                $this->formacion->paisMedioVerficicacionFormacion()->attach($this->medioVerificacionSelectedPivotTres, [
                    'medio_verificacion_file' => $this->file_documento_medio_verificacion_upload_tres->store("resultadocuatro/{$this->formacion->cohorte_participante_proyecto_id}/fichas/{$this->participante->id}/formaciones/medio_verificacion_formaciones", "s3"),
                    'active_at' => now()
                ]);
            }

        });

    }

}
