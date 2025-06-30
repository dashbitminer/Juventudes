<?php

namespace App\Livewire\Admin\Permisos\Index;

use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use App\Livewire\Admin\Permisos\Index\Sortable;
use App\Livewire\Admin\Permisos\Index\Searchable;
use Livewire\Attributes\On;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public $perPage = 10;

    public $selectedParticipanteIds = [];

    public $selectedIds = [];

    public $participanteIdsOnPage = [];

    public $tableIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $enableExport = true;

    #[Renderless]
    public function export()
    {
        dd('export');
    }

    #[On('refresh-permisos')]
    public function render()
    {
        $query = Permission::with("creator:id,name", "roles:id,name")
        ->withCount("roles");


        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        //$query = $this->filters->apply($query);

        $permisos = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $permisos->map(fn ($permiso) => (string) $permiso->id)->toArray();


        return view('livewire.admin.permisos.index.table',[
            'permisos' => $permisos
        ])
        ->layout('layouts.app', ['title' => 'Permisos', 'breadcrumb' => 'Permisos', 'admin' => true]);
    }

    public function delete(Permission $permiso)
    {
        $permiso->delete();

        $this->dispatch('refresh-permisos');

        $this->showSuccessIndicator = true;
    }

    public function deleteSelected()
    {
        Permission::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-permisos');

        $this->selectedIds = [];
    }
}
