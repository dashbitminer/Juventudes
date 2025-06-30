<?php

namespace App\Livewire\Admin\Mantenimientos\Razones\Index;

use Livewire\Component;
use App\Models\Razon;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use App\Livewire\Admin\Mantenimientos\Razones\Index\Sortable;
use App\Livewire\Admin\Mantenimientos\Razones\Index\Searchable;

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
        $query = Razon::with("categoriaRazon:id,nombre,tipo");

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $razones = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $razones->map(fn ($razon) => (string) $razon->id)->toArray();

        return view('livewire.admin.mantenimientos.razones.index.table', [
            'razones' => $razones
        ])
        ->layout('layouts.app', ['title' => 'Razones', 'breadcrumb' => 'Razones', 'admin' => true]);
    }
}
