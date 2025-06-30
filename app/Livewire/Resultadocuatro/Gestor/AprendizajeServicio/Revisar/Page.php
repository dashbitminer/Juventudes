<?php

namespace App\Livewire\Resultadocuatro\Gestor\AprendizajeServicio\Revisar;

use App\Livewire\Resultadocuatro\Gestor\AprendizajeServicio\Edit\Page as EditPage;
use App\Models\AprendizajeServicio;
use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;

class Page extends EditPage
{
    public AprendizajeServicio $aprendizajeServicio;
    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Ver visualizador'),
            403
        );

        $this->aprendizajeServicio = $this->form->aprendizajeServicio;

        return view('livewire.resultadocuatro.gestor.aprendizaje-servicio.revisar.page', $this->initializeProperties())
        ->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
            'resultadocuatro' => true,
        ]);
    }
}
