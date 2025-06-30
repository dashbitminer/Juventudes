<?php

namespace App\Exports\resultadocuatro;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PracticaEmpleabilidadExport implements FromQuery, WithMapping, WithHeadings
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

        $registros = \App\Models\PracticaEmpleabilidad::with([
            "directorio:id,nombre,tipo_institucion_id,area_intervencion_otros",
            "directorio.areaIntervencion:id,nombre",
            "directorio.tipoInstitucion:id,nombre",
            "cohorteParticipanteProyecto:id,cohorte_pais_proyecto_id,participante_id",
            "cohorteParticipanteProyecto.participante:id,primer_nombre,segundo_nombre,tercer_nombre,primer_apellido,segundo_apellido,tercer_apellido,fecha_nacimiento,gestor_id,sexo,documento_identidad",
            "cohorteParticipanteProyecto.participante.gestor:id,name,username,socio_implementador_id",
            "cohorteParticipanteProyecto.participante.gestor.socioImplementador:id,nombre",
            "cohorteParticipanteProyecto.cohortePaisProyecto.cohorte:id,nombre",
            "creator:id,name",
            "ciudad:id,nombre,departamento_id",
            "ciudad.departamento:id,nombre",
            "paisServicioDesarrollar:id,servicio_desarrollar_id",
            "paisServicioDesarrollar.servicioDesarrollar:id,nombre",
            "paisHabilidadesAdquirir:id,habilidad_adquirir_id",
            "paisHabilidadesAdquirir.habilidadAdquirir:id,nombre"
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
            'Nombre de la empresa',
            'Tipo de organización',
            'Área de intervención de la organización de acogida',
            'Programa/Proyecto/Dependencia de la organización',
            'Departamento',
            'Municipio',
            'Comunidad/Cantón/Aldea',
            'Fecha inicio',
            'Fecha fin',
            'Seleccione los servicios que desarrolla',
            'Escriba los servicios seleccionados',
            'Habilidades a adquirir',
            'Escriba las habilidades seleccionadas',
            'Otros conocimientos, habilidades o aprendizajes a adquirir',
            'Descripciones',
        ];
    }
    /**
     * @param Invoice $invoice
     */
    public function map($practica): array
    {
        return [
            $this->rowNumber++, // #
            $practica->cohorteParticipanteProyecto->participante->full_name,
            $practica->cohorteParticipanteProyecto->participante->sexo == 2 ? 'Masculino' : 'Femenino', // Sexo
            "\t".$practica->cohorteParticipanteProyecto->participante->documento_identidad,
            $practica->cohorteParticipanteProyecto->participante->edad,
            $practica->cohorteParticipanteProyecto->cohortePaisProyecto->cohorte->nombre ?? "",
            $practica->created_at->format('d/m/Y'), // Fecha de Registro
            $practica->directorio->nombre ?? "",
            $practica->directorio->tipoInstitucion->nombre ?? "",
            $practica->directorio->areaIntervencion->nombre ?? $practica->directorio->area_intervencion_otros,
            $practica->programa_proyecto,
            $practica->ciudad->departamento->nombre ?? "",
            $practica->ciudad->nombre ?? "",
            $practica->comunidad,
            $practica->fecha_inicio_prevista ? $practica->fecha_inicio_prevista->format('d/m/Y') : "",
            $practica->fecha_fin_prevista ? $practica->fecha_fin_prevista->format('d/m/Y') : "",
            $practica->paisServicioDesarrollar->pluck('servicioDesarrollar.nombre')->implode(', '),
            $practica->paisServicioDesarrollar->map(function($item) {
                return $item->pivot->descripcion_otros_servicios_desarrollar;
            })->filter()->implode(', '), //R
            $practica->paisHabilidadesAdquirir->pluck('habilidadAdquirir.nombre')->implode(', '),
            $practica->paisHabilidadesAdquirir->map(function($item) {
                return $item->pivot->descripcion_otras_habilidades;
            })->filter()->implode(', '), //T
            $practica->otros_conocimientos,
            $practica->descripciones,
        ];
    }
}
