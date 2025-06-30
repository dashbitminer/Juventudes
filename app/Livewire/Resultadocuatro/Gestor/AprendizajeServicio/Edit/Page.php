<?php

namespace App\Livewire\Resultadocuatro\Gestor\AprendizajeServicio\Edit;

use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Participante;
use Livewire\Attributes\Layout;
use App\Models\AprendizajeServicio;
use App\Livewire\Resultadocuatro\Gestor\AprendizajeServicio\Forms\AprendizajeForm;
use App\Livewire\Resultadocuatro\Gestor\AprendizajeServicio\Traits\AprendizajeTrait;

class Page extends Component
{
    use AprendizajeTrait;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;

    public AprendizajeForm $form;

    public AprendizajeServicio $id;

    public $showSuccessIndicator = false;

    public $ciudades = [];

    public $titulo = 'Aprendizaje de servicio';

    public $primerRegistro = false;

    public $cohortePaisProyecto;

    public function mount()
    {

        $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
        ->where('proyecto_id', $this->proyecto->id)
        ->firstOrFail();

        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->firstOrFail();

        $participanteEnProyectoCohorte = \App\Models\CohorteParticipanteProyecto::where('participante_id', $this->participante->id)
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->firstOrFail();

        $this->primerRegistro = !AprendizajeServicio::where('cohorte_participante_proyecto_id', $participanteEnProyectoCohorte->id)
                ->where('id', '<', $this->id->id)
                ->exists();

        $currentDepto = Ciudad::find($this->id->ciudad_id, ['departamento_id'])->departamento_id;

        $this->form->init($this->pais, $this->proyecto, $this->participante, $this->cohorte, $this->primerRegistro);
        $this->form->setAprendizajeServicio($this->id);
        $this->form->setDepartamento($currentDepto);
        $this->ciudades = Ciudad::where("departamento_id", $currentDepto)->pluck("nombre", "id");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.aprendizaje-servicio.create.page', $this->initializeProperties())
        ->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
            'resultadocuatro' => true,
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
