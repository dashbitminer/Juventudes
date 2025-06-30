<?php

namespace App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Create;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Cohorte;
use App\Models\Participante;
use App\Models\FichaEmprendimiento;
use App\Livewire\Resultadocuatro\Gestor\Emprendimiento\InitTrait;
use App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Forms\EmprendimientoForm;

class Page extends Component
{
    use WithFileUploads, InitTrait;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;

    public EmprendimientoForm $form;

    public $showSuccessIndicator = false;

    public $titulo = 'Ficha de Emprendimiento';

    public function mount(?FichaEmprendimiento $emprendimiento)
    {
        $this->form->init($this->pais, $this->participante);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.emprendimiento.create.page', $this->getData())
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
