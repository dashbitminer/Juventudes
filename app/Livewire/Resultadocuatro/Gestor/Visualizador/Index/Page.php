<?php

namespace App\Livewire\Resultadocuatro\Gestor\Visualizador\Index;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class Page extends Component
{

    public Pais $pais;

    public Proyecto $proyecto;

    #[On('update-table-data')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.visualizador.index.page')->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'resultadocuatro' => true,
        ]);
    }
}
