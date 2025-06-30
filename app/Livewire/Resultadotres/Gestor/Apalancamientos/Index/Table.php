<?php

namespace App\Livewire\Resultadotres\Gestor\Apalancamientos\Index;

use App\Exports\resultadotres\ApalancamientosByGestorExport;
use App\Models\Pais;
use App\Models\Apalancamiento;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\On;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public Pais $pais;

    public Proyecto $proyecto;

    public $perPage = 10;

    public $selectedApalancamientosIds = [];

    public $apalancamientosIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $selectedApalancamientos;

    public $openDrawer = false;

    public $socios;

    public $showSociosDropdown;

    public $selectedSocio;

    public $selectedSociosIds = [];


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
    
    #[Renderless]
    public function export()
    {
        abort_if(
            !auth()->user()->can('Exportar Apalancamiento'),
            403
        );
        return (new ApalancamientosByGestorExport($this->selectedApalancamientosIds, $this->pais, $this->socios))
            ->download('apalancamientos.xlsx');
    }

    #[On('refresh-apalancamiento')]
    public function render()
    {

        $query = Apalancamiento::with([
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

        $apalancamientos = $query->paginate($this->perPage);

        $this->apalancamientosIdsOnPage = $apalancamientos->map(fn ($apalancamiento) => (string) $apalancamiento->id)
            ->toArray();


        return view('livewire.resultadotres.gestor.apalancamientos.index.table', [
            'apalancamientos' => $apalancamientos,
        ]);
    }

    public function selectParticipante(Apalancamiento $apalancamiento)
    {

        $this->selectedApalancamientos = $apalancamiento;

        $this->openDrawer = true;

    }

    public function delete(Apalancamiento $apalancamiento)
    {
        abort_if(
            !auth()->user()->can('Eliminar Apalancamiento'),
            403
        );

        $apalancamiento->delete();
        $this->dispatch('refresh-apalancamiento');
    }

    public function deleteSelected()
    {
        abort_if(
            !auth()->user()->can('Eliminar Apalancamiento'),
            403
        );
        
        Apalancamiento::whereIn('id', $this->selectedApalancamientosIds)->each(function ($apalancamiento) {
            $apalancamiento->delete();
        });

        $this->selectedApalancamientosIds = [];
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-apalancamiento');
    }

    //
}
