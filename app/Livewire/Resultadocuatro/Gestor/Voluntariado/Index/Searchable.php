<?php

namespace App\Livewire\Resultadocuatro\Gestor\Voluntariado\Index;

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
            ->orWhere('nombre_contacto', 'like', '%'.$this->search.'%')
            ->orWhere('email_contacto', 'like', '%'.$this->search.'%')
            ->orWhere('telefono_contacto', 'like', '%'.$this->search.'%')
            ->orWhereHas('ciudad', function ($query) {
                $query->where('nombre', 'like', '%'.$this->search.'%');
            });
    }
}
