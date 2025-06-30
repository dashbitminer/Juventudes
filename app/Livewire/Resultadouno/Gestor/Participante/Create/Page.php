<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Create;

use Throwable;
use App\Models\Pais;
use App\Models\Etnia;
use App\Models\Ciudad;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\ApoyoHijo;
use App\Models\Parentesco;
use App\Models\EstadoCivil;
use App\Models\Discapacidad;
use App\Models\PaisProyecto;
use App\Models\Participante;
use App\Models\ProyectoVida;
use App\Models\SeccionGrado;
use App\Models\TurnoEstudio;
use App\Models\NivelAcademico;
use App\Models\NivelEducativo;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use App\Models\CohorteSocioUser;
use App\Models\PaisProyectoSocio;
use Livewire\Attributes\Validate;
use App\Models\GrupoPerteneciente;
use Illuminate\Support\Facades\DB;
use App\Models\ComparteResponsabilidadHijo;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Livewire\Resultadouno\Gestor\Participante\Forms\ParticipanteForm;
use App\Livewire\Resultadouno\Gestor\Participante\InitializeForm;
use App\Models\CohortePaisProyecto;

class Page extends Component
{

    use WithFileUploads, InitializeForm;

    public Proyecto $proyecto;

    public Pais $pais;

    public Cohorte $cohorte;

    public ParticipanteForm $form;

    public $showSuccessIndicator = false;

    public $showValidationErrorIndicator = false;

    public $ciudades = [];

    public $ciudadesNacimiento = [];

    public $formMode = 'create';

    public $cohortePaisProyecto;


    public function mount() {

        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto->load('perfilesParticipante:id,nombre');

        $this->form->participante = new Participante();

        $this->form->init($this->cohorte, $this->proyecto, $this->pais, $this->cohortePaisProyecto);

    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadouno.gestor.participante.registro-form',
            array_merge($this->initializeProperties(), [
                'participante' => New Participante(),
                'saveLabel' => 'Crear Participante',
                'formMode' => $this->formMode,
                'cohortePaisProyecto' => $this->cohortePaisProyecto,
            ]))
            ->layoutData([
                'cohorte' => $this->cohorte,
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'resultadouno' => true,
            ]);
    }


    public function save() {

        $this->form->update(new Participante());

        $this->showSuccessIndicator = true;

        sleep(1);

         // Redirect to the named route 'participantes.socioeconomico'
         return redirect()->route('participantes.socioeconomico', [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
            'cohorte' => $this->cohorte->slug,
            'participante' => $this->form->participante->slug,
        ]);

    }



}
