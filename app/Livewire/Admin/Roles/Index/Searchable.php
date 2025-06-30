<?php

namespace App\Livewire\Admin\Roles\Index;

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

        $this->search = trim($this->search);

        return $query->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('guard_name', 'like', '%'.$this->search.'%')
         //   ->orWhere('categoria', 'like', '%'.$this->search.'%')
            ->orWhereHas('creator', function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            });

    }
}
