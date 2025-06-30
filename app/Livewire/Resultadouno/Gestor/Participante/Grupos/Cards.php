<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos;

use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use App\Models\PaisProyecto;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\GrupoTrait;

class Cards extends Component
{
    use GrupoTrait;

    public Cohorte $cohorte;

    public Pais $pais;

    public Proyecto $proyecto;

    public CohortePaisProyecto $cohortePaisProyecto;

    #[On('update-grupos-cards')]
    public function render()
    {

        // 1. Get the PaisProyecto model instance
        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
                            ->where('proyecto_id', $this->proyecto->id)
                            ->firstOrFail();

        // 2 Get the Cohorte Pais Proyecto model instance
        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
                                ->where('pais_proyecto_id', $paisProyecto->id)
                                ->firstOrFail();

        $grupos = \App\Models\GrupoParticipante::with("grupo:id,nombre,slug")
                // ->join('grupos', 'grupo_participante.grupo_id', '=', 'grupos.id')
                ->whereHas('cohorteParticipanteProyecto', function ($query) {
                    $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
                })
                ->where('grupo_participante.user_id', auth()->user()->id)
                // ->withCount(['cohorteParticipanteProyecto' => function ($query) {
                //     $query->whereNotNull('grupo_participante.active_at');
                // }])
                ->groupBy("grupo_id")
                ->get();

        foreach ($grupos as $grupo) {
            $grupo->participantes_count =  \App\Models\GrupoParticipante::whereHas('cohorteParticipanteProyecto.participante', function ($query) {
                                                    $query->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                                                          ->where('participantes.gestor_id', auth()->user()->id);
                                                })
                                                ->where('grupo_id', $grupo->grupo_id)
                                                ->whereNotNull('active_at')
                                                ->count();
        }



        return view('livewire.resultadouno.gestor.participante.grupos.cards', [
            'grupos' => $grupos
        ]);
    }
}
