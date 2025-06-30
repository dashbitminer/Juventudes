<?php

namespace App\Livewire\Admin\Proyectos\Index;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\WithPagination;
use App\Livewire\Admin\Proyectos\Index\Sortable;

class Table extends Component
{
    use WithPagination, Sortable, Searchable;

    public $perPage = 10;

    public $selectedIds = [];

    public $tableIdsOnPage = [];

    public $enableExport = false;

    public $showSuccessIndicator = false;

    #[On('refresh-proyectos')]
    public function render()
    {
        $query = Proyecto::with('paises:id,nombre');

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $proyectos = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $proyectos->map(fn ($proyecto) => (string) $proyecto->id)->toArray();

        return view('livewire.admin.proyectos.index.table', [
            'proyectos' => $proyectos
        ])
        ->layout('layouts.app', ['title' => 'Proyectos', 'breadcrumb' => 'Proyectos', 'admin' => true]);
    }

    public function deleteSelected()
    {
        Proyecto::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-proyectos');
    }

    public function delete(Proyecto $proyecto)
    {   
        $proyecto->delete();

        $this->dispatch('refresh-proyectos');

        $this->showSuccessIndicator = true;
    }
}
