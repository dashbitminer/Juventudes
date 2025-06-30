<?php

namespace App\Livewire\Financiero\Admin\Participante\Index;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PaisProyecto;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use App\Models\CohortePaisProyecto;
use App\Models\BancarizacionGrupoParticipante;

class Participantes extends Component
{
    use WithPagination, Searchable, Sortable, GrupoTrait;

    #[Reactive]
    public Filters $filters;

    public $cohortePaisProyecto;

    public $paisProyecto;

    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $search = "";

    public $perPage = 10;

    public $openEditDrawer = false;

    public $lista = [];


    #[Validate('numeric', message: 'El campo monto es requerido y debe ser un número válido.')]
    #[Validate('required', message: 'El campo monto es requerido y debe ser un número válido.')]
    public $monto;


    public function mount($cohortePaisProyecto, $paisProyecto)
    {
        $this->cohortePaisProyecto = CohortePaisProyecto::with(['cohorte'])->find($cohortePaisProyecto);

        $this->paisProyecto = PaisProyecto::with(['pais:id,nombre', 'proyecto:id,nombre'])->find($paisProyecto);
    }

    #[On('actualizar-monto-grupos')]
    public function render()
    {

        $query = BancarizacionGrupoParticipante::whereHas('bancarizacionGrupo', function ($query) {
            $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->whereNotNull("active_at");
        })
            ->whereNotNull('active_at')
            ->with([
                'participante:id,documento_identidad,primer_nombre,segundo_nombre,tercer_nombre,primer_apellido,segundo_apellido,tercer_apellido,fecha_nacimiento,sexo,ciudad_id,created_at',
                'participante.ciudad:id,nombre,departamento_id',
                'participante.ciudad.departamento:id,nombre',
                'bancarizacionGrupo.user',
                'creator'
            ])
            ->when(!empty($this->search), function ($query) {
                $query->whereHas('participante', function ($query) {
                    $termino = trim($this->search);
                    $query->whereRaw(
                        "
                        CONCAT(
                            TRIM(COALESCE(primer_nombre, '')),
                            IF(TRIM(COALESCE(segundo_nombre, '')) != '', CONCAT(' ', TRIM(COALESCE(segundo_nombre, ''))), ''),
                            IF(TRIM(COALESCE(tercer_nombre, '')) != '', CONCAT(' ', TRIM(COALESCE(tercer_nombre, ''))), ''),
                            IF(TRIM(COALESCE(primer_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(primer_apellido, ''))), ''),
                            IF(TRIM(COALESCE(segundo_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(segundo_apellido, ''))), ''),
                            IF(TRIM(COALESCE(tercer_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(tercer_apellido, ''))), '')
                        ) like ?",
                        ['%' . $termino . '%']
                    )
                        ->orWhere('email', 'like', '%' . $termino . '%')
                        ->orWhere('documento_identidad', 'like', '%' . $termino . '%');
                });
            });

        $participantes = $query->paginate($this->perPage);
        //dd($participantes);

        $this->participanteIdsOnPage = $participantes->map(fn($record) => (string) $record->participante->id)->toArray();

        return view('livewire.financiero.admin.participante.index.participantes', [
            'records' => $participantes
        ]);
    }

    public function editarSelected()
    {

        $this->addParticipanteList();

        $this->openEditDrawer = true;
    }

    public function editParticipante($participante)
    {
        $this->selectedParticipanteIds = [$participante];

        $this->addParticipanteList();

        $this->openEditDrawer = true;
    }
}
