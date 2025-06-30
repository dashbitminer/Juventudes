<?php

namespace App\Livewire\Admin\Mantenimientos\Razones\Index;

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

        return $query->where('nombre', 'like', '%'.$this->search.'%')
            ->orWhere('comentario', 'like', '%'.$this->search.'%')
            ->orWhereHas('categoriaRazon', function ($query) {
                $query->where('nombre', 'like', '%'.$this->search.'%');
            });


            // ->orWhereHas('paisPerfilSeguimiento', function ($query) {
            //     $query->whereHas('perfilSeguimiento', function ($query) {
            //         $query->where('nombre', 'like', '%'.$this->search.'%');
            //     });
            // });

    }
}
