<?php

namespace App\Livewire\Financiero\Admin\Participante\Index;

use ZipArchive;
use App\Models\Pais;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\PaisProyecto;
use App\Models\Participante;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use App\Models\BancarizacionGrupo;
use App\Models\CohortePaisProyecto;
use Livewire\Attributes\Renderless;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Financiero\Admin\Participante\Index\Filters;
use App\Exports\bancarizacion\financiero\ParticipantesGrupoExport;
use App\Services\ExportService;

class Table extends Component
{

    use WithPagination, Searchable, Sortable, GrupoTrait;

    #[Reactive]
    public Filters $filters;

    #[Validate('required', message: 'Seleccione uno o más participantes de la lista principal')]
    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $lista = [];

    public $cohortePaisProyecto;

    public $paisProyecto;

    public $perPage = 10;

    public $openDrawer = false;

    public $modo;

    public $showSuccessIndicator = false;

    public $selectedPais;

    public $pais;

    public $openEditDrawer = false;

    #[Validate('numeric', message: 'El campo monto es requerido y debe ser un número válido.')]
    #[Validate('required', message: 'El campo monto es requerido y debe ser un número válido.')]
    public $monto;

    public $sobreescribir;

    protected $exportService;

    public function __construct()
    {
        $this->exportService = new ExportService();
    }


    #[Renderless]
    public function export()
    {

        set_time_limit(0);

        if ($this->paisProyecto->pais_id == Pais::GUATEMALA) {
            $result = $this->exportService->exportGuatemala($this->selectedParticipanteIds);
        } elseif ($this->paisProyecto->pais_id == Pais::HONDURAS) {
            $result = $this->exportService->exportHonduras($this->selectedParticipanteIds);
        } else {
            $result = '';
        }

        $this->selectedParticipanteIds = [];
        return $result;
    }


    public function exportarUnGrupo($grupoId)
    {
        set_time_limit(0);

        $this->selectedParticipanteIds = [$grupoId];

        if ($this->paisProyecto->pais_id == Pais::GUATEMALA) {
            $result = $this->exportService->exportGuatemala($this->selectedParticipanteIds);
        } elseif ($this->paisProyecto->pais_id == Pais::HONDURAS) {
            $result = $this->exportService->exportHonduras($this->selectedParticipanteIds);
        } else {
            $result = '';
        }

        $this->selectedParticipanteIds = [];

        return $result;
    }


    #[Renderless]
    public function export2()
    {
        $zipFileName = 'files.zip';
        $zipPath = storage_path($zipFileName);

        $zip = new ZipArchive;

        $fileNames = [];
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($this->selectedParticipanteIds as $grupo) {

                $grupoDetalle = BancarizacionGrupo::find($grupo);
                $filename = $grupoDetalle->id . '.xlsx';
                $fileNames[] = $filename;

                $excelFilePath = storage_path('app/' . $filename);
                Excel::store(new ParticipantesGrupoExport($grupoDetalle), $filename, 'local');
                $zip->addFile($excelFilePath, $filename);
            }

            $zip->close();
        }


        // Clean up Excel files
        foreach ($fileNames as $item) {
            Storage::delete($item);
        }

        // Return ZIP for download
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }


    #[Renderless]
    public function exportGuateTxt()
    {
        $zipFileName = 'filesGuatemala.zip';
        $zipPath = storage_path($zipFileName);

        $zip = new ZipArchive;

        $data[0] = [
            'NOMBRE',
            'APE1',
            'APE2',
            'APE3',
            'FE_NAC',
            'SEXO',
            'EST_CIVIL',
            'NACIONAL1',
            'PROF',
            'CED',
            'DEP_ID',
            'MUNI_ID',
            'DPI',
            'NIT',
            'PASS',
            'PAIS_PAS',
            'DIR',
            'CASA',
            'ZONA',
            'COL',
            'MUN_RES',
            'DEP_RES',
            'TEL',
            'CELULAR',
            'MAIL',
            'F_PEP',
            'P_PAREN',
            'P_ASOC',
            'INGRESOS',
            'MONEDA_2',
            'Monto_Egresos',
            'Nombre_puesto_de_trabajo',
            'COD_EMP',
            'NIVEL',
            'CIA_CEL',
            'AGE_INI',
            'APE1_BEN',
            'APE2_BEN',
            'APE3_BEN',
            'NOM_BEN',
            'PAR_BEN',
            'POR_BEN',
            'COND_MIGR',
            'Otra__Espcifí­que',
            'MONEDA',
            'NACIONAL2',
            'TIP_DOC',
            'LUG_NAC',
            'LUG_NAC_MUNI',
            'NAC_USA',
            'RES_USA',
            'IMPU_USA',
            'POS_USA',
            'TEL_USA',
            'TRA_USA',
            'POD_USA',
            'FLAG_BIMOV',
            'FLAG_CPE',
            'BANCA',
            'COPORATIVO',
            'CLUB_BI',
            'CERO_RIESGO',
            'AHORRO_NOMINA',
            'DIA_DE_DEBITO',
            'PDI',
            'PFP',
            'MONTO_INVER_INI',
            'PERIODICIDAD_AH',
            'MONTO_APORTE',
            'MONEDA_APORTE',
            'SEGURO_DE_VIDA',
            'SUELDO_ASEGURADO',
            'FUNERARIO_PLUS',
            'PREGUNTA_2_FUNPLUS',
            'PREGUNTA_1_FUNPLUS',
            'NOM_EMP_2',
            'TIPO_EMPRESA'
        ];

        $fileNames = [];
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {

            foreach ($this->selectedParticipanteIds as $grupo) {


                $grupoDetalle = \App\Models\BancarizacionGrupoParticipante::where('bancarizacion_grupo_id', $grupo)
                    ->whereNotNull('active_at')
                    ->with('participante', 'participante.direccionGuatemala.ciudad.departamento', 'participante.ciudad', 'participante.ciudad.departamento', 'bancarizacionGrupo.user', 'creator')
                    ->get();

                foreach ($grupoDetalle as $record) {
                    $data[] = [
                        $this->formatString(trim($record->participante->nombre_completo)),
                        $this->formatString($record->participante->primer_apellido),
                        isset($record->participante->segundo_apellido) ? $this->formatString($record->participante->segundo_apellido) : 0,
                        isset($record->participante->tercer_apellido) ? $this->formatString($record->participante->tercer_apellido) : 0,
                        isset($record->participante->fecha_nacimiento) ? $record->participante->fecha_nacimiento->format('d/m/Y') : '',
                        isset($record->participante->sexo) ? ($record->participante->sexo == 2 ? 'M' : 'F') : '',
                        isset($record->participante->estado_civil) ? $record->participante->estado_civil : '',
                        isset($record->participante->nacionalidad) ? 'GUATEMALTECA' : '',
                        'ESTUDIANTE',
                        '0',
                        '0',
                        '0',
                        isset($record->participante->documento_identidad) ? $record->participante->documento_identidad : '',
                        '0',
                        '0',
                        '0',
                        isset($record->participante->direccionGuatemala->direccion) ? $this->formatString($record->participante->direccionGuatemala->direccion) : '',
                        isset($record->participante->direccionGuatemala->casa) ? $this->formatString($record->participante->direccionGuatemala->casa) : '0',
                        isset($record->participante->direccionGuatemala->apartamento) ? $this->formatString($record->participante->direccionGuatemala->apartamento) : '0',
                        isset($record->participante->direccionGuatemala->zona) ? $this->formatString($record->participante->direccionGuatemala->zona) : '0',
                        isset($record->participante->direccionGuatemala->colonia) ? $this->formatString($record->participante->direccionGuatemala->colonia) : '0',
                        isset($record->participante->direccionGuatemala->ciudad->nombre) ? $this->formatString($record->participante->direccionGuatemala->ciudad->nombre) : '0',
                        isset($record->participante->direccionGuatemala->ciudad->departamento->nombre) ? $this->formatString($record->participante->direccionGuatemala->ciudad->departamento->nombre) : '',
                        '0',
                        isset($record->participante->telefono) ? $record->participante->telefono : '',
                        isset($record->participante->email) ? Str::upper($record->participante->email) : '0',
                        '0',
                        '0',
                        '0',
                        isset($record->participante->ingresos) ? $record->participante->ingresos : '0',
                        'QUETZALES',
                        isset($record->participante->monto_egresos) ? $record->participante->monto_egresos : '',
                        'PARTICIPANTE',
                        '0',
                        '0',
                        '0',
                        '0',
                        isset($record->participante->primer_apellido_beneficiario) ? $this->formatString($record->participante->primer_apellido_beneficiario) : '0',
                        isset($record->participante->segundo_apellido_beneficiario) ? $this->formatString($record->participante->segundo_apellido_beneficiario) : '0',
                        isset($record->participante->tercer_apellido_beneficiario) ? $this->formatString($record->participante->tercer_apellido_beneficiario) : '0',
                        $this->formatString(trim($record->participante->primer_apellido_beneficiario . ' ' . $record->participante->segundo_apellido_beneficiario . ' ' . $record->participante->tercer_apellido_beneficiario)),
                        isset($record->participante->parentesco_beneficiario) ? $this->formatString($record->participante->parentesco_beneficiario) : '',
                        '100%',
                        '0',
                        '0',
                        '0',
                        '0',
                        '1',

                        isset($record->participante->lugar_nacimiento) ? $record->participante->lugar_nacimiento : '',
                        isset($record->participante->lugar_nacimiento_municipio) ? $record->participante->lugar_nacimiento_municipio : '',

                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        '0',
                        'CENTRO ECUMENICO DE INTEGRACION PASTORAL',
                        'PRIVADA'
                    ];
                }

                $filename = $grupoDetalle->first()->bancarizacionGrupo->nombre . '.txt';

                $fileNames[] = $filename;

                $txtFilePath = storage_path('app/' . $filename);
                $txtFile = fopen($txtFilePath, 'w');
                foreach ($data as $row) {
                    fputcsv($txtFile, $row, "\t");
                }
                fclose($txtFile);

                $zip->addFile($txtFilePath, $filename);
                // unlink($txtFilePath);

                // Keep headers and reset data array
                //$data = [$data[0]];
            }

            $zip->close();
        }


        // Clean up Excel files
        foreach ($fileNames as $item) {
            Storage::delete($item);
        }

        // Return ZIP for download
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }


    #[On('updateSelectedCohortePaisProyecto')]
    public function mount($cohortePaisProyecto = null, $paisProyecto = null, $selectedPais = null)
    {
        $this->cohortePaisProyecto = CohortePaisProyecto::with(['cohorte'])->find($cohortePaisProyecto);

        $this->paisProyecto = PaisProyecto::with(['pais:id,nombre', 'proyecto:id,nombre'])->find($paisProyecto);

        $this->pais = Pais::find($selectedPais);
    }


    public function render()
    {
        if ($this->cohortePaisProyecto) {

            $query = BancarizacionGrupo::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->with('user:id,name,socio_implementador_id', 'user.socioImplementador:id,nombre', 'creator:id,name')
                ->withCount(['participantes' => function ($query) {
                    $query->whereNull('bancarizacion_grupo_participantes.deleted_at');
                }]);


            $query = $this->applySearch($query);

            $query = $this->applySorting($query);

            // $query = $this->filters->apply($query);

            $grupos = $query->paginate($this->perPage);

        } else {
            $grupos = BancarizacionGrupo::where("created_by", -1)->paginate($this->perPage);
        }

        $this->participanteIdsOnPage = $grupos->map(fn($grupo) => (string) $grupo->id)->toArray();

        return view('livewire.financiero.admin.participante.index.table', [
            'grupos' => $grupos,
        ]);
    }

    #[On('preview-financiero-selected-group')]
    public function previewSelected()
    {

        $this->modo = "crear";

        $this->addList();

        $this->openDrawer = true;
    }

    public function editarSelected()
    {

        // $this->modo = "editar";

        $this->addList();

        $this->openEditDrawer = true;
    }

    public function editarUnGrupo($grupoId)
    {

        $this->selectedParticipanteIds = [$grupoId];

        $this->addList();

        $this->openEditDrawer = true;
    }





    public function formatString($name)
    {
        // Replace "ñ" with "#"
        $name = str_replace('ñ', '#', $name);

        // Remove tildes (accents) from the string
        $name = Str::ascii($name);

        // Convert to uppercase
        $name = strtoupper($name);

        return $name;
    }
}
