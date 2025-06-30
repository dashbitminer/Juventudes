<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos;

use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\PaisProyecto;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

class Page extends Component
{

    public Cohorte $cohorte;

    public Pais $pais;

    public Proyecto $proyecto;

    // public Filters $filters;

    public $paisProyecto;

    public $cohortePaisProyecto;


    public function mount()
    {
        // 1. Get the PaisProyecto model instance
        // $this->paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
        // ->where('proyecto_id', $this->proyecto->id)
        // ->firstOrFail();

        // // 2. Get the Cohorte pais proyecto model instance
        // $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::with('perfilesParticipante:id,nombre')
        // ->where('pais_proyecto_id', $this->paisProyecto->id)
        // ->where('cohorte_id', $this->cohorte->id)
        // ->firstOrFail();

        // //3. Filters
        // $this->filters->init($this->cohorte, $this->paisProyecto, $this->cohortePaisProyecto);
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadouno.gestor.participante.grupos.page')
        ->layoutData([
            'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'resultadouno' => true,
        ]);
    }


}
