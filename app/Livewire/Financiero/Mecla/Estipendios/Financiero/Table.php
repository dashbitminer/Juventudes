<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Financiero;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Renderless;
use Illuminate\Support\Facades\Storage;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Cohorte;
use App\Models\PaisProyecto;
use App\Models\CohortePaisProyecto;
use App\Models\Estipendio;
use App\Livewire\Financiero\Mecla\Estipendios\Financiero\Filters;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    #[Reactive]
    public Filters $filters;

    #[Validate('required', message: 'Seleccione uno o más participantes de la lista principal')]
    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $lista = [];

    public $cohortePaisProyecto;

    public $paisProyecto;

    public $perPage = 10;

    public $openDrawer = false;

    public $modo;

    public $showSuccessIndicator = false;

    public $selectedPais;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public $openEditDrawer = false;

    #[On('updateSelectedCohortePaisProyecto')]
    public function mount($cohortePaisProyecto = null, $paisProyecto = null, $selectedPais = null)
    {
        $this->cohortePaisProyecto = CohortePaisProyecto::with(['cohorte'])->find($cohortePaisProyecto);

        $this->paisProyecto = PaisProyecto::with(['pais', 'proyecto:id,nombre'])->find($paisProyecto);

        $this->pais = $this->paisProyecto->pais;
        $this->proyecto = Proyecto::find($this->paisProyecto->proyecto->id);
        $this->cohorte = Cohorte::find($this->cohortePaisProyecto->cohorte_id);
    }

    public function render()
    {
        if ($this->cohortePaisProyecto) {

            $query = Estipendio::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->active()
                ->with('socioImplementador', 'perfilParticipante')
                ->where('is_closed', 1)
                ->groupBy('cohorte_pais_proyecto_perfil_id');

            $query = $this->applySearch($query);

            $query = $this->applySorting($query);

            // $query = $this->filters->apply($query);

            $estipendios = $query->paginate($this->perPage);

        } else {
            $estipendios = Estipendio::where("created_by", -1)->paginate($this->perPage);
        }

        $this->participanteIdsOnPage = $estipendios->map(fn($grupo) => (string) $grupo->id)->toArray();

        return view('livewire.financiero.mecla.estipendios.financiero.table', [
            'estipendiosGrouped' => $estipendios,
        ]);
    }
}
