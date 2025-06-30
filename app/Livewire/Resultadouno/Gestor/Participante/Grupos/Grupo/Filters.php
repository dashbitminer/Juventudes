<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos\Grupo;

use Livewire\Form;
use App\Models\Post;
use App\Models\Grupo;
use App\Models\Estado;
use App\Models\Cohorte;
use App\Models\PaisProyecto;
use App\Models\Participante;
use App\Models\EstadoRegistro;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class Filters extends Form
{
    public $selectedEstadosIds;

    public $selectedEstadosParticipanteIds;

    public Cohorte $cohorte;

    public PaisProyecto $paisProyecto;

    public Grupo $grupo;

    public $singrupo = 0;

    public $total = 0;


    public function init($cohorte, $paisProyecto, $grupo)
    {

        $this->cohorte = $cohorte;

        $this->paisProyecto = $paisProyecto;

        $this->grupo = $grupo;

        $this->initSelectedEstadosIds();

        $this->initSelectedEstadosParticipanteIds();

        $this->initSinGrupo();
    }




    public function estadosParticipante()
    {
        $subQuery = DB::table('estado_participante')
            ->leftJoin('grupo_participante', 'estado_participante.grupo_participante_id', '=', 'grupo_participante.id')
            ->where('grupo_participante.cohorte_id', $this->cohorte->id)
            ->where('grupo_participante.pais_proyecto_id', $this->paisProyecto->id)
            ->where('grupo_participante.user_id', auth()->id())
            ->where('grupo_participante.grupo_id', $this->grupo->id)
            ->whereNotNull('grupo_participante.active_at')
            ->select('grupo_participante_id', DB::raw('MAX(estado_participante.id) as last_estado_participante_id'))
            ->groupBy('grupo_participante_id');

         $lastEstados = DB::table('estado_participante as ep')
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('ep.id', '=', 'sub.last_estado_participante_id');
            })
            ->leftJoin('estados', 'ep.estado_id', '=', 'estados.id')
            ->select('estados.id as id', 'estados.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('ep.estado_id')
            ->get();

        return $lastEstados;
    }

    public function estadosParticipanteEnGrupo()
    {
        $subQuery = DB::table('estado_participante')
            ->leftJoin('grupo_participante', 'estado_participante.grupo_participante_id', '=', 'grupo_participante.id')
            ->where('grupo_participante.cohorte_id', $this->cohorte->id)
            ->where('grupo_participante.pais_proyecto_id', $this->paisProyecto->id)
            ->where('grupo_participante.user_id', auth()->id())
            ->whereNotNull('grupo_participante.active_at')
            ->select('grupo_participante_id', DB::raw('MAX(estado_participante.id) as last_estado_participante_id'))
            ->groupBy('grupo_participante_id');

         $lastEstados = DB::table('estado_participante as ep')
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('ep.id', '=', 'sub.last_estado_participante_id');
            })
            ->leftJoin('estados', 'ep.estado_id', '=', 'estados.id')
            ->select('estados.id as id', 'estados.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('ep.estado_id')
            ->get();

        return $lastEstados;
    }


    public function grupos()
    {
        return Grupo::join('grupo_participante', 'grupos.id', '=', 'grupo_participante.grupo_id')
            ->join('participantes', 'grupo_participante.participante_id', '=', 'participantes.id')
            ->whereNotNull('grupo_participante.active_at')
            ->whereNull('participantes.deleted_at')
            ->where('grupo_participante.cohorte_id', $this->cohorte->id)
            ->where('grupo_participante.pais_proyecto_id', $this->paisProyecto->id)
            ->where('grupo_participante.user_id', auth()->id())
            ->select([
                'grupos.id',
                'grupos.slug',
                'grupos.nombre',
                'grupo_participante.grupo_id',
                DB::raw('count(distinct grupo_participante.participante_id) as total')
            ])
            ->groupBy('grupo_participante.grupo_id')
            ->orderBy(DB::raw('MAX(grupos.nombre)'), 'desc')
            ->get();
    }

    public function initSelectedEstadosIds()
    {
        if (empty($this->selectedEstadosIds)) {
            $this->selectedEstadosIds = $this->grupos()->pluck('id')->toArray();
            array_push($this->selectedEstadosIds, 0); // Include records with no grupos relation
        }
    }

    public function initSelectedEstadosParticipanteIds()
    {
        //$this->selectedEstadosParticipanteIds = [];
        if (empty($this->selectedEstadosParticipanteIds)) {
            $this->selectedEstadosParticipanteIds = $this->estadosParticipante()->pluck('id')->toArray();
        }
    }

    function resetSelectedEstadosIds()
    {
        $this->selectedEstadosIds = $this->grupos()->pluck('id')->toArray();
        array_push($this->selectedEstadosIds, 0); // Include records with no grupos relation
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


    public function apply($query)
    {
        $query = $this->applyGrupo($query);

        $query = $this->applyEstadosParticipante($query);

        return $query;
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

       // $this->resetSelectedEstadosParticipantesIds();

        $selectedEstadosParticipanteIds = $this->selectedEstadosParticipanteIds;

        $query->where(function ($query) use ($selectedEstadosParticipanteIds) {

            if (in_array(0, $selectedEstadosParticipanteIds)) {
                $query->orWhereDoesntHave('grupoParticipante');
            }

            $query->orWhereHas('grupoParticipante', function ($query) use ($selectedEstadosParticipanteIds) {
                $query->whereNotNull('grupo_participante.active_at')
                    ->where('grupo_participante.cohorte_id', $this->cohorte->id)
                    ->where('grupo_participante.pais_proyecto_id', $this->paisProyecto->id)
                    ->where('grupo_participante.user_id', auth()->id())
                    ->whereHas('lastEstadoParticipante', function ($q) use ($selectedEstadosParticipanteIds) {
                        $q->whereIn('estado_participante.estado_id', $selectedEstadosParticipanteIds);
                    });
            });
        });


        return $query;
    }
}
