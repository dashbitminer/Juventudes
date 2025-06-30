<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Index;

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

        if ($this->sortCol === 'personal_socio_seguimiento') {
            $query->orderBy('personal_socio_seguimiento', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'progreso') {
            $query->orderBy('progreso', $this->sortAsc ? 'asc' : 'desc');
        }


        return $query;
    }
}
