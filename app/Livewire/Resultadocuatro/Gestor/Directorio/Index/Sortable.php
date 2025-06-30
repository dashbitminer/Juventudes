<?php

namespace App\Livewire\Resultadocuatro\Gestor\Directorio\Index;

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
            $query->orderBy('nombre', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'contacto') {
            $query->orderBy('ref_nombre', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'institucion') {
            $query->orderBy('tipo_institucion_id', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'fecha') {
            $query->orderBy('created_at', $this->sortAsc ? 'asc' : 'desc');
        }

        return $query;
    }
}
