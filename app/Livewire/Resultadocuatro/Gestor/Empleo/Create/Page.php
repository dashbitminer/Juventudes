<?php

namespace App\Livewire\Resultadocuatro\Gestor\Empleo\Create;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Cohorte;
use App\Models\Participante;
use App\Models\FichaEmpleo;
use App\Livewire\Resultadocuatro\Gestor\Empleo\initForm;
use App\Livewire\Resultadocuatro\Gestor\Empleo\Forms\EmpleoForm;

class Page extends Component
{
    use WithFileUploads, initForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;

    public EmpleoForm $form;

    public $showSuccessIndicator = false;

    public $titulo = 'Ficha de Empleo';

    public function mount(?FichaEmpleo $empleo)
    {
        $this->form->init($this->pais, $this->participante);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.empleo.create.page', $this->getData())
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
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
            'cohorte' => $this->cohorte,
        ]);
    }
}
