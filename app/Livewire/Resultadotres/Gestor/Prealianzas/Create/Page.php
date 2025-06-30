<?php

namespace App\Livewire\Resultadotres\Gestor\Prealianzas\Create;

use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\PreAlianza;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Livewire\Resultadotres\Gestor\Prealianzas\Forms\PrealianzaForm;
use App\Livewire\Resultadotres\Gestor\Prealianzas\InitializePreAlianzaForm;

class Page extends Component
{

    use WithFileUploads;

    use InitializePreAlianzaForm;

    public PrealianzaForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    public $showSuccessIndicator = false;

    public $socioImplementador;

    public function mount() {
        abort_if(
            !auth()->user()->can('Registrar Pre Alianza'),
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

        return view('livewire.resultadotres.gestor.prealianzas.prealianza-form',
            array_merge($this->initializeProperties(), [
                'alianza'   => New \App\Models\PreAlianza(),
                'saveLabel' => 'CREAR PREALIANZA',
                'formMode'  => 'create',
            ]))
            ->layoutData([
                //'cohorte' => $this->cohorte,
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'prealianza' => true,
                'resultadotres' => true,
            ]);
    }

    public function save() {

        $this->form->save(new PreAlianza());

        $this->showSuccessIndicator = true;

        sleep(1);

        // // Redirect to the named route 'participantes.socioeconomico'
        return redirect()->route('pre.alianzas.index', [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
        ]);

    }
}
