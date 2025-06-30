<?php

namespace App\Livewire\Resultadotres\Gestor\CostShares\Create;

use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;
use App\Livewire\Resultadotres\Gestor\CostShares\Forms\CostShareForm;
use App\Livewire\Resultadotres\Gestor\CostShares\InitializeForm;
use App\Models\CostShare;
use Livewire\WithFileUploads;

class Page extends Component
{
    use WithFileUploads;

    use InitializeForm;

    public CostShareForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    public $showSuccessIndicator = false;

    public $socioImplementador;

    public function mount(): void {
        abort_if(
            !auth()->user()->can('Registrar Costo Compartido'),
            403
        );

        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
        $this->form->init();
        $this->socioImplementador = $this->getSocioImplementador();

    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadotres.gestor.cost-shares.cost-share-form',
            array_merge(
                $this->initializeProperties(), [
                    'costShare' => New CostShare(),
                    'saveLabel' => 'Crear Costo Compartido',
                    'formMode' => 'create'
                ]
            ))->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'resultadotres' => true,
            ]);
    }

    public function save(){
        
       $this->form->save(new CostShare());
       $this->showSuccessIndicator = true;

        sleep(1);

        return redirect()->route('cost-share.index', [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
        ]);
    }
}
