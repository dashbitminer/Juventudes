<?php

namespace App\Livewire\Financiero\Admin\Participante\Cuentas;

use App\Models\CohorteParticipanteProyecto;
use Livewire\Component;
use App\Models\Participante;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Page extends Component
{
    use WithFileUploads;

    public $excelFile;
    public $participantes = [];
    public $processedData = [];
    public $errorMessages = [];
    public $processingComplete = false;
    public $isProcessing = false;

    protected $rules = [
        'excelFile' => 'required|file|mimes:xlsx,xls|max:10240',
        'processedData.*.cuenta_bancaria' => 'nullable|string|max:50',
    ];

    protected $messages = [
        'excelFile.required' => 'Debe seleccionar un archivo Excel.',
        'excelFile.mimes' => 'El archivo debe ser Excel (xlsx o xls).',
        'excelFile.max' => 'El archivo no debe exceder 10MB.',
    ];

    public function updatedExcelFile()
    {
        $this->validate([
            'excelFile' => 'file|mimes:xlsx,xls|max:10240',
        ]);
    }

    public function processFile()
    {
        $this->validate();
        $this->isProcessing = true;
        $this->processingComplete = false;
        $this->processedData = [];
        $this->errorMessages = [];

        try {
            // Increase memory limit for processing large Excel files
            ini_set('memory_limit', '512M');

            $path = $this->excelFile->getRealPath();
            $spreadsheet = IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();

            $rows = [];
            foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                if ($rowIndex === 1) continue; // Skip header row

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];
                $colIndex = 0;
                foreach ($cellIterator as $cell) {
                    if ($colIndex < 2) { // We only need the first two columns
                        $rowData[] = $cell->getValue();
                    }
                    $colIndex++;
                }

                if (!empty($rowData[0])) { // Skip empty rows
                    $rows[] = [
                        'documento_identidad' => trim($rowData[0] ?? ''),
                        'cuenta_bancaria' => trim($rowData[1] ?? '')
                    ];
                }
            }

            $this->processExcelData($rows);

        } catch (\Exception $e) {
            $this->errorMessages[] = 'Error al procesar el archivo: ' . $e->getMessage();
        }

        $this->isProcessing = false;
        $this->processingComplete = true;
    }

    protected function processExcelData($rows)
    {
        $processed = [];
        $notFound = [];

        $proyectos = \App\Models\CohorteProyectoUser::with([
            "cohortePaisProyecto.paisProyecto"
            ])
            ->whereHas('cohortePaisProyecto', function ($query) {
                $query->whereNotNull('active_at');
            })
            ->where("user_id", auth()->id())
            ->get();

            $paisIds = $proyectos->pluck('cohortePaisProyecto.paisProyecto')->unique('pais_id')->map(function ($paisProyecto) {
                return $paisProyecto->pais_id;
            })->toArray();

            $proyectoIds = $proyectos->pluck('cohortePaisProyecto.paisProyecto')->unique('proyecto_id')->map(function ($paisProyecto) {
                return $paisProyecto->proyecto_id;
            })->toArray();

           // dd($proyectos);



        $colores = [
            'bg-yellow-600 text-yellow-800',
            'bg-red-600 text-red-800',
            'bg-pink-600 text-pink-800',
            'bg-indigo-600 text-indigo-800',
            'bg-green-600 text-green-800',
            'bg-blue-600 text-blue-800',
        ];

        $index = 0;
        $aux = [];
        foreach ($rows as $index => $row) {
            if (empty($row['documento_identidad'])) {
                continue;
            }

            // Clean documento_identidad to remove any special characters or spaces
            $documentoIdentidad = preg_replace('/[^0-9a-zA-Z]/', '', $row['documento_identidad']);

            // Try to find participant by documento_identidad
            $participante = Participante::whereHas('cohorteParticipanteProyecto.cohortePaisProyecto.paisProyecto', function ($query) use($paisIds, $proyectoIds) {
                    $query->whereIn('pais_proyecto.pais_id', $paisIds)
                        ->whereIn('pais_proyecto.proyecto_id', $proyectoIds);
                })
                ->with('cohorteParticipanteProyecto.cohortePaisProyecto.cohorte')
                ->whereRaw("REPLACE(REPLACE(REPLACE(documento_identidad, '-', ''), ' ', ''), '.', '') = ?", [$documentoIdentidad])
                ->with('cohorteParticipanteProyecto')
                ->first();

            if ($participante) {

                $processed[] = [
                    'id' => $participante->id,
                    'documento_identidad' => $participante->documento_identidad,
                    'nombre' => $participante->full_name,
                    'cuenta_bancaria_actual' => $participante->cohorteParticipanteProyecto[0]->numero_cuenta ?? '',
                    'cuenta_bancaria' => $row['cuenta_bancaria'] ?? '',
                    'cohorte' => $participante->cohorteParticipanteProyecto[0]->cohortePaisProyecto->cohorte->nombre ?? '',
                    'encontrado' => true,
                    'color' => in_array($participante->cohorteParticipanteProyecto[0]->cohortePaisProyecto->cohorte->nombre, $aux) ? $colores[array_search($participante->cohorteParticipanteProyecto[0]->cohortePaisProyecto->cohorte->nombre, $aux)] : $colores[$index],
                ];

                if (!in_array($participante->cohorteParticipanteProyecto[0]->cohortePaisProyecto->cohorte->nombre, $aux)) {
                    $aux[] = $participante->cohorteParticipanteProyecto[0]->cohortePaisProyecto->cohorte->nombre;
                    $index++;
                }

              //  dd($processed);
            } else {
                $notFound[] = [
                    'id' => null,
                    'documento_identidad' => $row['documento_identidad'],
                    'cuenta_bancaria' => $row['cuenta_bancaria'] ?? '',
                    'encontrado' => false,
                ];
            }
        }

       // dd($processed);

        // Combine found and not found records, but put found ones first
        $this->processedData = array_merge($processed, $notFound);

        if (count($notFound) > 0) {
            $this->errorMessages[] = 'No se encontraron ' . count($notFound) . ' participantes. Revise los datos marcados en rojo.';
        }
    }

    public function saveAccounts()
    {
        $updated = 0;
        $errors = 0;

        $participanteIds = array_column(array_filter($this->processedData, fn($data) => $data['encontrado'] && !empty($data['id'])), 'id');
        $participantes = Participante::with('cohorteParticipanteProyecto')->whereIn('id', $participanteIds)->get()->keyBy('id');

        foreach ($this->processedData as $data) {
            if (!$data['encontrado'] || empty($data['id'])) {
                continue;
            }

            try {
                $participante = $participantes->get($data['id']);
                if ($participante) {
                    \DB::transaction(function () use ($participante, $data, &$updated, &$errors) {
                        $updatedRows = CohorteParticipanteProyecto::where('participante_id', $participante->id)->update(['numero_cuenta' => $data['cuenta_bancaria'], 'updated_by' => auth()->id()]);
                        if ($updatedRows > 0) {
                            $updated++;
                        } else {
                            $errors++;
                        }
                    });
                }
            } catch (\Exception $e) {
                \Log::error('Error updating participant account: ' . $e->getMessage());
                $errors++;
            }
        }

        session()->flash('message', "Se actualizaron {$updated} cuentas bancarias. Errores: {$errors}");
        $this->reset(['excelFile', 'processedData', 'processingComplete']);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.financiero.admin.participante.cuentas.page')->layoutData([
            'financiero' => true,
        ]);
    }
}
