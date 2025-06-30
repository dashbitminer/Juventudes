<?php

namespace App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Edit;

use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Participante;
use Livewire\Attributes\Layout;
use App\Models\CohortePaisProyecto;
use App\Models\PracticaEmpleabilidad;
use App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Forms\EmpleabilidadForm;
use App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Traits\EmpleabilidadTrait;

class Page extends Component
{
    use EmpleabilidadTrait;

    public Proyecto $proyecto;

    public Pais $pais;

    public Participante $participante;

    public Cohorte $cohorte;

    public EmpleabilidadForm $form;

    public PracticaEmpleabilidad $practica;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $showSuccessIndicator = false;

    public $ciudades = [];

    public $titulo = 'Editar práctica para empleabilidad';
    // /pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/practicas-empleabilidad/{practica}/edit

    public $primerRegistro = false;

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

        $this->primerRegistro = !PracticaEmpleabilidad::where('cohorte_participante_proyecto_id', $participanteEnProyectoCohorte->id)
                ->where('id', '<', $this->practica->id)
                ->exists();

        $currentDepto = Ciudad::find($this->practica->ciudad_id, ['departamento_id'])->departamento_id;

        $this->form->init($this->pais, $this->proyecto, $this->participante, $this->cohorte, $this->cohortePaisProyecto, $this->primerRegistro);

        $this->form->setPractica($this->practica);

        $this->form->setDepartamento($currentDepto);

        $this->ciudades = Ciudad::where("departamento_id", $currentDepto)->pluck("nombre", "id");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.practicas-empleabilidad.create.page', $this->initializeProperties())
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

        // Redirect to the named route 'participantes.socioeconomico'
        // return redirect()->route('ficha.voluntariado.index', [
        //     'pais' => $this->pais->slug,
        //     'proyecto' => $this->proyecto->slug,
        // ]);
    }
}
