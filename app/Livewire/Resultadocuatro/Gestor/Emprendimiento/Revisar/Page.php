<?php
namespace App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Revisar;

use App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Edit\Page as EditPage;
use App\Models\FichaEmprendimiento;
use Livewire\Attributes\Layout;

class Page extends EditPage
{
    public FichaEmprendimiento $ficha_emprendimiento;

    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Ver visualizador'),
            403
        );
        $this->ficha_emprendimiento = $this->form->emprendimiento;
        return view('livewire.resultadocuatro.gestor.emprendimiento.revisar.page', $this->getData())
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte,
                'resultadocuatro' => true
            ]);
    }
}
