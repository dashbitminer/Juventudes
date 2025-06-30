<?php

namespace App\Services;

use ZipArchive;
use Composer\Pcre\Preg;
use Illuminate\Support\Str;
use App\Models\BancarizacionGrupo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExportService
{
    public function exportGuatemala($selectedParticipanteIds)
    {
        // Set memory limit to 2048MB or unlimited (-1)
        ini_set('memory_limit', '-1'); // Use '-1' for unlimited memory

        try {
            $zip3 = new ZipArchive();
            $originalFilePath = storage_path('app/bancarizacion_guatemala_sample.xlsx');
            $gruposFoldersNames = [];
            $data = [];

            foreach ($selectedParticipanteIds as $grupo) {
                $grupoBanco = BancarizacionGrupo::find($grupo);
                $grupoDetalle = \App\Models\BancarizacionGrupoParticipante::where('bancarizacion_grupo_id', $grupo)
                    ->whereNotNull('active_at')
                    ->with('participante.gestor.socioImplementador', 'participante.direccionGuatemala.ciudad.departamento', 'participante.ciudad', 'participante.ciudad.departamento', 'bancarizacionGrupo.user', 'creator.socioImplementador')
                    ->get();

                $chunkedGrupoDetalle = $grupoDetalle->chunk(100);

                foreach ($chunkedGrupoDetalle as $i => $chunk) {
                    $copyFilePath = storage_path('app/copied_sample_' . trim($grupoBanco->nombre) . '_PARTE' . $i . '.xlsx');
                    copy($originalFilePath, $copyFilePath);

                    $spreadsheet = IOFactory::load($copyFilePath);
                    $sheet = $spreadsheet->getActiveSheet();

                    $data = [];
                    foreach ($chunk as $record) {


                        switch ($record->participante->estado_civil_id) {
                            case 4:
                                $estadoCivilConverted = 'UNIDO';
                                break;
                            case 2:
                                $estadoCivilConverted = 'CASADO';
                                break;
                            default:
                                $estadoCivilConverted = 'SOLTERO';
                                break;
                        }

                        switch ($record->participante->parentesco_id) {
                            case 1:
                                $parentescoConverted = 'MADRE';
                                break;
                            case 2:
                                $parentescoConverted = 'PADRE';
                                break;
                            case 3:
                                $parentescoConverted = 'HERMANO';
                                break;
                            case 4:
                                $parentescoConverted = 'ABUELO';
                                break;
                            case 5:
                                $parentescoConverted = 'CONYUGUE';
                                break;
                            default:
                                $parentescoConverted = 'OTROS';
                                break;
                        }


                        $data[] = [
                            $this->cleanUTF8String(trim($record->participante->nombre_completo)),
                            $this->cleanUTF8String($record->participante->primer_apellido),
                            isset($record->participante->segundo_apellido) ? $this->cleanUTF8String($record->participante->segundo_apellido) : '',
                            isset($record->participante->tercer_apellido) ? $this->cleanUTF8String($record->participante->tercer_apellido) : '',
                            isset($record->participante->fecha_nacimiento) ? $record->participante->fecha_nacimiento->format('d/m/Y') : '',
                            isset($record->participante->sexo) ? ($record->participante->sexo == 2 ? 'M' : 'F') : '',
                            isset($record->participante->estado_civil) ? $estadoCivilConverted : 'CASADO',
                            isset($record->participante->nacionalidad) ? 'GUATEMALTECA' : '',
                            'ESTUDIANTE',
                            '',
                            '',
                            '',
                            isset($record->participante->documento_identidad) ? $record->participante->documento_identidad : '',
                            '',
                            '',
                            '',
                            isset($record->participante->direccionGuatemala->direccion) ? $this->cleanUTF8String($record->participante->direccionGuatemala->direccion) : '',
                            isset($record->participante->direccionGuatemala->casa) ? $this->cleanUTF8String($record->participante->direccionGuatemala->casa) : '',
                            isset($record->participante->direccionGuatemala->apartamento) ? $this->cleanUTF8String($record->participante->direccionGuatemala->apartamento) : '',
                            isset($record->participante->direccionGuatemala->zona) ? $this->cleanUTF8String($record->participante->direccionGuatemala->zona) : '',
                            isset($record->participante->direccionGuatemala->colonia) ? $this->cleanUTF8String($record->participante->direccionGuatemala->colonia) : '',
                            isset($record->participante->direccionGuatemala->ciudad->nombre) ? $this->cleanUTF8String($record->participante->direccionGuatemala->ciudad->nombre) : '',
                            isset($record->participante->direccionGuatemala->ciudad->departamento->nombre) ? $this->cleanUTF8String($record->participante->direccionGuatemala->ciudad->departamento->nombre) : '',
                            '',
                            isset($record->participante->telefono) ? $record->participante->telefono : '',
                            isset($record->participante->email) ? Str::upper($record->participante->email) : '0',
                            '',
                            '',
                            '',
                            isset($record->monto) ? $record->monto : '',
                            'QUETZALES',
                            isset($record->monto) ? $record->monto : '',
                            'PARTICIPANTE',
                            '',
                            '',
                            '',
                            '',
                            isset($record->participante->primer_apellido_beneficiario) ? $this->cleanUTF8String($record->participante->primer_apellido_beneficiario) : '',
                            isset($record->participante->segundo_apellido_beneficiario) ? $this->cleanUTF8String($record->participante->segundo_apellido_beneficiario) : '',
                            isset($record->participante->tercer_apellido_beneficiario) ? $this->cleanUTF8String($record->participante->tercer_apellido_beneficiario) : '',
                            $this->cleanBeneficiarioName($record),
                            // $this->cleanUTF8String(trim($record->participante->primer_apellido_beneficiario . ' ' . $record->participante->segundo_apellido_beneficiario . ' ' . $record->participante->tercer_apellido_beneficiario)),
                            isset($record->participante->parentesco_id) ? $parentescoConverted : '',
                            '100%',
                            '',
                            '',
                            '',
                            '',
                            '1',
                            isset($record->participante->lugar_nacimiento) ? $record->participante->lugar_nacimiento : '',
                            isset($record->participante->lugar_nacimiento_municipio) ? $record->participante->lugar_nacimiento_municipio : '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $this->cleanUTF8String(trim($record->creator->socioImplementador->nombre ?? '')),
                            'PRIVADA'
                        ];
                    }

                    $row = 3;
                    foreach ($data as $item) {
                        $col = 'A';
                        foreach ($item as $value) {
                            $sheet->setCellValue($col . $row, $value);
                            $col++;
                        }
                        $row++;
                    }

                    if (count($data) < BancarizacionGrupo::GUATEMALA_LIMITE_FILAS) {
                        $spreadsheet->setActiveSheetIndexByName('TXT');
                        $sheet = $spreadsheet->getActiveSheet();
                        for ($r = $row - 1; $r <= BancarizacionGrupo::GUATEMALA_LIMITE_FILAS; $r++) {
                            for ($c = 'A'; $c !== 'EZ'; $c++) {
                                $sheet->setCellValue($c . $r, '');
                            }
                        }
                    }

                    $spreadsheet->setActiveSheetIndexByName('DATOS');
                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $writer->save($copyFilePath);

                    $s3TempDir = storage_path('app/s3_downloads/' . trim($grupoBanco->nombre) . '_PARTE' . $i . '/');
                    if (!file_exists($s3TempDir)) {
                        Storage::makeDirectory('s3_downloads/' . trim($grupoBanco->nombre) . '_PARTE' . $i);
                    }

                    foreach ($chunk as $file) {
                        $folderName = strtoupper(trim($file->participante->primer_nombre) . '_' . trim($file->participante->primer_apellido));
                        $folderPath = $s3TempDir . $folderName;

                        if (!file_exists(storage_path('app/s3_downloads/' . trim($grupoBanco->nombre) . '_PARTE' . $i . '/' . $folderName))) {
                            Storage::makeDirectory('s3_downloads/' . trim($grupoBanco->nombre) . '_PARTE' . $i . '/' . $folderName);
                        }

                        if ($file->participante->copia_documento_identidad) {
                            $extension = pathinfo($file->participante->copia_documento_identidad, PATHINFO_EXTENSION);
                            file_put_contents($folderPath . '/frente.' . $extension, Storage::disk('s3')->get($file->participante->copia_documento_identidad));
                            if ($file->participante->copia_documento_identidad_reverso) {
                                $extension_reverso = pathinfo($file->participante->copia_documento_identidad_reverso, PATHINFO_EXTENSION);
                                file_put_contents($folderPath . '/reverso.' . $extension_reverso, Storage::disk('s3')->get($file->participante->copia_documento_identidad_reverso));
                            }
                        }
                    }

                    $zipFilePath1 = storage_path('app/s3_files_' . trim($grupoBanco->nombre) . '_PARTE' . $i . '.zip');
                    $zip1 = new ZipArchive();
                    $s3TempDir = storage_path('app/s3_downloads/' . trim($grupoBanco->nombre) . '_PARTE' . $i . '/');
                    $contadorArchivos = 0;
                    if ($zip1->open($zipFilePath1, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                        foreach ($chunk as $file) {
                            $folderName = strtoupper(trim($file->participante->primer_nombre) . '_' . trim($file->participante->primer_apellido));
                            $folderPath = $s3TempDir . $folderName;

                            if ($file->participante->copia_documento_identidad) {
                                $extension = pathinfo($file->participante->copia_documento_identidad, PATHINFO_EXTENSION);
                                $zip1->addFile($folderPath . '/frente.' . $extension, $folderName . '/' . $folderName . '_frente.' . $extension);
                                if ($file->participante->copia_documento_identidad_reverso) {
                                    $extension_reverso = pathinfo($file->participante->copia_documento_identidad_reverso, PATHINFO_EXTENSION);
                                    $zip1->addFile($folderPath . '/reverso.' . $extension_reverso, $folderName . '/' . $folderName . '_reverso.' . $extension_reverso);
                                }
                                $contadorArchivos++;
                            }
                        }
                        $zip1->close();
                    }

                    $zipFilePath2 = storage_path('app/final_package_' . trim($grupoBanco->nombre) . '_PARTE' . $i . '.zip');
                    $zip2 = new ZipArchive();
                    if ($zip2->open($zipFilePath2, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                        $zip2->addFile($copyFilePath, 'grupo' . trim($grupoBanco->nombre) . '_PARTE' . $i . '.xlsx');
                        if($contadorArchivos > 0){
                            $zip2->addFile($zipFilePath1, 's3_files.zip');
                        }
                        $zip2->close();
                    }

                    $gruposFoldersNames[] = trim($grupoBanco->nombre) . '_PARTE' . $i;
                }
            }

            $zipBancarizacionPath = storage_path('app/bancarizacion.zip');
            $zip3 = new ZipArchive();
            if ($zip3->open($zipBancarizacionPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                foreach ($gruposFoldersNames as $item) {
                    $zip3->addFile(storage_path('app/final_package_' . $item . '.zip'), $item . '.zip');
                }
                $zip3->close();
            }

            return response()->download($zipBancarizacionPath)->deleteFileAfterSend(true);
        } finally {
            foreach ($gruposFoldersNames as $item) {
                Storage::delete('final_package_' . $item . '.zip');
                Storage::delete('copied_sample_' . $item . '.xlsx');
                Storage::delete('s3_files_' . $item . '.zip');
                Storage::deleteDirectory('s3_downloads/' . $item);
            }
        }
    }


    public function exportHonduras($selectedParticipanteIds)
    {
        // Set memory limit to 2048MB or unlimited (-1)
        ini_set('memory_limit', '-1'); // Use '-1' for unlimited memory

        try {
            $originalFilePath = storage_path('app/bancarizacion_honduras_sample.xlsx');
            $gruposFoldersNames = [];

            foreach ($selectedParticipanteIds as $grupoId) {
                $grupoBanco = BancarizacionGrupo::find($grupoId);

                // Use a more efficient query with specific columns and cursor pagination
                $query = DB::table('bancarizacion_grupo_participantes')
                    ->where('bancarizacion_grupo_id', $grupoId)
                    ->whereNotNull('bancarizacion_grupo_participantes.active_at')
                    ->join('participantes', 'bancarizacion_grupo_participantes.participante_id', '=', 'participantes.id')
                    ->leftJoin('direcciones_honduras', 'participantes.id', '=', 'direcciones_honduras.participante_id')
                    ->leftJoin('ciudades', 'participantes.ciudad_id', '=', 'ciudades.id')
                    ->leftJoin('departamentos', 'ciudades.departamento_id', '=', 'departamentos.id')
                    ->select([
                        'bancarizacion_grupo_participantes.id',
                        'bancarizacion_grupo_participantes.monto',
                        'participantes.id as participante_id',
                        'participantes.primer_nombre',
                        'participantes.segundo_nombre',
                        'participantes.tercer_nombre',
                        'participantes.primer_apellido',
                        'participantes.segundo_apellido',
                        'participantes.tercer_apellido',
                        'participantes.documento_identidad',
                        // 'participantes.nombre_completo',
                        //'participantes.apellido_completo',
                        'participantes.fecha_nacimiento',
                        'participantes.sexo',
                        'participantes.email',
                        'participantes.telefono',
                        'participantes.created_at',
                        'participantes.copia_documento_identidad',
                        'participantes.copia_documento_identidad_reverso',
                        'participantes.parentesco_id',
                        'participantes.primer_nombre_beneficiario',
                        'participantes.segundo_nombre_beneficiario',
                        'participantes.tercer_nombre_beneficiario',
                        'participantes.primer_apellido_beneficiario',
                        'participantes.segundo_apellido_beneficiario',
                        'participantes.tercer_apellido_beneficiario',
                        'direcciones_honduras.colonia',
                        'direcciones_honduras.calle',
                        'direcciones_honduras.sector',
                        'direcciones_honduras.bloque',
                        'direcciones_honduras.casa',
                        'direcciones_honduras.punto_referencia',
                        'ciudades.nombre as ciudad_nombre',
                        'departamentos.nombre as departamento_nombre'
                    ])
                    ->orderBy('bancarizacion_grupo_participantes.id');

                // Process in chunks using cursor for memory efficiency
                $chunkCounter = 0;
                $chunkSize = 100; // Smaller chunk size to reduce memory usage

                $query->chunk($chunkSize, function($chunk) use ($grupoBanco, &$chunkCounter, &$gruposFoldersNames, $originalFilePath) {
                    $copyFilePath = storage_path('app/copied_sample_' . trim($grupoBanco->nombre) . '_PARTE' . $chunkCounter . '.xlsx');
                    copy($originalFilePath, $copyFilePath);

                    $spreadsheet = IOFactory::load($copyFilePath);
                    $sheet = $spreadsheet->getActiveSheet();

                    $this->processExcelChunk($sheet, $chunk, $grupoBanco, $chunkCounter);
                    $this->processS3Files($chunk, $grupoBanco, $chunkCounter);

                    $gruposFoldersNames[] = trim($grupoBanco->nombre) . '_PARTE' . $chunkCounter;
                    $chunkCounter++;

                    // Free memory
                    $spreadsheet->disconnectWorksheets();
                    unset($spreadsheet);
                    gc_collect_cycles();
                });
            }

            return $this->createFinalZip($gruposFoldersNames);

        } finally {
            $this->cleanupTemporaryFiles($gruposFoldersNames);
        }
    }

    private function processExcelChunk($sheet, $chunk, $grupoBanco, $chunkCounter)
    {
        $meses = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril',
            '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto',
            '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
        ];

        $data = [];
        $num = 1;

        foreach ($chunk as $record) {

            $record->nombre_completo = trim(preg_replace('/\s+/', ' ', "{$record->primer_nombre} {$record->segundo_nombre} {$record->tercer_nombre}"));
            $record->apellido_completo = trim(preg_replace('/\s+/', ' ', "{$record->primer_apellido} {$record->segundo_apellido} {$record->tercer_apellido}"));

            $record->beneficiario_nombre_completo = trim(preg_replace('/\s+/', ' ', "{$record->primer_nombre_beneficiario} {$record->segundo_nombre_beneficiario} {$record->tercer_nombre_beneficiario} {$record->primer_apellido_beneficiario} {$record->segundo_apellido_beneficiario} {$record->tercer_apellido_beneficiario}"));

            $departamentoSeleccionado = 'NO_PARAMETRIZADO';
            if ($record->departamento_nombre) {
                $departamentoSeleccionado = $this->departamentosHonduras($record->departamento_nombre);
            }

            $municipioSeleccionado = 'NO_PARAMETRIZADO';
            if ($departamentoSeleccionado != 'NO_PARAMETRIZADO' && $record->ciudad_nombre) {
                $municipioSeleccionado = $this->municipiosByDepartamentoHonduras(
                    $record->departamento_nombre, $record->ciudad_nombre
                );
            }

            $parentesco = $this->getParentescoValue($record->parentesco_id, $record->sexo);
            $fecha_nacimiento = $record->fecha_nacimiento ? new \DateTime($record->fecha_nacimiento) : null;
            $created_at = $record->created_at ? new \DateTime($record->created_at) : null;



            $data[] = [
                $num,
                $record->documento_identidad ? str_replace('-', '', $record->documento_identidad) : '',
                $this->cleanUTF8String(trim($record->nombre_completo)),
                $this->cleanUTF8String(trim($record->apellido_completo)),
                $fecha_nacimiento ? $fecha_nacimiento->format('d') : '',
                $fecha_nacimiento ? strtoupper($meses[$fecha_nacimiento->format('m')]) : '',
                $fecha_nacimiento ? $fecha_nacimiento->format('Y') : '',
                isset($record->sexo) ? ($record->sexo == 2 ? 'MASCULINO' : 'FEMENINO') : '',
                $departamentoSeleccionado,
                $municipioSeleccionado,
                $record->colonia ? $this->cleanUTF8String($record->colonia) : '',
                $record->calle ? $this->cleanUTF8String($record->calle) : '',
                $record->sector ? $this->cleanUTF8String($record->sector) : '',
                $record->bloque ? $this->cleanUTF8String($record->bloque) : '',
                $record->casa ? $this->extractNumericValue($record->casa) : '',
                $record->punto_referencia ? Str::limit($this->cleanUTF8String(trim($record->punto_referencia)), 35) : '',
                $record->telefono ? str_replace('-', '', $record->telefono) : '',
                $record->email ? str_replace('_', '', $this->cleanUTF8String($record->email)) : '',
                'BACHILLER',
                $created_at ? $created_at->format('d') : '',
                $created_at ? strtoupper($meses[$created_at->format('m')]) : '',
                $created_at ? $created_at->format('Y') : '',
                'VOLUNTARIO (A)',
                $this->cleanUTF8String( $record->beneficiario_nombre_completo ?? ''),
                $parentesco,
                ''
            ];

            $num++;
        }

        $row = 2;
        foreach ($data as $item) {
            $col = 'A';
            foreach ($item as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        foreach ($sheet->getColumnIterator('B') as $column) {
            foreach ($column->getCellIterator() as $cell) {
                $cell->getStyle()->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            }
        }

        $writer = IOFactory::createWriter($sheet->getParent(), 'Xlsx');
        $copyFilePath = storage_path('app/copied_sample_' . trim($grupoBanco->nombre) . '_PARTE' . $chunkCounter . '.xlsx');
        $writer->save($copyFilePath);
    }

    private function processS3Files($chunk, $grupoBanco, $chunkCounter)
    {
        $s3TempDir = storage_path('app/s3_downloads/' . trim($grupoBanco->nombre) . '_PARTE' . $chunkCounter . '/');
        if (!file_exists($s3TempDir)) {
            Storage::makeDirectory('s3_downloads/' . trim($grupoBanco->nombre) . '_PARTE' . $chunkCounter);
        }

        $zip1 = new ZipArchive();
        $zipFilePath1 = storage_path('app/s3_files_' . trim($grupoBanco->nombre) . '_PARTE' . $chunkCounter . '.zip');
        $contadorArchivos = 0;

        if ($zip1->open($zipFilePath1, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($chunk as $record) {
                if (empty($record->copia_documento_identidad)) {
                    continue;
                }

                $folderName = strtoupper(trim($record->primer_nombre) . '_' . trim($record->primer_apellido));
                $folderPath = $s3TempDir . $folderName;

                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                try {
                    // Process front image
                    $extension = pathinfo($record->copia_documento_identidad, PATHINFO_EXTENSION);
                    $s3Content = Storage::disk('s3')->get($record->copia_documento_identidad);
                    file_put_contents($folderPath . '/frente.' . $extension, $s3Content);
                    unset($s3Content); // Free memory

                    $zip1->addFile($folderPath . '/frente.' . $extension, $folderName . '/' . $folderName . '_frente.' . $extension);
                    $contadorArchivos++;

                    // Process back image if exists
                    if ($record->copia_documento_identidad_reverso) {
                        $extension_reverso = pathinfo($record->copia_documento_identidad_reverso, PATHINFO_EXTENSION);
                        $s3ContentReverso = Storage::disk('s3')->get($record->copia_documento_identidad_reverso);
                        file_put_contents($folderPath . '/reverso.' . $extension_reverso, $s3ContentReverso);
                        unset($s3ContentReverso); // Free memory

                        $zip1->addFile($folderPath . '/reverso.' . $extension_reverso, $folderName . '/' . $folderName . '_reverso.' . $extension_reverso);
                    }
                } catch (\Exception $e) {
                    // Log error and continue with next record
                    \Log::error("Error processing S3 files for record {$record->participante_id}: " . $e->getMessage());
                    continue;
                }

                // Free memory
                gc_collect_cycles();
            }
            $zip1->close();
        }

        if ($contadorArchivos > 0) {
            $zipFilePath2 = storage_path('app/final_package_' . trim($grupoBanco->nombre) . '_PARTE' . $chunkCounter . '.zip');
            $zip2 = new ZipArchive();
            if ($zip2->open($zipFilePath2, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $zip2->addFile(
                    storage_path('app/copied_sample_' . trim($grupoBanco->nombre) . '_PARTE' . $chunkCounter . '.xlsx'),
                    'grupo' . trim($grupoBanco->nombre) . '_PARTE' . $chunkCounter . '.xlsx'
                );
                $zip2->addFile($zipFilePath1, 's3_files.zip');
                $zip2->close();
            }
        }
    }

    private function createFinalZip($gruposFoldersNames)
    {
        $zipBancarizacionPath = storage_path('app/bancarizacion.zip');
        $zip3 = new ZipArchive();
        if ($zip3->open($zipBancarizacionPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($gruposFoldersNames as $item) {
                $finalPackagePath = storage_path('app/final_package_' . $item . '.zip');
                if (file_exists($finalPackagePath)) {
                    $zip3->addFile($finalPackagePath, $item . '.zip');
                }
            }
            $zip3->close();
        }

        return response()->download($zipBancarizacionPath)->deleteFileAfterSend(true);
    }

    private function cleanupTemporaryFiles($gruposFoldersNames)
    {
        foreach ($gruposFoldersNames as $item) {
            if (file_exists(storage_path('app/final_package_' . $item . '.zip'))) {
                unlink(storage_path('app/final_package_' . $item . '.zip'));
            }
            if (file_exists(storage_path('app/copied_sample_' . $item . '.xlsx'))) {
                unlink(storage_path('app/copied_sample_' . $item . '.xlsx'));
            }
            if (file_exists(storage_path('app/s3_files_' . $item . '.zip'))) {
                unlink(storage_path('app/s3_files_' . $item . '.zip'));
            }
            Storage::deleteDirectory('s3_downloads/' . $item);
        }
    }

    private function getParentescoValue($parentesco_id, $sexo)
    {
        switch ($parentesco_id) {
            case 1:
            case 2:
                return '4 Padre / Madre';
            case 3:
                return '16 Hermano(a)';
            case 4:
                return '7 Abuelo(a)';
            case 5:
                return ($sexo == 2) ? '31 Esposa' : '9 Esposo';
            default:
                return '6 Tio(a)';
        }
    }

    private function formatString($name)
    {
        $name = str_replace('ñ', '#', $name);
        $name = Str::ascii($name);
        $name = strtoupper($name);
        return $name;
    }

    public function cleanUTF8String($string) {
        //$normalized = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $normalized = transliterator_transliterate("Any-Latin; Latin-ASCII", $string);
        return strtoupper($normalized);
    }

    protected function departamentosHonduras($departamento)
    {
        $departamento = $this->cleanUTF8String($departamento);

        $departamento = str_replace(' ', '_', $departamento);


        $departamentos = [
            'ATLANTIDA',
            'COLON',
            'COMAYAGUA',
            'COPAN',
            'CORTES',
            'CHOLUTECA',
            'EL_PARAISO',
            'FRANCISCO_MORAZAN',
            'GRACIAS_A_DIOS',
            'INTIBUCA',
            'ISLAS_DE_LA_BAHIA',
            'LA_PAZ',
            'LEMPIRA',
            'OCOTEPEQUE',
            'OLANCHO',
            'SANTA_BARBARA',
            'VALLE',
            'YORO'
        ];

        if (!in_array($departamento, $departamentos)) {
            return 'NO_PARAMETRIZADO';
        }

        return $departamento;
    }

    protected function municipiosByDepartamentoHonduras($departamento, $municipio)
    {

        $departamento = $this->cleanUTF8String($departamento);

        $departamento = str_replace(' ', '_', $departamento);

        $municipio = $this->cleanUTF8String($municipio);


        $municipios = [
            'ATLANTIDA' => [
                'LA CEIBA',
                'EL PORVENIR',
                'ESPARTA',
                'JUTIAPA',
                'LA MASICA',
                'SAN FRANCISCO',
                'TELA',
                'ARIZONA',
            ],
            'COLON' => [
                'TRUJILLO',
                'BALFATE',
                'IRIONA',
                'LIMON',
                'SABA',
                'SANTA FE',
                'SANTA ROSA DE AGUAN',
                'SONAGUERA',
                'TOCOA',
                'BONITO ORIENTAL',
            ],
            'COMAYAGUA' => [
                'COMAYAGUA',
                'AJUTERIQUE',
                'EL ROSARIO',
                'ESQUIAS',
                'HUMUYA',
                'LA LIBERTAD',
                'LAMANI',
                'LA TRINIDAD',
                'LEJAMANI',
                'MEAMBAR',
                'MINAS DE ORO',
                'OJOS DE AGUA',
                'SAN JERONIMO',
                'SAN JOSE DE COMAYAGUA',
                'SAN JOSE DEL POTRERO',
                'SAN LUIS',
                'SAN SEBASTIAN',
                'SIGUATEPEQUE',
                'VILLA DE SAN ANTONIO',
                'LAS LAJAS',
                'TAULABE',
            ],
            'COPAN' => [
                'SANTA ROSA DE COPAN',
                'CABANAS',
                'CONCEPCION',
                'COPAN RUINAS',
                'CORQUIN',
                'CUCUYAGUA',
                'DOLORES',
                'DULCE NOMBRE',
                'EL PARAISO',
                'FLORIDA',
                'LA JIGUA',
                'LA UNION',
                'NUEVA ARCADIA',
                'SAN AGUSTIN',
                'SAN ANTONIO',
                'SAN JERONIMO',
                'SAN JOSE',
                'SAN JUAN DE OPOA',
                'SAN NICOLAS',
                'SAN PEDRO DE COPAN',
                'SANTA RITA',
                'TRINIDAD DE COPAN',
                'VERACRUZ',
            ],
            'CORTES' => [
                'SAN PEDRO SULA',
                'CHOLOMA',
                'OMOA',
                'PIMIENTA',
                'POTRERILLOS',
                'PUERTO CORTES',
                'SAN ANTONIO DE CORTES',
                'SAN FRANCISCO DE YOJOA',
                'SAN MANUEL',
                'SANTA CRUZ DE YOJOA',
                'VILLANUEVA',
                'LA LIMA',
            ],
            'CHOLUTECA' => [
                'CHOLUTECA',
                'APACILAGUA',
                'CONCEPCION DE MARIA',
                'DUYURE',
                'EL CORPUS',
                'EL TRIUNFO',
                'MARCOVIA',
                'MOROLICA',
                'NAMASIGUE',
                'OROCUINA',
                'PESPIRE',
                'SAN ANTONIO DE FLORES',
                'SAN ISIDRO',
                'SAN JOSE',
                'SAN MARCOS DE COLON',
                'SANTA ANA DE YUSGUARE',
            ],
            'EL_PARAISO' => [
                'YUSCARAN',
                'ALAUCA',
                'DANLI',
                'EL PARAISO',
                'GUINOPE',
                'JACALEAPA',
                'LIURE',
                'MOROCELI',
                'OROPOLI',
                'POTRERILLOS',
                'SAN ANTONIO DE FLORES',
                'SAN LUCAS',
                'SAN MATIAS',
                'SOLEDAD',
                'TEUPASANTI',
                'TEXIGUAT',
                'VADO ANCHO',
                'YAUYUPE',
                'TROJES',
            ],
            'FRANCISCO_MORAZAN' => [
                'DISTRITO CENTRAL',
                'ALUBAREN',
                'CEDROS',
                'CURAREN',
                'EL PORVENIR',
                'GUAIMACA',
                'LA LIBERTAD',
                'LA VENTA',
                'LEPATERIQUE',
                'MARAITA',
                'MARALE',
                'NUEVA ARMENIA',
                'OJOJONA',
                'ORICA',
                'REITOCA',
                'SABANAGRANDE',
                'SAN ANTONIO DE ORIENTE',
                'SAN BUENAVENTURA',
                'SAN IGNACIO',
                'SAN JUAN DE FLORES',
                'SAN MIGUELITO',
                'SANTA ANA',
                'SANTA LUCIA',
                'TALANGA',
                'TATUMBLA',
                'VALLE DE ANGELES',
                'VILLA DE SAN FRANCISCO',
                'VALLECILLO',
            ],
            'GRACIAS_A_DIOS' => [
                'PUERTO LEMPIRA',
                'BRUS LAGUNA',
                'AHUAS',
                'JUAN FRANCISCO BULNES',
                'VILLEDA MORALES',
                'WAMPUSIRPE',
            ],
            'INTIBUCA' => [
                'LA ESPERANZA',
                'CAMASCA',
                'COLOMONCAGUA',
                'CONCEPCION',
                'DOLORES',
                'INTIBUCA',
                'JESUS DE OTORO',
                'MAGDALENA',
                'MASAGUARA',
                'SAN ANTONIO',
                'SAN ISIDRO',
                'SAN JUAN',
                'SAN MARCOS DE LA SIERRA',
                'SAN MIGUELITO',
                'SANTA LUCIA',
                'YAMARANGUILA',
                'SAN FRANCISCO DE OPALACA',
            ],
            'ISLAS_DE_LA_BAHIA' => [
                'ROATAN',
                'GUANAJA',
                'JOSE SANTOS GUARDIOLA',
                'UTILA',
            ],
            'LA_PAZ' => [
                'LA PAZ',
                'AGUANQUETERIQUE',
                'CABANAS',
                'CANE',
                'CHINACLA',
                'GUAJIQUIRO',
                'LAUTERIQUE',
                'MARCALA',
                'MERCEDES DE ORIENTE',
                'OPATORO',
                'SAN ANTONIO DEL NORTE',
                'SAN JOSE',
                'SAN JUAN',
                'SAN PEDRO DE TUTULE',
                'SANTA ANA',
                'SANTA ELENA',
                'SANTA MARIA',
                'SANTIAGO DE PURINGLA',
                'YARULA',
            ],
            'LEMPIRA' => [
                'GRACIAS',
                'BELEN',
                'CANDELARIA',
                'COLOLACA',
                'ERANDIQUE',
                'GUALCINCE',
                'GUARITA',
                'LA CAMPA',
                'LA IGUALA',
                'LAS FLORES',
                'LA UNION',
                'LA VIRTUD',
                'LEPAERA',
                'MAPULACA',
                'PIRAERA',
                'SAN ANDRES',
                'SAN FRANCISCO',
                'SAN JUAN GUARITA',
                'SAN MANUEL COLOHETE',
                'SAN RAFAEL',
                'SAN SEBASTIAN',
                'SANTA CRUZ',
                'TALGUA',
                'TAMBLA',
                'TOMALA',
                'VALLADOLID',
                'VIRGINIA',
                'SAN MARCOS DE CAIQUIN',
            ],
            'OCOTEPEQUE' => [
                'OCOTEPEQUE',
                'BELEN GUALCHO',
                'CONCEPCION',
                'DOLORES MERENDON',
                'FRATERNIDAD',
                'LA ENCARNACION',
                'LA LABOR',
                'LUCERNA',
                'MERCEDES',
                'SAN FERNANDO',
                'SAN FRANCISCO DEL VALLE',
                'SAN JORGE',
                'SAN MARCOS',
                'SANTA FE',
                'SENSENTI',
                'SINUAPA',
            ],
            'OLANCHO' => [
                'JUTICALPA',
                'CAMPAMENTO',
                'CATACAMAS',
                'CONCORDIA',
                'DULCE NOMBRE DE CULMI',
                'EL ROSARIO',
                'ESQUIPULAS DEL NORTE',
                'GUALACO',
                'GUARIZAMA',
                'GUATA',
                'GUAYAPE',
                'JANO',
                'LA UNION',
                'MANGULILE',
                'MANTO',
                'SALAMA',
                'SAN ESTEBAN',
                'SAN FRANCISCO DE BECERRA',
                'SAN FRANCISCO DE LA PAZ',
                'SANTA MARIA DEL REAL',
                'SILCA',
                'YOCON',
                'PATUCA',
            ],
            'SANTA_BARBARA' => [
                'SANTA BARBARA',
                'ARADA',
                'ATIMA',
                'AZACUALPA',
                'CEGUACA',
                'CONCEPCION DEL NORTE',
                'CONCEPCION DEL SUR',
                'CHINDA',
                'EL NISPERO',
                'GUALALA',
                'ILAMA',
                'MACUELIZO',
                'NARANJITO',
                'NUEVO CELILAC',
                'PETOA',
                'PROTECCION',
                'QUIMISTAN',
                'SAN FRANCISCO DE OJUERA',
                'SAN JOSE DE COLINAS',
                'SAN LUIS',
                'SAN MARCOS',
                'SAN NICOLAS',
                'SAN PEDRO ZACAPA',
                'SAN VICENTE CENTENARIO',
                'SANTA RITA',
                'TRINIDAD',
                'LAS VEGAS',
                'NUEVA FRONTERA',
            ],
            'VALLE' => [
                'NACAOME',
                'ALIANZA',
                'AMAPALA',
                'ARAMECINA',
                'CARIDAD',
                'GOASCORAN',
                'LANGUE',
                'SAN FRANCISCO DE CORAY',
                'SAN LORENZO',
            ],
            'YORO' => [
                'YORO',
                'ARENAL',
                'EL NEGRITO',
                'EL PROGRESO',
                'JOCON',
                'MORAZAN',
                'OLANCHITO',
                'SANTA RITA',
                'SULACO',
                'VICTORIA',
                'YORITO',
            ],
        ];

        if (!array_key_exists($departamento, $municipios) || !in_array($municipio, $municipios[$departamento])) {
            return 'NO_PARAMETRIZADO';
        }

        return $municipio;
    }

    public function extractNumericValue($string)
    {
        // preg_match('/\d+/', $string, $matches);
        // return $matches ? $matches[0] : '';
        //return preg_match('/\d+/', $string);
        //return preg_match('/\D/', $string);
        return preg_replace("/\D/", "", $string);
    }

    private function cleanBeneficiarioName($record)
    {
        $nombre = preg_replace('/\s+/', ' ', "{$record->participante->primer_nombre_beneficiario} {$record->participante->segundo_nombre_beneficiario} {$record->participante->tercer_nombre_beneficiario}");

        return $this->cleanUTF8String(trim($nombre));
    }

}
