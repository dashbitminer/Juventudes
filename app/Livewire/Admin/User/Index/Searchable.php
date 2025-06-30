<?php

namespace App\Livewire\Admin\User\Index;

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

      //  $getSchoolsIds = EscuelaGWDATA::where('fkCodeCountry', $this->pais->codigo)->where('name', 'like', '%'.$this->search.'%')->pluck('id')->toArray();

        return $query->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orWhereHas('roles', function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->orWhereHas('socioImplementador.pais', function ($query) {
                $query->where('nombre', 'like', '%'.$this->search.'%');
            });


            // ->orWhereHas('paisPerfilSeguimiento', function ($query) {
            //     $query->whereHas('perfilSeguimiento', function ($query) {
            //         $query->where('nombre', 'like', '%'.$this->search.'%');
            //     });
            // });

    }
}
