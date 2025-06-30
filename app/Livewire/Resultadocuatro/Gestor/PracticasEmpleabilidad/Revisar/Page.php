<?php

namespace App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Revisar;

use App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Edit\Page as PracticaEdit;
use App\Models\PracticaEmpleabilidad;
use Livewire\Attributes\Layout;

class Page extends PracticaEdit
{
    public PracticaEmpleabilidad $practica_empleabilidad;
    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Ver visualizador'),
            403
        );

        $this->practica_empleabilidad = $this->form->practica;

        return view('livewire.resultadocuatro.gestor.practicas-empleabilidad.revisar.page', $this->initializeProperties())
        ->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
            'resultadocuatro' => true
        ]);
    }
}
