<?php

namespace App\Livewire\Admin\Cohortes\Participantes\Index;

use Livewire\Form;
use Livewire\Attributes\Url;
use Illuminate\Support\Carbon;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Range;

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

    public $gestorSelected = [];

    public function init()
    {
        $this->initSelectedEstadosIds();
        $this->initRange();
    }


    public function estados()
    {
        $estados = [];
        return $estados;
    }

    public function initSelectedEstadosIds()
    {

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
      $query = $this->applyGestor($query);


       return $query;
    }

    public function applyRange($query)
    {
        if ($this->range === Range::All_Time) {
            return $query;
        }

        if ($this->range === Range::Custom) {
            $start = Carbon::createFromFormat('Y-m-d', $this->start)->startOfDay();
            $end = Carbon::createFromFormat('Y-m-d', $this->end)->endOfDay();

            return $query->whereBetween('created_at', [$start, $end]);
        }

        return $query->whereBetween('created_at', $this->range->dates());
    }


    public function applyGestor($query)
    {
        if (empty($this->gestorSelected)) {
            return $query;
        }

        return $query->whereHas('participante', function ($q) {
            $q->whereIn('gestor_id', $this->gestorSelected);
        });
    }
}
