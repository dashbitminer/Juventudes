<?php

namespace App\Livewire\Resultadocuatro\Gestor\Empleo\Index;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Cohorte;
use App\Models\Participante;

class Page extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.empleo.index.page')
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte,
                'resultadocuatro' => true,
            ]);
    }
}
