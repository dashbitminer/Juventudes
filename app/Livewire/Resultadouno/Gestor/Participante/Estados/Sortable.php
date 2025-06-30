<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Estados;

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

        if ($this->sortCol === 'estado') {
            $query->orderBy('estado_id', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'fecha') {
            $query->orderBy('created_at', $this->sortAsc ? 'asc' : 'desc');
        }

        return $query;
    }
}
