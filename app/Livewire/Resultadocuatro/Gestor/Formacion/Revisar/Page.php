<?php

namespace App\Livewire\Resultadocuatro\Gestor\Formacion\Revisar;

use App\Livewire\Resultadocuatro\Gestor\Formacion\Edit\Page as EditPage;
use App\Models\FichaFormacion;
use Livewire\Attributes\Layout;

class Page extends editPage
{
    public FichaFormacion $ficha_formacion;
    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Ver visualizador'),
            403
        );

        $this->ficha_formacion = $this->form->formacion;

        return view('livewire.resultadocuatro.gestor.formacion.revisar.page', $this->initializeProperties())
        ->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
            'resultadocuatro' => true
        ]);
    }
}
