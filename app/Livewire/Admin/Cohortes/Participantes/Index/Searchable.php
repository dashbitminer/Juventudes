<?php

namespace App\Livewire\Admin\Cohortes\Participantes\Index;

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
        if ($this->search === '') {
            return $query;
        }

        $this->search = trim($this->search);

        return $query->whereHas('participante', function ($q) {
            $q->where('nombres', 'like', '%' . $this->search . '%')
            ->orWhere('apellidos', 'like', '%' . $this->search . '%')
            ->orWhere('primer_nombre', 'like', '%' . $this->search . '%')
            ->orWhere('segundo_nombre', 'like', '%' . $this->search . '%')
            ->orWhere('tercer_nombre', 'like', '%' . $this->search . '%')
            ->orWhere('primer_apellido', 'like', '%' . $this->search . '%')
            ->orWhere('segundo_apellido', 'like', '%' . $this->search . '%')
            ->orWhere('tercer_apellido', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('documento_identidad', 'like', '%' . $this->search . '%')
            ;
        });
    }
}
