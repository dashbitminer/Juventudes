<?php

namespace App\Livewire\Admin\Cohortes\Index;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\WithPagination;
use App\Livewire\Admin\Cohortes\Index\Sortable;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\PaisProyecto;
use Maatwebsite\Excel\Concerns\ToArray;

class Table extends Component
{
    use WithPagination, Sortable, Searchable;

    public Proyecto $proyecto;

    public PaisProyecto $paisProyecto;

    public $perPage = 10;

    public $selectedIds = [];

    public $selectedPaisesIds = [];

    public $tableIdsOnPage = [];

    public $enableExport = false;

    public $showSuccessIndicator = false;

    public $showPaisesDropdown = true;

    public $paises = [];

    public function mount(){

        $paisProyecto = PaisProyecto::with(['pais'])
            ->where('proyecto_id', $this->proyecto->id)
            ->active();
        
        $this->paises = $paisProyecto->get()
            ->pluck('pais.nombre', 'id')
            ->toArray();


        $this->showPaisesDropdown = count($this->paises) > 1;
       
        $this->paisProyecto = $paisProyecto->firstOrFail();

        $this->selectedPaisesIds[] = $this->paisProyecto->id;

    }

    #[On('refresh-cohortes')]
    public function render()
    {
        $query = CohortePaisProyecto::query();

        if(count($this->selectedPaisesIds)) {
            $query = $query->whereIn('pais_proyecto_id', $this->selectedPaisesIds);
        }else {
            $ids = array_keys($this->paises);
            $query = $query->whereIn('pais_proyecto_id', $ids);
        }
        
        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $cohortePaisProyectos = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $cohortePaisProyectos->map(fn ($cohorte) => (string) $cohorte->id)->toArray();

        return view('livewire.admin.cohortes.index.table', [
            'cohortePaisProyectos' => $cohortePaisProyectos
        ])
        ->layout('layouts.app', ['title' => 'Cohortes', 'breadcrumb' => 'Cohortes', 'admin' => true]);
    }

    public function deleteSelected()
    {
        CohortePaisProyecto::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-cohortes');
    }

    public function delete(CohortePaisProyecto $cohortePaisProyecto)
    {   
        $cohortePaisProyecto->delete();

        $this->dispatch('refresh-cohortes');

        $this->showSuccessIndicator = true;
    }
}
