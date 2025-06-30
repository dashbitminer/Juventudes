<?php
namespace App\Livewire\Resultadocuatro\Gestor\Empleo\Revisar;

use App\Livewire\Resultadocuatro\Gestor\Empleo\Edit\Page as  EditPage;
use App\Models\FichaEmpleo;
use Livewire\Attributes\Layout;

class Page extends EditPage
{
    public FichaEmpleo $empleo;

    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Ver visualizador'),
            403
        );

        $this->empleo = $this->form->empleo;

        return view('livewire.resultadocuatro.gestor.empleo.revisar.page', $this->getData())
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte,
                'resultadocuatro' => true
            ]);
    }
}
