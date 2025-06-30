<?php

namespace App\Exports\bancarizacion\estipendio;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Storage;
use App\Models\Participante;

class ParticipantesExport implements WithMultipleSheets
{
    use Exportable;

    public $selectedIds;

    public $estipendiosIds;

    public $estipendio;

    public function __construct(array $selectedIds, $estipendiosIds, $estipendio)
    {
        $this->selectedIds = $selectedIds;
        $this->estipendiosIds = $estipendiosIds;
        $this->estipendio = $estipendio;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            new ParticipantesFinancieroExport($this->selectedIds, $this->estipendiosIds, $this->estipendio),
            new ParticipantesFinancieroExport($this->selectedIds, $this->estipendiosIds, $this->estipendio, true),
        ];
    }
}
