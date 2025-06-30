<?php

namespace App\Livewire\Resultadotres\Gestor\Alianzas\Index;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Alianza;
use App\Models\Proyecto;
use App\Livewire\Resultadotres\Gestor\Alianzas\Forms\AlianzaForm;
use App\Livewire\Resultadotres\Gestor\Alianzas\InitializeAlianzaForm;
use App\Livewire\Resultadotres\Gestor\Visualizador\Enums\Formularios;
use App\Livewire\Resultadotres\Gestor\Visualizador\Forms\ValidarForm;

class Revisar extends Component
{
    use InitializeAlianzaForm;

    public AlianzaForm $form;

    public ValidarForm $validarForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public Alianza $alianza;

    public $showSuccessIndicator = false;

    public $showValidarionErrorIndicator = false;

    public $ciudades;

    public $disabled = true;

    public function mount()
    {
        $this->form->setAlianza($this->alianza);
        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
        $this->form->init();

        $currentDepto = Ciudad::find($this->alianza->ciudad_id, ['departamento_id'])->departamento_id;
        $this->form->setDepartamento($currentDepto);
        $this->form->setCiudades();

        $this->form->readonly = true;

        $this->validarForm->init(Formularios::Alianzas);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Ver Ficha R3'),
            403
        );
        
        return view('livewire.resultadotres.gestor.alianzas.index.revisar',
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

        $this->validarForm->save();

        $this->showSuccessIndicator = true;

    }
}