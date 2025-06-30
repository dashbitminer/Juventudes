<?php

namespace App\Livewire\Financiero\Admin\Participante\Index;

use App\Models\SocioImplementador;
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
            $query->orderBy('nombre', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'edad') {
            $query->orderBy('fecha_nacimiento', $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->sortCol === 'socio') {

            $query->orderBy(
                SocioImplementador::select('nombre')
                    ->join('users', 'users.socio_implementador_id', '=', 'socios_implementadores.id')
                    ->whereColumn('bancarizacion_grupos.created_by', 'users.id')
                   // ->orderBy('estado_registro_participante.created_at', 'desc')
                    ->limit(1),
                $this->sortAsc ? 'asc' : 'desc'
            );
        }

        if ($this->sortCol === 'cantidad') {
            $query->orderBy('participantes_count', $this->sortAsc ? 'asc' : 'desc');
        }


        if ($this->sortCol === 'fecha') {
            $query->orderBy('created_at', $this->sortAsc ? 'asc' : 'desc');
        }

        return $query;
    }
}
