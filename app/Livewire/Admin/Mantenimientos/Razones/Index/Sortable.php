<?php

namespace App\Livewire\Admin\Mantenimientos\Razones\Index;

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
                // EstadoRegistro::select('nombre')
                //     ->join('estado_registro_participante', 'estado_registro_participante.estado_registro_id', '=', 'estado_registros.id')
                //     ->whereColumn('estado_registro_participante.participante_id', 'participantes.id')
                //     ->orderBy('estado_registro_participante.created_at', 'desc')
                //     ->limit(1),
                $this->sortAsc ? 'asc' : 'desc'
            );

        }

        if ($this->sortCol === 'fecha') {
            $query->orderBy('created_at', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'edad') {
            $query->orderBy('fecha_nacimiento', $this->sortAsc ? 'asc' : 'desc');
        }

        return $query;
    }
}
