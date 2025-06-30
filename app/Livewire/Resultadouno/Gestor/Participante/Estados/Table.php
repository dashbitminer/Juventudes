<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Estados;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\Participante;
use App\Models\EstadoParticipante;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;

    public $perPage = 10;

    public $selectedIds = [];

    public $tableIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $totalHistorico = 0;

    #[On('refresh-participante-estados')]
    public function render()
    {
        $this->participante->load('grupoactivo');

        $query = EstadoParticipante::with([
            'estado',
            'razon.categoriaRazon',
        ])->when($this->participante->grupoactivo, function ($query) {
            $query->where('grupo_participante_id', $this->participante->grupoactivo->id);
        });

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $historial = $query->paginate($this->perPage);

        $this->totalHistorico = $historial->total();

        $this->tableIdsOnPage = $historial->map(fn ($model) => (string) $model->id)->toArray();

        return view('livewire.resultadouno.gestor.participante.estados.table', [
            'historial' => $historial
        ]);
    }

    public function delete($id)
    {
        EstadoParticipante::destroy($id);

        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-participante-estados');
    }

    public function deleteSelected()
    {
        // Elimina todos a excepcion del primero, siempre debe de existir un estado
        if ($this->totalHistorico == count($this->selectedIds)) {
            unset($this->selectedIds[0]);
        }

        EstadoParticipante::whereIn('id', $this->selectedIds)->delete();

        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-participante-estados');

        $this->selectedIds = [];
    }
}
