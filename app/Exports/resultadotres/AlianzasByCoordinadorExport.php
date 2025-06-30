<?php

namespace App\Exports\resultadotres;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AlianzasByCoordinadorExport implements FromQuery, WithMapping, WithHeadings
{

    use Exportable;

    public $selectedAlianzasIds;

    public function __construct(array $selectedAlianzasIds)
    {
        $this->selectedAlianzasIds = $selectedAlianzasIds;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        //
    }

    public function headings(): array
    {
        return [];
    }

    public function map($row): array
    {
        return [];
    }
}
