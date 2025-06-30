<?php

namespace App\Livewire\Resultadocuatro\Gestor\Formacion\Edit;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Participante;
use Livewire\WithFileUploads;
use App\Models\FichaFormacion;
use Livewire\Attributes\Layout;
use App\Livewire\Resultadocuatro\Gestor\Formacion\Forms\FormacionForm;
use App\Livewire\Resultadocuatro\Gestor\Formacion\Traits\FormacionTrait;

class Page extends Component
{
    use FormacionTrait;
    use WithFileUploads;

    public Pais $pais;

    public Proyecto $proyecto;

    public Participante $participante;

    public Cohorte $cohorte;

    public FormacionForm $form;

    public FichaFormacion $id;

    public $showSuccessIndicator = false;

    public $titulo = 'Ficha de formación';

    public function mount()
    {
        $this->form->init($this->pais, $this->proyecto, $this->participante, $this->cohorte);
        $this->form->setFichaFormacion($this->id);
        $this->form->mode = 'edit';
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.formacion.formacion-form', $this->initializeProperties())
        ->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
            'resultadocuatro' => true
        ]);
    }

    public function save()
    {
        $this->form->save();

        $this->showSuccessIndicator = true;

        sleep(1);

        return redirect()->route('fichas.index', [
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
        ]);
    }
}
