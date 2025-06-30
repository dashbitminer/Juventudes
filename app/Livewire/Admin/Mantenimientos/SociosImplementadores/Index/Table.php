<?php

namespace App\Livewire\Admin\Mantenimientos\SociosImplementadores\Index;

use Livewire\Component;
use App\Models\SocioImplementador;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use App\Livewire\Admin\Mantenimientos\SociosImplementadores\Index\Sortable;
use App\Livewire\Admin\Mantenimientos\SociosImplementadores\Index\Searchable;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public $perPage = 10;

    public $selectedIds = [];

    public $tableIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $enableExport = true;

    #[Renderless]
    public function export()
    {
        dd('export');
    }

    public function render()
    {
        $query = SocioImplementador::with("pais:id,nombre")->withCount("users");

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $sociosImplementadores = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $sociosImplementadores->map(fn ($socio) => (string) $socio->id)->toArray();

        return view('livewire.admin.mantenimientos.socios-implementadores.index.table', [
            'sociosImplementadores' => $sociosImplementadores
        ])
        ->layout('layouts.app', ['title' => 'Socios Implementadores', 'breadcrumb' => 'Socios Implementadores', 'admin' => true]);
    }
}
