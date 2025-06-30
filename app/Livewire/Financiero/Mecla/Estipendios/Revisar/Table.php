<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Revisar;

use Livewire\Component;
use App\Models\Estado;
use App\Models\Estipendio;
use App\Models\Participante;
use Livewire\WithPagination;
use App\Models\EstipendioAgrupacion;
use App\Models\EstipendioParticipante;
use App\Models\EstipendioAgrupacionParticipante;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ParticipanteAlertaNivel;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\GrupoTrait;
use Livewire\Attributes\Renderless;
use App\Exports\bancarizacion\estipendio\ParticipantesExportFullInfo as ParticipantesExport;

class Table extends Component
{
    use WithPagination, Searchable, Sortable, GrupoTrait;

    public $openDrawerView = false;

    public $openDrawerEdit = false;

    public $openDrawerRevisar = false;

    public $agrupaciones;

    public $id_agrupacion;

    public $nombre_agrupacion;

    public $denominador_agrupacion;

    public $color;

    public $actividad_agrupacion;

    public $subactividad_agrupacion;

    public $modulo_agrupacion;

    public $submodulo_agrupacion;

    public Estipendio $estipendio;

    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $participantesIdsTotal = [];

    public $selectedEstadosIds = [];

    public $showSuccessIndicator = false;

    public $perPage = 100;

    public $estipendios;

    public EstipendioParticipante $estipendioParticipante;

    public $porcentaje_estipendio;

    public $observacion;

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

    #[Renderless]
    public function export()
    {
        $export = new ParticipantesExport(
            $this->selectedParticipanteIds,
            $this->estipendios->pluck('id')->toArray(),
            $this->estipendio
        );
        $export->loadAgrupaciones();
        return $export->download('revisar_estipendios.xlsx');


    }

    public function mount(): void
    {
        $this->estados = Estado::active()->pluck("nombre", "id");
        $this->selectedEstadosIds = array_keys($this->estados->toArray());

        $this->categorias = collect([]);
    }

    public function render()
    {
        $this->estipendio->load('perfilParticipante');

        $this->estipendios = Estipendio::where('cohorte_pais_proyecto_id', $this->estipendio->cohorte_pais_proyecto_id)
            // ->with('socioImplementador', 'perfilParticipante')
            ->where('cohorte_pais_proyecto_perfil_id', $this->estipendio->cohorte_pais_proyecto_perfil_id)
            ->where('mes', $this->estipendio->mes)
            ->where('anio', $this->estipendio->anio)
            ->where('fecha_inicio', $this->estipendio->fecha_inicio)
            ->where('fecha_fin', $this->estipendio->fecha_fin)
            //->where('is_closed', 0)
            ->get();

        $query = Participante::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'lastEstado.estado_registro:id,nombre,color,icon',
            'grupoactivo.grupo',
            'grupoactivo.lastEstadoParticipante.estado',
            'gestor.socioImplementador',
        ])
        ->join('estipendio_participantes', function($join) {
            $join->on('participantes.id', '=', 'estipendio_participantes.participante_id')
                ->whereIn('estipendio_participantes.estipendio_id', $this->estipendios->pluck('id')->toArray());
        })
        ->whereHas('grupoactivo.lastEstadoParticipante.estado', function ($query) {
            $query->whereIn('estados.id', $this->selectedEstadosIds);
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
            "estipendio_participantes.porcentaje",
            "estipendio_participantes.monto_estipendio",
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

        // Cargar agrupaciones
        $this->loadAgrupaciones();

        // Agrega alertas a los participantes
        $participantes->transform(function ($item, $key) {
            $alert = ParticipanteAlertaNivel::fromPercentage($item->porcentaje);
            $item->alerta = $alert->value;

            $item->porcentaje = number_format((float) $item->porcentaje, 1);

            return $item;
        });

        return view('livewire.financiero.mecla.estipendios.revisar.table', [
            'participantes' => $participantes,
        ]);
    }

    public function loadAgrupaciones()
    {
        $agrupaciones = EstipendioAgrupacion::with('agrupacionParticipantes')
            ->when($this->estipendios, function ($query) {
                $query->whereIn('estipendio_id', $this->estipendios->pluck('id')->toArray());
            })
            ->when(!$this->estipendios, function ($query) {
                $query->where('estipendio_id', $this->estipendio->id);
            })
            ->get();

        // Unificar las agrupaciones por nombre
        foreach ($agrupaciones as $agrupacion) {
            if (!isset($this->agrupaciones[$agrupacion->nombre])) {
                $this->agrupaciones[$agrupacion->nombre] = [
                    'id' => $agrupacion->id,
                    'nombre' => $agrupacion->nombre,
                    'color' => $agrupacion->color,
                    'denominador' => $agrupacion->denominador,
                    'agrupacionParticipantes' => $agrupacion->agrupacionParticipantes ?? collect()
                ];
            }
            elseif (isset($this->agrupaciones[$agrupacion->nombre]['agrupacionParticipantes'])) {
                $this->agrupaciones[$agrupacion->nombre]['agrupacionParticipantes'] = $this->agrupaciones[$agrupacion->nombre]['agrupacionParticipantes']->merge($agrupacion->agrupacionParticipantes);
            }
        }

        // dd($this->agrupaciones);

        foreach ($this->agrupaciones as &$agrupacion) {
            if (isset($agrupacion['agrupacionParticipantes'])) {
                foreach ($agrupacion['agrupacionParticipantes'] as $agrupacion_participante) {
                    $agrupacion['participantes'][$agrupacion_participante->participante_id] = [
                        'suma' => number_format((float) $agrupacion_participante->suma, 1),
                        'porcentaje' => number_format((float) $agrupacion_participante->porcentaje, 1),
                        'alerta' => $agrupacion_participante->alerta,
                    ];
                }

                unset($agrupacion['agrupacionParticipantes']);
            }
        }

        // dd($this->agrupaciones);
    }


    #[On('open-revisar')]
    public function openRevisar(EstipendioParticipante $estipendioParticipante)
    {
        $this->estipendioParticipante = $estipendioParticipante;

        // $this->porcentaje_estipendio = $estipendioParticipante->porcentaje_estipendio;
        $this->observacion = $estipendioParticipante->observacion;

        $this->openDrawerRevisar = true;
    }

    public function closeRevisar()
    {
        $this->openDrawerRevisar = false;

        $this->estipendioParticipante = new EstipendioParticipante();

        $this->reset('observacion');
    }

    public function updateRevisar()
    {
        // $this->estipendioParticipante->porcentaje_estipendio = $this->porcentaje_estipendio;

        // if ($this->porcentaje_estipendio > 0) {
        //     $this->estipendioParticipante->monto_estipendio = $this->estipendio->monto * ($this->porcentaje_estipendio / 100);
        // }

        $this->estipendioParticipante->observacion = $this->observacion;

        $this->estipendioParticipante->save();

        $this->closeRevisar();
    }

    public function updateParticipantePorcentaje($participanteId, $porcentaje)
    {
        $estipendioParticipante = EstipendioParticipante::where('participante_id', $participanteId)
            ->whereIn('estipendio_id', $this->estipendios->pluck('id')->toArray())
            ->first();

        if ($estipendioParticipante) {
            $estipendioParticipante->porcentaje_estipendio = $porcentaje;

            if ($porcentaje > 0) {
                $estipendioParticipante->monto_estipendio = $this->estipendio->monto * ($porcentaje / 100);
            }
            else {
                $estipendioParticipante->monto_estipendio = 0;
            }

            $estipendioParticipante->save();
        }
    }

    public function updateParticipanteObservacion($participanteId, $observacion)
    {
        $estipendioParticipante = EstipendioParticipante::where('participante_id', $participanteId)
            ->whereIn('estipendio_id', $this->estipendios->pluck('id')->toArray())
            ->first();

        if ($estipendioParticipante) {
            $estipendioParticipante->observacion = $observacion;
            $estipendioParticipante->save();
        }
    }
}
