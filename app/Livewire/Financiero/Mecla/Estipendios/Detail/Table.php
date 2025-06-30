<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Detail;

use Livewire\Component;
use App\Models\Estipendio;
use App\Models\Participante;
use Livewire\WithPagination;
use App\Models\EstipendioAgrupacion;
use App\Models\EstipendioParticipante;
use App\Models\EstipendioAgrupacionParticipante;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ParticipanteAlertaNivel;
use Livewire\Attributes\On;

class Table extends Component
{

    use WithPagination, Searchable, Sortable, SesionTrait;

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

    public $showSuccessIndicator = false;

    public $perPage = 100;

    public $actividades;

    public $subactividades;

    public $modulos;

    public $submodulos;

    public EstipendioParticipante $estipendioParticipante;

    public $observacion;


    public function mount()
    {
        $this->actividades = collect([]);
        $this->subactividades = collect([]);
        $this->modulos = collect([]);
        $this->submodulos = collect([]);
    }


    public function render()
    {
        $this->estipendio->load('perfilParticipante');

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
                 ->where('estipendio_participantes.estipendio_id', '=', $this->estipendio->id);
        })
        ->whereNull('estipendio_participantes.deleted_at')
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

        // Carga todas las actividades, subactividades, modulos y submodulos por sesion
        $this->loadSesionByDate();

        // Cargar agrupaciones
        $this->loadAgrupaciones();

        // Agrega alertas a los participantes
        $participantes->transform(function ($item, $key) {
            $alert = ParticipanteAlertaNivel::fromPercentage($item->porcentaje);
            $item->alerta = $alert->value;

            $item->porcentaje = number_format((float) $item->porcentaje, 1);

            return $item;
        });

        return view('livewire.financiero.mecla.estipendios.detail.table', [
            'participantes' => $participantes,
        ]);
    }

    public function loadAgrupaciones()
    {
        $this->agrupaciones = EstipendioAgrupacion::with('agrupacionParticipantes')
            ->where('estipendio_id', $this->estipendio->id)
            ->get()
            ->toArray();

        foreach ($this->agrupaciones as &$agrupacion) {
            foreach ($agrupacion['agrupacion_participantes'] as $agrupacion_participante) {
                $agrupacion['participantes'][$agrupacion_participante['participante_id']] = [
                    'suma' => number_format((float) $agrupacion_participante['suma'], 1),
                    'porcentaje' => number_format((float) $agrupacion_participante['porcentaje'], 1),
                    'alerta' => $agrupacion_participante['alerta'],
                ];
            }

            unset($agrupacion['agrupacion_participantes']);
        }
    }

    public function cargarPorcentajePorAgrupacion()
    {
        $participantes = [];

        $agrupaciones = EstipendioAgrupacion::with('agrupacionParticipantes')
            ->where('estipendio_id', $this->estipendio->id)
            ->get();

        $totalAgrupaciones = $agrupaciones->count();

        foreach ($agrupaciones as $agrupacion) {
            foreach ($agrupacion->agrupacionParticipantes as $agrupacionParticipante) {
                if (!isset($participantes[$agrupacionParticipante->participante_id])) {
                    $participantes[$agrupacionParticipante->participante_id]['porcentaje'] = 0;
                }

                $participantes[$agrupacionParticipante->participante_id]['porcentaje'] += $agrupacionParticipante->porcentaje;
            }
        }

        foreach ($participantes as $participante_id => $participante) {
            $estipendioParticipante = EstipendioParticipante::where('estipendio_id', $this->estipendio->id)
                ->where('participante_id', $participante_id)
                ->first();

            if ($estipendioParticipante) {
                $porcentaje = $participante['porcentaje'] / $totalAgrupaciones;

                $estipendioParticipante->porcentaje = $porcentaje;
                // $alert = ParticipanteAlertaNivel::fromPercentage($porcentaje);
                // $estipendioParticipante->alerta = $alert->value;
                $estipendioParticipante->save();
            }
        }
    }

    public function eliminarAgrupacion($id)
    {
        if (!empty($id)) {
            EstipendioAgrupacionParticipante::where('estipendio_agrupacion_id', $id)->delete();
            EstipendioAgrupacion::find($id)->delete();
        }

        $this->agrupaciones = [];

        // Calcular el total de porcentaje
        $this->cargarPorcentajePorAgrupacion();

        $this->loadAgrupaciones();
    }

    public function editarAgrupamiento($id)
    {
        $estipendioAgrupacion = EstipendioAgrupacion::find($id);

        $this->id_agrupacion = $estipendioAgrupacion->id;
        $this->nombre_agrupacion = $estipendioAgrupacion->nombre;
        $this->denominador_agrupacion = $estipendioAgrupacion->denominador;
        $this->color = $estipendioAgrupacion->color;
        $this->actividad_agrupacion = !empty($estipendioAgrupacion->actividades)? json_decode($estipendioAgrupacion->actividades) : null;
        $this->subactividad_agrupacion = !empty($estipendioAgrupacion->subactividades)? json_decode($estipendioAgrupacion->subactividades) : null;
        $this->modulo_agrupacion =!empty($estipendioAgrupacion->modulos)? json_decode($estipendioAgrupacion->modulos) : null;
        $this->submodulo_agrupacion =!empty($estipendioAgrupacion->submodulos)? json_decode($estipendioAgrupacion->submodulos) : null;

        // Calcular el total de porcentaje
        $this->cargarPorcentajePorAgrupacion();

        if (!empty($this->subactividad_agrupacion)) {
            $this->loadSubactividadesByActividad();
        }

        if (!empty($this->modulo_agrupacion)) {
            // Para casos donde no se selecciono una subactividad pero se guardo en la base.
            if (empty($this->subactividad_agrupacion)) {
                $this->loadSubactividadesByActividad();
            }

            $this->loadModulosBySubactividad();
        }

        if (!empty($this->submodulo_agrupacion)) {
            $this->loadSubmodulosByModulo();
        }

        $this->openDrawerEdit = true;
    }

    public function updateAgrupamiento()
    {
        $estipendioAgrupacion = EstipendioAgrupacion::find($this->id_agrupacion);
        $estipendioAgrupacion->nombre = $this->nombre_agrupacion;
        $estipendioAgrupacion->denominador = $this->denominador_agrupacion;
        $estipendioAgrupacion->color = $this->color;
        $estipendioAgrupacion->actividades =!empty($this->actividad_agrupacion)? json_encode($this->actividad_agrupacion) : null;
        $estipendioAgrupacion->subactividades =!empty($this->subactividad_agrupacion)? json_encode($this->subactividad_agrupacion) : null;
        $estipendioAgrupacion->modulos =!empty($this->modulo_agrupacion)? json_encode($this->modulo_agrupacion) : null;
        $estipendioAgrupacion->submodulos =!empty($this->submodulo_agrupacion)? json_encode($this->submodulo_agrupacion) : null;
        $estipendioAgrupacion->save();

        $grupos = $this->getTotalHorasPorSesiones();

        // Si la configuracion no coincide se vuelva asignar a todos los participantes el valor de 0 y alerta de 1
        if (empty($grupos)) {
            $estipendioParticipantes = EstipendioAgrupacionParticipante::where('estipendio_agrupacion_id', $estipendioAgrupacion->id)
                ->get();

            foreach ($estipendioParticipantes as $estipendioParticipante) {
                $estipendioParticipante->suma = 0;
                $estipendioParticipante->porcentaje = 0;
                $estipendioParticipante->alerta = 1;
                $estipendioParticipante->save();
            }
        }

        foreach ($grupos as $participante_id => $value) {
            $estipendioParticipante = EstipendioAgrupacionParticipante::where('estipendio_agrupacion_id', $estipendioAgrupacion->id)
                ->where('participante_id', $participante_id)
                ->first();

            if ($estipendioParticipante) {
                $estipendioParticipante->suma = $value['suma'];
                $estipendioParticipante->porcentaje = $value['porcentaje'];
                $estipendioParticipante->alerta = $value['alerta'];
                $estipendioParticipante->save();
            }
            else {
                // Si el participante no existe por la configuracion previa se crea un nuevo registro
                EstipendioAgrupacionParticipante::create([
                    'estipendio_agrupacion_id' =>  $estipendioAgrupacion->id,
                    'participante_id' => $participante_id,
                    'suma' => $value['suma'],
                    'porcentaje' => $value['porcentaje'] ?? 0.00,
                    'alerta' => $value['alerta'] ?? 1,
                ]);
            }
        }

        // Calcular el total de porcentaje
        $this->cargarPorcentajePorAgrupacion();

        $this->loadAgrupaciones();

        $this->reset('id_agrupacion', 'nombre_agrupacion', 'denominador_agrupacion', 'color', 'actividad_agrupacion', 'subactividad_agrupacion', 'modulo_agrupacion', 'submodulo_agrupacion');

        $this->openDrawerEdit = false;
    }

    public function crearAgrupamiento()
    {
        $grupos = $this->getTotalHorasPorSesiones();

        // Guarda la configuracion del grupo
        $estipendioAgrupacion = EstipendioAgrupacion::create([
            'nombre' => $this->nombre_agrupacion,
            'denominador' => $this->denominador_agrupacion,
            'estipendio_id' => $this->estipendio->id,
            'color' => $this->color,
            'actividades' => !empty($this->actividad_agrupacion) ? json_encode($this->actividad_agrupacion) : null,
            'subactividades' => !empty($this->subactividad_agrupacion) ? json_encode($this->subactividad_agrupacion) : null,
            'modulos' => !empty($this->modulo_agrupacion) ? json_encode($this->modulo_agrupacion) : null,
            'submodulos' => !empty($this->submodulo_agrupacion) ? json_encode($this->submodulo_agrupacion) : null,
        ]);

        foreach ($grupos as $participante_id => $value) {
            $estipendioParticipante = EstipendioAgrupacionParticipante::where('estipendio_agrupacion_id', $estipendioAgrupacion->id)
                ->where('participante_id', $participante_id)
                ->first();

            if ($estipendioParticipante) {
                $estipendioParticipante->update([
                    'suma' => $value['suma'],
                    'porcentaje' => $value['porcentaje'] ?? 0.00,
                    'alerta' => $value['alerta'] ?? 1,
                ]);
            } else {
                EstipendioAgrupacionParticipante::create([
                    'estipendio_agrupacion_id' =>  $estipendioAgrupacion->id,
                    'participante_id' => $participante_id,
                    'suma' => $value['suma'],
                    'porcentaje' => $value['porcentaje'] ?? 0.00,
                    'alerta' => $value['alerta'] ?? 1,
                ]);
            }
        }

        // Calcular el total de porcentaje
        $this->cargarPorcentajePorAgrupacion();

        $this->loadAgrupaciones();

        $this->reset('nombre_agrupacion', 'denominador_agrupacion', 'color', 'actividad_agrupacion', 'subactividad_agrupacion', 'modulo_agrupacion', 'submodulo_agrupacion');

        $this->openDrawerView = false;
    }


    #[On('open-revisar')]
    public function openRevisar(EstipendioParticipante $estipendioParticipante)
    {
        $this->estipendioParticipante = $estipendioParticipante;
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
        $this->estipendioParticipante->observacion = $this->observacion;
        $this->estipendioParticipante->save();

        $this->closeRevisar();
    }

    public function updatedActividadAgrupacion()
    {
        $this->subactividad_agrupacion = null;
        $this->subactividades = collect([]);

        $this->loadSubactividadesByActividad();
    }

    public function updatedSubactividadAgrupacion()
    {
        $this->modulo_agrupacion = null;
        $this->modulos = collect([]);
        $this->submodulo_agrupacion = null;
        $this->submodulos = collect([]);

        $this->loadModulosBySubactividad();
    }

    public function updatedModuloAgrupacion()
    {
        $this->submodulo_agrupacion = null;
        $this->submodulos = collect([]);

        $this->loadSubmodulosByModulo();
    }

}
