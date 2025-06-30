<?php
namespace App\Livewire\Resultadocuatro\Gestor\Voluntariado\Revisar;


use \App\Livewire\Resultadocuatro\Gestor\Voluntariado\Edit\Page as EditPage;
use Livewire\Attributes\Layout;

class Page extends EditPage
{
    #[Layout('layouts.app')]
    public function render(){
        abort_if(
            !auth()->user()->can('Ver visualizador'),
            403
        );

        return view('livewire.resultadocuatro.gestor.voluntariado.revisar.page', $this->initializeProperties())
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte,
                'resultadocuatro' => true
            ]);
    }
}
