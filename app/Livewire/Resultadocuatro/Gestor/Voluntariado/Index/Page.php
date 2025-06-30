<?php

namespace App\Livewire\Resultadocuatro\Gestor\Voluntariado\Index;

use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;

class Page extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    public $titulo = 'Ficha voluntariado';

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.voluntariado.index.page',[
            'pais' => $this->pais,
            'titulo' => $this->titulo
        ])
        ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'resultadocuatro' => true
            ]);
    }
}
