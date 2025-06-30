<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Financiero;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use App\Models\PaisProyecto;
use App\Models\CohortePaisProyecto;
use Illuminate\Support\Facades\DB;
use App\Livewire\Financiero\Mecla\Estipendios\Financiero\Filters;

class Page extends Component
{
    public Filters $filters;

    public array $paises = [];
    public array $cohortes = [];
    public array $proyectos = [];

    #[Url(history: true, as: 'pais')]
    public $selectedPais;

    #[Url(history: true, as: 'proyecto')]
    public $selectedPaisProyecto;

    #[Url(history: true, as: 'cohorte')]
    public $selectedCohortePaisProyecto;


    public $paisProyecto;
    public $cohortePaisProyecto;

    public bool $filtersInitialized = false;

    public $cohortePoryectoUsers;
    public $cohortePaisProyectos;
    public $paisProyectos;

    public function mount(): void
     {
        $cohorteProyectoUsers = DB::table('cohorte_proyecto_user')
            ->whereNotNull('active_at')
            ->where('user_id', auth()->user()->id)
            ->pluck('cohorte_pais_proyecto_id');

        $this->cohortePaisProyectos = CohortePaisProyecto::whereIn('id', $cohorteProyectoUsers)
            ->whereNotNull('active_at')
            ->get();

        $this->paisProyectos = PaisProyecto::whereIn('id', $this->cohortePaisProyectos->pluck('pais_proyecto_id'))
            ->with('pais')
            ->get();

        $this->paises = $this->paisProyectos->pluck("pais.nombre", "id")->toArray();
     }

    #[Layout('layouts.app')]
    public function render()
    {
        if($this->selectedCohortePaisProyecto && !$this->filtersInitialized){
            $this->filters->init($this->selectedCohortePaisProyecto);
            $this->filtersInitialized = true;
        }

        if($this->selectedPais){

            $this->proyectos = PaisProyecto::where('id', $this->selectedPais)
                ->with("proyecto")
                ->get()
                ->pluck('proyecto.nombre', 'id')
                ->toArray();

        }

        if($this->selectedPaisProyecto){

            $this->paisProyecto = PaisProyecto::with(['pais:id,nombre', 'proyecto:id,nombre'])->find($this->selectedPaisProyecto);

            $this->cohortes = CohortePaisProyecto::where('pais_proyecto_id', $this->paisProyecto->id)
                ->whereIn("id",  $this->cohortePaisProyectos->pluck('id')->toArray())
                ->with('cohorte')
                ->get()
                ->pluck('cohorte.nombre', 'id')
                ->toArray();
        }

        if($this->selectedCohortePaisProyecto){
            $this->cohortePaisProyecto = CohortePaisProyecto::with(['cohorte'])->find($this->selectedCohortePaisProyecto);
        }

        return view('livewire.financiero.mecla.estipendios.financiero.page')->layoutData([
            'financiero' => true,
        ]);
    }

    public function updatedSelectedPais($paisId): void
    {
        $this->proyectos = [];
        $this->cohortes = [];

        $this->reset(['selectedPaisProyecto', 'selectedCohortePaisProyecto']);

        if (!$paisId) {
            return;
        }

        $this->proyectos = PaisProyecto::where('pais_id', $paisId)
            ->with('proyecto')
            ->get()
            ->pluck('proyecto.nombre', 'id')
            ->toArray();
    }

    public function updatedSelectedPaisProyecto($paisProyectoId): void
    {
        $this->cohortes = [];

        $this->reset(['selectedCohortePaisProyecto']);

        if (!$this->selectedPais || !$paisProyectoId) {
            return;
        }

        $this->paisProyecto = \App\Models\PaisProyecto::with(['pais:id,nombre', 'proyecto:id,nombre'])
                        ->find($paisProyectoId);

        $this->cohortes = \App\Models\CohortePaisProyecto::where('pais_proyecto_id', $paisProyectoId)
            ->with('cohorte')
            ->get()
            ->pluck('cohorte.nombre', 'id')
            ->toArray();
    }

    public function updatedSelectedCohortePaisProyecto()
    {
        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::with(['cohorte'])
                            ->find($this->selectedCohortePaisProyecto);

        $this->dispatch('updateSelectedCohortePaisProyecto', $this->selectedCohortePaisProyecto, $this->selectedPaisProyecto);
    }

    public function resetFilters(): void
    {
        $this->reset(['selectedPais', 'selectedPaisProyecto', 'selectedCohortePaisProyecto', 'proyectos', 'cohortes']);
    }
}
