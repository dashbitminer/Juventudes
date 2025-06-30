<?php
namespace App\Livewire\Admin\Cohortes\Participantes\Edit;

use App\Models\CohortePaisProyecto;
use App\Models\Participante;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

use function Laravel\Prompts\clear;

class ReasignarGestor extends Component
{
    const GESTOR = 2;

    public $openDrawer = false;

    public $showSuccessIndicator = false;

    public $showSuccessIndicatorModal = false;

   public Participante $participante;

   public  CohortePaisProyecto $cohortePaisProyecto;

   public $gestores = [];

   public $gestor;

   public $gestor_id;

    public function mount($cohortePaisProyecto)
    {
        $this->cohortePaisProyecto = $cohortePaisProyecto;
    }
    

    public function render()
    {
        return view('livewire.admin.cohortes.participantes.edit.reasignar-gestor');
    }

    #[On('openParticipantes')]
    public function openParticipantes($participanteID){
        $this->openDrawer = true;
        
        $this->setParticipante($participanteID);
        $this->gestores = $this->getGestores();
    }


    public function setParticipante($participanteID)
    {
        $this->participante = Participante::find($participanteID);
     }


    public function save()
    {

        $gestor = User::where('username', $this->gestor)->first();
        $this->gestor_id = $gestor->id;

        $this->validate([
            'gestor_id' => 'required|exists:users,id',
        ]);

        $this->participante->update([
            'gestor_id' => $this->gestor_id,
        ]);

        $this->reset(['gestor_id', 'gestor', 'participante']);

        $this->dispatch('refresh-participantes');

        $this->showSuccessIndicator = true;
        $this->openDrawer = false;
        $this->showSuccessIndicatorModal = true;

    }

    public function getGestores()
    {
        return User::with('roles')
            ->whereHas('cohorteProyectoUser', function ($query) {
                $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
            })
            ->whereHas('roles', function ($q) {
                $q->whereIn('roles.id', [self::GESTOR]);
            })
            ->where('id', '!=', $this->participante->gestor_id)
            ->pluck('username', 'id')
            ->toArray();
    }
}