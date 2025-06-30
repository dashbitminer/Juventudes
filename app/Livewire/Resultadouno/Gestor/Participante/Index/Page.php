<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Index;

use App\Models\Pais;
use App\Models\Estado;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\DB;
use App\Models\CohortePaisProyecto;

class Page extends Component
{
    public Proyecto $proyecto;

    public Pais $pais;

    public Cohorte $cohorte;

    public CohortePaisProyecto $cohortePaisProyecto;

    public Filters $filters;


    public function updated($propertyName, $value): void
    {
        if (
            $propertyName === "filters.status" ||
            $propertyName === "filters.range" ||
            str($propertyName)->startsWith('filters.selectedEstadosIds')
        ) {
            $this->dispatch('update-page');
        }
    }

    #[On('refresh-component')]
    public function mount()
    {
        // 1. Get the PaisProyecto model instance
        $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
        ->where('proyecto_id', $this->proyecto->id)
        ->firstOrFail();

        // 2. Get the Cohorte pais proyecto model instance
        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::where('pais_proyecto_id', $paisProyecto->id)
        ->where('cohorte_id', $this->cohorte->id)
        ->firstOrFail();

         $this->filters->init($this->cohortePaisProyecto);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadouno.gestor.participante.index.page')
        ->layoutData([
            'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'resultadouno' => true,
        ]);
    }

    public function validarSelected(){
        dd('Dendekeleneger');
    }

}
