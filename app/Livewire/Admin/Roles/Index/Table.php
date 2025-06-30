<?php

namespace App\Livewire\Admin\Roles\Index;

use Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use App\Livewire\Admin\Roles\Index\Sortable;
use App\Livewire\Admin\Roles\Index\Searchable;
use Livewire\Attributes\On;

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

    #[On('refresh-roles')]
    public function render()
    {
        $query = Role::with("permissions:id,name")->withCount("permissions");

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $roles = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $roles->map(fn ($role) => (string) $role->id)->toArray();

        return view('livewire.admin.roles.index.table', [
            'roles' => $roles
        ])
        ->layout('layouts.app', ['title' => 'Roles', 'breadcrumb' => 'Roles', 'admin' => true]);
    }

    public function delete(Role $role)
    {
        $role->delete();

        $this->dispatch('refresh-roles');

        $this->showSuccessIndicator = true;
    }

    public function deleteSelected()
    {
        Role::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-roles');

        $this->selectedIds = [];
    }
}
