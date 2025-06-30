<?php

namespace App\Livewire\Resultadotres\Gestor\CostShares\Index;

use App\Livewire\Resultadotres\Gestor\CostShares\Forms\CostShareForm;
use App\Livewire\Resultadotres\Gestor\CostShares\InitializeForm;
use App\Livewire\Resultadotres\Gestor\Visualizador\Forms\ValidarForm;
use App\Livewire\Resultadotres\Gestor\Visualizador\Enums\Formularios;
use App\Models\Ciudad;
use App\Models\CostShare;
use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class Revisar extends Component
{
    use WithFileUploads, InitializeForm;

    public CostShareForm $form;

    public ValidarForm $validarForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public CostShare $costShare;

    public $showSuccessIndicator = false;

    public $showValidarionErrorIndicator = false;

    public $ciudades;

    public $socioImplementador;

    public function mount()
    {
        $this->form->setCostShare($this->costShare);
        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
        $this->form->init();

        $currentDepto = Ciudad::find($this->costShare->ciudad_id, ['departamento_id'])->departamento_id;
        $this->form->setDepartamento($currentDepto);
        $this->form->setCiudades();

        $this->socioImplementador = $this->getSocioImplementador();

        $this->form->readonly = true;

        $this->validarForm->init(Formularios::CostoCompartido);
    }
    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Ver Ficha R3'),
            403
        );
        
        return view('livewire.resultadotres.gestor.cost-shares.index.revisar',
        array_merge($this->initializeProperties(), [
            'saveLabel' => 'Actualizar Costo Compartido',
            'formMode'  => 'edit',
        ]))->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'resultadotres' => true,
        ]);
    }

    public function save() {

        $this->validarForm->save();

        $this->showSuccessIndicator = true;

    }
}
