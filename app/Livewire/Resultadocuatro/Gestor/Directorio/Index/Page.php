<?php

namespace App\Livewire\Resultadocuatro\Gestor\Directorio\Index;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;

class Page extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    public ?Cohorte $cohorte;


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.directorio.index.page')
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte ?? '',
                'directorio' => true,
                'resultadocuatro' => true,
            ]);
    }
}
