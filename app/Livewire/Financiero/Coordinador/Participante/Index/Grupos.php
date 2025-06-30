<?php

namespace App\Livewire\Financiero\Coordinador\Participante\Index;

use App\Exports\bancarizacion\coordinador\ParticipantesGrupoExport;
use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PaisProyecto;
use Livewire\Attributes\Reactive;
use App\Models\BancarizacionGrupo;
use App\Models\CohortePaisProyecto;
use Livewire\Attributes\Renderless;
use App\Models\BancarizacionGrupoParticipante;

class Grupos extends Component
{

    use GrupoTrait, CoordinadorTrait;

    public $cohortePaisProyecto;

    public $paisProyecto;

    public $grupos = [];

    public $selectedGrupoView;

    public $selectedParticipanteIds = [];

    public $openDrawerView = false;

    public $searchTerm = '';

    public $allparticipantes;

    public $deleteGrupoIndicator;

    public $nombre;

    public $descripcion;

    #[On('updateSelectedCohortePaisProyecto')]
    public function mount($cohortePaisProyecto = null, $paisProyecto = null)
    {

        $this->cohortePaisProyecto = CohortePaisProyecto::with(['cohorte'])->find($cohortePaisProyecto);

        $this->paisProyecto = PaisProyecto::with(['pais:id,nombre', 'proyecto:id,nombre'])->find($paisProyecto);
    }

    #[On('update-financierons-grupos-cards')]
    public function render()
    {
        if ($this->cohortePaisProyecto) {

            $this->grupos = BancarizacionGrupo::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->withCount(['participantes' => function ($query) {
                    $query->where('bancarizacion_grupo_participantes.active_at', '!=', null)
                        ->where('bancarizacion_grupo_participantes.deleted_at', null);
                }])
                ->where('created_by', auth()->user()->id)
                ->get(['id', 'nombre', 'participantes_count', 'monto'])
                ->map(function ($grupo) {
                    return [
                        'id' => $grupo->id,
                        'nombre' => $grupo->nombre,
                        'participantes' => $grupo->participantes_count,
                    ];
                });
        }


        return view('livewire.financiero.coordinador.participante.index.grupos', [
            'grupos' => $this->grupos,
            'paisProyecto' => $this->paisProyecto,
        ]);
    }



    #[Renderless]
    public function exportParticipantes($grupo)
    {
        return (new ParticipantesGrupoExport($grupo))->download('participantes.xlsx');


        $this->selectedParticipanteIds = BancarizacionGrupoParticipante::where('bancarizacion_grupo_id', $grupo)
            ->pluck('participante_id')
            ->toArray();


        $participantes = \App\Models\Participante::whereIn('id', $this->selectedParticipanteIds)
            ->get(['primer_nombre', 'segundo_nombre', 'tercer_nombre', 'primer_apellido', 'segundo_apellido', 'tercer_apellido', 'documento_identidad']);

        $data = $participantes->map(function ($participante) {
            $fullName = trim("{$participante->primer_nombre} {$participante->segundo_nombre} {$participante->tercer_nombre} {$participante->primer_apellido} {$participante->segundo_apellido} {$participante->tercer_apellido}");
            return [
                'full_name' => $fullName,
                'documento_identidad' => $participante->documento_identidad,
            ];
        });

        if ($this->paisProyecto->pais_id == 1) {
            $filename = 'participantes.csv';
            $handle = fopen($filename, 'w');
            fputcsv($handle, ['full_name', 'documento_identidad']);
            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        } else {
            $filename = 'participantes.txt';
            $handle = fopen($filename, 'w');
            foreach ($data as $row) {
                fwrite($handle, implode("\t", $row) . PHP_EOL);
            }
            fclose($handle);
        }

        return response()->download($filename)->deleteFileAfterSend(true);
    }



}
