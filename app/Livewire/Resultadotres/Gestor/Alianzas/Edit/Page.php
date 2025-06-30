<?php

namespace App\Livewire\Resultadotres\Gestor\Alianzas\Edit;

use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Alianza;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Livewire\Resultadotres\Gestor\Alianzas\Forms\AlianzaForm;
use App\Livewire\Resultadotres\Gestor\Alianzas\InitializeAlianzaForm;

class Page extends Component
{
    use WithFileUploads, InitializeAlianzaForm;

    public AlianzaForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    public Alianza $alianza;

    public $showSuccessIndicator = false;

    public $showValidarionErrorIndicator = false;

    public $ciudades;

    public $socioImplementador;

    public function mount()
    {
        abort_if(
            !auth()->user()->can('Editar Alianza'),
            403
        );
        
        $this->form->setAlianza($this->alianza);
        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
        $this->form->init();

        $currentDepto = Ciudad::find($this->alianza->ciudad_id, ['departamento_id'])->departamento_id;
        $this->form->setDepartamento($currentDepto);
        $this->form->setCiudades();
        $this->socioImplementador = $this->form->getSocioImplementador();

    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadotres.gestor.alianzas.alianza-form',
            array_merge($this->initializeProperties(), [
                'saveLabel' => 'Actualizar Alianza',
                'formMode'  => 'edit',
            ]))
        ->layoutData([
            //'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'alianza' => true,
            'resultadotres' => true,
        ]);
    }

    public function save() {

        $this->form->save();

        $this->showSuccessIndicator = true;

    }
}
