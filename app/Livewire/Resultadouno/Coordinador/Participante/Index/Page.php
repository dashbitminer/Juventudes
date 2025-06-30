<?php

namespace App\Livewire\Resultadouno\Coordinador\Participante\Index;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Models\Proyecto;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;

class Page extends Component
{
    public Proyecto $proyecto;
    public Pais $pais;
    public Cohorte $cohorte;

    public Filters $filters;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $selectedGestoresAll;

    public function updated($propertyName, $value): void
    {
        if (
            $propertyName === "filters.status" ||
            $propertyName === "filters.range" ||
            str($propertyName)->startsWith('filters.selectedEstadosIds')
        ) {
            $this->dispatch('update-page');
        }elseif($propertyName == "selectedGestoresAll"){
            // dd($propertyName, $value);
            if(!$value){
                $this->filters->selectedGestoresIds = [];
            }else{
                $this->filters->resetGestoresIds();
            }
        }
    }

    #[On('refresh-component')]
    public function mount()
    {
        //$this->cohortePaisProyecto = new CohortePaisProyecto();

        $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
        ->where('proyecto_id', $this->proyecto->id)
        ->firstOrFail();

        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
                                                            ->where('pais_proyecto_id', $paisProyecto->id)
                                                            ->firstOrFail();


        $this->filters->proyecto = $this->proyecto;
        $this->filters->pais = $this->pais;
        $this->filters->cohorte = $this->cohorte;

        $this->filters->init($this->cohortePaisProyecto);

        $this->selectedGestoresAll = true;
    }

    #[Layout('layouts.table8xl')]
    public function render()
    {
        return view('livewire.resultadouno.coordinador.participante.index.page')->layoutData([
            'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
        ]);
    }
}
