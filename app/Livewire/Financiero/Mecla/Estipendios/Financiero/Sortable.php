<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Financiero;

use App\Models\Estado;
use App\Models\EstadoRegistro;
use App\Models\EstipendioAgrupacionParticipante;
use App\Models\SocioImplementador;
use Livewire\Attributes\Url;

trait Sortable
{
    #[Url]
    public $sortCol;

    #[Url]
    public $sortAsc = false;


    public function updatedSortable($property)
    {
        if ($property === 'sortCol') {
            $this->resetPage();
        }
    }

    public function sortBy($column)
    {
        if ($this->sortCol === $column) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortCol = $column;
            $this->sortAsc = false;
        }
    }

    protected function applySorting($query)
    {
        if (!$this->sortCol) {
            return $query;
        }

        if ($this->sortCol === 'nombres') {
            $query->orderBy('primer_nombre', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'estado') {
            $query->orderBy(
                Estado::select('nombre')
                    ->join('estado_participante', 'estado_participante.estado_id', '=', 'estados.id')
                    ->join('grupo_participante', 'grupo_participante.id', '=', 'estado_participante.grupo_participante_id')
                    ->join('cohorte_participante_proyecto', 'cohorte_participante_proyecto.id', '=', 'grupo_participante.cohorte_participante_proyecto_id')
                    ->whereColumn('cohorte_participante_proyecto.participante_id', 'participantes.id')
                    ->orderBy('estado_participante.id', 'desc')
                    ->limit(1),
                $this->sortAsc ? 'asc' : 'desc'
            );
        }

        if ($this->sortCol === 'socio') {
            $query->orderBy(
                SocioImplementador::select('nombre')
                    ->join('users', 'users.socio_implementador_id', '=', 'socios_implementadores.id')
                    ->whereColumn('users.id', 'participantes.gestor_id')
                    ->limit(1),
                $this->sortAsc ? 'asc' : 'desc'
            );
        }


        // Orden dinamico por agrupacion
        if (str_starts_with($this->sortCol, 'agrupacion_')) {
            $agrupacion_id = substr($this->sortCol, 11);

            $query->orderBy(
                EstipendioAgrupacionParticipante::select('porcentaje')
                    ->whereColumn('participante_id', 'participantes.id')
                    ->where('estipendio_agrupacion_id', $agrupacion_id)
                    ->orderBy('id', 'desc')
                    ->limit(1),
                $this->sortAsc? 'asc' : 'desc'
            );
        }

        return $query;
    }
}
