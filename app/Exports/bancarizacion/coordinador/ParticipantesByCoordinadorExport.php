<?php

namespace App\Exports\bancarizacion\coordinador;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use App\Livewire\Financiero\Coordinador\Participante\Index\CoordinadorTrait;

class ParticipantesByCoordinadorExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable, CoordinadorTrait;

    public $selectedParticipanteIds;

    public $cohortePaisProyecto;

    private $rowIndex = 1;

    public function __construct($selectedParticipanteIds, $cohortePaisProyecto)
    {
        $this->selectedParticipanteIds = $selectedParticipanteIds;

        $this->cohortePaisProyecto = $cohortePaisProyecto;
    }

    public function query()
    {
        $socioImplementadorId = auth()->user()->socio_implementador_id;

        return \App\Models\Participante::whereHas('cohortePaisProyecto', function($query) {
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
            "cohortePaisProyectoPerfiles.perfilesParticipante:id,nombre"
        ])
        ->when(!empty($this->selectedParticipanteIds), function ($query) {
            $query->whereIn('id', $this->selectedParticipanteIds);
        })
        ->whereIn("gestor_id", $this->getMisGestores())
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
            "created_by",
            "created_at",
            "documento_identidad",
            "fecha_nacimiento",
            "sexo",
        ]);
    }

    public function map($participante): array
    {
        return [
            $this->rowIndex++,
            $participante->full_name,
            $participante->edad,
            $participante->sexo == 1 ? 'Femenino' : 'Masculino',
            $participante->documento_identidad,
            $participante->cohortePaisProyectoPerfiles->where('pivot.active_at', '!=', null)->first()->perfilesParticipante->nombre ?? '',
            $participante->email,
            $participante->telefono,
            $participante->bancarizacionGrupos->where('pivot.active_at', '!=', null)->whereNull('pivot.deleted_at')->first()->nombre ?? '',
            $participante->creator->name ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Completo',
            'Edad',
            'Sexo',
            'Documento identidad',
            'Perfil',
            'Email',
            'Teléfono',
            'Grupo',
            'Creado Por',
            // 'Pais',
            // 'Ciudad',
            // 'Departamento',
        ];
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'E' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
    //     ];
    // }
}
