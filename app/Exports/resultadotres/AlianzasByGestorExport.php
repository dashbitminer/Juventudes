<?php

namespace App\Exports\resultadotres;

use App\Models\Alianza;
use App\Models\Pais;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AlianzasByGestorExport implements FromQuery, WithMapping, WithHeadings
{

    use Exportable;

    public $selectedAlianzasIds;

    public Pais $pais;

    public $socios;

    public $selectedSociosIds;

    public function __construct(array $selectedAlianzasIds, $pais, $socios, $selectedSociosIds)
    {
        $this->selectedAlianzasIds = $selectedAlianzasIds;
        $this->pais = $pais;
        $this->socios = $socios;
        $this->selectedSociosIds = $selectedSociosIds;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Alianza::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre',
            'tipoSectorSelected',
            'paisTipoSectorPublicoSelected',
            'paisTipoSectorPrivadoSelected',
            'paisOrigenEmpresaPrivadaSelected',
            'paisTamanoEmpresaPrivadaSelected',
            'paisTipoSectorAcademicaSelected',
            'paisTipoSectorComunitariaSelected',
            'tipoAlianzaSelected',
            'areascoberturas:id,nombre',
            'propositoAlianzaSelected',
            'modalidadEstrategiaAlianzaSelected',
            'paisObjetivoAsistenciaAlianzaSelected',
           // 'lastEstado:id,estado_registro_participante.participante_id,estado_registro_id,estado_registro_participante.created_at',
            'lastEstado',
            'lastEstado.estado_registro:id,nombre,color,icon',
            'creator'
        ])
        ->when(count($this->selectedSociosIds), function ($query) {
            $query->whereIn('socio_implementador_id', $this->selectedSociosIds);
        })
        ->when(!empty($this->selectedAlianzasIds), function ($query) {
            return $query->whereIn('id', $this->selectedAlianzasIds);
        })
        ->when($this->pais && empty($this->selectedAlianzasIds), function ($query) {
            return $query->where('pais_id', $this->pais->id);
        })
        ->when($this->socios && empty($this->selectedAlianzasIds), function ($query) {
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
            'Área de cobertura de la organización',
            'Perfil de la organización',
            'Perfil Público',
            'Perfil Privado',
            'Perfil Privado Otro',
            'Origen de la empresa del sector privado',
            'Tamaño de la empresa del sector privado',
            'Tipo de Sector Acádemia y de Investigación',
            'Tipo de Sector Comunitaria',
            'Nombre del punto de Contacto' ,
            'Correo electrónico del punto de contacto',
            'Teléfono de la Organización',
            'Tipo de Alianza',
            'Fecha de inicio de Alianza',
            'Fecha tentativa de finalización de Alianza',
            'Propósito del compromiso en conjunto',
            'Propósito del compromiso en conjunto Otro',
            'Modalidad de la estrategia de desarrollo y cooperación',
            'Objetivo de la asistencia',
            'Objetivo de la asistencia Otro',
            'Impacto previsto de la alianza',
            'Comentarios',
            'Estado',
            'Documento de Respaldo',
            'Fecha de registro'
        ];
    }

    public function map($alianza): array
    {
        $tipoSectorSlug =  $alianza->tipoSectorSelected->tipoSector->slug;
        $tipoSectorPrivadoSlug = $alianza->paisTipoSectorPrivadoSelected->tipoSectorPrivado->slug ?? "";
        $propositoCompromisoSlug = $alianza->propositoAlianzaSelected->propositoAlianza->slug;
        $objetoAsistenciaSlug = $alianza->paisObjetivoAsistenciaAlianzaSelected->objetivoAsistenciaAlianza->slug;

        return [
            $alianza->id,
            $alianza->nombre_organizacion,
            $alianza->ciudad->nombre,
            implode(', ', $alianza->areascoberturas->pluck('nombre')->toArray(', ')),
            $alianza->tipoSectorSelected->tipoSector->nombre,
            $tipoSectorSlug === 'publico' ? ($alianza->paisTipoSectorPublicoSelected->tipoSectorPublico->nombre ?? "") : "",
            $tipoSectorSlug === 'privado' ? ($alianza->paisTipoSectorPrivadoSelected->tipoSectorPrivado->nombre ?? "") : "",
            $tipoSectorSlug === 'privado' && $tipoSectorPrivadoSlug == 'otro' ? $alianza->otro_tipo_sector_privado : "",
            $tipoSectorSlug === 'privado' && $tipoSectorPrivadoSlug != 'otro' ? ($alianza->paisOrigenEmpresaPrivadaSelected->origenEmpresaPrivada->nombre ?? "") : "",
            $tipoSectorSlug === 'privado' && $tipoSectorPrivadoSlug != 'otro' ? ($alianza->paisTamanoEmpresaPrivadaSelected->tamanoEmpresaPrivada->nombre ?? "") : "",
            $tipoSectorSlug === 'academia-y-de-investigacion' ? ($alianza->paisTipoSectorAcademicaSelected->tipoSectorAcademica->nombre ?? "") : "",
            $tipoSectorSlug === 'comunitario' ? ($alianza->paisTipoSectorComunitariaSelected->tipoSectorComunitaria->nombre ?? "") : "",
            $alianza->nombre_contacto,
            $alianza->email_contacto,
            $alianza->telefono_contacto,
            $alianza->tipoAlianzaSelected->tipoAlianza->nombre,
            Carbon::parse($alianza->fecha_inicio)->format('d/m/Y g:i A'),
            Carbon::parse($alianza->fecha_fin_tentativa)->format('d/m/Y g:i A'),
            $alianza->propositoAlianzaSelected->propositoAlianza->nombre,
            $propositoCompromisoSlug === 'otro' ? $alianza->otro_proposito_alianza : $alianza->propositoAlianzaSelected->propositoAlianza->nombre,
            $alianza->modalidadEstrategiaAlianzaSelected->modalidadEstrategiaAlianza->nombre,
            $alianza->paisObjetivoAsistenciaAlianzaSelected->objetivoAsistenciaAlianza->nombre,
            $objetoAsistenciaSlug === 'otro' ? $alianza->otro_objetivo_asistencia_alianza : $alianza->paisObjetivoAsistenciaAlianzaSelected->objetivoAsistenciaAlianza->nombre,
            $alianza->impacto_previsto_alianza,
            $alianza->comentario,
            $alianza->lastEstado->estado_registro->nombre ?? "registrado",
            Storage::disk('s3')->temporaryUrl($alianza->documento_respaldo, now()->addMinutes(10)),
            $alianza->created_at->format('d/m/Y g:i A')
        ];
    }
}
