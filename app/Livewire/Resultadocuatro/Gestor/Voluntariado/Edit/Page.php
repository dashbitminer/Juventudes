<?php

namespace App\Livewire\Resultadocuatro\Gestor\Voluntariado\Edit;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Participante;
use Livewire\WithFileUploads;
use App\Models\FichaVoluntario;
use Livewire\Attributes\Layout;
use App\Models\CohortePaisProyecto;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Forms\VoluntarioForm;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Traits\VoluntariadoTrait;

class Page extends Component
{

    use VoluntariadoTrait;
    use WithFileUploads;

    public Proyecto $proyecto;

    public Pais $pais;

    public Participante $participante;

    public Cohorte $cohorte;

    public FichaVoluntario $voluntario;

    public CohortePaisProyecto $cohortePaisProyecto;

    public VoluntarioForm $form;

    public $showSuccessIndicator = false;

    public $openDrawer = false;

    public $titulo = 'Ficha Voluntariado';

    public $mode = 'edit';



    public function mount() : void
    {
        $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->firstOrFail();

        $this->form->init($this->pais, $this->proyecto, $this->participante, $this->cohorte, $this->cohortePaisProyecto);

        $this->form->setFichaVoluntario($this->voluntario);

        $this->form->setMode('edit');

    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.voluntariado.voluntario-form', $this->initializeProperties())
        ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte,
                'resultadocuatro' => true
            ]);
    }

    public function save()
    {
        $this->form->save();

        $this->showSuccessIndicator = true;

        sleep(1);

        return redirect()->route('fichas.index', [
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
        ]);
    }
}
