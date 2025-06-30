<?php

namespace App\Livewire\Financiero\Coordinador\Participante\Index;

use App\Models\Pais;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PaisProyecto;
use App\Models\Participante;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use App\Models\CohortePaisProyecto;
use Livewire\Attributes\Renderless;
use App\Exports\bancarizacion\coordinador\ParticipantesByCoordinadorExport;

class Table extends Component
{

    use WithPagination, Searchable, Sortable, GrupoTrait, CoordinadorTrait;

    #[Reactive]
    public Filters $filters;

    #[Validate('required_if:modo,crear', message: 'El campo nombre del grupo es requerido.')]
    public $nombre;

    public $descripcion;

    #[Validate('required_if:modo,mover', message: 'Debe de seleccionar un grupo destino.')]
    public $grupodestino;

    #[Validate('required', message: 'Seleccione uno o más participantes de la lista principal')]
    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $lista = [];

    public $cohortePaisProyecto;

    public $paisProyecto;

    public $perPage = 10;

    public $openDrawer = false;

    public $openDrawerMover = false;

    public $modo;

    public $showSuccessIndicator = false;

    public $selectedPais;

    public $pais;

    public $searchTerm = '';

    public $listagrupos;

    public $titulo = '¡Guardado exitosamente!';

    public $mensaje = 'El grupo se ha guardo exitosamente con todos los participantes.';

    #[Renderless]
    public function export() {
        return (new ParticipantesByCoordinadorExport($this->selectedParticipanteIds, $this->cohortePaisProyecto))->download('participantes.xlsx');
    }

    #[On('updateSelectedCohortePaisProyecto')]
    public function mount($cohortePaisProyecto = null, $paisProyecto = null, $selectedPais = null)
    {
        $this->cohortePaisProyecto = CohortePaisProyecto::with(['cohorte'])->find($cohortePaisProyecto);

        $this->paisProyecto = PaisProyecto::with(['pais:id,nombre', 'proyecto:id,nombre'])->find($paisProyecto);

        $this->pais = Pais::find($selectedPais);
    }

    #[On('removeParticipanteFromGroup')]
    public function render()
    {
        if($this->cohortePaisProyecto){

            $socioImplementadorId = auth()->user()->socio_implementador_id;

            $query = Participante::whereHas('cohortePaisProyecto', function($query) {
                            $query->where('cohorte_pais_proyecto.id', $this->cohortePaisProyecto->id)
                                ->whereNotNull('cohorte_participante_proyecto.active_at');
                        })
                        ->whereHas('lastEstado', function ($q) {
                            $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
                        })
                        ->whereHas('gestor', function ($q) use ($socioImplementadorId) {
                            $q->where('socio_implementador_id', $socioImplementadorId);
                        })

                        ->with([
                            'creator',
                            'lastEstado.estado_registro',
                            'ciudad.departamento',
                            'cohortePaisProyecto',
                            "bancarizacionGrupos:id,nombre,cohorte_pais_proyecto_id,monto",
                            "cohortePaisProyectoPerfiles:id,cohorte_pais_proyecto_id,perfil_participante_id",
                            "cohortePaisProyectoPerfiles.perfilesParticipante:id,nombre",
                            "gestor"
                        ])
                        ->leftJoin('users', 'participantes.gestor_id', '=', 'users.id')
                        ->leftJoin('ciudades', 'participantes.ciudad_id', '=', 'ciudades.id')
                    //    ->whereIn("gestor_id", $this->getMisGestores())
                        ->select([
                            "participantes.id",
                            "participantes.slug",
                            "participantes.email",
                            "primer_nombre",
                            "segundo_nombre",
                            "tercer_nombre",
                            "primer_apellido",
                            "segundo_apellido",
                            "tercer_apellido",
                            "ciudad_id",
                            "participantes.created_by",
                            "participantes.created_at",
                            "documento_identidad",
                            "fecha_nacimiento",
                            "sexo",
                            "gestor_id",
                            "users.name as nombre_gestor",
                            "ciudades.nombre as nombre_ciudad",
                        ]);

            $query = $this->applySearch($query);

            $query = $this->applySorting($query);

            $query = $this->filters->apply($query);

            $participantes = $query->paginate($this->perPage);

        }else{
            $participantes = Participante::where("created_by", -1)->paginate($this->perPage);
        }

        $this->participanteIdsOnPage = $participantes->map(fn($participante) => (string) $participante->id)->toArray();

        return view('livewire.financiero.coordinador.participante.index.table',[
            'participantes' => $participantes,
        ]);
    }

    #[On('preview-financiero-selected-group')]
    public function previewSelected()
    {

        $this->modo = "crear";

        $this->titulo = '¡Guardado exitosamente!';

        $this->mensaje = 'El grupo se ha guardo exitosamente con todos los participantes.';

        $this->addList();

        $this->openDrawer = true;
    }


    public function moverSelected()
    {

        $this->modo = "mover";

        $this->titulo = '¡Guardado exitosamente!';

        $this->mensaje = 'Se han movido todos los participantes seleccionados al nuevo grupo.';

        $this->listagrupos = $this->getlistagrupos();

        $this->addList();

        $this->openDrawerMover = true;
    }

    public function moverSingleAGrupo($id)
    {

        $this->modo = "mover";

        $this->titulo = '¡Guardado exitosamente!';

        $this->mensaje = 'Se han movido todos los participantes seleccionados al nuevo grupo.';

        $this->listagrupos = $this->getlistagrupos();

        $this->selectedParticipanteIds = [$id];

        $this->addList();

        $this->openDrawerMover = true;

    }


}
