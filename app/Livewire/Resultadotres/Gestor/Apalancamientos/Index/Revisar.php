<?php

namespace App\Livewire\Resultadotres\Gestor\Apalancamientos\Index;

use App\Livewire\Resultadotres\Gestor\Apalancamientos\Forms\ApalancamientoForm;
use App\Livewire\Resultadotres\Gestor\Apalancamientos\InitializeApalancamientoForm;
use App\Livewire\Resultadotres\Gestor\Visualizador\Forms\ValidarForm;
use App\Livewire\Resultadotres\Gestor\Visualizador\Enums\Formularios;
use App\Models\Apalancamiento;
use App\Models\Ciudad;
use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class Revisar extends Component
{
    use WithFileUploads, InitializeApalancamientoForm;

    public ApalancamientoForm $form;

    public ValidarForm $validarForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public Apalancamiento $apalancamiento;

    public $showSuccessIndicator = false;

    public $showValidarionErrorIndicator = false;

    public $ciudades;

    public function mount()
    {
        //dd($this->alianza);
        $this->form->setApalancamiento($this->apalancamiento);
        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
        $this->form->init();

        $currentDepto = Ciudad::find($this->apalancamiento->ciudad_id, ['departamento_id'])->departamento_id;
        $this->form->setDepartamento($currentDepto);
        $this->form->setCiudades();

        $this->form->readonly = true;

        $this->validarForm->init(Formularios::Apalancamiento);
    }
    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Ver Ficha R3'),
            403
        );
        
        return view('livewire.resultadotres.gestor.apalancamientos.index.revisar',
        array_merge($this->initializeProperties(), [
            'saveLabel' => 'Actualizar Apalancamiento',
            'formMode'  => 'edit',
        ]))->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'apalancamiento' => true,
            'alianza' => true,
            'resultadotres' => true,
        ]);
    }

    public function save() {

        $this->validarForm->save();

        $this->showSuccessIndicator = true;

    }
}
