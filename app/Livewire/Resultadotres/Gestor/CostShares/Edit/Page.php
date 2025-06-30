<?php

namespace App\Livewire\Resultadotres\Gestor\CostShares\Edit;

use App\Livewire\Resultadotres\Gestor\CostShares\Forms\CostShareForm;
use App\Livewire\Resultadotres\Gestor\CostShares\InitializeForm;
use App\Models\Apalancamiento;
use App\Models\Ciudad;
use App\Models\CostShare;
use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class Page extends Component
{
    use WithFileUploads, InitializeForm;

    public CostShareForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    public CostShare $costShare;

    public $showSuccessIndicator = false;

    public $showValidarionErrorIndicator = false;

    public $ciudades;

    public $socioImplementador;

    public function mount()
    {
        abort_if(
            !auth()->user()->can('Editar Costo Compartido'),
            403
        );

        $this->form->setCostShare($this->costShare);
        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
        $this->form->init();

        $currentDepto = Ciudad::find($this->costShare->ciudad_id, ['departamento_id'])->departamento_id;
        $this->form->setDepartamento($currentDepto);
        $this->form->setCiudades();

        $this->socioImplementador = $this->getSocioImplementador();
    }
    #[Layout('layouts.app')]
    public function render()
    {
        
        return view('livewire.resultadotres.gestor.cost-shares.cost-share-form',
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

        $this->form->save($this->costShare);

        $this->showSuccessIndicator = true;

        sleep(1);

        return redirect()->route('cost-share.index', [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
        ]);

    }
}
