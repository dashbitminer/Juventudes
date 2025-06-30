<?php

namespace App\Livewire\Resultadotres\Gestor\CostShares\Index;

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

        return $query->where('nombre_organizacion', 'like', '%'.$this->search.'%')
            ->orWhere('nombre_persona_registra', 'like', '%'.$this->search.'%')
            ->orWhereHas('ciudad', function ($query) {
                $query->where('nombre', 'like', '%'.$this->search.'%');
            });
    }
}
