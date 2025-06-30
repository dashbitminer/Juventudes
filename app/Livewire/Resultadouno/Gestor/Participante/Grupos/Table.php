<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos;

use App\Models\Pais;
use App\Models\Grupo;
use App\Models\Razon;
use App\Models\Estado;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use App\Models\PaisProyecto;
use App\Models\Participante;
use Livewire\WithPagination;
use App\Models\CategoriaRazon;
use App\Models\EstadoRegistro;
use Illuminate\Validation\Rule;
use App\Models\GrupoParticipante;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Models\CohortePaisProyecto;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\Filters;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Sortable;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Searchable;

class Table extends Component
{

    use WithPagination, Sortable, Searchable, GrupoTrait;

    public Filters $filters;

    public Cohorte $cohorte;

    public Pais $pais;

    public Proyecto $proyecto;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $perPage = 10;

    #[Validate('required', message: 'Seleccione uno o más participantes de la lista principal')]
    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $selectedParticipante;

    public $openDrawer = false;

    public $openDrawerMover = false;

    public $openDrawerEditar = false;

    public $openDrawerEstado = false;

    public $openDrawerListaEstados = false;

    public $lista;

    public $historial;

    public $nombre;

    public $descripcion;

    public $paisProyecto;

    public $misGrupos;

    // #[Validate('required', message: 'La información del grupo es requerida, consulte con el administrador sobre este error de validación')]
    public $nuevogrupo;

    public $comentario;

    // #[Validate('required', message: 'La información del grupo es requerida, consulte con el administrador sobre este error de validación')]
    public $nextGroup;

    public $estados;
    public $selectedEstado;

    public $categorias;
    public $selectedCategoria;

    public $razones;
    public $selectedRazon;

    public $modo;

    public $participantesSinGrupo;

    public $perfilSelected;

    public $fechaCambioEstado;

    public GrupoParticipante $grupoParticipante;



    public function rules()
    {
        return [
            'nuevogrupo' => [
                'required_if:modo,crear',
            ],
            'nextGroup' => [
                'required_if:modo,crear',
            ],
            'selectedRazon' => Rule::requiredIf(function ()  {
                return in_array($this->selectedEstado, [Estado::REINGRESO, Estado::DESERTADO, Estado::PAUSADO] )  && $this->modo == "estado";
            }),
            'fechaCambioEstado' => [
                'required_if:modo,estado',
                'after_or_equal:' . $this->cohortePaisProyecto->fecha_inicio,
                'before_or_equal:' . $this->cohortePaisProyecto->fecha_fin,
            ],
            'selectedEstado' => [
                'required_if:modo,estado',
            ],
            'nuevogrupo' => [
                'required_if:modo,mover',
            ],
            'perfilSelected' => [
                'sometimes',
            ],
        ];
    }


    public function messages()
    {
        return [
            'nuevogrupo.required' => 'La información del grupo es requerida, consulte con el administrador sobre este error de validación',
            'nextGroup.min' => 'La información del grupo es requerida, consulte con el administrador sobre este error de validación',
          //  'perfilSelected.required' => 'El campo perfil es obligatorio.',
            'nuevogrupo.required_if' => 'El campo grupo es requerido.',
            'fechaCambioEstado.required_if' => 'La fecha de cambio de estado es obligatoria.',
            'fechaCambioEstado.after_or_equal' => 'La fecha de cambio de estado debe ser igual o posterior a la fecha de inicio de la cohorte.',
            'fechaCambioEstado.before_or_equal' => 'La fecha de cambio de estado debe ser igual o anterior a la fecha de finalización de la cohorte.',
        ];
    }

    public function mount(): void
    {
        $this->estados = Estado::active()->pluck("nombre", "id");

        $this->categorias = collect([]);

        // 1. Get the PaisProyecto model instance
        $this->paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        // 2. Get the Cohorte pais proyecto model instance
        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::with('perfilesParticipante:id,nombre')
        ->where('pais_proyecto_id', $this->paisProyecto->id)
        ->where('cohorte_id', $this->cohorte->id)
        ->firstOrFail();

        //3. Filters
        $this->filters->init($this->cohorte, $this->paisProyecto, $this->cohortePaisProyecto);


        //4. Get my groups
        $this->misGrupos = GrupoParticipante::whereHas('cohorteParticipanteProyecto', function ($query) {
            $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
        })
        ->where('user_id', auth()->id())
        ->join('grupos', 'grupo_participante.grupo_id', '=', 'grupos.id')
        ->groupBy("grupo_id")
        ->pluck("grupos.nombre", "grupos.id");


    }

    public function getNextrGroup()
    {

        $current = GrupoParticipante::whereHas('cohorteParticipanteProyecto', function ($query) {
            $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
        })
            ->where('user_id', auth()->id())
            ->whereNotNull('active_at')
            ->max('grupo_id');


        return Grupo::where('id',  $current + 1)->first(['id', 'nombre']);
    }

    #[On('update-grupos-participantes')]
    public function render()
    {
        $this->nextGroup = $this->getNextrGroup();

        $query = Participante::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'lastEstado.estado_registro:id,nombre,color,icon',
            'grupoactivo.lastEstadoParticipante.estado',
            'grupoactivo.grupo',
            //"grupoParticipante.lastEstadoParticipante.estado",
        ])
            ->misRegistros()
            ->whereHas('cohortePaisProyecto', function($query) {
                $query->where('cohorte_pais_proyecto.id', $this->cohortePaisProyecto->id)
                    ->whereNotNull('cohorte_participante_proyecto.active_at');
            })
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', EstadoRegistro::VALIDADO);
            })
            ->select([
                "id",
                "slug",
                "email",
                "primer_nombre",
                "segundo_nombre",
                "tercer_nombre",
                "primer_apellido",
                "segundo_apellido",
                "tercer_apellido",
                "ciudad_id",
                "created_at",
                "documento_identidad",
                "fecha_nacimiento",
                "sexo",
            ]);

       $query = $this->applySearch($query);

       $query = $this->applySorting($query);

       $query = $this->filters->apply($query);

       $participantes = $query->paginate($this->perPage);

       $this->participanteIdsOnPage = $participantes->map(fn($participante) => (string) $participante->id)->toArray();

        $this->participantesSinGrupo = Participante::where('gestor_id', auth()->id())
            ->whereHas('cohorteParticipanteProyecto', function ($query) {
                $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
            })
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', EstadoRegistro::VALIDADO);
            })
            ->whereDoesntHave('grupoParticipante')
            ->count();

        return view('livewire.resultadouno.gestor.participante.grupos.table', [
            'participantes' => $participantes,
            'cohorteId' => $this->cohorte->id,
            'cohortePaisProyecto' => $this->cohortePaisProyecto,
            'paisProyectoId' => $this->paisProyecto->id,
            'participantesSinGrupo' => $this->participantesSinGrupo ?? 0,
        ]);
    }

    #[On('preview-selected-group')]
    public function previewSelected()
    {
        $this->modo = "crear";

        $this->addList();

        $this->openDrawer = true;
    }


    #[On('update-page')]
    public function updatedPerPage()
    {
        $this->resetPage();
    }


    #[On('open-form-editar-grupo')]
    public function openEditarGrupo($id)
    {
        $this->grupoParticipante = GrupoParticipante::with([
            'cohorteParticipanteProyecto',
            'grupo'
        ])->find($id);

        if ($this->grupoParticipante) {
            $this->perfilSelected = $this->grupoParticipante->cohorte_pais_proyecto_perfil_id;
            $this->nuevogrupo = $this->grupoParticipante->grupo->id;

            $this->openModalEditar($this->grupoParticipante);
        }
    }

}
