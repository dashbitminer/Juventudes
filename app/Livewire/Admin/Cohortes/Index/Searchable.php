<?php

namespace App\Livewire\Admin\Cohortes\Index;

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

        return $query->whereHas('cohorte', function ($q)  {
            $q->where('nombre', 'like', '%' . $this->search . '%');
        });

    }
}
