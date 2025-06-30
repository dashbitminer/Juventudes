<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

class SesionesImport implements WithMultipleSheets
{
    use WithConditionalSheets;

    public function conditionalSheets(): array
    {
        return [
            'Sesiones GT' => new JLIImport(),
            'Sesiones' => new JLIImport(),
            'HN' => new JLIImport(),
            'GT' => new JLIImport(),
        ];
    }
}
