<?php

namespace App\Livewire\Resultadotres\Gestor\Apalancamientos\Create;

use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;
use App\Livewire\Resultadotres\Gestor\Apalancamientos\Forms\ApalancamientoForm;
use App\Livewire\Resultadotres\Gestor\Apalancamientos\InitializeApalancamientoForm;
use App\Models\Apalancamiento;
use Livewire\WithFileUploads;

class Page extends Component
{
    use WithFileUploads;
    use InitializeApalancamientoForm;

    public ApalancamientoForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    public $showSuccessIndicator = false;

    public $socioImplementador;

    public function mount(): void {
        abort_if(
            !auth()->user()->can('Registrar Apalancamiento'),
            403
        );

        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
        $this->form->init();

        $this->socioImplementador = $this->form->getSocioImplementador();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadotres.gestor.apalancamientos.apalancamiento-form',
            array_merge(
                $this->initializeProperties(), [
                    'apalancamiento' => New Apalancamiento(),
                    'saveLabel' => 'Crear Apalancamiento',
                    'formMode' => 'create'
                ]
            ))->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'apalancamiento' => true,
                'alianza' => true,
                'resultadotres' => true,
            ]);
    }

    public function save(){

       $this->form->save(new Apalancamiento());
       $this->showSuccessIndicator = true;

        sleep(1);

        return redirect()->route('apalancamientos.index', [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
        ]);
    }
}
