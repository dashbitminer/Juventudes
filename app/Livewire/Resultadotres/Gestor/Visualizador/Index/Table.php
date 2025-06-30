<?php

namespace App\Livewire\Resultadotres\Gestor\Visualizador\Index;

use App\Exports\resultadotres\AlianzasByGestorExport;
use App\Exports\resultadotres\ApalancamientosByGestorExport;
use App\Exports\resultadotres\CostShareByGestorExport;
use App\Livewire\Resultadotres\Gestor\Visualizador\Enums\Formularios;
use App\Models\Alianza;
use App\Models\Apalancamiento;
use App\Models\CoordinadorGestor;
use App\Models\CostShare;
use App\Models\EstadoRegistroAlianza;
use App\Models\EstadoRegistroApalancamiento;
use App\Models\EstadoRegistroCostShare;
use App\Models\Pais;
use App\Models\PaisProyecto;
use App\Models\Proyecto;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public Pais $pais;

    public Proyecto $proyecto;

    public $perPage = 10;

    public $cohortes;

    public $socios;

    public $mipais;

    public $showSociosDropdown;

    public $selectedFormTypes = [];

    public $selectedSocio;

    public $selectedSociosIds = [];

    public $selectedIds = [];

    public $selectedFormType = Formularios::Alianzas->value;

    

    public $route = 'alianza.revisar';

    public $tableIdsOnPage = [];

    public $placeholder = "Buscar por nombre de contacto, nombre organizacion";

    public $progress = 0;

    public $processing = false;

    public PaisProyecto $paisProyecto;

    public $showEmtyIfNotSocioSelected = false;

    public $formShown = 'alianza';

    #[Renderless]
    public function export()
    {
        abort_if(
            !auth()->user()->can('Exportar Visualizador R3'),
            403
        );

        switch ($this->selectedFormType) {

            case Formularios::Apalancamiento->value:
                return (new ApalancamientosByGestorExport($this->selectedIds, $this->pais, $this->socios))
                    ->download('formularios-apalancamientos-resultado3.xlsx');

            case Formularios::CostoCompartido->value:
                return (new CostShareByGestorExport($this->selectedIds, $this->pais, $this->socios))
                    ->download('formularios-costo-compartidos-resultado3.xlsx');
            default:
                return (new AlianzasByGestorExport($this->selectedIds, $this->pais, $this->socios, $this->selectedSociosIds))
                    ->download('formularios-alianzas-resultado3.xlsx');

        }

    }

    public function mount()
    {
        $this->paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        $this->selectedFormTypes = array_map(fn($type) => $type->value, Formularios::cases());

        $this->initSocios();
    }

    public function render()
    {
        abort_if(
            !auth()->user()->can('Listar Visualizador R3'),
            403
        );

        return view('livewire.resultadotres.gestor.visualizador.index.table', [
            'formularios' => $this->getData(),
        ]);
    }

    public function getData()
    {
        switch ($this->selectedFormType){
            case Formularios::Apalancamiento->value:
                $query = $this->getBaseQuery(\App\Models\Apalancamiento::class);
                $this->route = 'apalancamiento.revisar';
                $this->formShown = 'apalancamiento';
                break;
            case Formularios::CostoCompartido->value:
                $query = $this->getBaseQuery(\App\Models\CostShare::class);
                $this->route = 'cost-share.revisar';
                $this->formShown = 'cost-share';
                break;

            default:
                $query = $this->getBaseQuery(\App\Models\Alianza::class);
                $this->route = 'alianza.revisar';
                $this->formShown = 'alianza';
                break;
        }

        if ($query instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $registros = $query; 
        } else {
            $registros = $query->paginate($this->perPage);
        }

        $this->tableIdsOnPage = $registros->map(fn($registro) => (string) $registro->id)->toArray();

        return $registros;
    }

    private function getBaseQuery($model)
    {
        $query = $model::with('registrador')
                ->where('pais_id', $this->pais->id);

        if($this->showEmtyIfNotSocioSelected && count($this->selectedSociosIds) == 0) {
            return new LengthAwarePaginator([], 0, $this->perPage, 1);
        }

       if(count($this->selectedSociosIds)){
            $query->whereIn('socio_implementador_id', $this->selectedSociosIds);
        }

        $query = $this->applySearch($query);
        $query = $this->applySorting($query);

        return $query;
    }

    public function validarSelected()
    {
        abort_if(
            !auth()->user()->can('Validar R3'),
            403
        );

        switch ($this->selectedFormType){
            case Formularios::Apalancamiento->value:
                $this->validarApalancamiento();
                break;
            case Formularios::CostoCompartido->value:
                $this->validarCostShare();
                break;
            default:
               $this->validarAlianza();
                break;
        }
    }

    public function validarApalancamiento(){
        Apalancamiento::whereIn('id', $this->selectedIds)->each( function($apalancamiento, $index){
            $this->progress = ($index + 1) * (100 / count($this->selectedIds));
            DB::transaction(function () use ($apalancamiento) {
                try{
                    $apalancamiento->estados_registros()
                    ->attach(EstadoRegistroApalancamiento::VALIDADO);

                    $this->dispatch('progress-updated', progress: $this->progress);
                }catch (\Exception $e) {
                    Log::error('Error processing apalancamiento: ' . $e->getMessage(), [
                        'participante_id' => $apalancamiento->id,
                        'exception' => $e,
                    ]);
                    throw $e;
                }
            });
        });

        $this->dispatch('update-table-data');

        $this->selectedIds = [];

        //$this->showSuccessIndicator = true;

        $this->resetPage();
    }

    public function validarAlianza(){
        Alianza::whereIn('id', $this->selectedIds)->each( function($alianza, $index){
            $this->progress = ($index + 1) * (100 / count($this->selectedIds));
            DB::transaction(function () use ($alianza) {
                try{
                    $alianza->estados_registros()
                    ->attach(EstadoRegistroAlianza::VALIDADO,
                    [
                        'created_by' => auth()->user()->id,
                    ]);

                    $this->dispatch('progress-updated', progress: $this->progress);
                }catch (\Exception $e) {
                    Log::error('Error processing alianza: ' . $e->getMessage(), [
                        'participante_id' => $alianza->id,
                        'exception' => $e,
                    ]);
                    throw $e;
                }
            });
        });

        $this->dispatch('update-table-data');

        $this->selectedIds = [];

        //$this->showSuccessIndicator = true;

        $this->resetPage();
    }

    public function validarCostShare(){
        CostShare::whereIn('id', $this->selectedIds)->each( function($cost_share, $index){
            $this->progress = ($index + 1) * (100 / count($this->selectedIds));
            DB::transaction(function () use ($cost_share) {
                try{
                    $cost_share->estados_registros()
                    ->attach(EstadoRegistroCostShare::VALIDADO);

                    $this->dispatch('progress-updated', progress: $this->progress);
                }catch (\Exception $e) {
                    Log::error('Error processing alianza: ' . $e->getMessage(), [
                        'participante_id' => $cost_share->id,
                        'exception' => $e,
                    ]);
                    throw $e;
                }
            });
        });

        $this->dispatch('update-table-data');

        $this->selectedIds = [];

        //$this->showSuccessIndicator = true;

        $this->resetPage();
    }

    public function validar($model_id){
        $this->selectedIds[] = $model_id;

        $this->validarSelected();
    }

    private function getMisSocioRegistradores()
    {
        $coordinadorUserId = auth()->id();

        $socios = DB::table('coordinador_gestores as cg')
            ->join('cohorte_proyecto_user as cpu', 'cpu.id', '=', 'cg.gestor_id')
            ->join('cohorte_pais_proyecto as cpp', 'cpp.id', '=', 'cpu.cohorte_pais_proyecto_id')
            ->join('pais_proyecto as pp', 'pp.id', '=', 'cpp.pais_proyecto_id')
            ->join('users as u', 'u.id', '=', 'cpu.user_id')
            ->where('pp.id',$this->paisProyecto->id)
            ->whereIn('cg.coordinador_id', function ($subquery) use ($coordinadorUserId) {
                $subquery->select('cpu_inner.id')
                    ->from('cohorte_proyecto_user as cpu_inner')
                    ->join('cohorte_pais_proyecto as cpp_inner', 'cpp_inner.id', '=', 'cpu_inner.cohorte_pais_proyecto_id')
                    ->join('pais_proyecto as pp_inner', 'pp_inner.id', '=', 'cpp_inner.pais_proyecto_id')
                    ->where('cpu_inner.user_id', $coordinadorUserId);
            })
            ->distinct()
            ->pluck('u.socio_implementador_id')
            ->toArray();

        return $socios;
    }

    private function initSocios()
    {
        $this->showSociosDropdown = true;

        if(auth()->user()->hasRole('MECLA')){ /// MECLA
            $this->socios = \App\Models\SocioImplementador::active()
                            ->where('pais_id', $this->pais->id)
                            ->get();

            $this->showSociosDropdown = true;
            $this->selectedSociosIds = $this->socios->pluck('id')->toArray();

        }else if(auth()->user()->hasRole('Validación R3')){
            //getMisRegistradores()
            $misSociosRegistradores = $this->getMisSocioRegistradores();

            $this->socios = \App\Models\SocioImplementador::active()
                ->where('pais_id', $this->pais->id)
                ->whereIn('id', $misSociosRegistradores)
                ->get();

            $this->showSociosDropdown = true;
            $this->selectedSociosIds = $this->socios->pluck('id')->toArray();
            $this->showEmtyIfNotSocioSelected  = true;
        }else{
            //auth()->user()->can('Filtrar registros por socio')
            // Staff and others
            $user = auth()->user()->load('socioImplementador');

            $socioImplementadorId = $user->socioImplementador->id;

            $this->socios = \App\Models\SocioImplementador::active()
                ->where('pais_id', $this->pais->id)
                ->where('id', $socioImplementadorId)
                ->get();

            $this->showSociosDropdown = false;
            $this->selectedSocio = $socioImplementadorId;
            $this->selectedSociosIds[] = $this->selectedSocio;
        }
    }

    public function updatedSelectedSociosIds()
    {
        if (!empty($this->selectedSociosIds) && array_search('-1', $this->selectedSociosIds) !== false) {
            // Para la opcion de "Seleccionar Todo"
            $this->initSocios();
        }
    }
}
