<?php

namespace App\Livewire\Admin\Sesiones\Actividad;

trait Searchable
{
    public $search = '';

    public function updatedSearchable($property)
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }

    protected function applySearch($query)
    {
        if($this->search === ''){
            return $query;
        }

        // $this->search = trim($this->search);

        return $query->where('nombre', 'like', '%'.$this->search.'%')
            ->orWhere('comentario', 'like', '%'.$this->search.'%');

    }
}
