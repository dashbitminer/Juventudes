<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class JLIImport implements ToCollection, WithHeadingRow, WithChunkReading,ShouldQueue
//WithBatchInserts
{
    public function collection(Collection $rows)
    {
        return $rows;
    }

    // public function batchSize(): int
    // {
    //     return 400;
    // }

    public function chunkSize(): int
    {
        return 1000;
    }
}
