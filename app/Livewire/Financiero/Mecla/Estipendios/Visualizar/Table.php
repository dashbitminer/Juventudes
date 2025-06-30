<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Visualizar;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Cohorte;
use App\Models\PaisProyecto;
use App\Models\CohortePaisProyecto;
use App\Models\Estipendio;
use App\Models\Participante;
use App\Models\Estado;
use Livewire\Attributes\Renderless;
use App\Exports\bancarizacion\estipendio\ParticipantesExportFullInfo as ParticipantesExport;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\GrupoTrait;

class Table extends Component
{
    use WithPagination, Searchable, Sortable, GrupoTrait;

    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $participantesIdsTotal = [];

    public $perPage = 100;

    public $estipendios;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Estipendio $estipendio;

    public $openDrawerListaEstados = false;

    public $lista;

    public $historial;

    public $estados;
    public $selectedEstado;

    public $categorias;
    public $selectedCategoria;

    public $razones;
    public $selectedRazon;

    public $modo;

    public $comentario;

    public $fechaCambioEstado;

    public function mount(): void
    {
        $this->estados = Estado::active()->pluck("nombre", "id");

        $this->categorias = collect([]);
    }

    #[Renderless]
    public function export()
    {
        /*return (new ParticipantesExport(
            $this->selectedParticipanteIds,
            $this->estipendios->pluck('id')->toArray(),
            $this->estipendio
            ))->download('visualizar_estipendios.xlsx');*/

        $export = new ParticipantesExport(
            $this->selectedParticipanteIds,
            $this->estipendios->pluck('id')->toArray(),
            $this->estipendio
        );
        $export->loadAgrupaciones(); 
        return $export->download('visualizar_estipendios.xlsx');


    }

    public function render()
    {
        $this->estipendio->load('perfilParticipante');

        $this->estipendios = Estipendio::where('cohorte_pais_proyecto_id', $this->estipendio->cohorte_pais_proyecto_id)
            ->where('cohorte_pais_proyecto_perfil_id', $this->estipendio->cohorte_pais_proyecto_perfil_id)
            ->where('mes', $this->estipendio->mes)
            ->where('anio', $this->estipendio->anio)
            ->where('fecha_inicio', $this->estipendio->fecha_inicio)
            ->where('fecha_fin', $this->estipendio->fecha_fin)
            ->get();

        $query = Participante::with([
                'ciudad:id,nombre,departamento_id',
                'ciudad.departamento:id,nombre,pais_id',
                'lastEstado.estado_registro:id,nombre,color,icon',
                'grupoactivo.grupo',
                'grupoactivo.lastEstadoParticipante.estado',
                'gestor.socioImplementador',
                'cohorteParticipanteProyecto',
            ])
            ->join('estipendio_participantes', function($join) {
                $join->on('participantes.id', '=', 'estipendio_participantes.participante_id')
                    ->whereIn('estipendio_participantes.estipendio_id', $this->estipendios->pluck('id')->toArray());
            })
            ->select([
                "participantes.id",
                "slug",
                "email",
                "primer_nombre",
                "segundo_nombre",
                "tercer_nombre",
                "primer_apellido",
                "segundo_apellido",
                "tercer_apellido",
                "gestor_id",
                "ciudad_id",
                "participantes.created_at",
                "documento_identidad",
                "fecha_nacimiento",
                "sexo",
                "estipendio_participantes.id as estipendio_participante_id",
                "estipendio_participantes.porcentaje_estipendio",
                "estipendio_participantes.observacion",
            ]);

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        // Clonar el query para cargar el ID de todos los participantes para el filtro por agrupacion
        $participantesQuery = clone $query;

        $participantes = $query->paginate($this->perPage);

        $this->participanteIdsOnPage = $participantes->map(fn ($participante) => (string) $participante->id)->toArray();

        $results = $participantesQuery->get();
        $this->participantesIdsTotal = $results->map(fn ($participante) => (string) $participante->id)->toArray();

        return view('livewire.financiero.mecla.estipendios.visualizar.table', [
            'participantes' => $participantes,
        ]);
    }
}
