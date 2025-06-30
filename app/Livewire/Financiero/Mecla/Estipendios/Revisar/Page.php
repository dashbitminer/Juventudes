<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Revisar;

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
        return view('livewire.financiero.mecla.estipendios.revisar.page')->layoutData([
            'cohorte' => $this->cohorte,
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
        ]);
    }

    public function cerrarEstipendio(Estipendio $estipendio)
    {
        $estipendios = Estipendio::where('cohorte_pais_proyecto_id', $estipendio->cohorte_pais_proyecto_id)
                    ->where('cohorte_pais_proyecto_perfil_id', $estipendio->cohorte_pais_proyecto_perfil_id)
                    ->where('mes', $estipendio->mes)
                    ->where('anio', $estipendio->anio)
                    ->where('fecha_inicio', $estipendio->fecha_inicio)
                    ->where('fecha_fin', $estipendio->fecha_fin)
                    ->where('is_closed', 0)
                    ->get();

        foreach ($estipendios as $model) {
            $model->is_closed = 1;
            $model->save();
        }

        $this->redirectRoute('estipendios.mecla.revisar', [
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
            'estipendio' => $this->estipendio,
        ]);
    }
}
