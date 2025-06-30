<?php

namespace App\Exports\resultadocuatro;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ServicioComunitarioExport implements FromQuery, WithMapping, WithHeadings
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

        $registros = \App\Models\ServicioComunitario::with([
            "socioImplementador:id,nombre",
            "ciudad:id,nombre",
            "departamento:id,nombre",
            "cohortePaisProyecto:id,pais_proyecto_id,cohorte_id",
            "cohortePaisProyecto.cohorte:id,nombre",
            "paisRecursoPrevisto:id,recurso_previsto_id",
            "paisRecursoPrevisto.recursoPrevisto:id,nombre",
            "paisRecursoPrevistoLeverage.recursoPrevistoLeverage:id,nombre",
            "paisRecursoPrevistoCostShare.recursoPrevistoCostShare:id,nombre",
            "paisRecursoPrevistoUsaid.recursoPrevistoUsaid:id,nombre",
            "paisPcjSostenibilidad:id,pcj_sostenibilidad_id",
            "paisPcjSostenibilidad.pcjSostenibilidad:id,nombre",
            "paisPcjAlcance:id,pcj_alcance_id",
            "paisPcjAlcance.pcjAlcance:id,nombre",
            "paisPcjFortaleceArea:id,pcj_fortalece_area_id",
            "paisPcjFortaleceArea.pcjFortaleceArea:id,nombre",
            "poblacionesBeneficiadasDirecta.paisPoblacionBeneficiada.poblacionBeneficiada:id,nombre", 
            "poblacionesBeneficiadasIndirecta.paisPoblacionBeneficiada.poblacionBeneficiada:id,nombre"
        ])
        ->withCount('scParticipantes')
        ->whereIn('cohorte_pais_proyecto_id', $this->selectedCohortesIds)
        ->when(!empty($this->selectedIds), function ($query) {
            $query->whereIn('id', $this->selectedIds);
        });

        if(auth()->user()->can('Filtrar registros por socio')){
            $registros->whereIn('socio_implementador_id', $this->selectedSociosIds);
        }elseif(auth()->user()->can('Filtrar registros por socios por pais')){
            $registros->whereIn('socio_implementador_id', $this->selectedSociosIds);
        }else{
            $registros->where('created_by', auth()->id());
        }
        
        return $registros;
    }

    public function headings(): array
    {
        return [
            '#',
            'Cohorte',
            'Socio implementador',
            'Personal socio que da seguimiento',
            'Nombre del proyecto de servicio comunitario',
            'Total de participantes',
            'Escriba el total de jovenes de 15 a 18 años que lo desarrollarán',
            'Escriba el total de jovenes de 18 a 29 años que lo desarrollarán',
            'Selecciona el Departamento donde se desarrollará el PCJ',
            'Selecciona el Municipio donde se desarrollará el PCJ',
            'Escriba la comunidad/localidad donde se desarrollará el PCJ',
            'Descripción de PCJ',
            'Escriba el objetivo de PCJ',
            'Describa las consideraciones o riesgos potenciales',
            'Describa las calificaciones/requisitos',
            'Escriba la capacitación específica',
            'Seleccione los Recursos Previstos',
            'Tipo de Recurso Previsto',
            'Especifique otro tipo de Recurso Previstos',
            'Escriba el total de Moneda Local del presupuesto',
            'Escriba el total de Dolares del presupuesto',
            'Fecha Estimada de entrega',
            'Describa la Proyección Pedagógica (Alcance)',
            'Escriba la retroalimentación de equipo de Glasswing',
            'Seleccione la sostenibilidad del PCJ',
            'Seleccione el alcance del PCJ',
            'Seleccione el área que fortalece el PCJ',
            'Seleccione el tipo de población beneficiada',
            'Población directa beneficiada',
            'Total población directa beneficiada',
            'Población indirecta beneficiada',
            'Total población idirecta beneficiada',
            '¿La comunidad colabora adicionalmente en el PCJ?',
            '¿Las Instituciones de gobierno colaboran adicionalmente en el PCJ?',
            '¿Las Empresas privadas colaboran adicionalmente en el PCJ?',
            '¿Las Organizaciones juveniles colaboran adicionalmente en el PCJ?',
            '¿Las ONG´s colaboran adicionalmente en el PCJ?',
            '¿Poseen Carta de entendimiento?',
            'Seleccione el Estatus del PCJ:',
            'Observaciones',
            'Escriba los apoyos requeridos',
            'Escriba el Progreso en (%)',
            'Nombre de quien elabora y reporta',
            'Cargo de quien elabora y reporta',
            'Fecha de elaboración y reporte',
            'Nombre de quien valida',
            'Cargo de quien valida',
            'Fecha de validación',
        ];
    }

    /**
     * @param Invoice $invoice
     */
    public function map($servicio): array
    {
        return [
            $this->rowNumber++, // #
            $servicio->cohortePaisProyecto->cohorte->nombre,
            $servicio->socioImplementador->nombre ?? "",
            $servicio->personal_socio_seguimiento,
            $servicio->nombre,
            strval($servicio->sc_participantes_count),
            strval($servicio->total_jovenes),
            strval($servicio->total_adultos_jovenes),
            $servicio->departamento->nombre ?? "",
            $servicio->ciudad->nombre ?? "",
            $servicio->comunidad,
            $servicio->descripcion,
            $servicio->objetivos,
            $servicio->riesgos_potenciales,
            $servicio->describir_calificaciones,
            $servicio->capacitacion,
            $servicio->paisRecursoPrevisto->recursoPrevisto->nombre ?? "",
            $this->getTipoRecursoPrevisto($servicio),
            $servicio->recursos_previstos_especifique ?? "",
            $servicio->monto_local,
            $servicio->monto_dolar,
            $servicio->fecha_entrega ? $servicio->fecha_entrega->format('d/m/Y') : "",
            $servicio->proyeccion_pedagogica,
            $servicio->retroalimentacion,
            $servicio->paisPcjSostenibilidad->pcjSostenibilidad->nombre ?? "",
            $servicio->paisPcjAlcance->pcjAlcance->nombre ?? "",
            $servicio->paisPcjFortaleceArea->pcjFortaleceArea->nombre ?? "",
            $servicio->tipo_poblacion_beneficiada == 1 ? 'Directa'
                                                      : ($servicio->tipo_poblacion_beneficiada == 2 ? 'Directa e Indirecta' : 'Indirecta'),

            $servicio->poblacionesBeneficiadasDirecta->map(function ($directa) {
                return $directa->paisPoblacionBeneficiada->poblacionBeneficiada->nombre ?? '';
            })->implode(', '),
            
            $servicio->total_poblacion ?? 0,
            
            $servicio->poblacionesBeneficiadasIndirecta->map(function ($indirecta) {
                return $indirecta->paisPoblacionBeneficiada->poblacionBeneficiada->nombre ?? '';
            })->implode(', '),

            $servicio->total_poblacion_indirecta ?? 0,
            $servicio->comunidad_colabora ? 'Si' : 'No',
            $servicio->gobierno_colabora ? 'Si' : 'No',
            $servicio->empresa_privada_colabora ? 'Si' : 'No',
            $servicio->organizaciones_juveniles_colabora ? 'Si' : 'No',
            $servicio->ong_colabora ? 'Si' : 'No',
            $servicio->posee_carta_entendimiento ? 'Si' : 'No',

            $servicio->estado == 1 ? "En Tiempo" :
                                             ($servicio->estado == 2 ? "Atrasado" :
                                             ($servicio->estado == 3 ? "Observado" : "Completado")),

            $servicio->observaciones,
            $servicio->apoyos_requeridos,
            $servicio->progreso.' %',
            $servicio->nombre_reporta,
            $servicio->cargo_reporta,
            $servicio->fecha_elaboracion ? $servicio->fecha_elaboracion->format('d/m/Y') : "",
            $servicio->nombre_valida,
            $servicio->cargo_valida,
            $servicio->fecha_valida ? $servicio->fecha_valida->format('d/m/Y') : "",
        ];
    }

    private function getTipoRecursoPrevisto($servicio){
        switch($servicio->paisRecursoPrevisto->recursoPrevisto->nombre){
            case 'Fondos USAID':
                return $servicio->paisRecursoPrevistoUsaid->recursoPrevistoUsaid->nombre ?? "";
            
            case 'Cost Share':
                return $servicio->paisRecursoPrevistoCostShare->recursoPrevistoCostShare->nombre ?? "";
          
            case 'Leverage':
                return $servicio->paisRecursoPrevistoLeverage->recursoPrevistoLeverage->nombre ?? "";
         
            default: 
                return '';
        }
    }
}
