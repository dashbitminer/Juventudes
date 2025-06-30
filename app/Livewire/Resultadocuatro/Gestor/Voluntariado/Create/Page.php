<?php

namespace App\Livewire\Resultadocuatro\Gestor\Voluntariado\Create;

use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use App\Models\Participante;
use Livewire\WithFileUploads;
use App\Models\FichaVoluntario;
use Livewire\Attributes\Layout;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Forms\VoluntarioForm;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Traits\VoluntariadoTrait;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;

class Page extends Component
{

    use VoluntariadoTrait;
    use WithFileUploads;

    public Proyecto $proyecto;

    public Pais $pais;

    public Cohorte $cohorte;

    public Participante $participante;

    public CohortePaisProyecto $cohortePaisProyecto;

    public VoluntarioForm $form;

    public $showSuccessIndicator = false;

    public $openDrawer = false;

    public $titulo = 'Ficha Voluntariado';

    public $mode = 'create';



    public function mount()
    {
        $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
        ->where('proyecto_id', $this->proyecto->id)
        ->firstOrFail();

        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->firstOrFail();

        $this->form->init($this->pais, $this->proyecto, $this->participante, $this->cohorte, $this->cohortePaisProyecto);
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

    // #[On('nuevo-directorio')]
    // public function newDirectorio($directorio)
    // {
    //     //dd($directorio);
    //     $this->form->directorioSelected = $directorio["id"];
    // }

    public function save()
    {
        $this->form->save(new FichaVoluntario());

        $this->showSuccessIndicator = true;

        sleep(1);

        return redirect()->route('fichas.index', [
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
        ]);
    }
}
