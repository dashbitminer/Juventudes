<?php

namespace App\Exports\resultadocuatro;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FichaFormacionExport implements FromQuery, WithMapping, WithHeadings
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

        return \App\Models\FichaFormacion::with([
            "directorio:id,nombre,tipo_institucion_id",
            "cohorteParticipanteProyecto:id,cohorte_pais_proyecto_id,participante_id",
            "cohorteParticipanteProyecto.participante:id,primer_nombre,segundo_nombre,tercer_nombre,primer_apellido,segundo_apellido,tercer_apellido,fecha_nacimiento,gestor_id,sexo,documento_identidad",
            "cohorteParticipanteProyecto.participante.gestor:id,name,username,socio_implementador_id",
            "cohorteParticipanteProyecto.participante.gestor.socioImplementador:id,nombre",
            "cohorteParticipanteProyecto.cohortePaisProyecto:id,cohorte_id",
            "cohorteParticipanteProyecto.cohortePaisProyecto.cohorte:id,nombre",
            "creator:id,name",
            "paisMedioVida:id,medio_vida_id",
            "paisMedioVida.medioVida:id,nombre",
            "paisTipoEstudio:id,tipo_estudio_id",
            "paisTipoEstudio.tipoEstudio:id,nombre",
            "paisAreaFormacion:id,area_formacion_id",
            "paisAreaFormacion.areaFormacion:id,nombre",
            "paisMedioVerficicacionFormacion:id,medio_verificacion_formacion_id",
            "paisMedioVerficicacionFormacion.medioVerificacionFormacion:id,nombre"
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
            'Tipo de estudio',
            'Especifique',
            'Área de formación',
            'Total de horas de duración',
            'Tipo de modalidad',
            'Medio de verificación',
            'Archivo de medio de verificación',
            'Medio de verificación',
            'Archivo de medio de verificación',
            'Medio de verificación',
            'Archivo de medio de verificación',
            'Información adicional que desee mencionar sobre la formación de la o el joven:',            
        ];
    }
    /**
     * @param Invoice $invoice
     */
    public function map($formacion): array
    {
        // return Storage::disk('s3')->temporaryUrl($documento, now()->addHour());
        return [
            $this->rowNumber++, // #
            $formacion->cohorteParticipanteProyecto->participante->full_name,
            $formacion->cohorteParticipanteProyecto->participante->sexo == 2 ? 'Masculino' : 'Femenino', // Sexo
            "\t".$formacion->cohorteParticipanteProyecto->participante->documento_identidad,
            $formacion->cohorteParticipanteProyecto->participante->edad,
            $formacion->cohorteParticipanteProyecto->cohortePaisProyecto->cohorte->nombre ?? "",
            $formacion->created_at->format('d/m/Y'), // Fecha de Registro
            $formacion->paisMedioVida->medioVida->nombre ?? "",
            $formacion->directorio->nombre ?? "",
            $formacion->paisTipoEstudio->tipoEstudio->nombre ?? "",
            $formacion->otro_tipo_estudio,
            $formacion->paisAreaFormacion->areaFormacion->nombre ?? "",
            $formacion->total_horas_duracion,
            $formacion->tipo_modalidad == 1 ? 'Virtual' : ($formacion->tipo_modalidad == 2 ? 'Presencial' : 'Virtual y Presencial'),
            $formacion->paisMedioVerficicacionFormacion->isNotEmpty() ? $formacion->paisMedioVerficicacionFormacion->first()->medioVerificacionFormacion->nombre : "",

            $formacion->paisMedioVerficicacionFormacion->isNotEmpty() ? Storage::disk('s3')
                                            ->temporaryUrl($formacion->paisMedioVerficicacionFormacion->first()->pivot->medio_verificacion_file, now()->addHour())
                                            : "",

            $formacion->paisMedioVerficicacionFormacion->count() > 1 ? $formacion->paisMedioVerficicacionFormacion[1]->medioVerificacionFormacion->nombre : "",
            $formacion->paisMedioVerficicacionFormacion->count() > 1 ? Storage::disk('s3')
                                                    ->temporaryUrl($formacion->paisMedioVerficicacionFormacion[1]->pivot->medio_verificacion_file, now()->addHour())
                                                     : "",

            $formacion->paisMedioVerficicacionFormacion->count() > 2 ? $formacion->paisMedioVerficicacionFormacion[2]->medioVerificacionFormacion->nombre : "",
            $formacion->paisMedioVerficicacionFormacion->count() > 2 ? Storage::disk('s3')
                                                    ->temporaryUrl($formacion->paisMedioVerficicacionFormacion[2]->pivot->medio_verificacion_file, now()->addHour())
                                                    : "",

            $formacion->informacion_adicional,
        ];
    }
}
