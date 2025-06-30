<?php

namespace App\Livewire\Resultadotres\Gestor\Visualizador\Index;

use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Page extends Component
{

    public Pais $pais;

    public Proyecto $proyecto;

    // public Cohorte $cohorte;

    #[On('update-table-data')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadotres.gestor.visualizador.index.page')->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'resultadotres' => true,
        ]);
    }   

}