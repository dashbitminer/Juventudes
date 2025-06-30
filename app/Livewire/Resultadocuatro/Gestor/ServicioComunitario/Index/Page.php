<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Index;

use App\Models\Cohorte;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Pais;
use App\Models\Proyecto;

class Page extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public $paisProyecto;

    public $cohortePaisProyecto;


    public function mount(Pais $pais, Proyecto $proyecto, Cohorte $cohorte)
    {
        $this->pais = $pais;
        $this->proyecto = $proyecto;
        $this->cohorte = $cohorte;

        // 1. Get the PaisProyecto model instance
        $this->paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        // 2. Get the Cohorte pais proyecto model instance
        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::where('pais_proyecto_id', $this->paisProyecto->id)
                ->where('cohorte_id', $this->cohorte->id)
                ->firstOrFail();

    }


    #[Layout('layouts.app')]
    public function render()
    {

        abort_if(
            !auth()->user()->can('Listado servicios comunitarios'),
            403
        );


        return view('livewire.resultadocuatro.gestor.servicio_comunitario.index.page')
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte,
                'resultadocuatro' => true,
            ]);
    }
}
