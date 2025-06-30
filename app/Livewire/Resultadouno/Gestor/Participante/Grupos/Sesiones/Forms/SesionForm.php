<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos\Sesiones\Forms;

use Livewire\Form;
use App\Models\Grupo;
use App\Models\Sesion;
use App\Models\SesionTipo;
use App\Models\SesionTitulo;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use App\Models\SesionParticipante;
use App\Models\SesionParticipanteTimeTracking;
use App\Models\Actividad;
use App\Models\Subactividad;
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\CohortePaisProyecto;
use Carbon\Carbon;

class SesionForm extends Form
{
    public CohortePaisProyecto $cohortePaisProyecto;

    public ?Sesion $sesion;

    public Grupo $grupo;

    public Actividad | Subactividad | Modulo | Submodulo $model;

    public $cohorte_pais_proyecto_perfil_id;

    public $actividad_id;

    public $subactividad_id;

    public $modulo_id;

    public $submodulo_id;

    public $fecha;

    public $fecha_fin;

    public $modalidad;

    public $titulo_id;

    public $titulo;

    public $comentario;

    public $hora;

    public $minuto;

    public $titulo_abierto;

    public $tipo_sesion;

    public $selectedParticipanteIds = [];

    public $isNew = true;

    public $enableSesionByFecha = false;

    public $rangeDates = [];

    public $rangoParticipanteHora = [];

    public $rangoParticipanteMinutos = [];


    public function boot()
    {
        $this->withValidator(function ($validator) {

            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    public function resetRangeDates()
    {
        $this->rangeDates = [];
        $this->rangoParticipanteFecha = [];
        $this->rangoParticipanteHora = [];
        $this->rangoParticipanteMinutos = [];
    }

    public function setSesion(Sesion $sesion) {
        $this->sesion = $sesion;

        $this->fecha = $sesion->fecha;
        $this->fecha_fin = $sesion->fecha_fin;
        $this->modalidad = $sesion->modalidad;
        $this->titulo_id = $sesion->titulo_id;
        $this->titulo = $sesion->titulo;
        // $this->tipo_sesion = $sesion->tipo;
        $this->hora = $sesion->hora;
        $this->minuto = $sesion->minuto;
        $this->actividad_id = $sesion->actividad_id;
        $this->subactividad_id = $sesion->subactividad_id;
        $this->modulo_id = $sesion->modulo_id;
        $this->submodulo_id = $sesion->submodulo_id;
        $this->comentario = $sesion->comentario;

        // Se sobre escribe el tipo de titulo y sesion por sesion
        // $this->titulo_abierto = SesionTitulo::CERRADO;

        // if ($sesion->titulo_id == '' && $sesion->titulo != '') {
        //     $this->titulo_abierto = SesionTitulo::ABIERTO;
        // }

        // $this->tipo_sesion = $sesion->tipo;

        // Habilita el form para agregar tiempo por dias
        if ($this->tipo_sesion == SesionTipo::HORAS_PARTICIPANTE) {
            $this->enableSesionByFecha = $this->fecha && $this->fecha_fin;

            // Comprueba si hay registro de participantes
            if ($sesion->sesionParticipantes()->count()) {
                foreach ($sesion->sesionParticipantes as $participante) {
                    if ($participante->tracking()->count()) {

                        // Obtener las fechas de todos los participantes
                        if (empty($this->rangeDates)) {
                            $participante->tracking->each(function ($item, $key) use ($participante) {

                                $item_fecha = Carbon::parse($item->fecha);

                                if ($item_fecha->between($this->fecha, $this->fecha_fin)) {
                                    $this->rangeDates[] = $item_fecha->format('d-m-Y');
                                }

                            });
                        }

                        $participante->tracking->each(function ($item, $key) use ($participante) {
                            $this->rangoParticipanteHora[$participante->participante_id][] = $item->hora;
                            $this->rangoParticipanteMinutos[$participante->participante_id][] = $item->minuto;
                        });

                    }
                }
            }

        }
    }

    public function rules()
    {
        return [
            'titulo_id' => Rule::requiredIf($this->titulo_abierto == SesionTitulo::CERRADO),
            //'titulo' => Rule::when($this->titulo_abierto == SesionTitulo::ABIERTO, ['required', 'min:5']),
            'fecha' => 'required|date',
            'fecha_fin' => Rule::when($this->tipo_sesion == SesionTipo::HORAS_PARTICIPANTE, ['required', 'date']),
            'selectedParticipanteIds' => Rule::when($this->tipo_sesion == SesionTipo::SESION_GENERAL, ['required']),
            'modalidad' => 'required',
            'hora' => Rule::requiredIf(intval($this->hora) < 0),
            'minuto' => Rule::requiredIf(intval($this->minuto) < 0),
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'El titulo es requerido.',
            'titulo.min' => 'El titulo debe tener al menos 5 caracteres.',
            'titulo_id.required' => 'Seleccione un titulo.',
            'fecha.required' => 'La fecha de inicio es requerida.',
            'fecha.date' => 'Ingrese una fecha valida.',
            'fecha_fin.required' => 'La fecha fin es requerida.',
            'fecha_fin.date' => 'Ingrese una fecha valida.',
            'selectedParticipanteIds.required' => 'Seleccione al menos a un participante.',
            'hora.required' => 'Ingrese un valor valido para la hora.',
            'minuto.required' => 'Ingrese un valor valido para el minuto.',
            'modalidad.required' => 'Ingrese la modalidad de la sesion.',
        ];
    }

    public function update()
    {
        $this->validate();

        $this->sesion = $this->model->sesiones()->updateOrCreate(
            [
                'id' => $this->sesion->id,
                'cohorte_pais_proyecto_id' => $this->cohortePaisProyecto->id,
                'cohorte_pais_proyecto_perfil_id' => $this->cohorte_pais_proyecto_perfil_id,
                'actividad_id' => $this->actividad_id,
                'subactividad_id' => $this->subactividad_id,
                'modulo_id' => $this->modulo_id,
                'submodulo_id' => $this->submodulo_id,
                'deleted_at' => null
            ],
            [
                'fecha' => $this->fecha,
                'fecha_fin' => $this->fecha_fin,
                'titulo_id' => $this->titulo_id,
                'titulo' => $this->titulo,
                'modalidad' => $this->modalidad,
                'hora' => $this->hora,
                'minuto' => $this->minuto,
                'comentario' => $this->comentario,
                'grupo_id' => $this->grupo->id,
                'user_id' => auth()->user()->id,
                'active_at' => now(),
            ]
        );

        $this->saveParticipantes();
        $this->customReset();
    }

    private function saveParticipantes() {
        if ($this->tipo_sesion == SesionTipo::SESION_GENERAL) {

            foreach ($this->selectedParticipanteIds as $participanteId => $value) {
                SesionParticipante::updateOrCreate(
                    ['sesion_id' => $this->sesion->id, 'participante_id' => $participanteId],
                    ['asistencia' => (bool) $value]
                );
            }

        }
        else {

            foreach ($this->selectedParticipanteIds as $participanteId => $value) {
                $sesionParticipante = SesionParticipante::updateOrCreate(
                    ['sesion_id' => $this->sesion->id, 'participante_id' => $participanteId],
                    ['asistencia' => (bool) $value]
                );

                foreach ($this->rangeDates as $key => $value) {
                    $fecha = Carbon::parse($value);

                    $sesionParticipante->tracking()->updateOrCreate(
                        ['fecha' => $fecha->format('Y-m-d')],
                        [
                            'hora' => $this->rangoParticipanteHora[$participanteId][$key] ?? 0,
                            'minuto' => $this->rangoParticipanteMinutos[$participanteId][$key] ?? 0,
                        ]
                    );
                }
            }

        }
    }

    public function customReset()
    {
        $this->reset([
            'fecha',
            'fecha_fin',
            'titulo_id',
            'titulo',
            'modalidad',
            'hora',
            'minuto',
            'comentario',
            'selectedParticipanteIds',
        ]);
    }
}
