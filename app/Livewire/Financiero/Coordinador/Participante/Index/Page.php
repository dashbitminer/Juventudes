<?php

namespace App\Livewire\Financiero\Coordinador\Participante\Index;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use App\Models\PaisProyecto;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use App\Models\CohortePaisProyecto;

class Page extends Component
{

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

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

        $userId = auth()->id();

        $cohorteProyectoUsers = DB::table('cohorte_proyecto_user')
            ->where('user_id', $userId)
            ->whereNotNull('active_at')
            ->pluck('cohorte_pais_proyecto_id');

        $this->cohortePaisProyectos = CohortePaisProyecto::whereIn('id', $cohorteProyectoUsers)
            ->whereNotNull('active_at')
            ->get();

        $this->paisProyectos = PaisProyecto::whereIn('id', $this->cohortePaisProyectos->pluck('pais_proyecto_id'))
                        ->with('pais')
                        ->get();


        $this->paises = $this->paisProyectos->pluck("pais.nombre", "id")->toArray();

        $this->selectedPais = $this->pais->id;

        $this->selectedPaisProyecto = PaisProyecto::where('pais_id', $this->pais->id)->where('proyecto_id', $this->proyecto->id)
                                                ->firstOrFail()
                                                ->id;

        $this->selectedCohortePaisProyecto = CohortePaisProyecto::where('pais_proyecto_id', $this->selectedPaisProyecto)
                                                ->where('cohorte_id', $this->cohorte->id)
                                                ->firstOrFail()
                                                ->id;

    }


    // #[On('removeParticipanteFromGroup')]
    #[On('update-financierons-grupos-cards')]
    #[Layout('layouts.app')]
    public function render()
    {

        if($this->selectedCohortePaisProyecto && !$this->filtersInitialized){
            $this->filters->init($this->selectedCohortePaisProyecto);
            $this->filtersInitialized = true;
        }


        if($this->selectedPais){

            $this->proyectos = PaisProyecto::where('pais_id', $this->selectedPais)
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


        return view('livewire.financiero.coordinador.participante.index.page')->layoutData([
            'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
        ]);
    }

    #[On('update-financierons-grupos-cards')]
    public function updateGruposSelected()
    {
        $this->filters->selectedGruposIds = $this->filters->grupos()->pluck('grupo_id')->toArray();
    }

    public function updatedSelectedPais($paisId): void
    {
        $this->proyectos = [];
        $this->cohortes = [];

        $this->reset(['selectedPaisProyecto', 'selectedCohortePaisProyecto']);

        if (!$paisId) {
            return;
        }

        $this->proyectos = PaisProyecto::where('id', $paisId)
            ->with("proyecto")
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

        $this->paisProyecto = PaisProyecto::with(['pais:id,nombre', 'proyecto:id,nombre'])->find($paisProyectoId);

        $this->cohortes = CohortePaisProyecto::where('pais_proyecto_id', $paisProyectoId)
            ->whereIn("id",  $this->cohortePaisProyectos->pluck('id')->toArray())
            ->with('cohorte')
            ->get()
            ->pluck('cohorte.nombre', 'id')
            ->toArray();
    }

    public function updatedSelectedCohortePaisProyecto()
    {
        $this->cohortePaisProyecto = CohortePaisProyecto::with(['cohorte'])->find($this->selectedCohortePaisProyecto);

        $this->dispatch('updateSelectedCohortePaisProyecto', $this->selectedCohortePaisProyecto);
    }

    public function resetFilters(): void
    {
        $this->reset(['selectedPais', 'selectedPaisProyecto', 'selectedCohortePaisProyecto', 'proyectos', 'cohortes']);
    }


    public function updated($property, $value){
        //dd($property, $value);
        if (str_starts_with($property, 'filters.selectedPerfilesIds')) {

            if (!empty($this->filters->selectedPerfilesIds) && array_search('-1', $this->filters->selectedPerfilesIds) !== false) {
                // Para la opcion de "Seleccionar Todo"
                $this->filters->selectedPerfilesIds = [];
                $this->filters->initSelectedPerfilesIds();
            }

        }elseif(str_starts_with($property, 'filters.selectedGruposIds')){

            if (!empty($this->filters->selectedGruposIds) && array_search('-1', $this->filters->selectedGruposIds) !== false) {
                // Para la opcion de "Seleccionar Todo"
                $this->filters->selectedGruposIds = [];
                $this->filters->initSelectedGruposIds();
            }

        }elseif(str_starts_with($property, 'filters.selectedSexosIds')){
            
            if (!empty($this->filters->selectedSexosIds) && array_search('-1', $this->filters->selectedSexosIds) !== false) {
                // Para la opcion de "Seleccionar Todo"
                $this->filters->selectedSexosIds = [];
                $this->filters->initSelectedSexosIds();
            }

        }elseif(str_starts_with($property, 'filters.selectedDepartamentosIds')){

            if (!empty($this->filters->selectedDepartamentosIds) && array_search('-1', $this->filters->selectedDepartamentosIds) !== false) {
                // Para la opcion de "Seleccionar Todo"
                $this->filters->selectedDepartamentosIds = [];
                $this->filters->initSelectedDepartamentosIds();
            }

            $this->filters->listOfMunicipios = $this->filters->municipios();

            $this->filters->selectedMunicipiosIds = $this->filters->listOfMunicipios->pluck('ciudad_id')->toArray();

        }elseif(str_starts_with($property, 'filters.selectedMunicipiosIds')){

            if (!empty($this->filters->selectedMunicipiosIds) && array_search('-1', $this->filters->selectedMunicipiosIds) !== false) {
                // Para la opcion de "Seleccionar Todo"
                $this->filters->selectedMunicipiosIds = [];
                $this->filters->initSelectedMunicipiosIds();
            }

        }elseif(str_starts_with($property, 'filters.selectedGestoresIds')){

            if (!empty($this->filters->selectedGestoresIds) && array_search('-1', $this->filters->selectedGestoresIds) !== false) {
                // Para la opcion de "Seleccionar Todo"
                $this->filters->selectedGestoresIds = [];
                $this->filters->initSelectedGestoresIds();
            }

        }
    }
}
