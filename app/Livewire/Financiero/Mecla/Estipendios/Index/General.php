<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Index;

use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\WithPagination;

class General extends Component
{

    use WithPagination;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $perPage = 10;

    public CohortePaisProyecto $cohortePaisProyecto;


    public function render()
    {
        // selectRaw('cohorte_pais_proyecto_perfil_id, mes, anio, COUNT(*) as total, id, fecha_inicio, fecha_fin')
        // ->
        $query = \App\Models\Estipendio::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->active()
            ->latest()
            ->with('socioImplementador', 'perfilParticipante')
            ->groupBy('cohorte_pais_proyecto_perfil_id', 'mes', 'anio');

        $estipendios = $query->paginate($this->perPage);

        //dd($estipendios);

        $this->participanteIdsOnPage = $estipendios->map(fn ($estipendio) => (string) $estipendio->id)->toArray();

        return view('livewire.financiero.mecla.estipendios.index.general', [
            'estipendios' => $estipendios,
        ]);
    }
}
