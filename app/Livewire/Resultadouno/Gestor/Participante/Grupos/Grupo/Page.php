<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos\Grupo;

use App\Models\Pais;
use App\Models\Grupo;
use App\Models\Modulo;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Submodulo;
use Livewire\Attributes\On;
use App\Models\PaisProyecto;
use App\Models\Participante;
use App\Models\Subactividad;
use App\Models\Actividad;
use Livewire\Attributes\Layout;
use App\Models\CohorteSocioUser;
use App\Models\GrupoParticipante;
use App\Models\PaisProyectoSocio;
use Illuminate\Support\Facades\DB;
use App\Models\CohortePaisProyecto;
use App\Models\CohorteActividad;
use App\Models\CohorteSubactividad;
use App\Models\CohorteProyectoSocio;
use App\Models\CohorteSubactividadModulo;

class Page extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Grupo $grupo;

    public CohortePaisProyecto $cohortePaisProyecto;

    public ?Actividad $actividad = null;

    public ?Subactividad $subactividad = null;

    public ?Modulo $modulo = null;

    public ?Submodulo $submodulo = null;


    #[Layout('layouts.app')]
    public function render()
    {
        $data = [];

        // Find the PaisProyecto record
        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->first();

        // For getting the data subactividades, modulos y submodulos
        $this->cohortePaisProyecto = CohortePaisProyecto::with('actividades')
            ->where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->first();

        $grupoParticipante = GrupoParticipante::whereHas('cohorteParticipanteProyecto', function ($query) {
                $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
            })
            ->active()
            ->select('cohorte_pais_proyecto_perfil_id')
            ->where('user_id', auth()->id())
            ->where('grupo_id', $this->grupo->id)
            ->whereNotNull('cohorte_pais_proyecto_perfil_id')
            ->groupBy("grupo_id")
            ->first();

        // dd($grupoParticipante);


        if ($grupoParticipante) {
            $actividades = $this->cohortePaisProyecto->actividades()
                ->where('cohorte_pais_proyecto_perfil_id', $grupoParticipante->cohorte_pais_proyecto_perfil_id)
                ->whereNull('cohorte_actividades.deleted_at')
                ->get();
        }
        else {
            $actividades = collect();
        }

        if ($actividades->count()) {
            $data['actividades'] = $actividades;
        }


        if ($this->actividad) {
            $cohorteActividad = CohorteActividad::with('cohorteSubactividad.subactividades')
                ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->where('cohorte_pais_proyecto_perfil_id', $grupoParticipante->cohorte_pais_proyecto_perfil_id)
                ->where('actividad_id', $this->actividad->id)
                ->first();

            if ($cohorteActividad->cohorteSubactividad()->count()) {
                $data['subactividades'] = $cohorteActividad->cohorteSubactividad()->with('subactividades')
                    ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                    ->where('cohorte_pais_proyecto_perfil_id', $grupoParticipante->cohorte_pais_proyecto_perfil_id)
                    ->get()
                    ->pluck('subactividades');
            }
        }

        if ($this->subactividad) {
            $cohorteSubactividad = CohorteSubactividad::with("modulos")
                ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->where('cohorte_pais_proyecto_perfil_id', $grupoParticipante->cohorte_pais_proyecto_perfil_id)
                ->where('cohorte_actividad_id', $cohorteActividad->id)
                ->where('subactividad_id', $this->subactividad->id)
                ->first();

            if ($cohorteSubactividad->modulos->count()) {
                $data['modulos'] = $cohorteSubactividad->modulos()
                    ->wherePivot('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                    ->wherePivot('cohorte_pais_proyecto_perfil_id', $grupoParticipante->cohorte_pais_proyecto_perfil_id)
                    ->get();
            }
        }

        if ($this->modulo) {
            $cohorteSubactividadModulo = CohorteSubactividadModulo::with('submodulos')
                ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->where('cohorte_pais_proyecto_perfil_id', $grupoParticipante->cohorte_pais_proyecto_perfil_id)
                ->where('modulo_id', $this->modulo->id)
                ->where('cohorte_subactividad_id', $cohorteSubactividad->id)
                ->first();

            if ($cohorteSubactividadModulo->submodulos->count()) {
                $data['submodulos'] = $cohorteSubactividadModulo->submodulos()
                    ->wherePivot('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                    ->wherePivot('cohorte_pais_proyecto_perfil_id', $grupoParticipante->cohorte_pais_proyecto_perfil_id)
                    ->get();
            }
        }

        return view('livewire.resultadouno.gestor.participante.grupos.grupo.page', $data)
            ->layoutData([
                'cohorte' => $this->cohorte,
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'resultadouno' => true,
            ]);
    }

    public function accessSession(?Actividad $actividad = null, ?Subactividad $subactividad = null, ?Modulo $modulo = null, ?Submodulo $submodulo = null) {
        $this->actividad = !empty($actividad->id) ? $actividad : null;
        $this->subactividad = !empty($subactividad->id) ? $subactividad : null;
        $this->modulo = !empty($modulo->id) ? $modulo : null;
        $this->submodulo = !empty($submodulo->id) ? $submodulo : null;
    }
}
