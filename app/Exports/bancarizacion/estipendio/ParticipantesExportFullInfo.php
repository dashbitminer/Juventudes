<?php

namespace App\Exports\bancarizacion\estipendio;

use App\Models\EstipendioAgrupacion;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Storage;
use App\Models\Participante;

class ParticipantesExportFullInfo implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    private $rowNumber = 1;

    public $selectedIds;

    public $estipendiosIds;

    public $estipendio;

    private $agrupaciones = [];

    public function __construct(array $selectedIds, $estipendiosIds, $estipendio)
    {
        $this->selectedIds = $selectedIds;
        $this->estipendiosIds = $estipendiosIds;
        $this->estipendio = $estipendio;
    }

    public function query()
    {
        //dd($this->estipendiosIds);
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
                ->whereIn('estipendio_participantes.estipendio_id', $this->estipendiosIds);
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
            "estipendio_participantes.monto_estipendio",
            "estipendio_participantes.porcentaje_estipendio",
            "estipendio_participantes.observacion",
        ]);

        return $query;

    }

    public function headings(): array
    {
        $base = [
            '#',
            'Numero cuenta',
            'Nombre completo',
            'Socio',
            'Grupo',
            'Perfil',
            'Estado',
        ];

        foreach ($this->agrupaciones as $nombre => $agrupacion) {
            $base[] = "$nombre Porcentaje";
            $base[] = "$nombre Suma";
            $base[] = "$nombre Alerta";
        }

        $base[] = 'Promedio de cumplimiento';
        $base[] = 'Alerta general';
        $base[] = 'Monto Estipendio';
        $base[] = 'Porcentaje Estipendio';
        $base[] = 'Observación';

        return $base;
    }

    /**
     * @param Invoice $invoice
     */
    public function map($row): array
    {
        $build = [
            $this->rowNumber++, // #
            $row->cohorteParticipanteProyecto[0]->numero_cuenta ?? '',
            $row->full_name,
            $row->gestor->socioImplementador->nombre ?? "",
            $row->grupoactivo?->grupo?->nombre ?? "No tiene grupo asignado",
            $this->estipendio->perfilParticipante->nombre ?? "",
            isset($row->grupoactivo) ? $row->grupoactivo->lastEstadoParticipante->estado->nombre ?? "Registrado" : 'No tiene estado asignado aún',

        ];

        foreach ($this->agrupaciones as $agrupacion) {
            $datos = $agrupacion['participantes'][$row->id] ?? null;

            $build[] = $datos['porcentaje'] ?? '0.0';
            $build[] = $datos['suma'] ?? '0.0';
            $build[] = $this->getIconoAlerta($datos['alerta'] ?? 0) ;
        }

        $build[] = $row->porcentaje ?? '0.0';
        $build[] = $this->getIconoAlerta($row->alerta ?? 0);
        $build[] = $row->monto_estipendio ?? '0.0';
        $build[] = $row->porcentaje_estipendio ?? '0.0';
        $build[] = $row->observacion ?? '';

        return $build;
    }

    private function getIconoAlerta($alerta)
    {
        if ($alerta == 4) {
            return html_entity_decode('&#x2B06;'); // ⬆
        } elseif ($alerta == 3) {
            return html_entity_decode('&#x2197;'); // ↗
        } elseif ($alerta == 2) {
            return html_entity_decode('&#x2198;'); // ↘
        } else {
            return html_entity_decode('&#x2B07;'); // ⬇
        }
    }

    public function loadAgrupaciones()
    {
        $agrupaciones = EstipendioAgrupacion::with('agrupacionParticipantes')
            ->when($this->estipendiosIds, function ($query) {
                $query->whereIn('estipendio_id', $this->estipendiosIds);
            })
            ->when(!$this->estipendiosIds, function ($query) {
                $query->where('estipendio_id', $this->estipendio->id);
            })
            ->get();

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
    }
}
