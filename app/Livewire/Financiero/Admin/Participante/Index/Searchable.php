<?php

namespace App\Livewire\Financiero\Admin\Participante\Index;

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
        if(trim($this->search) === ''){
            return $query;
        }

        $termino = trim($this->search);

        return $query->where("bancarizacion_grupos.nombre", 'like', '%'.$termino.'%');

        // return $query->where(function($query) use ($termino) {
        //     $query->whereRaw("
        //             CONCAT(
        //                 TRIM(COALESCE(primer_nombre, '')),
        //                 IF(TRIM(COALESCE(segundo_nombre, '')) != '', CONCAT(' ', TRIM(COALESCE(segundo_nombre, ''))), ''),
        //                 IF(TRIM(COALESCE(tercer_nombre, '')) != '', CONCAT(' ', TRIM(COALESCE(tercer_nombre, ''))), ''),
        //                 IF(TRIM(COALESCE(primer_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(primer_apellido, ''))), ''),
        //                 IF(TRIM(COALESCE(segundo_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(segundo_apellido, ''))), ''),
        //                 IF(TRIM(COALESCE(tercer_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(tercer_apellido, ''))), '')
        //             ) like ?", ['%'.$termino.'%']
        //         )
        //         ->orWhere('email', 'like', '%'.$termino.'%')
        //         ->orWhere('documento_identidad', 'like', '%'.$termino.'%')
        //         ->orWhereHas('ciudad', function ($query) use($termino) {
        //             $query->where('nombre', 'like', '%'.$termino.'%');
        //         });
        // });
    }
}
