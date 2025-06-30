<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Index;

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
            $builder->where('nombre', 'like', '%'.$this->search.'%')
                ->orWhere('personal_socio_seguimiento', 'like', '%'.$this->search.'%')
                ->orWhereHas('ciudad', function ($query) {
                    $query->where('nombre', 'like', '%'.$this->search.'%');
                });
        });
    }
}
