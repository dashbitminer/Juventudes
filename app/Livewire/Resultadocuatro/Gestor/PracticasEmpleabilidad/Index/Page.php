<?php

namespace App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Index;

use App\Models\Cohorte;
use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;

class Page extends Component
{

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.practicas-empleabilidad.index.page')
        ->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'resultadocuatro' => true
        ]);
    }
}
