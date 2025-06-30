<?php

namespace App\Exports\bancarizacion\financiero;

use App\Models\BancarizacionGrupo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\BancarizacionGrupoParticipante;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ParticipantesGrupoExport  extends DefaultValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder
{


    public $grupo;


    public function __construct(BancarizacionGrupo $grupo)
    {
        $this->grupo = $grupo;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return BancarizacionGrupoParticipante::where('bancarizacion_grupo_id', $this->grupo->id)
            ->whereNotNull('active_at')
            ->with('participante', 'participante.ciudad', 'participante.ciudad.departamento', 'bancarizacionGrupo.user', 'creator');

    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->participante->full_name,
            $row->participante->documento_identidad,
            // Add other fields as necessary
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Participante',
            'Documento Identidad',
            // Add other headings as necessary
        ];
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'C' => NumberFormat::FORMAT_TEXT,
    //     ];
    // }
    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() === 'C' && is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}
