<?php

namespace App\Livewire\Resultadotres\Gestor\Prealianzas\Index;

use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\PreAlianza;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use App\Exports\resultadortres\AlianzasByGestorExport;
use App\Exports\resultadotres\PrealianzasByGestorExport;
use Livewire\Attributes\On;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public Pais $pais;

    public Proyecto $proyecto;

    public $perPage = 10;

    public $selectedPreAlianzasIds = [];

    public $prealianzasIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $selectedAlianza;

    public $openDrawer = false;

    public $estado = [
        '1' => 'Atrasado', 
        '2' => 'Cierto nivel de atraso', 
        '3' => 'En tiempo'
    ];

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
            !auth()->user()->can('Exportar Pre Alianza'),
            403
        );
        return (new PrealianzasByGestorExport($this->selectedPreAlianzasIds))->download('prealianzas.xlsx');
    }

    #[On('refresh-prealianza')]
    public function render()
    {

        $query = PreAlianza::with([
            'areascoberturas',
            'coberturanacional',
            'socioImplementador:id,nombre',
            'tipoSector:id,tipo_sector_id',
            'tipoSectorPublico:id,pais_id,tipo_sector_publico_id',
            'tipoSectorPrivado:id,pais_id,tipo_sector_privado_id',
            'tamanoEmpresaPrivada:id,pais_id,tamano_empresa_privada_id',
            'origenEmpresaPrivada:id,pais_id,origen_empresa_privada_id',
            'tipoSectorComunitaria:id,pais_id,tipo_sector_comunitaria_id',
            'tipoSectorAcademica:id,pais_id,tipo_sector_academica_id',
            'tipoAlianza:id,pais_id,tipo_alianza_id',
            'coberturaGeografica:id,pais_id,cobertura_geografica_id',
            'lastActualizacionPrealianza',
        ]);

        $query->where('pais_id', $this->pais->id);

        $query->where('gestor_id', auth()->user()->id);

        if(count($this->selectedSociosIds)){
           $query->whereIn('socio_implementador_id', $this->selectedSociosIds);
        }

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $prealianzas = $query->paginate($this->perPage);

        $this->prealianzasIdsOnPage = $prealianzas->map(fn ($prealianza) => (string) $prealianza->id)->toArray();


        return view('livewire.resultadotres.gestor.prealianzas.index.table', [
            'prealianzas' => $prealianzas,
            'estado' => $this->estado
        ]);
    }

    public function selectParticipante(PreAlianza $prealianza)
    {

        $this->selectedAlianza = $prealianza;

        // $this->selectedAlianza->load([
        //     'estadosregistrosparticipantes:id,participante_id,estado_registro_id,created_at,created_by,comentario',
        //     'estadosregistrosparticipantes.estado_registro:id,nombre,color,icon,created_by',
        //     'estadosregistrosparticipantes.creator'
        // ]);

        $this->openDrawer = true;

    }

    public function delete($id)
    {

        $preAlianza = PreAlianza::find($id);

        abort_if(
            !auth()->user()->can('Eliminar Pre Alianza'),
            403
        );

        $preAlianza->delete();
        $this->dispatch('refresh-prealianza');
    }

    public function deleteSelected()
    {
        abort_if(
            !auth()->user()->can('Eliminar Pre Alianza'),
            403
        );
        
        PreAlianza::whereIn('id', $this->selectedPreAlianzasIds)->each(function ($prealianza) {
            $prealianza->delete();
        });

        $this->selectedPreAlianzasIds = [];
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-prealianza');
    }
}
