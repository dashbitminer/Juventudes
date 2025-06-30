<?php

namespace App\Livewire\Resultadotres\Gestor\Apalancamientos\Edit;

use App\Livewire\Resultadotres\Gestor\Apalancamientos\Forms\ApalancamientoForm;
use App\Livewire\Resultadotres\Gestor\Apalancamientos\InitializeApalancamientoForm;
use App\Models\Apalancamiento;
use App\Models\Ciudad;
use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class Page extends Component
{
    use WithFileUploads, InitializeApalancamientoForm;

    public ApalancamientoForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    public Apalancamiento $apalancamiento;

    public $showSuccessIndicator = false;

    public $showValidarionErrorIndicator = false;

    public $ciudades;

    public $socioImplementador;

    public function mount()
    {
        abort_if(
            !auth()->user()->can('Editar Apalancamiento'),
            403
        );
        
        $this->form->setApalancamiento($this->apalancamiento);
        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
        $this->form->init();

        $currentDepto = Ciudad::find($this->apalancamiento->ciudad_id, ['departamento_id'])->departamento_id;
        $this->form->setDepartamento($currentDepto);
        $this->form->setCiudades();

        $this->socioImplementador = $this->form->getSocioImplementador();
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadotres.gestor.apalancamientos.apalancamiento-form',
        array_merge($this->initializeProperties(), [
            'saveLabel' => 'Actualizar Apalancamiento',
            'formMode'  => 'edit',
        ]))->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'apalancamiento' => true,
            'resultadotres' => true,
        ]);
    }

    public function save() {

        $this->form->save();

        $this->showSuccessIndicator = true;

    }
}
