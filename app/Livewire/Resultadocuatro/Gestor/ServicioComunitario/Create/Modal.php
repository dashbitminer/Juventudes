<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Create;

use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Forms\ServicioComunitarioModal;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\InitForm;
use App\Models\Cohorte;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\ServicioComunitario;
use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{
    use InitForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public $openDrawer = false;

    public $showSuccessIndicatorModal = false;

    public $servicioComunitarioId;

    public ServicioComunitario $servicioComunitario;

    public ServicioComunitarioModal $form;

    public $historicos;

    public function mount()
    {
        $this->form->setCohorte($this->cohorte);
        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
    }

    public function save(){

        $this->form->save();
    
        sleep(1);
        $this->dispatch('refresh-servicios-comunitarios');

        $this->showSuccessIndicatorModal = true;

        $this->openDrawer = false;
    }

    public function render()
    {
        return view('livewire.resultadocuatro.gestor.servicio_comunitario.create.modal', $this->getData())
        ->layoutData([
            'pais' => $this->pais,
        ]);
    }

    #[On('openModal')]
    public function openModal($id)
    {
        $this->openDrawer = true;

        $this->servicioComunitario = ServicioComunitario::find($id);

        $this->historicos = $this->getHistoricoServicioComunitario($id);

        $this->form->readonly = $this->servicioComunitario->estado == Estados::Completado->value;

        $this->form->setServicioComunitario($this->servicioComunitario);
    }
}