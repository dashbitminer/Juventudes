<?php

namespace App\Livewire\Resultadotres\Gestor\Visualizador\Index;

use App\Livewire\Resultadotres\Gestor\Visualizador\Enums\Formularios;
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

        switch ($this->selectedFormType){
            case Formularios::Apalancamiento->value:
            case Formularios::CostoCompartido->value:
                $query->where('nombre_organizacion', 'like', '%'.$this->search.'%')
                ->orWhere('nombre_persona_registra', 'like', '%'.$this->search.'%')
                    ->orWhereHas('ciudad', function ($query) {
                        $query->where('nombre', 'like', '%'.$this->search.'%');
                    });

                break;
            default:
                $query->where('nombre_organizacion', 'like', '%'.$this->search.'%')
                    ->orWhere('nombre_contacto', 'like', '%'.$this->search.'%')
                    ->orWhereHas('ciudad', function ($query) {
                        $query->where('nombre', 'like', '%'.$this->search.'%');
                    });
                break;
        }

        return $query;
    }
}
