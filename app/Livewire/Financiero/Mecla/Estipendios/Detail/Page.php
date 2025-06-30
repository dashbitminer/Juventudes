<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Detail;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Estipendio;
use Livewire\Attributes\Layout;

class Page extends Component
{

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Estipendio $estipendio;

    public $agrupaciones = [];


    public function mount(Pais $pais, Proyecto $proyecto, Cohorte $cohorte, Estipendio $estipendio)
    {
        $this->pais = $pais;
        $this->proyecto = $proyecto;
        $this->cohorte = $cohorte;
        $this->estipendio = $estipendio;
    }



    #[Layout('layouts.app')]
    public function render()
    {

        return view('livewire.financiero.mecla.estipendios.detail.page')->layoutData([
            'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
        ]);
    }
}
