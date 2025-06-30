<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Index;

use App\Livewire\Financiero\Mecla\Estipendios\Forms\EstipendioIndexForm;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\PaisProyecto;
use App\Models\Participante;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;

class Page extends Component
{

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public $socios;

    public CohortePaisProyecto $cohortePaisProyecto;

    public EstipendioIndexForm $form;

    public function mount(Pais $pais, Proyecto $proyecto, Cohorte $cohorte)
    {
        $this->pais = $pais;
        $this->proyecto = $proyecto;
        $this->cohorte = $cohorte;

        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->with("perfilesParticipante")
            ->firstOrFail();

        $this->socios = Participante::with(['gestor.socioImplementador'])
                            ->whereHas('cohorteParticipanteProyecto', function ($query)  {
                                $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
                            })
                            ->get()
                            ->pluck('gestor.socioImplementador')
                            ->unique('id')
                            ->values();

        $this->form->init($this->cohortePaisProyecto);



    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.financiero.mecla.estipendios.index.page')->layoutData([
            'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
        ]);
    }

    public function generar()
    {

        $this->form->save();

        sleep(1);

        $this->dispatch('estipendioCreated');

        //dd($this->form->selectedMes, $this->form->selectedAnio);
    }
}
