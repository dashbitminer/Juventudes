<?php

namespace App\Exports\resultadotres;


use App\Models\Apalancamiento;
use App\Models\Pais;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApalancamientosByGestorExport implements FromQuery, WithMapping, WithHeadings
{

    use Exportable;

    public $selectedApalancamientosIds;

    public Pais $pais;

    public $socios;

    public function __construct(array $selectedApalancamientosIds, $pais, $socios)
    {
        $this->selectedApalancamientosIds = $selectedApalancamientosIds;
        $this->pais = $pais;
        $this->socios = $socios;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
       return Apalancamiento::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre',
            'lastEstado.estado_registro:id,nombre,color,icon',
            'areascoberturas:id,nombre',
            'tipoSectorSelected',
            'paisTipoSectorPublicoSelected',
            'paisTipoSectorPrivadoSelected',
            'paisOrigenEmpresaPrivadaSelected',
            'paisTamanoEmpresaPrivadaSelected',
            'paisTipoSectorAcademicaSelected',
            'paisTipoSectorComunitariaSelected',
            'paisTipoRecursoSelected',
            'paisOrigenRecursoSelected',
            'paisFuenteRecursoSelected',
            'modalidadEstrategiaApalancamientoSelected',
            'paisObjetivoAsistenciaApalancamientoSelected',
            'creator'
        ])
        ->when(!empty($this->selectedApalancamientosIds), function ($query) {
            return $query->whereIn('id', $this->selectedApalancamientosIds);
        })
        ->when($this->pais && empty($this->selectedApalancamientosIds), function ($query) {
            return $query->where('pais_id', $this->pais->id);
        })
        ->when($this->socios && empty($this->selectedApalancamientosIds), function ($query) {
            $socios = $this->socios->pluck('id')->toArray();
            return $query->whereIn('socio_implementador_id', $socios);
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Nombre de Organización',
            'Ciudad',
            'Departamento',
            'Área de cobertura de la organización',
            'Tipo de Sector',
            'Tipo de Sector Público',
            'Tipo de Sector Privado',
            'Tipo de Sector Privado Otro',
            'Origen de la empresa del sector privado',
            'Tamaño de la empresa del sector privado',
            'Tipo de Sector Acádemia y de Investigación',
            'Tipo de Sector Comunitaria',
            'Tipo de Recurso',
            'Origen de los recursos del sector',
            'Origen de los recursos del sector Otro',
            'Fuente de recursos del sector',
            'Fuente de recursos del sector Otro',
            'Modalidad de la estrategia de desarrollo y cooperación',
            'Objetivo de la asistencia',
            'Objetivo de la asistencia Otro',
            'Monto Apalancado',
            'Concepto del Recurso',
            'Nombre de la persona que registra',
            'Comentario',
            'Estado',
            'Documento de Respaldo',
            'Fecha de Registro'
        ];
    }

    public function map($apalancamiento): array
    {
        $tipoSectorSlug =  $apalancamiento->tipoSectorSelected->tipoSector->slug;
        $tipoSectorPrivadoSlug = $apalancamiento->paisTipoSectorPrivadoSelected->tipoSectorPrivado->slug ?? "";
        $origenRecursoSlug = $apalancamiento->paisOrigenRecursoSelected->origenRecurso->slug;
        $fuenteRecursoSlug = $apalancamiento->paisFuenteRecursoSelected->fuenteRecurso->slug;
        $objetivoAsistenciaSlug = $apalancamiento->paisObjetivoAsistenciaApalancamientoSelected->objetivoAsistenciaAlianza->slug;

        return [
            $apalancamiento->id,
            $apalancamiento->nombre_organizacion,
            $apalancamiento->ciudad->nombre,
            $apalancamiento->ciudad->departamento->nombre,
            implode(', ', $apalancamiento->areascoberturas->pluck('nombre')->toArray(', ')),
            $apalancamiento->tipoSectorSelected->tipoSector->nombre,
            $tipoSectorSlug === 'publico' ? ($apalancamiento->paisTipoSectorPublicoSelected->tipoSectorPublico->nombre ?? "") : "",
            $tipoSectorSlug === 'privado' ? ($apalancamiento->paisTipoSectorPrivadoSelected->tipoSectorPrivado->nombre ?? "") : "",
            $tipoSectorSlug === 'privado' && $tipoSectorPrivadoSlug == 'otro' ? $apalancamiento->otro_tipo_sector_privado : "",
            $tipoSectorSlug === 'privado' && $tipoSectorPrivadoSlug != 'otro' ? ($apalancamiento->paisOrigenEmpresaPrivadaSelected->origenEmpresaPrivada->nombre ?? "") : "",
            $tipoSectorSlug === 'privado' && $tipoSectorPrivadoSlug != 'otro' ? ($apalancamiento->paisTamanoEmpresaPrivadaSelected->tamanoEmpresaPrivada->nombre ?? "") : "",
            $tipoSectorSlug === 'academia-y-de-investigacion' ? ($apalancamiento->paisTipoSectorAcademicaSelected->tipoSectorAcademica->nombre ?? "") : "",
            $tipoSectorSlug === 'comunitario' ? ($apalancamiento->paisTipoSectorComunitariaSelected->tipoSectorComunitaria->nombre ?? "") : "",
            $apalancamiento->paisTipoRecursoSelected->tipoRecurso->nombre,
            $apalancamiento->paisOrigenRecursoSelected->origenRecurso->nombre,
            $origenRecursoSlug === 'otros' ? $apalancamiento->otros_recursos_sector : "",
            $apalancamiento->paisFuenteRecursoSelected->fuenteRecurso->nombre,
            $fuenteRecursoSlug === 'otros' ? $apalancamiento->otros_fuente_recursos_sector : "",
            $apalancamiento->modalidadEstrategiaApalancamientoSelected->modalidadEstrategiaAlianza->nombre,
            $apalancamiento->paisObjetivoAsistenciaApalancamientoSelected->objetivoAsistenciaAlianza->nombre,
            $objetivoAsistenciaSlug === 'otro' ? $apalancamiento->otro_objetivo_asistencia_alianza : "",
            $apalancamiento->monto_apalancado,
            $apalancamiento->concepto_recurso,
            $apalancamiento->nombre_persona_registra,
            $apalancamiento->comentario,
            $apalancamiento->lastEstado->estado_registro->nombre ?? "registrado",
            Storage::disk('s3')->temporaryUrl($apalancamiento->documento_respaldo, now()->addMinutes(10)),
            $apalancamiento->created_at->format('d/m/Y g:i A')
        ];
    }
}
