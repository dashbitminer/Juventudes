<?php

namespace App\Livewire\Resultadouno\Coordinador\Participante\Index;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Participante;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\Pais;


class View extends Component
{

    public Participante $participante;

    public Cohorte $cohorte;

    public Proyecto $proyecto;

    public Pais $pais;

    #[Layout('layouts.app')]
    public function render()
    {

      //  dd($this->participante->load(""));

        return view('livewire.resultadouno.coordinador.participante.index.view')->layoutData([
            'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
        ]);
    }

}
