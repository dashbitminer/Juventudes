<?php

namespace App\Livewire\Admin\Socios\Index;

use Livewire\Component;
use App\Models\SocioImplementador;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use App\Livewire\Admin\Socios\Index\Sortable;
use App\Livewire\Admin\Socios\Index\Searchable;
use Livewire\Attributes\On;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public $perPage = 10;

    public $selectedIds = [];

    public $tableIdsOnPage = [];

    public $showSuccessIndicator = false;

    #[Renderless]
    public function export()
    {
        //dd('export');
    }

    #[On('refresh-socios')]
    public function render()
    {
        $query = SocioImplementador::with("pais:id,nombre")
            ->active()
            ->orderBy('created_at', 'DESC');

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $socios = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $socios->map(fn ($role) => (string) $role->id)->toArray();

        return view('livewire.admin.socios.index.table', [
            'socios' => $socios
        ])
        ->layout('layouts.app', ['title' => 'Socios', 'breadcrumb' => 'Socios', 'admin' => true]);
    }

    public function delete($socio)
    {
        $socio = SocioImplementador::find($socio);

        if ($socio) {
            $socio->delete();

            $this->dispatch('refresh-socios');

            $this->showSuccessIndicator = true;
        }
    }

    public function deleteSelected()
    {
        SocioImplementador::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-socios');

        $this->selectedIds = [];
    }
}
