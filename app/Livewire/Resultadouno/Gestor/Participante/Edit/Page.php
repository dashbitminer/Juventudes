<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Edit;

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
use Livewire\Attributes\Layout;
use App\Models\CohorteSocioUser;
use App\Models\PaisProyectoSocio;
use App\Models\GrupoPerteneciente;
use App\Models\CohortePaisProyecto;
use App\Models\ComparteResponsabilidadHijo;
use Livewire\Features\SupportFormObjects\Form;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Livewire\Resultadouno\Gestor\Participante\InitializeForm;
use App\Livewire\Resultadouno\Gestor\Participante\Forms\ParticipanteForm;

class Page extends Component
{
    use WithFileUploads, InitializeForm;

    public Participante $participante;

    public ParticipanteForm $form;

    public Cohorte $cohorte;

    public Proyecto $proyecto;

    public Pais $pais;

    public $ciudades;

    public $ciudadesNacimiento;

    public $showSuccessIndicator = false;

    public $showValidarionErrorIndicator = false;

    public $formMode = 'edit';

    public $cohortePaisProyecto;

    public function mount()
    {

        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
        ->where('proyecto_id', $this->proyecto->id)
        ->firstOrFail();

        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto->load('perfilesParticipante:id,nombre');


        $this->form->init($this->cohorte, $this->proyecto, $this->pais, $this->cohortePaisProyecto);

        $this->form->setParticipante($this->participante);

        if ($this->participante->ciudad_id) {

            $currentDepto = Ciudad::find($this->participante->ciudad_id, ['departamento_id'])->departamento_id;

            $this->form->setDepartamento($currentDepto);

            $this->ciudades = Ciudad::where("departamento_id", $currentDepto)->pluck("nombre", "id");
        }

        if ($this->participante->nacionalidad == 1) {

            $currentDeptoNacimiento = Ciudad::find($this->participante->municipio_nacimiento_id, ['departamento_id'])->departamento_id;

            $this->ciudadesNacimiento = Ciudad::where("departamento_id", $currentDeptoNacimiento)->pluck("nombre", "id");

            $this->form->setDepartamentoNacimiento($currentDeptoNacimiento);
        }
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadouno.gestor.participante.registro-form', array_merge(
            $this->initializeProperties(),
            [
                'saveLabel' => 'Editar Participante',
                'formMode' => $this->formMode,
                'cohortePaisProyecto' => $this->cohortePaisProyecto,
            ]
        ))
            ->layoutData([
                'cohorte' => $this->cohorte,
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'resultadouno' => true,
            ]);
    }



    public function save()
    {
        $this->form->update();

        $this->showSuccessIndicator = true;

         usleep(3000000);

         // Redirect to the named route 'participantes'
         return redirect()->route('participantes', [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
            'cohorte' => $this->cohorte->slug,
        ]);


        //return redirect()->route('participantes');

    }
}
