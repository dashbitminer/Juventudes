<?php

namespace App\Livewire\Financiero\Coordinador\Participante\Index;

use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;

trait Sortable
{
    #[Url]
    public $sortCol;

    #[Url]
    public $sortAsc = false;


    public function updatedSortable($property)
    {
        if ($property === 'sortCol') {
            $this->resetPage();
        }
    }

    public function sortBy($column)
    {
        if ($this->sortCol === $column) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortCol = $column;
            $this->sortAsc = false;
        }
    }

    protected function applySorting($query)
    {
        if (!$this->sortCol) {
            return $query;
        }

        if ($this->sortCol === 'nombres') {
            $query->orderBy('primer_nombre', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'edad') {
            $query->orderBy('fecha_nacimiento', $this->sortAsc ? 'asc' : 'desc');
        }

        if($this->sortCol === 'gestor'){
            $query->orderBy('nombre_gestor', $this->sortAsc ? 'asc' : 'desc');
        }

        if($this->sortCol === 'ciudad'){
            $query->orderBy('nombre_ciudad', $this->sortAsc ? 'asc' : 'desc');
        }


        if ($this->sortCol === 'perfil') {

            $query->orderBy(
                DB::table('cohorte_participante_proyecto')
                    ->join('cohorte_pais_proyecto_perfil', 'cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', '=', 'cohorte_pais_proyecto_perfil.id')
                    ->join('perfiles_participantes', 'cohorte_pais_proyecto_perfil.perfil_participante_id', '=', 'perfiles_participantes.id')
                    ->select('perfiles_participantes.nombre')
                    ->whereColumn('cohorte_participante_proyecto.participante_id', 'participantes.id')
                    ->orderBy('cohorte_participante_proyecto.created_at', 'desc')
                    ->limit(1),
                $this->sortAsc ? 'asc' : 'desc'
            );

        }


        if ($this->sortCol === 'fecha') {
            $query->orderBy('created_at', $this->sortAsc ? 'asc' : 'desc');
        }

        return $query;
    }
}
