<?php

namespace App\Livewire\Resultadocuatro\Gestor\Empleo\Forms;

use Livewire\Form;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\DB;
use App\Models\Pais;
use App\Models\Participante;
use App\Models\FichaEmpleo;

class EmpleoForm extends Form
{
    public $showValidationErrorIndicator = false;

    public $showSuccessIndicator = false;

    public $readonly = false;

    public Pais $pais;

    public Participante $participante;

    public FichaEmpleo $empleo;

    public $cohorte_participante_proyecto_id;


    public $medio_vida_id;

    public $directorio_id;

    public $sector_empresa_organizacion_id;

    public $tipo_empleo_id;

    public $cargo;

    public $salario_id;

    public $habilidades;

    public $medio_verificacion_id;

    public $medio_verificacion_otros;

    public $medio_verificacion_archivos;

    public $informacion_adicional;

    public $achivos_verificacion;

    public $require_upload_files;


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
            'medio_vida_id' => 'required',
            'directorio_id' => 'required',
            'sector_empresa_organizacion_id' => 'required',
            'tipo_empleo_id' => 'required',
            'cargo' => [
                'required',
                'min:3',
            ],
            'salario_id' => 'required',
            'habilidades' => [
                'required',
                'min:5',
            ],
            'medio_verificacion_id' => 'required',
            'medio_verificacion_otros' => Rule::requiredIf(function () {
                return $this->pais->medioVerificacion()
                    ->where('medio_verificaciones.id', $this->medio_verificacion_id)
                    ->where('medio_verificaciones.slug', 'otros')
                    ->count();
            }),
            'achivos_verificacion' => Rule::requiredIf(
                fn() => $this->require_upload_files
            ),
        ];
    }

    public function messages()
    {
        return [
            'medio_vida_id.required' => 'Seleccione un medio de vida.',
            'directorio_id.required' => 'Seleccione una organización.',
            'medio_verificacion_id.required' => 'Seleccione al menos un medio de verificacion.',
            'tipo_empleo_id.required' => 'Seleccione al menos un tipo de empleo.',
            'sector_empresa_organizacion_id.required' => 'El campo sector de la empresa u organización es obligatorio.',
            'salario_id.required' => 'El campo salario es obligatorio.',
            'habilidades.required' => 'Debe agregar al menos una habilidad.',
            'habilidades.min' => 'La habilidad debe tener mas de 5 caracteres.',
            'achivos_verificacion.required' => 'El campo archivos es obligatorio.',
        ];
    }


    public function init(Pais $pais, Participante $participante)
    {
        $this->pais = $pais;
        $this->participante = $participante;
        $this->empleo = new FichaEmpleo();
        $this->cohorte_participante_proyecto_id = $this->participante
            ->cohortePaisProyecto()
            ->pluck('cohorte_participante_proyecto.id')
            ->first();

        $this->medio_vida_id = [];
        $this->directorio_id = [];
        $this->sector_empresa_organizacion_id = [];
        $this->tipo_empleo_id = [];
        $this->salario_id = [];
        $this->medio_verificacion_id = [];
        $this->achivos_verificacion = [];
        $this->medio_verificacion_archivos = [];
        $this->require_upload_files = true;
    }

    public function setFichaEmpleo(FichaEmpleo $empleo)
    {
        $this->empleo = $empleo;

        $this->cohorte_participante_proyecto_id = $empleo->cohorte_participante_proyecto_id;
        $this->medio_vida_id = $empleo->medio_vida_id;
        $this->directorio_id = $empleo->directorio_id;
        $this->sector_empresa_organizacion_id = $empleo->sector_empresa_organizacion_id;
        $this->tipo_empleo_id = $empleo->tipo_empleo_id;
        $this->cargo = $empleo->cargo;
        $this->salario_id = $empleo->salario_id;
        $this->habilidades = $empleo->habilidades;
        $this->medio_verificacion_otros = $empleo->medio_verificacion_otros;
        $this->informacion_adicional = $empleo->informacion_adicional;
        $this->require_upload_files = false;
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function() {
            $cohorte_participante_proyecto = $this->participante->cohortePaisProyecto->first();

            $this->empleo->cohorte_participante_proyecto_id = $this->cohorte_participante_proyecto_id;
            $this->empleo->medio_vida_id = $this->medio_vida_id;
            $this->empleo->directorio_id = $this->directorio_id;
            $this->empleo->sector_empresa_organizacion_id = $this->sector_empresa_organizacion_id;
            $this->empleo->tipo_empleo_id = $this->tipo_empleo_id;
            $this->empleo->cargo = $this->cargo;
            $this->empleo->salario_id = $this->salario_id;
            $this->empleo->habilidades = $this->habilidades;
            $this->empleo->medio_verificacion_otros = $this->medio_verificacion_otros;
            $this->empleo->informacion_adicional = $this->informacion_adicional;
            $this->empleo->active_at = now();
            $this->empleo->gestor_id = auth()->user()->id;
            $this->empleo->save();

            if ($this->medio_verificacion_id) {
                $sync = [];

                foreach ($this->medio_verificacion_id as $id) {
                    $values = ['active_at' => now()];

                    if (!empty($this->achivos_verificacion[$id])) {
                        $documento = $this->achivos_verificacion[$id]
                            ->store("resultadocuatro/{$cohorte_participante_proyecto->id}/fichas/{$this->participante->id}/empleos", 's3');

                        $values['documento'] = $documento;
                    }
                    else if (!empty($this->medio_verificacion_archivos[$id])) {
                        // On edit, se vuelve a cargar la ruta del archivo
                        $values['documento'] = $this->medio_verificacion_archivos[$id];
                    }

                    $sync[$id] = $values;
                }

                $this->empleo->mediosVerificacion()->sync($sync);
            }

            $this->customReset();

        });
    }

    public function customReset()
    {
        $this->reset([
            'cohorte_participante_proyecto_id',
            'medio_vida_id',
            'directorio_id',
            'sector_empresa_organizacion_id',
            'tipo_empleo_id',
            'cargo',
            'salario_id',
            'habilidades',
            'medio_verificacion_id',
            'medio_verificacion_otros',
            'achivos_verificacion',
            'informacion_adicional',
        ]);
    }
}
