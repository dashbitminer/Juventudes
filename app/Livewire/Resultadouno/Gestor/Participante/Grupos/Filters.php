<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos;

use Livewire\Form;
use App\Models\Post;
use App\Models\Grupo;
use App\Models\Estado;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\PaisProyecto;
use App\Models\Participante;
use App\Models\EstadoRegistro;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class Filters extends Form
{
    public $selectedEstadosIds;

    public array $selectedEstadosParticipanteIds = [];

    public array $selectedSociosIds = [];

    public Cohorte $cohorte;

    public PaisProyecto $paisProyecto;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $singrupo = 0;

    public $total = 0;

    public function init($cohorte, $paisProyecto, $cohortePaisProyecto)
    {

        $this->cohorte = $cohorte;

        $this->paisProyecto = $paisProyecto;

        $this->cohortePaisProyecto = $cohortePaisProyecto;

        $this->initSelectedEstadosIds();

        $this->initSelectedEstadosParticipanteIds();

        $this->initSinGrupo();

        $this->initSociosIds();
    }


    public function socios(){

            $cohortePaisProyectoId = $this->cohortePaisProyecto->id;

            $totalParticipantes = DB::table("participantes")
            ->join(
                "cohorte_participante_proyecto",
                "participantes.id",
                "=",
                "cohorte_participante_proyecto.participante_id"
            )
            ->join("users", "participantes.gestor_id", "=", "users.id")
            ->join(
                "socios_implementadores",
                "users.socio_implementador_id",
                "=",
                "socios_implementadores.id"
            )
            ->join('estado_registro_participante', 'participantes.id', '=', 'estado_registro_participante.participante_id')
            ->where(
                "cohorte_participante_proyecto.cohorte_pais_proyecto_id",
                $cohortePaisProyectoId
            )
            ->where('estado_registro_participante.estado_registro_id',  EstadoRegistro::VALIDADO)
            ->whereNotNull("cohorte_participante_proyecto.active_at")
            ->select(
                "socios_implementadores.id",
                "socios_implementadores.nombre",
                DB::raw("count(participantes.id) as total_participantes")
            )
            ->groupBy("socios_implementadores.id")
            ->orderBy('socios_implementadores.nombre', 'asc')
            ->get();

           return $totalParticipantes;
       // return  \App\Models\SocioImplementador::where("pais_id", auth()->user()->socioImplementador->pais_id)->active()->get();


    }

    public function initSociosIds()
    {
        $this->selectedSociosIds = $this->socios()->pluck('id')->toArray();
    }


    public function initSelectedEstadosIds()
    {
        if (empty($this->selectedEstadosIds)) {

            $this->selectedEstadosIds = $this->grupos()->pluck('id')->toArray(); // Include records with no grupos relation
            array_push($this->selectedEstadosIds, 0); // Include records with no grupos relation
        }
    }

    public function initSelectedEstadosParticipanteIds()
    {
        if (empty($this->selectedEstadosParticipanteIds)) {
            $this->selectedEstadosParticipanteIds = $this->estadosParticipante()->pluck('id')->toArray();
            array_push($this->selectedEstadosParticipanteIds, 0); // Include records with no grupos relation
        }
    }

    function resetSelectedEstadosIds()
    {
        $this->selectedEstadosIds = $this->grupos()->pluck('id')->toArray();
        array_push($this->selectedEstadosIds, 0); // Include records with no grupos relation

        $this->selectedEstadosParticipanteIds = $this->estadosParticipante()->pluck('id')->toArray();
        array_push($this->selectedEstadosParticipanteIds, 0); // Include records with no grupos relation
    }

    function resetSelectedEstadosParticipantesIds()
    {
       // $this->selectedEstadosParticipanteIds = $this->estadosParticipante()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        $this->selectedEstadosParticipanteIds   = $this->estadosParticipante()->pluck('id')->toArray();
    }

    public function initSinGrupo()
    {
        $this->singrupo = Participante::whereDoesntHave('grupos')
            ->misRegistros()
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', EstadoRegistro::VALIDADO);
            })
            ->count();
    }

    public function estadosParticipante()
    {

        $subQuery = DB::table('estado_participante')
            ->join('grupo_participante', 'estado_participante.grupo_participante_id', '=', 'grupo_participante.id')
            ->join('cohorte_participante_proyecto', 'grupo_participante.cohorte_participante_proyecto_id', '=', 'cohorte_participante_proyecto.id')
            ->join('users', 'grupo_participante.user_id', '=', 'users.id')
            ->join('socios_implementadores', 'users.socio_implementador_id', '=', 'socios_implementadores.id')
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->when(auth()->user()->can('Ver mis participantes R4'), function ($query) {
                $query->where('grupo_participante.user_id', auth()->id());
            })
            ->when(auth()->user()->can('Ver participantes mi socio implementador R4'), function ($query) {
                $query->where('users.socio_implementador_id', auth()->user()->socio_implementador_id);
            })
            ->when(auth()->user()->can('Ver participantes mi pais R4'), function ($query) {
                $query->where('socios_implementadores.pais_id', auth()->user()->socioImplementador->pais_id);
            })
            ->whereNotNull('grupo_participante.active_at')
            ->select('grupo_participante_id', DB::raw('MAX(estado_participante.id) as last_estado_participante_id'))
            ->groupBy('grupo_participante_id');

         $lastEstados = DB::table('estado_participante as ep')
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('ep.id', '=', 'sub.last_estado_participante_id');
            })
            ->leftJoin('estados', 'ep.estado_id', '=', 'estados.id')
            ->whereNotNull("estados.active_at")
            ->select('estados.id as id', 'estados.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('ep.estado_id')
            ->orderBy('estados.nombre', 'asc')
            ->get();

        return $lastEstados;
    }


    public function grupos()
    {
        return Grupo::join('grupo_participante', 'grupos.id', '=', 'grupo_participante.grupo_id')
            ->join('cohorte_participante_proyecto', 'grupo_participante.cohorte_participante_proyecto_id', '=', 'cohorte_participante_proyecto.id')
            ->join('participantes', 'cohorte_participante_proyecto.participante_id', '=', 'participantes.id')
            ->join('users', 'grupo_participante.user_id', '=', 'users.id')
            ->join('socios_implementadores', 'users.socio_implementador_id', '=', 'socios_implementadores.id')
            ->whereNotNull('grupo_participante.active_at')
            ->whereNull('participantes.deleted_at')
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->when(auth()->user()->can('Ver mis participantes R4'), function ($query) {
                $query->where('grupo_participante.user_id', auth()->id());
            })
            ->when(auth()->user()->can('Ver participantes mi socio implementador R4'), function ($query) {
                $query->where('users.socio_implementador_id', auth()->user()->socio_implementador_id);
            })
            ->when(auth()->user()->can('Ver participantes mi pais R4'), function ($query) {
                $query->where('socios_implementadores.pais_id', auth()->user()->socioImplementador->pais_id);
            })
            ->select([
                'grupos.id',
                'grupos.slug',
                'grupos.nombre',
                'grupo_participante.grupo_id',
                DB::raw('count(distinct grupo_participante.cohorte_participante_proyecto_id) as total')
            ])
            ->groupBy('grupo_participante.grupo_id')
            //->orderBy(DB::raw('MAX(grupos.nombre)'), 'desc')
            ->orderByRaw("CAST(SUBSTRING(grupos.nombre, 7) AS UNSIGNED) ASC")
            ->get();
    }


    public function apply($query)
    {
       $query = $this->applyGrupo($query);

        $query = $this->applyEstadosParticipante($query);

        if(auth()->user()->can('Ver participantes mi pais R4')){
            $query = $this->applySocioFilter($query);
        }

        return $query;
    }


    public function applySocioFilter($query)
    {
        return $query->whereHas('gestor.socioImplementador', function ($q) {
            $q->whereIn('socios_implementadores.id', $this->selectedSociosIds);
        });

    }


    public function applyGrupo($query)
    {
        $selectedEstadosIds = $this->selectedEstadosIds;

        $query->where(function ($query) use ($selectedEstadosIds) {
            // If selectedEstadosIds contains 0, include records with no grupos relation
            if (in_array(0, $selectedEstadosIds)) {
                $query->orWhereDoesntHave('grupos');
            }

            // Include records where grupos relation exists in selectedEstadosIds
            $query->orWhereHas('grupos', function ($query) use ($selectedEstadosIds) {
                $query->whereIn('grupo_participante.grupo_id', $selectedEstadosIds);
            });
        });

        return $query;
    }

    public function applyEstadosParticipante($query)
    {
       // dd($this->selectedEstadosParticipanteIds);


        $selectedEstadosParticipanteIds = $this->selectedEstadosParticipanteIds;


        $query->where(function ($query) use ($selectedEstadosParticipanteIds) {

            if (in_array(0, $selectedEstadosParticipanteIds)) {
                $query->orWhereDoesntHave('grupoactivo');
            }

            $query->orWhereHas('grupoactivo', function ($query) use ($selectedEstadosParticipanteIds) {

                $query->whereNotNull('grupo_participante.active_at')

                   // ->where('grupo_participante.user_id', auth()->id())

                    ->when(auth()->user()->can('Ver mis participantes R4'), function ($query) {
                        $query->where('grupo_participante.user_id', auth()->id());
                    })
                    ->when(auth()->user()->can('Ver participantes mi socio implementador R4'), function ($query) {
                        $query->whereHas('user', function ($q) {
                            $q->where('socio_implementador_id', auth()->user()->socio_implementador_id);
                        });
                    })
                    ->when(auth()->user()->can('Ver participantes mi pais R4'), function ($query) {
                        $query->whereHas('user.socioImplementador', function ($q) {
                            $q->where('pais_id', auth()->user()->socioImplementador->pais_id);
                        });
                    })


                    ->whereHas('lastEstadoParticipante', function ($q) use ($selectedEstadosParticipanteIds) {
                        $q->whereIn('estado_participante.estado_id', $selectedEstadosParticipanteIds);
                    });
            });
        });


        return $query;
    }

}
