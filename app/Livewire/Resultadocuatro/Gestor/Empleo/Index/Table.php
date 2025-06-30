<?php

namespace App\Livewire\Resultadocuatro\Gestor\Empleo\Index;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\WithPagination;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Cohorte;
use App\Models\Participante;
use App\Models\FichaEmpleo;

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

    public $openDrawer = false;

    public $enableExport = false;

    #[Renderless]
    public function export()
    {
        dd('export');
    }

    #[On('refresh-ficha-empleos')]
    public function render()
    {
        $query = FichaEmpleo::with([
            "participante",
            "mediosVida",
            "directorios",
            "sectorEmpresaOrganizacion",
            "tipoEmpleo",
        ])->active();

        $query = $this->applySearch($query);
        $query = $this->applySorting($query);
        $empleos = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $empleos->map(fn ($models) => (string) $models->id)->toArray();

        return view('livewire.resultadocuatro.gestor.empleo.index.table', [
            'empleos' => $empleos,
        ]);
    }

    public function delete(FichaEmpleo $empleo)
    {
        $empleo->delete();

        $this->dispatch('refresh-ficha-empleos');
    }
}
