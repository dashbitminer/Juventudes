<?php

namespace App\Exports\resultadotres;

use App\Models\CostShare;
use App\Models\Pais;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CostShareByGestorExport implements FromQuery, WithMapping, WithHeadings
{

    use Exportable;

    public $selectedCostSharesIds;

    public Pais $pais;

    public $socios;

    public function __construct(array $selectedCostSharesIds, $pais, $socios)
    {
        $this->selectedCostSharesIds = $selectedCostSharesIds;
        $this->pais = $pais;
        $this->socios = $socios;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return CostShare::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre',
            'areascoberturas:id,nombre',
            'tipoSectorSelected',
            'paisTipoSectorPublicoSelected',
            'paisTipoSectorPrivadoSelected',
            'paisOrigenEmpresaPrivadaSelected',
            'paisTamanoEmpresaPrivadaSelected',
            'paisTipoSectorAcademicaSelected',
            'paisTipoSectorComunitariaSelected',
            'resultado',
            'costshareCategorias',
            'paisCostShareValoracion',
            'costshareActividades',
            'creator'
        ])
        ->when(!empty($this->selectedCostSharesIds), callback: function ($query) {
            return $query->whereIn('id', $this->selectedCostSharesIds);
        })
        ->when($this->pais && empty($this->selectedCostSharesIds), function ($query) {
            return $query->where('pais_id', $this->pais->id);
        })
        ->when($this->socios && empty($this->selectedCostSharesIds), function ($query) {
            $socios = $this->socios->pluck('id')->toArray();
            return $query->whereIn('socio_implementador_id', $socios);
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Nombre de Organización',
            'Nombre de Contacto',
            'Ciudad',
            'Departamento',
            'Area de cobertura de la organización',
            'Tipo de Sector',
            'Tipo de Sector Público',
            'Tipo de Sector Privado',
            'Tipo de Sector Privado Otro',
            'Origen de la empresa del sector privado',
            'Tamaño de la empresa del sector privado',
            'Tipo de Sector Acádemia y de Investigación',
            'Tipo de Sector Comunitaria',
            'Descripcion de la Contribución',
            'Categorias del Costo Compartido',
            'Valor monetario',
            'Metodo de Valoración',
            'Actividad de la iniciativa',
            'Ya se encuentra registrado contablemente',
            'Resultado 1',
            'Porcentaje',
            'Resultado 2',
            'Porcentaje',
            'Resultado 3',
            'Porcentaje',
            'Resultado 4',
            'Porcentaje',
            'Estado',
            'Documento de Respaldo',
            'Fecha de Registro'
        ];
    }

    public function map($row): array
    {
        
        $resultados = $row->resultado->mapWithKeys(function ($resultado) {
            return [
                'resultado' . $resultado->costshare_resultado_id => $resultado->pivot->porcentaje
            ];
        });

        $tipoSectorSlug =  $row->tipoSectorSelected->tipoSector->slug;
        $tipoSectorPrivadoSlug = $row->paisTipoSectorPrivadoSelected->tipoSectorPrivado->slug ?? "";

        return [
            $row->id,
            $row->nombre_organizacion,
            $row->nombre_persona_registra,
            $row->ciudad->nombre,
            $row->ciudad->departamento->nombre,
            implode(', ', $row->areascoberturas->pluck('nombre')->toArray(', ')),
            $row->tipoSectorSelected->tipoSector->nombre,
            $tipoSectorSlug === 'publico' ? ($row->paisTipoSectorPublicoSelected->tipoSectorPublico->nombre ?? "") : "",
            $tipoSectorSlug === 'privado' ? ($row->paisTipoSectorPrivadoSelected->tipoSectorPrivado->nombre ?? "") : "",
            $tipoSectorSlug === 'privado' && $tipoSectorPrivadoSlug == 'otro' ? $row->otro_tipo_sector_privado : "",
            $tipoSectorSlug === 'privado' ? ($row->paisOrigenEmpresaPrivadaSelected->origenEmpresaPrivada->nombre ?? "") : "",
            $tipoSectorSlug === 'privado' ? ($row->paisTamanoEmpresaPrivadaSelected->tamanoEmpresaPrivada->nombre ?? "") : "",
            $tipoSectorSlug === 'academia-y-de-investigacion' ? ($row->paisTipoSectorAcademicaSelected->tipoSectorAcademica->nombre ?? "") : "",
            $tipoSectorSlug === 'comunitario' ? ($row->paisTipoSectorComunitariaSelected->tipoSectorComunitaria->nombre ?? "") : "",
            $row->descripcion_contribucion,
            implode(', ', $row->costshareCategorias->pluck('nombre')->toArray()),
            $row->monto,
            $row->paisCostShareValoracion->costshareValoracion->nombre,
            implode(', ', $row->costshareActividades->pluck('nombre')->toArray()),
            $row->registrado_contablemente == 1 ? 'Sí' : 'No',
            optional($resultados)['resultado1'] ? 'Sí' : null,
            optional($resultados)['resultado1'] ? optional($resultados)['resultado1'] . '%' : null,
            optional($resultados)['resultado2'] ? 'Sí' : null,
            optional($resultados)['resultado2'] ? optional($resultados)['resultado2'] . '%' : null,
            optional($resultados)['resultado3'] ? 'Sí' : null,
            optional($resultados)['resultado3'] ? optional($resultados)['resultado3'] . '%' : null,
            optional($resultados)['resultado4'] ? 'Sí' : null,
            optional($resultados)['resultado4'] ? optional($resultados)['resultado4'] . '%' : null,
            optional($row->lastEstado)->estado_registro?->nombre ?? 'Sin estado',
            Storage::disk('s3')->temporaryUrl($row->documento_soporte, now()->addMinutes(10)),
            optional($row->lastEstado)->created_at?->format('d/m/Y H:i:s') ?? 'Sin fecha'
        ];
    }
}
