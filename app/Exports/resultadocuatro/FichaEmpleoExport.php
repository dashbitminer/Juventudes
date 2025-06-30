<?php

namespace App\Exports\resultadocuatro;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Storage;

class FichaEmpleoExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;


    public $selectedIds;

    private $rowNumber = 1;

    private $socio;

    private $selectedCohortesIds;

    public $modalidad;

    public $selectedSociosIds;

    public function __construct(array $selectedIds, $selectedCohortesIds, $selectedSociosIds)
    {
        $this->selectedIds = $selectedIds;

        $this->selectedCohortesIds = $selectedCohortesIds;

        $this->selectedSociosIds = $selectedSociosIds;

    }

    public function query()
    {

        $registros =  \App\Models\FichaEmpleo::with([
            "directorio:id,nombre",
            "cohorteParticipanteProyecto:id,cohorte_pais_proyecto_id,participante_id",
            "cohorteParticipanteProyecto.cohortePaisProyecto:id,cohorte_id,pais_proyecto_id",
            "cohorteParticipanteProyecto.cohortePaisProyecto.cohorte:id,nombre",
            "cohorteParticipanteProyecto.participante:id,primer_nombre,segundo_nombre,tercer_nombre,primer_apellido,segundo_apellido,tercer_apellido,fecha_nacimiento,gestor_id,documento_identidad,sexo",
            "cohorteParticipanteProyecto.participante.gestor:id,name,username,socio_implementador_id",
            "cohorteParticipanteProyecto.participante.gestor.socioImplementador:id,nombre",
            "creator:id,name",
            "sectorEmpresaOrganizacion:id,nombre",
            "tipoEmpleo:id,nombre",
            "salario:id,nombre",
            "mediosVerificacion",
            "mediosVida"
        ])->whereHas('cohorteParticipanteProyecto', function ($query) {
            $query->whereIn('cohorte_pais_proyecto_id', $this->selectedCohortesIds);
        })
        ->when(!empty($this->selectedIds), function ($query) {
            $query->whereIn('id', $this->selectedIds);
        });

        if(auth()->user()->can('Filtrar registros por socio')){
            $registros->whereHas('cohorteParticipanteProyecto.participante.gestor', function ($q) {
                $q->whereIn('socio_implementador_id', $this->selectedSociosIds);
            });
        }elseif(auth()->user()->can('Filtrar registros por socios por pais')){
            $registros->whereHas('cohorteParticipanteProyecto.participante.gestor', function ($q) {
                $q->whereIn('socio_implementador_id', $this->selectedSociosIds);
            });
        }else{
            $registros->where('created_by', auth()->id());
        }

        return $registros;

    }

    public function headings(): array
    {
        return [
            '#',
            'Nombre completo',
            'Género',
            'Documento de identidad',
            'Edad',
            'Cohorte',
            'Fecha de registro',
            '¿Cómo accedió al medio de vida?',
            'Nombre de la empresa',
            'Sector de organización u institución',
            'Tipo de empleo',
            'Cargo desempeñado',
            'Salario',
            '¿Qué habilidades adquiridas o fortalecidas en el programa le ayudaron a conseguir el empleo?',
            'Seleccione los Medios de verificación del enlace a medio de vida',
            'Especifique:',
            'medios de verificación del enlace a medio de vida',
            'Información adicional que desee mencionar sobre el empleo de la o el joven:',
        ];
    }

    /**
     * @param Invoice $invoice
     */
    public function map($empleo): array
    {
        return [
            $this->rowNumber++, // #
            $empleo->cohorteParticipanteProyecto->participante->full_name,
            $empleo->cohorteParticipanteProyecto->participante->sexo == 2 ? 'Masculino' : 'Femenino', // Sexo
            "\t" . $empleo->cohorteParticipanteProyecto->participante->documento_identidad,
            $empleo->cohorteParticipanteProyecto->participante->edad,
            $empleo->cohorteParticipanteProyecto->cohortePaisProyecto->cohorte->nombre ?? "",
            $empleo->created_at->format('d/m/Y'), // Fecha de Registro
            $empleo->mediosVida->nombre ?? "",
            $empleo->directorio->nombre ?? "",
            $empleo->sectorEmpresaOrganizacion->nombre ?? "",
            $empleo->tipoEmpleo->nombre ?? "",
            $empleo->cargo,
            $empleo->salario->nombre ?? "",
            $empleo->habilidades,
            $empleo->mediosVerificacion->pluck('nombre')->implode(', '),
            $empleo->medio_verificacion_otros,
            $empleo->mediosVerificacion->pluck('pivot.documento')->map(function ($documento) {
                if ($documento) {
                    return Storage::disk('s3')->temporaryUrl($documento, now()->addHour());
                } else {
                    return '';
                }

            })->implode(', '),
            $empleo->informacion_adicional,
        ];
    }
}
