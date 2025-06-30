<?php

namespace App\Livewire\Resultadotres\Gestor\Alianzas\Create;

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

    use WithFileUploads;

    use InitializeAlianzaForm;

    public AlianzaForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    public $showSuccessIndicator = false;

    public $socioImplementador;

    public function mount() {
        
        abort_if(
            !auth()->user()->can('Registrar Alianza'),
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

        return view('livewire.resultadotres.gestor.alianzas.alianza-form',
            array_merge($this->initializeProperties(), [
                'alianza'   => New \App\Models\Alianza(),
                'saveLabel' => 'Crear Alianza',
                'formMode'  => 'create',
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

        $this->form->save(new Alianza());

        $this->showSuccessIndicator = true;

        sleep(1);

        // Redirect to the named route 'participantes.socioeconomico'
        return redirect()->route('alianzas.index', [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
        ]);

    }





}
