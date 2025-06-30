<?php

namespace App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Forms;

use Carbon\Carbon;
use Livewire\Form;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\DB;
use App\Models\Pais;
use App\Models\Participante;
use App\Models\FichaEmprendimiento;

class EmprendimientoForm extends Form
{
    public Pais $pais;

    public Participante $participante;

    public FichaEmprendimiento $emprendimiento;

    public $showValidationErrorIndicator = false;

    public $showSuccessIndicator = false;

    public $readonly = false;

    public $minDate;

    public $maxDate;

    public $cohorte_participante_proyecto_id;


    public $medio_vida_id;

    public $nombre;

    public $rubro_emprendimiento_id;

    public $fecha_inicio_emprendimiento;

    public $etapa_emprendimiento_id;

    public $tiene_capital_semilla;

    public $capital_semilla_id;

    public $capital_semilla_otros;

    public $monto_local;

    public $monto_dolar;

    public $ingresos_promedio_id;

    public $tiene_red_emprendimiento;

    public $red_empredimiento;

    public $emprendimiento_medio_verificaciones;

    public $medio_verificacion_otros;

    public $medio_verificacion_file;

    public $medio_verificacion_upload;

    public $medio_verificacion_required;

    public $informacion_adicional;

    public $comentario;


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
            'nombre' => [
                'required',
                'min:3',
            ],
            'rubro_emprendimiento_id' => 'required',
            'fecha_inicio_emprendimiento' => [
                'required',
                'date'
            ],
            'etapa_emprendimiento_id' => 'required',
            'tiene_capital_semilla' => 'required',
            'capital_semilla_id' => Rule::requiredIf(
                fn() => $this->tiene_capital_semilla == '1'
            ),
            'capital_semilla_otros' => [
                Rule::when(function () {
                    return $this->tiene_capital_semilla == '1' && $this->pais->capitalSemilla()
                        ->where('capital_semillas.id', $this->capital_semilla_id)
                        ->where('capital_semillas.slug', 'otros')
                        ->count();
                }, ['required', 'min:3']),
            ],
            'monto_local' => Rule::requiredIf(
                fn() => $this->tiene_capital_semilla == '1'
            ),
            'monto_dolar' => Rule::requiredIf(
                fn() => $this->tiene_capital_semilla == '1'
            ),
            'tiene_red_emprendimiento' => 'required',
            'red_empredimiento' => Rule::requiredIf(
                fn() => $this->tiene_red_emprendimiento == '1'
            ),
            'emprendimiento_medio_verificaciones' => 'required',
            'medio_verificacion_otros' => [
                Rule::when(function () {
                    return $this->pais->medioVerificacionEmprendimiento()
                        ->whereIn('medio_verificacion_emprendimientos.id', $this->emprendimiento_medio_verificaciones)
                        ->where('medio_verificacion_emprendimientos.slug', 'otros')
                        ->count();
                }, ['required', 'min:3']),
            ],
            'medio_verificacion_file' => [
                Rule::when(
                    $this->medio_verificacion_required,
                    [
                        'required',
                        File::types(['pdf', 'jpeg', 'png'])
                            ->min('1kb')
                            ->max('5mb')
                    ]
                ),
            ],
            'ingresos_promedio_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'medio_vida_id.required' => 'Seleccione un medio de vida.',
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.min' => 'El campo debe tener mas de 3 caracteres.',
            'rubro_emprendimiento_id.required' => 'Seleccione un rubro.',
            'fecha_inicio_emprendimiento.required' => 'El campo fecha es requerido.',
            'fecha_inicio_emprendimiento.date' => 'El campo fecha debe ser una fecha valida.',
            'etapa_emprendimiento_id.required' => 'El campo etapa del emprendimiento es requerido.',
            'tiene_capital_semilla.required' => 'Seleccione si tiene capital semilla.',
            'capital_semilla_id.required' => 'Seleccione una capital semilla.',
            'capital_semilla_otros.required' => 'Especifique un valor.',
            'capital_semilla_otros.min' => 'El campo debe tener mas de 3 caracteres.',
            'monto_local.required' => 'El campo monto local es requerido.',
            'monto_dolar.required' => 'El campo monto dolar es requerido.',
            'tiene_red_emprendimiento.required' => 'Seleccione si forma parte de una red de emprendimiento.',
            'red_empredimiento.required' => 'Seleccione una red de emprendimiento.',
            'medio_verificacion_otros.required' => 'Especifique un valor.',
            'medio_verificacion_otros.min' => 'El campo debe tener mas de 3 caracteres.',
            'medio_verificacion_file.required' => 'El campo medio de verificacion es requerido.',
            'medio_verificacion_file.max' => 'El archivo de medio de verificacion debe de ser de máximo 5mb.',
            'ingresos_promedio_id.required' => 'Seleccione un ingresos promedio.',
        ];
    }

    public function init(Pais $pais, Participante $participante)
    {
        $this->pais = $pais;
        $this->participante = $participante;
        $this->emprendimiento = new FichaEmprendimiento();

        $this->cohorte_participante_proyecto_id = $this->participante
            ->cohortePaisProyecto()
            ->pluck('cohorte_participante_proyecto.id')
            ->first();

        $this->emprendimiento_medio_verificaciones = [];

        $this->minDate = Carbon::createFromDate($this->participante->fecha_nacimiento)
            ->format('Y-m-d');
        $this->maxDate = Carbon::now()->format('Y-m-d');

        $this->medio_verificacion_required = true;
    }

    public function setEmprendimiento(FichaEmprendimiento $fichaEmprendimiento)
    {
        $this->emprendimiento = $fichaEmprendimiento;

        $this->cohorte_participante_proyecto_id = $fichaEmprendimiento->cohorte_participante_proyecto_id;
        $this->medio_vida_id = $fichaEmprendimiento->medio_vida_id;
        $this->nombre = $fichaEmprendimiento->nombre;
        $this->rubro_emprendimiento_id = $fichaEmprendimiento->rubro_emprendimiento_id;
        $this->fecha_inicio_emprendimiento = $fichaEmprendimiento->fecha_inicio_emprendimiento;
        $this->etapa_emprendimiento_id = $fichaEmprendimiento->etapa_emprendimiento_id;
        $this->tiene_capital_semilla = $fichaEmprendimiento->tiene_capital_semilla;
        $this->capital_semilla_id = $fichaEmprendimiento->capital_semilla_id;
        $this->capital_semilla_otros = $fichaEmprendimiento->capital_semilla_otros;
        $this->monto_local = $fichaEmprendimiento->monto_local;
        $this->monto_dolar = $fichaEmprendimiento->monto_dolar;
        $this->ingresos_promedio_id = $fichaEmprendimiento->ingresos_promedio_id;
        $this->tiene_red_emprendimiento = $fichaEmprendimiento->tiene_red_emprendimiento;
        $this->red_empredimiento = $fichaEmprendimiento->red_empredimiento;
        $this->medio_verificacion_otros = $fichaEmprendimiento->medio_verificacion_otros;
        $this->medio_verificacion_upload = $fichaEmprendimiento->medio_verificacion_file;
        $this->informacion_adicional = $fichaEmprendimiento->informacion_adicional;
        $this->comentario = $fichaEmprendimiento->comentario;

        $this->emprendimiento_medio_verificaciones = $fichaEmprendimiento->medioVerificacion()
            ->pluck('medio_verificacion_emprendimientos.id')
            ->toArray();
    }

    public function customReset()
    {
        $this->reset([
            'cohorte_participante_proyecto_id',
            'medio_vida_id',
            'nombre',
            'rubro_emprendimiento_id',
            'fecha_inicio_emprendimiento',
            'etapa_emprendimiento_id',
            'tiene_capital_semilla',
            'capital_semilla_id',
            'capital_semilla_otros',
            'monto_local',
            'monto_dolar',
            'tiene_red_emprendimiento',
            'red_empredimiento',
            'emprendimiento_medio_verificaciones',
            'medio_verificacion_otros',
            'medio_verificacion_file',
            'informacion_adicional',
            'comentario',
        ]);
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function() {

            $this->emprendimiento->cohorte_participante_proyecto_id = $this->cohorte_participante_proyecto_id;
            $this->emprendimiento->medio_vida_id = $this->medio_vida_id;
            $this->emprendimiento->nombre = $this->nombre;
            $this->emprendimiento->rubro_emprendimiento_id = $this->rubro_emprendimiento_id;
            $this->emprendimiento->fecha_inicio_emprendimiento = $this->fecha_inicio_emprendimiento;
            $this->emprendimiento->etapa_emprendimiento_id = $this->etapa_emprendimiento_id;
            $this->emprendimiento->tiene_capital_semilla = $this->tiene_capital_semilla;
            $this->emprendimiento->capital_semilla_id = $this->capital_semilla_id;
            $this->emprendimiento->capital_semilla_otros = $this->capital_semilla_otros;
            $this->emprendimiento->monto_local = $this->monto_local;
            $this->emprendimiento->monto_dolar = $this->monto_dolar;
            $this->emprendimiento->ingresos_promedio_id = $this->ingresos_promedio_id;
            $this->emprendimiento->tiene_red_emprendimiento = $this->tiene_red_emprendimiento;
            $this->emprendimiento->red_empredimiento = $this->red_empredimiento;
            $this->emprendimiento->medio_verificacion_otros = $this->medio_verificacion_otros;
            $this->emprendimiento->informacion_adicional = $this->informacion_adicional;
            $this->emprendimiento->gestor_id = auth()->user()->id;
            $this->emprendimiento->comentario = $this->comentario;
            $this->emprendimiento->active_at = now();

            $this->emprendimiento->save();

            $this->emprendimiento->medioVerificacion()
                ->syncWithPivotValues(
                    $this->emprendimiento_medio_verificaciones,
                    ['active_at' => now()]
                );

            if ($this->medio_verificacion_file) {
                $this->emprendimiento->medio_verificacion_file = $this->medio_verificacion_file
                    ->store("resultadocuatro/{$this->cohorte_participante_proyecto_id}/fichas/{$this->participante->id}/emprendimientos", 's3');

                $this->emprendimiento->save();
            }

            $this->customReset();

        });
    }
}
