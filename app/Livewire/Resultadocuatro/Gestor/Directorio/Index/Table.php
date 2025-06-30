<?php

namespace App\Livewire\Resultadocuatro\Gestor\Directorio\Index;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Directorio;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;

class Table extends Component
{

    use WithPagination, Searchable, Sortable;

    public Pais $pais;

    public Proyecto $proyecto;

    public ?Cohorte $cohorte;

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

    #[On('refresh-directorios')]
    public function render()
    {
        $query = Directorio::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'tipoInstitucion'
        ]);

        $query = $this->applySearch($query);
        $query = $this->applySorting($query);
        $directorios = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $directorios->map(fn ($models) => (string) $models->id)->toArray();

        return view('livewire.resultadocuatro.gestor.directorio.index.table', [
            'directorios' => $directorios,
        ]);
    }

    public function delete(Directorio $directorio)
    {
        $directorio->delete();

        $this->dispatch('refresh-directorios');
    }

}
