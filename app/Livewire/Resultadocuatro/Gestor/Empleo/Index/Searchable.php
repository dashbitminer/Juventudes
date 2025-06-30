<?php

namespace App\Livewire\Resultadocuatro\Gestor\Empleo\Index;

use Illuminate\Database\Eloquent\Builder;

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

        return $query->where(function (Builder $builder) {
            $builder->whereHas('mediosVida', fn($subquery) => $subquery->where('nombre', 'like', '%'.$this->search.'%'))
                ->orWhereHas('directorios', fn($subquery) => $subquery->where('nombre', 'like', '%'.$this->search.'%'))
                ->orWhereHas('sectorEmpresaOrganizacion', fn($subquery) => $subquery->where('nombre', 'like', '%'.$this->search.'%'))
                ->orWhereHas('tipoEmpleo', fn($subquery) => $subquery->where('nombre', 'like', '%'.$this->search.'%'));
        });
    }
}
