<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Index;

use Livewire\Form;
use App\Models\Estado;
use Livewire\Attributes\Url;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Range;
use App\Models\CohortePaisProyecto;
use App\Models\EstadoRegistro;
use App\Models\EstadoRegistroParticipante;

class Filters extends Form
{
    public $estados;

    public $status = 0;

    public $updatepage = false;

    public $cohortePaisProyecto;

    #[Url]
    public Range $range = Range::All_Time;

    #[Url]
    public $start;

    #[Url]
    public $end;

    #[Url(as: 'estados')]
    public $selectedEstadosIds = [];


    public function init($cohortePaisProyecto)
    {
        $this->cohortePaisProyecto = $cohortePaisProyecto;
        $this->initSelectedEstadosIds();
        $this->initRange();
    }


    public function estados()
    {
        $subquery = EstadoRegistroParticipante::select('estado_registro_participante.participante_id', DB::raw('MAX(estado_registro_participante.id) as last_id'))
                                        ->join('participantes', 'estado_registro_participante.participante_id', '=', 'participantes.id')
                                        ->join('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
                                        ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                                        ->where('participantes.gestor_id', auth()->id())
                                        ->whereNull('participantes.deleted_at')
                                        ->groupBy('estado_registro_participante.participante_id');

        $estados = EstadoRegistroParticipante::query()
            ->joinSub($subquery, 'last_erp', function ($join) {
                $join->on('estado_registro_participante.id', '=', 'last_erp.last_id');
            })
            ->join('estado_registros as er', 'estado_registro_participante.estado_registro_id', '=', 'er.id')
            ->select('er.id', 'er.nombre', 'er.color', DB::raw('COUNT(estado_registro_participante.participante_id) as total'))
            ->groupBy('er.id', 'er.nombre', 'er.color')
            ->orderBy('er.id')
            ->get();

        return $estados;
    }

    public function initSelectedEstadosIds()
    {
        if (empty($this->selectedEstadosIds)) {
            $this->selectedEstadosIds = $this->estados()->pluck('id')->toArray();
        }
    }

    public function initRange()
    {
        if ($this->range !== Range::Custom) {
            $this->start = null;
            $this->end = null;
        }
    }

    public function apply($query)
    {
      $query = $this->applyEstado($query);
      $query = $this->applyStatusCards($query);
      $query = $this->applyRange($query);

       return $query;
    }

    public function applyEstado($query)
    {
        return $query->whereHas('lastEstado', function ($q) {
            $q->whereIn('estado_registro_participante.estado_registro_id', $this->selectedEstadosIds);
        });
    }

    public function applyStatusCards($query, $status = null)
    {
        $status = $status ?? $this->status;

        if ($status == 0) {
            return $query;
        }

        return $query->whereHas('lastEstado', function ($q) use ($status) {
            $q->where('estado_registro_participante.estado_registro_id', $status);
        });

    }

    public function applyRange($query)
    {
        if ($this->range === Range::All_Time) {
            return $query;
        }

        if ($this->range === Range::Custom) {
            $start = Carbon::createFromFormat('Y-m-d', $this->start)->startOfDay();
            $end = Carbon::createFromFormat('Y-m-d', $this->end)->endOfDay();

           //return $query->whereBetween(DB::raw('CONVERT_TZ(created_at, "+00:00", "-06:00")'), [$start, $end]);

            return $query->whereBetween('created_at', [$start, $end]);
        }

        return $query->whereBetween('created_at', $this->range->dates());
    }




}
