<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Visualizar;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Estipendio;
use App\Models\PaisProyecto;
use Livewire\Attributes\Layout;

class Page extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Estipendio $estipendio;

    public PaisProyecto $paisProyecto;

    public function mount(Pais $pais, Proyecto $proyecto, Cohorte $cohorte, Estipendio $estipendio)
    {
        $this->pais = $pais;
        $this->proyecto = $proyecto;
        $this->cohorte = $cohorte;
        $this->estipendio = $estipendio;

        $this->paisProyecto = PaisProyecto::where('pais_id', $pais->id)
            ->where('proyecto_id', $proyecto->id)
            ->first();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.financiero.mecla.estipendios.visualizar.page')->layoutData([
            'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
        ]);
    }
}
