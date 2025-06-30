<?php

namespace App\Exports\bancarizacion\estipendio;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\Storage;
use App\Models\Participante;
use App\Services\ExportService;

class ParticipantesFinancieroExport implements FromQuery, WithMapping, WithHeadings, WithTitle
{
    use Exportable;

    private $rowNumber = 1;

    public $selectedIds;

    public $estipendiosIds;

    public $estipendio;

    public $withZeroValue;

    public $exportService;

    public function __construct(array $selectedIds, $estipendiosIds, $estipendio, $withZeroValue = false)
    {
        $this->selectedIds = $selectedIds;
        $this->estipendiosIds = $estipendiosIds;
        $this->estipendio = $estipendio;
        $this->withZeroValue = $withZeroValue;

        $this->exportService = new ExportService();
    }

    public function title(): string
    {
        return $this->withZeroValue ? 'Participantes con 0%' : 'Participantes sin 0%';
    }

    public function query()
    {
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
        ->when($this->withZeroValue, function ($query) {
            $query->where('estipendio_participantes.porcentaje_estipendio', '=', 0)
                ->orWhereNull('estipendio_participantes.porcentaje_estipendio');
        })
        ->when(!$this->withZeroValue, function ($query) {
            $query->where('estipendio_participantes.porcentaje_estipendio', '>', 0);
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
            "estipendio_participantes.porcentaje_estipendio",
            "estipendio_participantes.observacion",
            "estipendio_participantes.monto_estipendio",
        ]);

        return $query;

    }

    public function headings(): array
    {
        return [
            '#',
            'Numero cuenta',
            'Nombre completo',
            'Socio',
            'Grupo',
            'Perfil',
            'Estado',
            'Porcentaje',
            'Observación',
            'Monto en dolares',
        ];
    }

    /**
     * @param Invoice $invoice
     */
    public function map($row): array
    {
        $build = [
            $this->rowNumber++, // #
            $row->cohorteParticipanteProyecto[0]->numero_cuenta ?? '',
            $this->exportService->cleanUTF8String($row->fullName),
            $row->gestor->socioImplementador->nombre ?? "",
            $row->grupoactivo?->grupo?->nombre ?? "No tiene grupo asignado",
            $this->estipendio->perfilParticipante->nombre ?? "",
            isset($row->grupoactivo) ? $row->grupoactivo->lastEstadoParticipante->estado->nombre ?? "Registrado" : 'No tiene estado asignado aún',
            $row->porcentaje_estipendio ?? '0.0',
            $row->observacion?? '',
            $row->monto_estipendio?? '0',
        ];

        return $build;
    }
}
