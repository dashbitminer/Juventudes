<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Financiero;

use Livewire\Form;
use App\Models\Estado;
use Livewire\Attributes\Url;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Livewire\Financiero\Mecla\Estipendios\Financiero\Range;
use App\Models\CohortePaisProyecto;
use App\Models\CohorteParticipanteProyecto;
use App\Models\EstadoRegistro;
use App\Models\EstadoRegistroParticipante;

class Filters extends Form
{
    public $estados;

    public $status = 0;

    public $updatepage = false;

    #[Url]
    public Range $range = Range::All_Time;

    #[Url]
    public $start;

    #[Url]
    public $end;

    #[Url(as: 'estados')]
    public $selectedEstadosIds = [];

    public $selectedPerfilesIds = [];

    public $selectedSexosIds = [];

    public $selectedGruposIds = [];

    public $cohortePaisProyecto;



    public function init($selectedCohortePaisProyecto = null)
    {

        $this->cohortePaisProyecto = CohortePaisProyecto::find($selectedCohortePaisProyecto);

        $this->initRange();
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
        $query = $this->applyRange($query);

        return $query;
    }

    public function applyRange($query)
    {
        //dump($this->range);
        if ($this->range === Range::All_Time) {
            //  dump('All_Time');
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
