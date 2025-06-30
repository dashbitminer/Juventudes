<?php

namespace App\Livewire\Resultadotres\Gestor\CostShares\Index;

use App\Exports\resultadotres\ApalancamientosByGestorExport;
use App\Exports\resultadotres\CostShareByGestorExport;
use App\Models\Pais;
use App\Models\Apalancamiento;
use App\Models\CostShare;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public Pais $pais;

    public Proyecto $proyecto;

    public $perPage = 10;

    public $selectedCostSharesIds = [];

    public $costSharesIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $selectedCostShares;

    public $openDrawer = false;

    public $socios;

    public $showSociosDropdown;

    public $selectedSocio;

    public $selectedSociosIds = [];


    #[Renderless]
    public function export()
    {
        abort_if(
            !auth()->user()->can('Exportar Costo Compartido'),
            403
        );

        return (new CostShareByGestorExport($this->selectedCostSharesIds, $this->pais, $this->socios))
            ->download('costo-compartido.xlsx');
    }

    public function mount(){
        $this->socios = \App\Models\SocioImplementador::active()
            ->where('pais_id', $this->pais->id)
            ->get();

        $this->showSociosDropdown = true;

        if (auth()->user()->can('Filtrar registros por socio')) {
            $this->showSociosDropdown = false;
            $this->selectedSocio = auth()->user()->socio_implementador_id;
            $this->selectedSociosIds[] = $this->selectedSocio;
        } elseif (auth()->user()->can('Filtrar registros por socios por pais')) {
            $this->showSociosDropdown = true;
            $this->selectedSociosIds = $this->socios->pluck('id')->toArray();
        } else { 
            $this->showSociosDropdown = false;
            $this->selectedSocio = auth()->user()->socio_implementador_id;
            $this->selectedSociosIds[] = $this->selectedSocio;
        }
    }

    #[On('refresh-cost-share')]
    public function render()
    {

        $query = CostShare::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'lastEstado.estado_registro:id,nombre,color,icon'
        ]);

        $query->where('pais_id', $this->pais->id);

        $query->where('gestor_id', auth()->user()->id);

        if(count($this->selectedSociosIds)){
            $query->whereIn('socio_implementador_id', $this->selectedSociosIds);
        }

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $costShares = $query->paginate($this->perPage);

        $this->costSharesIdsOnPage = $costShares->map(fn ($costShare) => (string) $costShare->id)
            ->toArray();


        return view('livewire.resultadotres.gestor.cost-shares.index.table', [
            'costShares' => $costShares,
        ]);
    }

    public function selectParticipante(Apalancamiento $apalancamiento)
    {

        $this->selectedCostShares = $apalancamiento;

        $this->openDrawer = true;

    }

    public function delete(CostShare $costShare)
    {
        abort_if(
            !auth()->user()->can('Eliminar Costo Compartido'),
            403
        );

        $costShare->delete();
        $this->dispatch('refresh-cost-share');
    }

    public function deleteSelected()
    {
        abort_if(
            !auth()->user()->can('Eliminar Costo Compartido'),
            403
        );
        
        CostShare::whereIn('id', $this->selectedCostSharesIds)->each(function ($costShare) {
                $costShare->delete();
        });

        $this->selectedCostSharesIds = [];
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-cost-share');
    }
}
