<?php

namespace App\Livewire\Resultadocuatro\Gestor\Visualizador\Index;

use App\Exports\resultadocuatro\AprendizajeServicioExport;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\ServicioComunitario;
use App\Models\ServicioComunitarioHistorico;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\FichaEmpleo;
use App\Models\PaisProyecto;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use App\Exports\resultadocuatro\FichaEmpleoExport;
use App\Exports\resultadocuatro\FichaFormacionExport;
use App\Exports\resultadocuatro\FichaVoluntariadoExport;
use App\Exports\resultadocuatro\FichaEmprendimientoExport;
use App\Exports\resultadocuatro\PracticaEmpleabilidadExport;
use App\Exports\resultadocuatro\ServicioComunitarioExport;
use App\Livewire\Resultadocuatro\Gestor\Visualizador\Enums\Formularios;
use App\Models\EstadoRegistroAprendizajeServicio;
use App\Models\EstadoRegistroFichaEmpleo;
use App\Models\EstadoRegistroFichaEmprendimiento;
use App\Models\EstadoRegistroFichaFormacion;
use App\Models\EstadoRegistroFichaVoluntariado;
use App\Models\EstadoRegistroPracticaEmpleabilidad;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados as ServicioCoumnitarioEstados;

class Table extends Component
{

    use WithPagination, Searchable, Sortable;

    public Pais $pais;

    public Proyecto $proyecto;

    // public Cohorte $cohorte;

    public $perPage = 10;

    public $cohortePaisProyecto;

    public $selectedFicha = 1;

    public $selectedIds = [];

    public $tableIdsOnPage = [];

    public $selectedSociosIds = [];

    public $enableExport = true;

    public $selectedFormTypes = [];

    public $selectedCohortesIds = [];

    public $cohortes;

    public $selectedFormType = Formularios::Voluntariado->value;

    public $color;

    public $formularioName;

    public $mainQuery;

    public $socios;
    public $selectedSocio;
    public $showSociosDropdown;

    public $mipais;

    public $search = '';

    public $placeholder = "Buscar por nombre, socio o institución";

    private $formModel = \App\Models\FichaVoluntario::class;

    private $estadoModelValidado = EstadoRegistroFichaVoluntariado::VALIDADO;

    public $route = 'ficha.voluntariado.revisar';

    public $routeName = 'voluntario';

    public $routeModel = true;


    #[Renderless]
    public function export()
    {
        if (empty($this->selectedCohortesIds)) {
            return;
        }

        switch ($this->selectedFormType) {

            case Formularios::Voluntariado->value:
                return (new FichaVoluntariadoExport($this->selectedIds, $this->selectedCohortesIds, $this->selectedSociosIds))
                    ->download('formularios_voluntariado.xlsx');

            case Formularios::Empleabilidad->value:
                return (new PracticaEmpleabilidadExport($this->selectedIds, $this->selectedCohortesIds, $this->selectedSociosIds))
                    ->download('formularios_practicas_empleabilidad.xlsx');

            case Formularios::Empleo->value:
                return (new FichaEmpleoExport($this->selectedIds, $this->selectedCohortesIds, $this->selectedSociosIds))
                    ->download('formularios_fichas_empleo.xlsx');

            case Formularios::Formacion->value:
                return (new FichaFormacionExport($this->selectedIds, $this->selectedCohortesIds, $this->selectedSociosIds))
                    ->download('formularios_formacion.xlsx');

            case Formularios::Emprendimiento->value:
                return (new FichaEmprendimientoExport($this->selectedIds, $this->selectedCohortesIds, $this->selectedSociosIds))
                    ->download('formularios_emprendimiento.xlsx');

            case Formularios::Aprendizaje->value:
                return (new AprendizajeServicioExport($this->selectedIds, $this->selectedCohortesIds, $this->selectedSociosIds))
                    ->download('formularios_aprendizajes_servicio.xlsx');
            case Formularios::Comunitario->value:
                return (new ServicioComunitarioExport($this->selectedIds, $this->selectedCohortesIds, $this->selectedSociosIds))
                    ->download('formularios_servicios_comunitario.xlsx');
                break;
            default:
                return (new FichaVoluntariadoExport($this->selectedIds, $this->selectedCohortesIds, $this->selectedSociosIds))
                    ->download('formularios_voluntariado.xlsx');
                break;
        }

    }

    public function mount()
    {

        $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();


        $this->cohortes = \App\Models\CohortePaisProyecto::with('cohorte:id,nombre')->where('pais_proyecto_id', $paisProyecto->id)->get();

        $this->selectedFormTypes = array_map(fn($type) => $type->value, Formularios::cases());

        $miusuario = auth()->user()->load('socioImplementador');

        $this->mipais = $miusuario->socioImplementador->pais_id;

        $this->color = Formularios::Voluntariado->color();

        $this->formularioName = Formularios::Voluntariado->label();

        $this->socios = \App\Models\SocioImplementador::active()->where('pais_id', $this->mipais)->get();

        if (auth()->user()->can('Filtrar registros por socio')) {
            $this->showSociosDropdown = false;
            $this->selectedSocio = auth()->user()->socio_implementador_id;
            $this->selectedSociosIds[] = $this->selectedSocio;
            $this->selectedCohortesIds = $this->cohortes->pluck('id')->toArray();
        } elseif (auth()->user()->can('Filtrar registros por socios por pais')) {
            $this->showSociosDropdown = true;
            $this->selectedSociosIds = $this->socios->pluck('id')->toArray();
            $this->selectedCohortesIds = $this->cohortes->pluck('id')->toArray();
        } else { // auth()->user()->can('Ver mis participantes R4')
            $this->showSociosDropdown = false;
            $this->selectedSocio = auth()->user()->socio_implementador_id;
            $this->selectedSociosIds[] = $this->selectedSocio;
            $this->selectedCohortesIds = $this->cohortes->pluck('id')->toArray();
        }

    }

    public function render()
    {
        return view('livewire.resultadocuatro.gestor.visualizador.index.table', [
            'formularios' => $this->getData(),
        ]);
    }


    public function updatedSelectedFormType($value)
    {
        $this->color = Formularios::from($value)->color();
        $this->formularioName = Formularios::from($value)->label();
        $this->tableIdsOnPage = [];
        $this->selectedIds = [];
        $this->resetPage();
    }

    private function setCurrentModel()
    {
        switch ($this->selectedFormType){
            case Formularios::Comunitario->value:
                $this->formModel = \App\Models\ServicioComunitario::class;
                $this->estadoModelValidado = null;
                $this->route = 'servicio-comunitario.revisar';
                $this->routeName = 'servicioComunitario';
            break;
            case Formularios::Empleabilidad->value:
                $this->formModel = \App\Models\PracticaEmpleabilidad::class;
                $this->estadoModelValidado = EstadoRegistroPracticaEmpleabilidad::VALIDADO;
                $this->route = 'practicas.empleabilidad.revisar';
                $this->routeName = 'practica';
                break;
            case Formularios::Empleo->value:
                $this->formModel = \App\Models\FichaEmpleo::class;
                $this->estadoModelValidado = EstadoRegistroFichaEmpleo::VALIDADO;
                $this->route = 'empleo.revisar';
                $this->routeName = 'empleo';
                break;
            case Formularios::Formacion->value:
                $this->formModel = \App\Models\FichaFormacion::class;
                $this->estadoModelValidado = EstadoRegistroFichaFormacion::VALIDADO;
                $this->route = 'ficha.formacion.revisar';
                $this->routeName = 'formacion';
                break;
            case Formularios::Emprendimiento->value:
                $this->formModel = \App\Models\FichaEmprendimiento::class;
                $this->estadoModelValidado = EstadoRegistroFichaEmprendimiento::VALIDADO;
                $this->route = 'ficha.emprendimiento.revisar';
                $this->routeName = 'emprendimiento';

                break;
            case Formularios::Aprendizaje->value:
                $this->formModel =\App\Models\AprendizajeServicio::class;
                $this->estadoModelValidado = EstadoRegistroAprendizajeServicio::VALIDADO;
                $this->route = 'ficha.aprendizaje.servicio.revisar';
                $this->routeName = 'aprendizaje';
                break;
            default:
                $this->formModel = \App\Models\FichaVoluntario::class;
                $this->estadoModelValidado = EstadoRegistroFichaVoluntariado::VALIDADO;
                $this->route = 'ficha.voluntariado.revisar';
                $this->routeName = 'voluntario';
                break;
        }

        $routeModel = [
            Formularios::Formacion->value,
            Formularios::Aprendizaje->value
        ];

        $this->routeModel = !in_array($this->selectedFormType, $routeModel);
    }

    public function updatedSearch($property)
    {
        $this->resetPage();
    }

    /**
     * @param $model
     * @return mixed
     */
    private function getBaseQuery($model)
    {
        $registros = $model::with([
            "directorio:id,nombre",
            "cohorteParticipanteProyecto:id,cohorte_pais_proyecto_id,participante_id",
            "cohorteParticipanteProyecto.cohortePaisProyecto:id,cohorte_id,pais_proyecto_id",
            "cohorteParticipanteProyecto.cohortePaisProyecto.cohorte",
            "cohorteParticipanteProyecto.participante",
            "creator:id,name"
        ])
        ->whereHas('cohorteParticipanteProyecto.participante', function ($query) {
            $query->whereNull('participantes.deleted_at');
        })
        ->whereHas('cohorteParticipanteProyecto', function ($query) {
            $query->whereIn('cohorte_pais_proyecto_id', $this->selectedCohortesIds);
        })
        ->when(!empty($this->search), function ($query) {
            $query->whereHas('cohorteParticipanteProyecto.participante.gestor', function ($q) {
                     $termino = trim($this->search);
                     $q->where('name', 'like', '%' . $this->search . '%')
                     ->orWhere(function($query) use ($termino) {
                             $query->whereRaw("
                                 CONCAT(
                                     TRIM(COALESCE(primer_nombre, '')),
                                     IF(TRIM(COALESCE(segundo_nombre, '')) != '', CONCAT(' ', TRIM(COALESCE(segundo_nombre, ''))), ''),
                                     IF(TRIM(COALESCE(tercer_nombre, '')) != '', CONCAT(' ', TRIM(COALESCE(tercer_nombre, ''))), ''),
                                     IF(TRIM(COALESCE(primer_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(primer_apellido, ''))), ''),
                                     IF(TRIM(COALESCE(segundo_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(segundo_apellido, ''))), ''),
                                     IF(TRIM(COALESCE(tercer_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(tercer_apellido, ''))), '')
                                 ) like ?", ['%'.$termino.'%']
                             )
                             ->orWhere('email', 'like', '%'.$termino.'%')
                             ->orWhere('documento_identidad', 'like', '%'.$termino.'%');
                         });
            })
             ->orWhereHas('cohorteParticipanteProyecto.participante.gestor.socioImplementador', function ($q) {
                  $q->where('socios_implementadores.nombre', 'like', '%' . $this->search . '%')
                    ->where('socios_implementadores.pais_id', $this->pais->id);
              })
              ->orWhereHas('directorio', function ($q) {
                  $q->where('directorios.nombre', 'like', '%' . $this->search . '%');
              });
        });

        if(auth()->user()->can('Filtrar registros por socio')){
            $registros->whereHas('cohorteParticipanteProyecto.participante.gestor', function ($q) {
                $q->where('socio_implementador_id', $this->selectedSocio);

            });
        }elseif(auth()->user()->can('Filtrar registros por socios por pais')){
            $registros->whereHas('cohorteParticipanteProyecto.participante.gestor', function ($q) {
                $q->whereIn('socio_implementador_id', $this->selectedSociosIds);
            });
        }else{

            $registros->where('created_by', auth()->id());
        }

        return $this->applySorting($registros);
    }

    public function getData()
    {
        $this->setCurrentModel();

        switch ($this->selectedFormType) {
            case Formularios::Comunitario->value:
                $query = $this->formModel::with([
                    "socioImplementador:id,nombre",
                    "ciudad:id,nombre",
                    "departamento:id,nombre",
                    "cohortePaisProyecto:id,pais_proyecto_id,cohorte_id",
                    "cohortePaisProyecto.cohorte",
                    "user:id,name,socio_implementador_id",
                    "user.socioImplementador:id,nombre"
                ])
                    ->whereIn('cohorte_pais_proyecto_id', $this->selectedCohortesIds)
                    ->where('pais_id', $this->pais->id)
                    ->when(!empty($this->selectedIds), function ($query) {
                        $query->whereIn('id', $this->selectedIds);
                    });
                    if(auth()->user()->can('Filtrar registros por socio') || auth()->user()->can('Filtrar registros por socios por pais')){
                        $query->whereHas('user', function ($q) {
                            $q->whereIn('socio_implementador_id', $this->selectedSociosIds);
                        });
                    }else{
                        $query->where('created_by', auth()->id());
                    }
                break;
            default:
                $query = $this->getBaseQuery($this->formModel);
                break;
        }

        $registros = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $registros->map(fn($registro) => (string) $registro->id)->toArray();

        return $registros;
    }

    public function validar($model_id)
    {
        $this->selectedIds[] = $model_id;

        $this->validarSelected();
    }

    public function validarSelected()
    {
        abort_if(
            !auth()->user()->can('Validar R4'),
            403
        );

        $this->setCurrentModel();

        $this->validarForm();
    }

    private function validarForm() : void
    {

        $this->formModel::whereIn('id', $this->selectedIds)->each( function($data, $index){
            DB::transaction(function () use ($data) {
                try{
                    if($this->selectedFormType  === Formularios::Comunitario->value){
                        $data->estado = ServicioCoumnitarioEstados::Completado->value;
                        $data->save();

                        ServicioComunitarioHistorico::create([
                            'servicio_comunitario_id' => $data->id,
                            'estado' => ServicioCoumnitarioEstados::Completado->value,
                        ]);
                    }else{
                        $data->estados_registros()->attach($this->estadoModelValidado);
                    }
                }catch (\Exception $e) {
                    Log::error('Error processing Form: ' . $e->getMessage(), [
                        'participante_id' => $data->id,
                        'exception' => $e,
                    ]);
                    throw $e;
                }
            });
        });

        $this->dispatch('update-table-data');
        $this->selectedIds = [];
    }

    public function getEstadoInfo($estado)
    {
        return ServicioCoumnitarioEstados::getInfo($estado);
    }

    public function updatedSelectedSociosIds()
    {
        if (!empty($this->selectedSociosIds) && array_search('-1', $this->selectedSociosIds) !== false) {
            // Para la opcion de "Seleccionar Todo"
            if (auth()->user()->can('Filtrar registros por socio')) {
                $this->showSociosDropdown = false;
                $this->selectedSocio = auth()->user()->socio_implementador_id;
                $this->selectedSociosIds[] = $this->selectedSocio;
            } elseif (auth()->user()->can('Filtrar registros por socios por pais')) {
                $this->showSociosDropdown = true;
                $this->selectedSociosIds = $this->socios->pluck('id')->toArray();
            } else { // auth()->user()->can('Ver mis participantes R4')
                $this->showSociosDropdown = false;
                $this->selectedSocio = auth()->user()->socio_implementador_id;
                $this->selectedSociosIds[] = $this->selectedSocio;
            }
        }
    }

    public function updatedSelectedCohortesIds()
    {
        if (!empty($this->selectedCohortesIds) && array_search('-1', $this->selectedCohortesIds) !== false) {
            // Para la opcion de "Seleccionar Todo"
            if (auth()->user()->can('Filtrar registros por socio')) {
                $this->selectedCohortesIds = $this->cohortes->pluck('id')->toArray();
            } elseif (auth()->user()->can('Filtrar registros por socios por pais')) {
                $this->selectedCohortesIds = $this->cohortes->pluck('id')->toArray();
            } else { // auth()->user()->can('Ver mis participantes R4')
                $this->selectedCohortesIds = $this->cohortes->pluck('id')->toArray();
            }
        }
    }
}
