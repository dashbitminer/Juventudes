<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Forms;

use App\Models\EstipendioParticipante;
use App\Rules\UniqueDateForEstipendio;
use Throwable;
use Livewire\Form;


class EstipendioIndexForm extends Form
{

    public $cohortePaisProyecto;

    public $lastMes = null;

    public $lastAnio = null;

    public $selectedMes;

    public $selectedAnio;

    public $fechaInicio;

    public $fechaFin;

    public $showSuccessIndicator = false;
    public $showValidationErrorIndicator = false;


    public function rules()
    {
        return [
            'selectedMes' => [
                'required',
                'numeric',
                'min:1',
                'max:12',
                new UniqueDateForEstipendio($this->selectedMes, $this->selectedAnio, $this->cohortePaisProyecto),
            ],
            'selectedAnio' => [
                'required',
                'numeric',
                'min:2024',
                'max:2230',
            ],
            'fechaInicio' => [
                'required',
                'date',
            ],
            'fechaFin' => [
                'required',
                'date',
                'after:fechaInicio',
            ],

        ];
    }


    public function messages()
    {
        return [
            'selectedMes.required' => 'El campo es requerido.',
            'selectedAnio.required' => 'El campo es requerido.',
            'fechaInicio.required' => 'El campo es requerido.',
            'fechaFin.required' => 'El campo es requerido.',
        ];
    }




    public function boot()
    {
        $this->withValidator(function ($validator) {

            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    public function init($cohortePaisProyecto)
    {

        $this->setCohortePaisProyecto($cohortePaisProyecto);

        $lastEstipendio = \App\Models\Estipendio::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
        ->orderBy('anio', 'desc')
        ->orderBy('mes', 'desc')
        ->first();

        if ($lastEstipendio) {
            $this->lastMes = $lastEstipendio->mes;
            $this->lastAnio = $lastEstipendio->anio;

            $this->selectedMes = $lastEstipendio->mes + 1;
            $this->selectedAnio = ($lastEstipendio->mes == 12) ? $lastEstipendio->anio + 1 : $lastEstipendio->anio;

        } else {
            $this->lastMes = null;
            $this->lastAnio = null;

            $this->selectedMes = date('n');
            $this->selectedAnio = date('Y');
        }

    }

    public function setCohortePaisProyecto($cohortePaisProyecto): void
    {
        $this->cohortePaisProyecto = $cohortePaisProyecto;
    }

    public function save()
    {
        $this->validate();

        try {

            if (!empty($this->cohortePaisProyecto->perfilesParticipante)) {
                $this->cohortePaisProyecto->load("perfilesParticipante");
            }

            // Check if Estipendio for selectedMes, selectedAnio, and cohortePaisProyecto already exists
            // $existingEstipendio = \App\Models\Estipendio::where('mes', $this->selectedMes)
            //     ->where('anio', $this->selectedAnio)
            //     ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            //     ->first();

            // if ($existingEstipendio) {
            //     $this->addError('selectedMes', 'Ya existe un estipendio para el mes y año seleccionados en este proyecto.');
            //     $this->addError('selectedAnio', 'Ya existe un estipendio para el mes y año seleccionados en este proyecto.');
            //     return;
            // }

            $socios = \App\Models\Participante::with(['gestor.socioImplementador'])
                ->whereHas('cohorteParticipanteProyecto', function ($query)  {
                    $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
                })
                ->get()
                ->pluck('gestor.socioImplementador')
                ->unique('id')
                ->values();


            foreach ($socios as $socio) {
                foreach($this->cohortePaisProyecto->perfilesParticipante as $perfil) {

                    //1. Create Estipendio

                    $estipendio = new \App\Models\Estipendio();
                    $estipendio->mes = $this->selectedMes;
                    $estipendio->anio = $this->selectedAnio;
                    $estipendio->fecha_inicio = $this->fechaInicio;
                    $estipendio->fecha_fin = $this->fechaFin;
                    $estipendio->cohorte_pais_proyecto_id = $this->cohortePaisProyecto->id;
                    $estipendio->socio_implementador_id = $socio->id;
                    $estipendio->perfil_participante_id = $perfil->id;
                    $estipendio->cohorte_pais_proyecto_perfil_id = $perfil->pivot->id ?? NULL;
                    $estipendio->active_at = now();
                    $estipendio->save();

                    // 2. Get Participantes for the current socio and perfil

                    $participantes = \App\Models\Participante::whereHas('cohorteParticipanteProyecto', function ($query)  {
                        $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
                    })
                    ->whereHas('gestor.socioImplementador', function ($query) use ($socio) {
                        $query->where('socios_implementadores.id', $socio->id);
                    })
                    ->whereHas('grupoParticipante', function ($query) use ($perfil) {
                        $query->where('grupo_participante.cohorte_pais_proyecto_perfil_id', $perfil->pivot->id);
                    })
                    ->whereHas('lastEstado', function ($q) {
                        $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
                    })
                    ->get();

                    // 3. Create Estipendio Participante for each participante
                    foreach ($participantes as $participante) {
                        EstipendioParticipante::create([
                            'estipendio_id' => $estipendio->id,
                            'participante_id' => $participante->id,
                        ]);
                    }


                }
            }





            $this->showSuccessIndicator = true;

            if($this->selectedMes == 12) {
                $this->selectedMes = 1;
                $this->selectedAnio = $this->selectedAnio + 1;
            }else{
                $this->selectedMes = $this->selectedMes + 1;
            }


            $this->reset('fechaInicio', 'fechaFin');

            //$this->emit('estipendioCreated');


        } catch (Throwable $e) {
            $this->showValidationErrorIndicator = true;
            \Log::error('Error creating estipendio: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}
