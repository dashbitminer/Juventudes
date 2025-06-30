<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Create;

use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Forms\ServicioComunitarioGrupoForm;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\InitForm;
use App\Models\Cohorte;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\ServicioComunitario;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalParticipante extends Component
{
    use InitForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public $openDrawer = false;

    public $showSuccessIndicatorModal = false;

    public $servicioComunitarioId;

    public ServicioComunitario $servicioComunitario;

    public ServicioComunitarioGrupoForm $form;

    public $selectedGrupo;

    public $selectedParticipantes = [];

    public $socioImplementadorId;

    public $readonly = false;

    public function mount()
    {
        $this->form->setPais($this->pais);
    }

    #[On('refresh-modal-participantes')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.servicio_comunitario.create.modal-participante', 
            $this->getParticipantesData()
        )
        ->layoutData([
            'pais' => $this->pais,
        ]);
    }

    public function updatedSelectedGrupo($value)
    {
        $this->selectedParticipantes = [];
        $grupo_id = is_array($value) ? (int) $value['value'] : (int) $value;
        $this->form->grupo = $grupo_id;
        
        $this->form->setParticipantes($grupo_id);
      //  dd($this->form->participantes);
    }

    public function removeParticipante($participante_id){
        $this->form->deleteParticipante($participante_id);
        $this->form->setParticipantesIncluidos();
        $this->form->setParticipantes($this->form->grupo);
        $this->dispatch('refresh-modal-participantes');
    }

    public function save()
    {
        $this->form->save( $this->selectedParticipantes );
        $this->form->setParticipantesIncluidos();
        $this->form->setParticipantes($this->form->grupo);
        $this->dispatch('refresh-modal-participantes');
    }

    #[On('openModalParticipante')]
    public function openModalParticipante($id)
    {
        $this->servicioComunitario = ServicioComunitario::find($id);

        $this->socioImplementadorId = $this->servicioComunitario->socio_implementador_id;

        $this->form->servicioComunitario = $this->servicioComunitario;

        if($this->servicioComunitario->estado == Estados::Completado->value){
          //  $this->readonly = true;
        }

        $this->form->init();
        $this->form->setParticipantesIncluidos();

        $this->selectedGrupo = [];

        $this->dispatch('refresh-modal-participantes');

        $this->openDrawer = true;
    }
}