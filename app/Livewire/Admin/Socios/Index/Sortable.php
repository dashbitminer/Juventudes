<?php

namespace App\Livewire\Admin\Socios\Index;

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

        if ($this->sortCol === 'socio') {
            $query->orderBy('nombre', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'pais') {
            $query->orderBy('pais_id', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'fecha') {
            $query->orderBy('created_at', $this->sortAsc ? 'asc' : 'desc');
        }

        return $query;
    }
}
