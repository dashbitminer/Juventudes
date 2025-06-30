<?php

namespace App\Exports\bancarizacion\coordinador;

use App\Models\BancarizacionGrupo;
use App\Models\Participante;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ParticipantesGrupoExport implements FromQuery, WithMapping, WithHeadings
{

    use Exportable;

    public $grupo;

    private $rowIndex = 1;

    public function __construct($grupo)
    {
        $this->grupo = $grupo;
    }

    public function query()
    {
        return Participante::with([
            'cohortePaisProyectoPerfiles',
            'ciudad.departamento',
            'cohortePaisProyectoPerfiles:id,cohorte_pais_proyecto_id,perfil_participante_id',
            'cohortePaisProyectoPerfiles.perfilesParticipante:id,nombre'
        ])
            ->whereHas('bancarizacionGrupos', function ($query) {
                $query->where('bancarizacion_grupo_participantes.bancarizacion_grupo_id', $this->grupo)
                    ->whereNotNull('bancarizacion_grupo_participantes.active_at')
                    ->whereNull('bancarizacion_grupo_participantes.deleted_at');
            });

        // $records =  BancarizacionGrupo::find($this->grupo);

        // return $records->load(['participantes' => function ($query) {
        //     $query->wherePivot('active_at', '!=', null)
        //         ->wherePivot('deleted_at', null);
        // }]);

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
            '',
            $participante->ciudad->nombre ?? '',
            $participante->ciudad->departamento->nombre ?? '',
            // $participante->paisProyectoSocio->socio->nombre,
            // $participante->paisProyectoSocio->pais->nombre,
            // $participante->paisProyectoSocio->proyecto->nombre,
            // $participante->perfil,
            // $participante->paisProyectoSocio->socio->nombre,
            // $participante->paisProyectoSocio->pais->nombre,
            // $participante->paisProyectoSocio->proyecto->nombre,
            // $participante->paisProyectoSocio->proyecto->modalidad->nombre,
            // $participante->paisProyectoSocio->proyecto->tipoProyecto->nombre,
            // $participante->paisProyectoSocio->proyecto->tipoProyecto->tipoProyecto->nombre,
            // $participante->paisProyectoSocio->proyecto->tipoProyecto->tipoProyecto->tipoProyecto->nombre,
            // $participante->paisProyectoSocio->proyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->nombre,
            // $participante->paisProyectoSocio->proyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->nombre,
            // $participante->paisProyectoSocio->proyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->nombre,
            // $participante->paisProyectoSocio->proyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->tipoProyecto->nombre,
            // $participante->paisProyectoSocio->pro
        ];
    }


    public function headings(): array
    {
        return [
            '#',
            'Nombre Completo',
            'Edad',
            'Sexo',
            'Documento identidad',
            'Perfil',
            'Email',
            'Teléfono',
            'Pais',
            'Ciudad',
            'Departamento',
        ];
    }
}
