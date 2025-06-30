<?php

namespace App\Exports\resultadocuatro;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class FichaVoluntariadoExport implements FromQuery, WithMapping, WithHeadings
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

        $registros = \App\Models\FichaVoluntario::with([
            "directorio:id,nombre,tipo_institucion_id",
            "directorio.tipoInstitucion:id,nombre",
            "cohorteParticipanteProyecto:id,cohorte_pais_proyecto_id,participante_id",
            "cohorteParticipanteProyecto.participante:id,primer_nombre,segundo_nombre,tercer_nombre,primer_apellido,segundo_apellido,tercer_apellido,fecha_nacimiento,gestor_id,sexo,documento_identidad",
            "cohorteParticipanteProyecto.participante.gestor:id,name,username,socio_implementador_id",
            "cohorteParticipanteProyecto.participante.gestor.socioImplementador:id,nombre",
            "cohorteParticipanteProyecto.cohortePaisProyecto.cohorte:id,nombre",
            "creator:id,name",
            "paisMedioVida:id,medio_vida_id",
            "paisMedioVida.medioVida:id,nombre",
            "paisVinculadoDebido:id,vinculado_debido_id",
            "paisVinculadoDebido.vinculadoDebido:id,nombre",
            "paisAreaIntervencion:id,area_intervencion_id",
            "paisAreaIntervencion.areaIntervencion:id,nombre",
            "paisServicioDesarrollar:id,servicio_desarrollar_id",
            "paisServicioDesarrollar.servicioDesarrollar:id,nombre",
            "paisMedioVerificacionVoluntario:id,medio_verificacion_voluntario_id",
            "paisMedioVerificacionVoluntario.medioVerificacionVoluntario:id,nombre"
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
            'Tipo de organización/institución',
            'Está vinculado debido a:',
            'Especifique:',
            '¿Desde cuando realizan el voluntariado?',
            'Área de intervención de la organización/institución:',
            'Escriba el promedio de horas que realizan al mes:',
            'Seleccione los servicios que desarrolla:',
            'Otros',
            'Seleccione los Medios de verificación del voluntariado:',
            'Cargue los medios de verificación del voluntariado',
            'Información adicional que desee mencionar sobre el empleo de la o el joven:',
        ];
    }
    /**
     * @param Invoice $invoice
     */
    public function map($voluntariado): array
    {
        return [
            $this->rowNumber++, // #
            $voluntariado->cohorteParticipanteProyecto->participante->full_name,
            $voluntariado->cohorteParticipanteProyecto->participante->sexo == 2 ? 'Masculino' : 'Femenino', // Sexo
            "\t".$voluntariado->cohorteParticipanteProyecto->participante->documento_identidad,
            $voluntariado->cohorteParticipanteProyecto->participante->edad,
            $voluntariado->cohorteParticipanteProyecto->cohortePaisProyecto->cohorte->nombre ?? "",
            $voluntariado->created_at->format('d/m/Y'), // Fecha de Registro
            $voluntariado->paisMedioVida->medioVida->nombre ?? "",
            $voluntariado->directorio->nombre ?? "",
            $voluntariado->directorio->tipoInstitucion->nombre ?? "",
            $voluntariado->paisVinculadoDebido->vinculadoDebido->nombre ?? "",
            $voluntariado->vinculado_otro,
            $voluntariado->fecha_inicio_voluntariado->format('d/m/Y'),
            $voluntariado->paisAreaIntervencion->areaIntervencion->nombre ?? "",
            $voluntariado->promedio_horas,
            $voluntariado->paisServicioDesarrollar ? $voluntariado->paisServicioDesarrollar->pluck('servicioDesarrollar.nombre')->implode(', ') : "",
            $voluntariado->servicio_otro,
            $voluntariado->paisMedioVerificacionVoluntario->medioVerificacionVoluntario->nombre ?? "",
            $voluntariado->medio_verificacion_file  ? Storage::disk('s3')->temporaryUrl($voluntariado->medio_verificacion_file, now()->addHour())
                                                    : "",
            $voluntariado->informacion_adicional,
        ];
    }
}
