<?php

namespace App\Livewire\Resultadotres\Gestor\Prealianzas\Edit;

use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Livewire\Resultadotres\Gestor\Prealianzas\Forms\PrealianzaForm;
use App\Livewire\Resultadotres\Gestor\Prealianzas\InitializePreAlianzaForm;
use App\Models\PreAlianza;

class Page extends Component
{
    use WithFileUploads, InitializePreAlianzaForm;

    public PrealianzaForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    public PreAlianza $prealianza;

    public $showSuccessIndicator = false;

    public $showValidarionErrorIndicator = false;

    public $ciudades;

    public $socioImplementador;


    public function mount()
    {
        abort_if(
            !auth()->user()->can('Editar Pre Alianza'),
            403
        );

        $this->form->setPreAlianza($this->prealianza);
        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);
        $this->socioImplementador = $this->form->getSocioImplementador();

        $this->form->init();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadotres.gestor.prealianzas.prealianza-form',
            array_merge($this->initializeProperties(), [
                'saveLabel' => 'ACTUALIZAR PREALIANZA',
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

        sleep(1);

        // // Redirect to the named route 'participantes.socioeconomico'
        return redirect()->route('pre.alianzas.index', [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
        ]);

    }
}
