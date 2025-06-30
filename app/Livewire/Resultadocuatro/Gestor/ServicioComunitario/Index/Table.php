<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Index;

use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\InitForm;
use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ServicioComunitario;
use Livewire\Attributes\Renderless;

class Table extends Component
{

    use WithPagination, Searchable, Sortable, InitForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public $perPage = 10;

    public $selectedIds = [];

    public $tableIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $enableExport = false;

    public $socioImplementador;

    public $cohortePaisProyecto;


    #[Renderless]
    public function export()
    {
        dd('export');
    }

    public function mount()
    {
        $this->socioImplementador = $this->getSocioImplementador();

        $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->firstOrFail();
    }

    #[On('refresh-servicios-comunitarios')]
    public function render()
    {
        //dd($this->socioImplementador->id);
        $query = ServicioComunitario::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'cohortePaisProyecto'
        ])
        ->where('socio_implementador_id', $this->socioImplementador->id)
        ->where('pais_id', $this->pais->id)
        ->whereHas('cohortePaisProyecto', function ($query) {
            $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
        });

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $servicioComunitarios = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $servicioComunitarios->map(fn ($models) => (string) $models->id)->toArray();

        return view('livewire.resultadocuatro.gestor.servicio_comunitario.index.table', [
            'servicioComunitarios' => $servicioComunitarios,
        ]);
    }

    public function delete(ServicioComunitario $servicioComunitarios)
    {
        $servicioComunitarios->delete();
        $this->dispatch('refresh-servicios-comunitarios');
    }

    public function deleteSelected()
    {
        ServicioComunitario::whereIn('id', $this->selectedIds)->each(function ($servicioComunitario) {
                $this->delete($servicioComunitario);
        });

        $this->selectedIds = [];
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-servicios-comunitarios');
    }

}
