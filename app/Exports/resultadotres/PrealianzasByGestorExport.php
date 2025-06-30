<?php

namespace App\Exports\resultadotres;

use App\Models\PreAlianza;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PrealianzasByGestorExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public $selectedPreAlianzasIds;

    public $estado = [
        '1' => 'Atrasado', 
        '2' => 'Cierto nivel de atraso', 
        '3' => 'En tiempo'
    ];

    public function __construct(array $selectedPreAlianzasIds)
    {
        $this->selectedPreAlianzasIds = $selectedPreAlianzasIds;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return PreAlianza::with([
            'areascoberturas',
            'coberturanacional',
            'socioImplementador:id,nombre',
            'tipoSector:id,tipo_sector_id',
            'tipoSectorPublico:id,pais_id,tipo_sector_publico_id',
            'tipoSectorPrivado:id,pais_id,tipo_sector_privado_id',
            'tamanoEmpresaPrivada:id,pais_id,tamano_empresa_privada_id',
            'origenEmpresaPrivada:id,pais_id,origen_empresa_privada_id',
            'tipoSectorComunitaria:id,pais_id,tipo_sector_comunitaria_id',
            'tipoSectorAcademica:id,pais_id,tipo_sector_academica_id',
            'tipoAlianza:id,pais_id,tipo_alianza_id',
            'coberturaGeografica:id,pais_id,cobertura_geografica_id',
            'creator'
        ])
        ->when(!empty($this->selectedPreAlianzasIds), function ($query) {
            return $query->whereIn('id', $this->selectedPreAlianzasIds);
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Nombre de organización',
            'Nombre de contacto',
            'Estado',
            'Fecha de registro'
        ];
    }

    public function map($prealianza): array
    {
        return [
            $prealianza->id,
            $prealianza->nombre_organizacion,
            $prealianza->nombre_contacto,
            $this->estado[$prealianza->estado_alianza],
            $prealianza->created_at->format('d/m/Y g:i A')

        ];
    }
}
