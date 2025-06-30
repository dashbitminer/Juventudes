<?php

namespace App\Livewire\Admin\Sesiones\Sesion;

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

        return $query->whereHas('titulos', function ($query) {
                $query->where('nombre', 'like', '%'.$this->search.'%');
            });

    }
}
