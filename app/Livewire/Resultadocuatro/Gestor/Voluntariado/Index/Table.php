<?php

namespace App\Livewire\Resultadocuatro\Gestor\Voluntariado\Index;

use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Index\Sortable;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Index\Searchable;
use App\Models\FichaVoluntario;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public Pais $pais;

    public Proyecto $proyecto;

    public $perPage = 10;

    public $selectedAlianzasIds = [];

    public $alianzasIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $selectedAlianza;

    public $openDrawer = false;


    #[Renderless]
    public function export()
    {
       // return (new AlianzasByGestorExport($this->selectedAlianzasIds))->download('alianzas.xlsx');
    }

    public function render()
    {
        $query = FichaVoluntario::with([
            'paisServicioDesarrollar',
            'paisMedioVida',
            'paisVinculadoDebido',
            'paisMedioVerificacionVoluntario',
            'paisAreaIntervencion',
            'directorio'
        ]);

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $voluntariados = $query->paginate($this->perPage);

        $this->alianzasIdsOnPage = $voluntariados->map(fn ($voluntariado) => (string) $voluntariado->id)->toArray();

        return view('livewire.resultadocuatro.gestor.voluntariado.index.table', [
            'voluntariados' => $voluntariados,
        ]);
    }
}
