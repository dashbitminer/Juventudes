<?php

namespace App\Exports\resultadocuatro;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AprendizajeServicioExport implements FromQuery, WithMapping, WithHeadings
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

        return

        $registros = \App\Models\AprendizajeServicio::with([
            "directorio:id,nombre,tipo_institucion_id,area_intervencion_id",
            "directorio.areaIntervencion:id,nombre",
            "directorio.tipoInstitucion:id,nombre",
            "cohorteParticipanteProyecto:id,cohorte_pais_proyecto_id,participante_id",
            "cohorteParticipanteProyecto.cohortePaisProyecto:id,cohorte_id,pais_proyecto_id",
            "cohorteParticipanteProyecto.cohortePaisProyecto.cohorte:id,nombre",
            "cohorteParticipanteProyecto.participante:id,primer_nombre,segundo_nombre,tercer_nombre,primer_apellido,segundo_apellido,tercer_apellido,fecha_nacimiento,gestor_id,documento_identidad,sexo",
            "cohorteParticipanteProyecto.participante.gestor:id,name,username,socio_implementador_id",
            "cohorteParticipanteProyecto.participante.gestor.socioImplementador:id,nombre",
            "creator:id,name",
            "paisMotivoCambioOrganizacion:id,motivo_cambio_organizacion_id",
            "paisMotivoCambioOrganizacion.motivoCambioOrganizacion:id,nombre",
            "ciudad:id,nombre,departamento_id",
            "ciudad.departamento:id,nombre",
            "paisServicioDesarrollar:id,servicio_desarrollar_id",
            "paisServicioDesarrollar.servicioDesarrollar:id,nombre",
            "paisHabilidadesAdquirir:id,habilidad_adquirir_id",
            "paisHabilidadesAdquirir.habilidadAdquirir:id,nombre",
        ])->whereHas('cohorteParticipanteProyecto', function ($query) {
            $query->whereIn('cohorte_pais_proyecto_id', $this->selectedCohortesIds);
        })
        ->whereHas('cohorteParticipanteProyecto.participante', function ($query) {
            $query->whereNull('participantes.deleted_at');
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
            'Cambiar organización',
            'Motivo cambio',
            'Nombre de la empresa',
            'Tipo de organización',
            'Área de intervención de la organización de acogida',
            'Programa/Proyecto/Dependencia de la organización',
            'Departamento',
            'Municipio',
            'Comunidad/cantón/aldea',
            'Fecha de inicio',
            'Fecha de finalización',
            'Temas sobre los que realizara el aprendizaje de servicio',
            'Escriba los servicios seleccionados',
            'Habilidades a adquirir',
            'Escriba las habilidades seleccionadas',
            'Otros conocimientos, habilidades o aprendizajes a adquirir',
            'Titulo contribución al cambio',
            'Escriba el objetivo principal de contribución al cambio',
            'Escriba las principales acciones de contribución al cambio',
            'Fecha inicio de contribución al cambio',
            'Fecha fin de contribución al cambio',
            'Cantidad promedio de personas atendidas durante el aprendizaje de servicio',
            'Otros comentarios'
        ];
    }

    /**
     * @param Invoice $invoice
     */
    public function map($servicio): array
    {
        // if(!$servicio->cohorteParticipanteProyecto || !$servicio->cohorteParticipanteProyecto->participante) {
        //     dd($servicio);
        // }


        $full_name = trim(preg_replace('/\s+/', ' ', "{$servicio->cohorteParticipanteProyecto->participante->primer_nombre} {$servicio->cohorteParticipanteProyecto->participante->segundo_nombre} {$servicio->cohorteParticipanteProyecto->participante->tercer_nombre} {$servicio->cohorteParticipanteProyecto->participante->primer_apellido} {$servicio->cohorteParticipanteProyecto->participante->segundo_apellido} {$servicio->cohorteParticipanteProyecto->participante->tercer_apellido}"));

        return [
            $this->rowNumber++, // #
            $full_name,
            $servicio->cohorteParticipanteProyecto->participante->sexo == 2 ? 'Masculino' : 'Femenino', // Sexo
            "\t".$servicio->cohorteParticipanteProyecto->participante->documento_identidad,
            $servicio->cohorteParticipanteProyecto->participante->edad,
            $servicio->cohorteParticipanteProyecto->cohortePaisProyecto->cohorte->nombre ?? "",
            $servicio->created_at->format('d/m/Y'), // Fecha de Registro
            $servicio->cambio_organizacion ? 'Si' : 'No',
            $servicio->paisMotivoCambioOrganizacion->motivoCambioOrganizacion->nombre ?? "",
            $servicio->directorio->nombre ?? "",
            $servicio->directorio->tipoInstitucion->nombre ?? "",
            $servicio->directorio->areaIntervencion->nombre ?? $servicio->directorio->area_intervencion_otros,
            $servicio->programa_proyecto,
            $servicio->ciudad->departamento->nombre ?? "",
            $servicio->ciudad->nombre ?? "",
            $servicio->comunidad,
            $servicio->fecha_inicio_prevista ? $servicio->fecha_inicio_prevista->format('d/m/Y') : "",
            $servicio->fecha_fin_prevista ? $servicio->fecha_fin_prevista->format('d/m/Y') : "",
            $servicio->paisServicioDesarrollar->pluck('servicioDesarrollar.nombre')->implode(', '),
            $servicio->descripcion_otros_servicios_desarrollar,
            $servicio->paisHabilidadesAdquirir->pluck('habilidadAdquirir.nombre')->implode(', '),
            $servicio->descripcion_habilidad_adquirir,
            $servicio->otros_conocimientos,
            $servicio->titulo_contribucion_cambio,
            $servicio->objetivo_contribucion_cambio,
            $servicio->acciones_contribucion_cambio,
            $servicio->fecha_inicio_cambio ? $servicio->fecha_inicio_cambio->format('d/m/Y') : "",
            $servicio->fecha_fin_cambio ? $servicio->fecha_fin_cambio->format('d/m/Y') : "",
            $servicio->promedio_aprendizaje,
            $servicio->otros_comentarios,
        ];
    }

}
