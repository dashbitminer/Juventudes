<?php

namespace App\Livewire\Resultadotres\Gestor\Alianzas\Index;

use App\Exports\resultadotres\AlianzasByGestorExport;
use App\Models\Pais;
use App\Models\Alianza;
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

    public $selectedAlianzasIds = [];

    public $alianzasIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $selectedAlianza;

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
            !auth()->user()->can('Exportar Alianza'),
            403
        );

        return (new AlianzasByGestorExport($this->selectedAlianzasIds, $this->pais, $this->socios, $this->selectedSociosIds))->download('alianzas.xlsx');
    }

    #[On('refresh-alianza')]
    public function render()
    {

        $query = Alianza::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'lastEstado.estado_registro:id,nombre,color,icon'
        ]);

        $query->where('pais_id', $this->pais->id);

        if(count($this->selectedSociosIds)){
            $query->whereIn('socio_implementador_id', $this->selectedSociosIds);
        }

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $alianzas = $query->paginate($this->perPage);

        $this->alianzasIdsOnPage = $alianzas->map(fn ($alianza) => (string) $alianza->id)->toArray();


        return view('livewire.resultadotres.gestor.alianzas.index.table', [
            'alianzas' => $alianzas,
        ]);
    }

    public function selectParticipante(Alianza $alianza)
    {

        $this->selectedAlianza = $alianza;

        // $this->selectedAlianza->load([
        //     'estadosregistrosparticipantes:id,participante_id,estado_registro_id,created_at,created_by,comentario',
        //     'estadosregistrosparticipantes.estado_registro:id,nombre,color,icon,created_by',
        //     'estadosregistrosparticipantes.creator'
        // ]);

        $this->openDrawer = true;

    }

    public function delete(Alianza $alianza)
    {
        abort_if(
            !auth()->user()->can('Eliminar Alianza'),
            403
        );

        $alianza->delete();
        $this->dispatch('refresh-alianza');
    }

    public function deleteSelected()
    {
        abort_if(
            !auth()->user()->can('Eliminar Alianza'),
            403
        );

        Alianza::whereIn('id', $this->selectedAlianzasIds)->each(function ($alianza) {
            $alianza->delete();
        });

        $this->selectedAlianzasIds = [];
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-alianza');
    }
}
