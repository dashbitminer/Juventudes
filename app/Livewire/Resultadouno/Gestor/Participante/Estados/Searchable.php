<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Estados;

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

        return $query->where('comentario', 'like', '%'.$this->search.'%');
    }
}
