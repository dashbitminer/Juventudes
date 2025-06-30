<?php

namespace App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Create;

use App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Forms\EmpleabilidadForm;
use App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Traits\EmpleabilidadTrait;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\CohorteParticipanteProyecto;
use App\Models\Pais;
use App\Models\PaisProyecto;
use App\Models\Participante;
use App\Models\PracticaEmpleabilidad;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Page extends Component
{
    use EmpleabilidadTrait;

    public Proyecto $proyecto;

    public Pais $pais;

    public Participante $participante;

    public Cohorte $cohorte;

    public CohortePaisProyecto $cohortePaisProyecto;

    public EmpleabilidadForm $form;

    public $showSuccessIndicator = false;

    public $ciudades = [];

    public $titulo = 'Ficha práctica para empleabilidad';

    public $primerRegistro = false;


    public function mount()
    {
        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->firstOrFail();

        $participanteEnProyectoCohorte = CohorteParticipanteProyecto::where('participante_id', $this->participante->id)
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->firstOrFail();

        if (! PracticaEmpleabilidad::where('cohorte_participante_proyecto_id', $participanteEnProyectoCohorte->id)->exists() ) {
            $this->primerRegistro = true;
        }

        $this->form->init($this->pais, $this->proyecto, $this->participante, $this->cohorte, $this->cohortePaisProyecto, $this->primerRegistro);


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
        $this->form->save(new PracticaEmpleabilidad());

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
