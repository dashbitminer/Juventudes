<?php

namespace App\Exports\resultadocuatro;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class FichaEmprendimientoExport implements FromQuery, WithMapping, WithHeadings
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

        $registros =  \App\Models\FichaEmprendimiento::with([
            "directorio:id,nombre,tipo_institucion_id",
            "cohorteParticipanteProyecto:id,cohorte_pais_proyecto_id,participante_id",
            "cohorteParticipanteProyecto.participante:id,primer_nombre,segundo_nombre,tercer_nombre,primer_apellido,segundo_apellido,tercer_apellido,fecha_nacimiento,gestor_id,sexo,documento_identidad",
            "cohorteParticipanteProyecto.participante.gestor:id,name,username,socio_implementador_id",
            "cohorteParticipanteProyecto.participante.gestor.socioImplementador:id,nombre",
            "cohorteParticipanteProyecto.cohortePaisProyecto:id,cohorte_id",
            "cohorteParticipanteProyecto.cohortePaisProyecto.cohorte:id,nombre",
            "creator:id,name",
            "mediosVida:id,nombre",
            "rubroEmprendimiento:id,nombre",
            "etapaEmprendimiento:id,nombre",
            "capitalSemilla:id,nombre",
            "ingresosPromedio:id,nombre",
            "medioVerificacion",
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
            'Nombre de emprendimiento',
            'Rubro de emprendimiento',
            'Fecha de inicio del emprendimiento',
            'Seleccione la Etapa del emprendimiento',
            '¿Ha recibido capital semilla?',
            '¿De quién?',
            'Especifique',
            'Escriba el monto de capital semilla recibido en moneda local',
            'Escriba el monto de capital semilla recibido en dólares',
            'Los ingresos promedios generados por el emprendimiento son',
            '¿Forma parte de una red de emprendedores?',
            'Especifique',
            'Seleccione los Medios de verificación del enlace a medio de vida',
            'Especifique',
            'Medio de verificación',
            'Información adicional que desee mencionar sobre el emprendimiento de la o el joven:',
        ];
    }


    /**
     * @param Invoice $invoice
     */
    public function map($emprendimiento): array
    {
        // return Storage::disk('s3')->temporaryUrl($documento, now()->addHour());
        return [
            $this->rowNumber++, // #
            $emprendimiento->cohorteParticipanteProyecto->participante->full_name,
            $emprendimiento->cohorteParticipanteProyecto->participante->sexo == 2 ? 'Masculino' : 'Femenino', // Sexo
            "\t".$emprendimiento->cohorteParticipanteProyecto->participante->documento_identidad,
            $emprendimiento->cohorteParticipanteProyecto->participante->edad,
            $emprendimiento->cohorteParticipanteProyecto->cohortePaisProyecto->cohorte->nombre ?? "",
            $emprendimiento->created_at->format('d/m/Y'), // Fecha de Registro
            $emprendimiento->mediosVida->nombre ?? "",
            $emprendimiento->nombre,
            $emprendimiento->rubroEmprendimiento->nombre,
            $emprendimiento->fecha_inicio_emprendimiento ? $emprendimiento->fecha_inicio_emprendimiento->format('d/m/Y') : "",
            $emprendimiento->etapaEmprendimiento->nombre ?? "",
            $emprendimiento->tiene_capital_semilla ? 'Si' : 'No',
            $emprendimiento->capitalSemilla->nombre ?? "",
            $emprendimiento->capital_semilla_otros,
            $emprendimiento->monto_local,
            $emprendimiento->monto_dolar,
            $emprendimiento->ingresosPromedio->nombre ?? "",
            $emprendimiento->tiene_red_emprendimiento ? 'Si' : 'No',
            $emprendimiento->red_empredimiento,
            $emprendimiento->medioVerificacion ? $emprendimiento->medioVerificacion->pluck('nombre')->implode(', ') : "",
            $emprendimiento->medio_verificacion_otros,
            $emprendimiento->medio_verificacion_file ? Storage::disk('s3')
                                        ->temporaryUrl($emprendimiento->medio_verificacion_file, now()->addHour())  : "",
            $emprendimiento->informacion_adicional,
        ];
    }


}
