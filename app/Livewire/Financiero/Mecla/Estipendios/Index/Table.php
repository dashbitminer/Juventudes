<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Index;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Estipendio;
use Livewire\Attributes\On;
use App\Models\CohortePaisProyecto;
use App\Livewire\Financiero\Mecla\Estipendios\Forms\EstipendioIndexForm;
use App\Models\EstipendioParticipante;
use Livewire\WithPagination;

class Table extends Component
{

    use WithPagination;

    public $perPage = 10;

    public $openDrawerView = false;

    public $openDrawerMonto = false;

    public $agrupaciones = [];

    public $nombre_agrupacion;

    public $denominador_agrupacion;

    public $color;

    public $estipendiosMeses = [];

    public CohortePaisProyecto $cohortePaisProyecto;

    public EstipendioIndexForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public $actividades;

    public $subactividades;

    public $modulos;

    public $submodulos;

    public Estipendio $estipendio;

    public $estipendio_monto;

    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];



    public function mount()
    {
        $this->actividades = collect([]);
        $this->subactividades = collect([]);
        $this->modulos = collect([]);
        $this->submodulos = collect([]);
    }


    #[On('estipendioCreated')]
    public function render()
    {
        $query = Estipendio::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                    ->active()
                    ->latest()
                    ->with('socioImplementador', 'perfilParticipante');

        $estipendios = $query->paginate($this->perPage);

        $this->participanteIdsOnPage = $estipendios->map(fn ($estipendio) => (string) $estipendio->id)->toArray();



        // $estipendiosGrouped = $estipendios->unique('cohorte_pais_proyecto_perfil_id');

        // dd($estipendios, $estipendiosGrouped);

        return view('livewire.financiero.mecla.estipendios.index.table', [
            'estipendios' => $estipendios,
            //'estipendiosGrouped' => $estipendiosGrouped
        ]);
    }

    public function editarAgrupamiento()
    {
        $this->openDrawerView = true;
    }

    public function crearAgrupamiento()
    {
        $this->agrupaciones[] = [
            'nombre' => $this->nombre_agrupacion,
            'denominador' => $this->denominador_agrupacion,
            'color' => $this->color
        ];

        $this->reset('nombre_agrupacion', 'denominador_agrupacion', 'color');

        $this->openDrawerView = false;
    }

    #[On('open-drawer-monto')]
    public function openDrawerMonto(Estipendio $estipendio)
    {
        $this->estipendio = $estipendio;

        $this->estipendio_monto = $estipendio->monto;

        $this->openDrawerMonto = true;
    }

    public function updateEstipendioMonto()
    {
        $estipendiosIds = [];

        $estipendios = Estipendio::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                    // ->with('socioImplementador', 'perfilParticipante')
                    ->where('cohorte_pais_proyecto_perfil_id', $this->estipendio->cohorte_pais_proyecto_perfil_id)
                    ->where('mes', $this->estipendio->mes)
                    ->where('anio', $this->estipendio->anio)
                    ->where('fecha_inicio', $this->estipendio->fecha_inicio)
                    ->where('fecha_fin', $this->estipendio->fecha_fin)
                    ->where('is_closed', 0)
                    ->get();

        foreach ($estipendios as $estipendio) {
            $estipendio->monto = $this->estipendio_monto;
            $estipendio->save();

            $estipendiosIds[] = $estipendio->id;
        }


        // Se va actualizar el porcentaje como 100% y el monto como el 100%
        $participantesIds = [];

        $participantes = EstipendioParticipante::with('participante.grupoactivo.lastEstadoParticipante')
            ->whereIn('estipendio_id', $estipendiosIds)
            ->get();

        foreach ($participantes as $participante) {
            if (($participante->participante->grupoactivo->lastEstadoParticipante?->estado_id ?? 2) == 1) {
                $participantesIds[] = $participante->participante_id;
            }
        }

        EstipendioParticipante::whereIn('estipendio_id', $estipendiosIds)
            ->whereIn('participante_id', $participantesIds)
            ->update([
                'porcentaje_estipendio' => 100,
                'monto_estipendio' => $this->estipendio_monto * (100 / 100)
            ]);


        $this->reset('estipendio', 'estipendio_monto');

        $this->openDrawerMonto = false;
    }

    #[On('cerrar-estipendio')]
    public function cerrarEstipendio(Estipendio $estipendio)
    {
        $estipendios = Estipendio::where('cohorte_pais_proyecto_id', $estipendio->cohorte_pais_proyecto_id)
                    ->where('cohorte_pais_proyecto_perfil_id', $estipendio->cohorte_pais_proyecto_perfil_id)
                    ->where('mes', $estipendio->mes)
                    ->where('anio', $estipendio->anio)
                    ->where('fecha_inicio', $estipendio->fecha_inicio)
                    ->where('fecha_fin', $estipendio->fecha_fin)
                    ->where('is_closed', 0)
                    ->get();

        foreach ($estipendios as $model) {
            $model->is_closed = 1;
            $model->save();
        }

        $this->dispatch('estipendioCreated');
    }

    public function deleteSelected()
    {
        $estipendios = Estipendio::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                    ->whereIn('id', $this->selectedParticipanteIds)
                    ->get();

        foreach ($estipendios as $estipendio) {

            EstipendioParticipante::where('estipendio_id', $estipendio->id)
                ->delete();

            $estipendio->delete();
        }

        $this->selectedParticipanteIds = [];
        //$this->dispatch('estipendioCreated');
    }

    public function delete($estipendioId)
    {
        $estipendio = Estipendio::find($estipendioId);

        if ($estipendio) {
            EstipendioParticipante::where('estipendio_id', $estipendio->id)
                ->delete();

            $estipendio->delete();
        }

       // $this->dispatch('estipendioCreated');
    }
}
