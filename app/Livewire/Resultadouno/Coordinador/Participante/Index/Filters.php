<?php

namespace App\Livewire\Resultadouno\Coordinador\Participante\Index;

use App\Models\User;
use App\Models\Grupo;
use Livewire\Attributes\Url;
use App\Models\EstadoRegistro;
use App\Models\CoordinadorGestor;
use App\Models\GrupoPerteneciente;
use Illuminate\Support\Facades\DB;
use App\Models\EstadoRegistroParticipante;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Filters AS FiltersGestor;
use App\Models\Proyecto;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\CohorteProyectoUser;
use App\Models\PaisProyecto;
use App\Models\GrupoParticipante;

class Filters extends FiltersGestor
{

    // #[Url(as: 'gestores')]
    public $selectedGestoresIds = [];

    #[Url(as: 'grupos')]
    public $selectedGruposIds = [];


    public Proyecto $proyecto;

    public Pais $pais;

    public Cohorte $cohorte;

    public $cohortePaisProyecto;

    public $cohortePaisProyectoFromTable;

    public $selectedGestoresAll;



    public function init($cohortePaisProyecto)
    {
        $this->cohortePaisProyecto = $cohortePaisProyecto;

        $this->initSelectedGestoresIds();
        $this->initSelectedGruposIds();
        $this->initSelectedEstadosIds();
        $this->initRange();

        $this->selectedGestoresAll = true;

    }


    /**
     * Obtener todos los gestores pertenecientes al coordinador
     *
     * @return \Illuminate\Support\Collection
     */
    public function getGestoresByCoordinador(): array
    {

        $miUsuarioCoordinador = \App\Models\CohorteProyectoUser::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                        ->where('user_id', auth()->id())
                        ->where('rol', 'coordinador')
                        ->first();



        $gestores = \App\Models\CoordinadorGestor::join('cohorte_proyecto_user', 'coordinador_gestores.gestor_id', '=', 'cohorte_proyecto_user.id')
                ->where('coordinador_id', $miUsuarioCoordinador->id)
                ->where('cohorte_proyecto_user.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->pluck('cohorte_proyecto_user.user_id');

        return $gestores->unique()->toArray();
    }

    public function estados()
    {
        $subquery = EstadoRegistroParticipante::select('cohorte_participante_proyecto.participante_id', DB::raw('MAX(estado_registro_participante.id) as last_id'))
            ->join('participantes', 'estado_registro_participante.participante_id', '=', 'participantes.id')
            ->join('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->whereIn('participantes.gestor_id', $this->selectedGestoresIds)
            ->where('estado_registro_participante.estado_registro_id', '!=', EstadoRegistro::DOCUMENTACION_PENDIENTE)
            ->whereNull('participantes.deleted_at');

        //dd($this->selectedGruposIds);

        if (count($this->selectedGruposIds) > 1 && !in_array(0, $this->selectedGruposIds)) {
            $grupos = GrupoParticipante::whereIn('grupo_id', $this->selectedGruposIds)
                            ->leftJoin('cohorte_participante_proyecto', 'grupo_participante.cohorte_participante_proyecto_id', '=', 'cohorte_participante_proyecto.id')
                            ->pluck('cohorte_participante_proyecto.participante_id');
                            //dd($grupos);

            $subquery->whereIn('cohorte_participante_proyecto.participante_id', $grupos);
        }

        $subquery->groupBy('cohorte_participante_proyecto.participante_id');

        $estados = EstadoRegistroParticipante::query()
            ->joinSub($subquery, 'last_erp', function ($join) {
                $join->on('estado_registro_participante.id', '=', 'last_erp.last_id');
            })
            ->join('estado_registros as er', 'estado_registro_participante.estado_registro_id', '=', 'er.id')
            ->select('er.id', 'er.nombre', 'er.color', DB::raw('COUNT(estado_registro_participante.participante_id) as total'))
            ->groupBy('er.id', 'er.nombre', 'er.color')
            ->orderBy('er.id')
            ->get();

            //dd($estados);

        return $estados;
    }

    public function gestores()
    {

       return User::query()
            ->select('users.id', 'users.name', DB::raw('COUNT(participantes.id) as total'))
            ->join('participantes', 'users.id', '=', 'participantes.gestor_id')
            ->join('estado_registro_participante', 'participantes.id', '=', 'estado_registro_participante.participante_id')
            ->join('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
            ->whereIn('users.id', $this->getGestoresByCoordinador())
            ->where('estado_registro_participante.estado_registro_id', '!=', EstadoRegistro::DOCUMENTACION_PENDIENTE)
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->groupBy('users.name')
            ->get();

    }

    public function grupos3()
    {
        return Grupo::join('grupo_participante', 'grupos.id', '=', 'grupo_participante.grupo_id')
            ->join('cohorte_participante_proyecto', 'grupo_participante.cohorte_participante_proyecto_id', '=', 'cohorte_participante_proyecto.id')
            ->join('participantes', 'cohorte_participante_proyecto.participante_id', '=', 'participantes.id')
            ->join('users', 'grupo_participante.user_id', '=', 'users.id')
            ->join('socios_implementadores', 'users.socio_implementador_id', '=', 'socios_implementadores.id')
            ->whereNotNull('grupo_participante.active_at')
            ->whereNull('participantes.deleted_at')
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->whereIn('grupo_participante.user_id',$this->selectedGestoresIds)
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

    public function grupos()
    {

        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        return Grupo::join('grupo_participante', 'grupos.id', '=', 'grupo_participante.grupo_id')
            ->join('cohorte_participante_proyecto', 'grupo_participante.cohorte_participante_proyecto_id', '=', 'cohorte_participante_proyecto.id')
            ->join('cohorte_pais_proyecto', 'cohorte_participante_proyecto.cohorte_pais_proyecto_id', '=', 'cohorte_pais_proyecto.id')
            ->join('participantes', 'cohorte_participante_proyecto.participante_id', '=', 'participantes.id')
            ->whereNotNull('grupo_participante.active_at')
            ->whereNull('participantes.deleted_at')
            ->where('cohorte_pais_proyecto.cohorte_id', $this->cohorte->id)
            ->where('cohorte_pais_proyecto.pais_proyecto_id', $paisProyecto->id)
            ->whereIn('grupo_participante.user_id',$this->selectedGestoresIds)
            ->select([
                'grupos.id',
                'grupos.nombre',
                DB::raw('count(distinct cohorte_participante_proyecto.participante_id) as total')
            ])
            ->groupBy('grupo_participante.grupo_id')
            ->orderBy(DB::raw('MAX(grupos.nombre)'), 'desc')
            ->get();

        /*return Grupo::with('participantes')
            ->whereHas('participantes', function ($query) {
                $query->whereIn('grupo_participante.user_id', $this->selectedGestoresIds);
            })
            ->select('grupos.id', 'grupos.nombre')
            ->get();*/
    }

    public function participantesSinGrupos()
    {
        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
        ->where('proyecto_id', $this->proyecto->id)
        ->firstOrFail();


        return \App\Models\Participante::with([
                'ciudad:id,nombre,departamento_id',
                'ciudad.departamento:id,nombre,pais_id',
                'lastEstado.estado_registro:id,nombre,color,icon',
                'gestor',
                'grupos',
            ])
            ->select([
                "id",
                "slug",
                "email",
                "primer_nombre",
                "segundo_nombre",
                "tercer_nombre",
                "primer_apellido",
                "segundo_apellido",
                "tercer_apellido",
                "ciudad_id",
                "created_at",
                "documento_identidad",
                "fecha_nacimiento",
                "sexo",
                "telefono",
                "gestor_id",
            ])

        ->whereIn('participantes.gestor_id', $this->selectedGestoresIds)
        ->whereHas("cohortePaisProyecto", function ($query) {
            $query->where("cohorte_pais_proyecto.id", $this->cohortePaisProyecto->id)
                ->whereNotNull("cohorte_participante_proyecto.active_at");
        })
        ->whereDoesntHave('grupos')
        ->count();

    }

    public function initSelectedGestoresIds()
    {
        if (empty($this->selectedGestoresIds)) {
            $this->selectedGestoresIds = $this->gestores()->pluck('id')->toArray();
        }
    }

    public function resetGestoresIds(){
        $this->selectedGestoresIds = $this->gestores()->pluck('id')->toArray();
    }

    public function initSelectedGruposIds()
    {
        if (empty($this->selectedGruposIds)) {
            $this->selectedGruposIds = $this->grupos()->pluck('id')->toArray();
            $this->selectedGruposIds[] = 0;
        }
    }

    public function apply($query)
    {
        $query = $this->applyEstado($query);
        $query = $this->applyStatusCards($query);
        $query = $this->applyRange($query);
        $query = $this->applyGestores($query);
        $query = $this->applyGrupos($query);

        return $query;
    }

    public function applyGestores($query)
    {
        return $query->whereIn('participantes.gestor_id', $this->selectedGestoresIds);
    }

    public function applyGrupos2($query)
    {

        // The 0 is for all participants who belong to groups or do not belong to them
        if (count($this->selectedGruposIds) > 1) {
            return $query->whereHas('grupos', function ($q) {
                $q->whereIn('grupo_participante.grupo_id', $this->selectedGruposIds);
            });
        }

        return $query;
    }


    public function applyGrupos($query)
    {
        //dd($this->selectedGruposIds);
        $selectedGruposIds = $this->selectedGruposIds;

        if(empty($selectedGruposIds)){
            return $query;
        }

        $query->where(function ($query) use ($selectedGruposIds) {
            // If selectedEstadosIds contains 0, include records with no grupos relation
            if (in_array(0, $selectedGruposIds)) {
                $query->orWhereDoesntHave('grupos');
            }

            // Include records where grupos relation exists in selectedEstadosIds
            $query->orWhereHas('grupos', function ($query) use ($selectedGruposIds) {
                $query->whereIn('grupo_participante.grupo_id', $selectedGruposIds);
            });
        });

        return $query;
    }

}
