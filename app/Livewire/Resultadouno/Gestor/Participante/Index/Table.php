<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Index;

use App\Models\Pais;
use Livewire\Livewire;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use App\Models\Participante;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Renderless;
use App\Exports\ParticipantesExport;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Sortable;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Searchable;
use App\Models\CohortePaisProyecto;

// #[Lazy]
class Table extends Component
{

    use WithPagination, Searchable, Sortable;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Pais $pais;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $perPage = 10;

    // public $search = "";

    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $selectedParticipante;

    public $openDrawer = false;




    #[Reactive]
    public Filters $filters;


    #[On('update-page')]
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[Renderless]
    public function export()
    {
        return (new ParticipantesExport($this->selectedParticipanteIds, $this->cohorte, $this->pais, $this->proyecto))->download('participantes.xlsx');
    }


    public function mount($cohorte, $pais, $proyecto)
    {
        // 1. Get the PaisProyecto model instance
        $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        // 2. Get the Cohorte pais proyecto model instance
        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::where('pais_proyecto_id', $paisProyecto->id)
        ->where('cohorte_id', $this->cohorte->id)
        ->firstOrFail();
    }

    public function render()
    {
        $query = Participante::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'lastEstado.estado_registro:id,nombre,color,icon',
            'socioeconomico',
        ])
        ->whereHas('cohortePaisProyecto', function($query) {
            $query->where('cohorte_pais_proyecto.id', $this->cohortePaisProyecto->id)
                ->whereNotNull('cohorte_participante_proyecto.active_at');
        })
        ->misRegistros()
        ->select([
            "id",
            "slug",
            "email",
            "primer_nombre",
            "segundo_nombre",
            "tercer_nombre",
            "primer_apellido",
            "segundo_apellido",
            "tercer_apellido",
            "ciudad_id",
            "created_at",
            "documento_identidad",
            "fecha_nacimiento",
            "sexo",
            "telefono",
            "pdf",
        ]);


        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        //$query = $this->filters->apply($query);

        $participantes = $query->paginate($this->perPage);

        $this->participanteIdsOnPage = $participantes->map(fn ($participante) => (string) $participante->id)->toArray();

        return view('livewire.resultadouno.gestor.participante.index.table', [
            'participantes' => $participantes
        ]);
    }

    public function selectParticipante(Participante $participante)
    {

        $this->selectedParticipante = $participante;

        $this->selectedParticipante->load([
            'estadosregistrosparticipantes:id,participante_id,estado_registro_id,created_at,created_by,comentario',
            'estadosregistrosparticipantes.estado_registro:id,nombre,color,icon,created_by',
            'estadosregistrosparticipantes.creator'
        ]);

        $this->openDrawer = true;

    }

    // public function placeholder()
    // {
    //     return view('livewire.gestor.participante.index.table-placeholder');
    // }


    public function deleteSelected()
    {
        Participante::whereIn('id', $this->selectedParticipanteIds)->each(function ($participante) {

            $participante->load('lastEstado.estado_registro:id,nombre,color,icon');
            if($participante->lastEstado->estado_registro_id == \App\Models\EstadoRegistro::DOCUMENTACION_PENDIENTE){
                $this->delete($participante);
            }

        });

        $this->selectedParticipanteIds = [];

        $this->showSuccessIndicator = true;
    }

    public function delete(Participante $participante)
    {
       // $this->authorize('update', $order);

        $participante->delete();

        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-component');
    }


}
