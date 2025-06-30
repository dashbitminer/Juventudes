<?php

namespace App\Livewire\Resultadouno\Coordinador\Participante\Index;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\On;
use App\Models\Participante;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Renderless;
use App\Exports\ParticipantesByCoordinadorExport;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Sortable;
use App\Livewire\Resultadouno\Coordinador\Participante\Index\Searchable;
use App\Models\CohortePaisProyecto;
use App\Models\EstadoRegistro;

class Table extends Component
{

    use WithPagination, Searchable, Sortable;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Pais $pais;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $perPage = 10;

    public $selectedParticipanteIds = [];

    public $participanteIdsOnPage = [];

    public $showSuccessIndicator = false;

    public $selectedParticipante;

    public $openDrawer = false;

    #[Reactive]
    public Filters $filters;

    #[On('update-page')]
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[Renderless]
    public function export()
    {
        return (new ParticipantesByCoordinadorExport($this->selectedParticipanteIds, $this->cohorte, $this->pais, $this->proyecto))->download('participantes.xlsx');
    }

    public function mount()
    {
        $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
                                                                ->where('pais_proyecto_id', $paisProyecto->id)
                                                                ->firstOrFail();


    }

    public function render()
    {
        //dd($this->getMisGestores());

        $query = Participante::with([
                'ciudad:id,nombre,departamento_id',
                'ciudad.departamento:id,nombre,pais_id',
                'lastEstado.estado_registro:id,nombre,color,icon',
                'gestor',
                'grupos',
            ])
            ->select([
                "id",
                "slug",
                "email",
                "primer_nombre",
                "segundo_nombre",
                "tercer_nombre",
                "primer_apellido",
                "segundo_apellido",
                "tercer_apellido",
                "ciudad_id",
                "created_at",
                "documento_identidad",
                "fecha_nacimiento",
                "sexo",
                "telefono",
                "gestor_id",
            ])

       // ->whereIn("gestor_id", $this->getMisGestores())
        ->whereHas("cohortePaisProyecto", function ($query) {
            $query->where("cohorte_pais_proyecto.id", $this->cohortePaisProyecto->id)
                ->whereNotNull("cohorte_participante_proyecto.active_at");
        });

        $query = $this->applySearch($query);
        $query = $this->applySorting($query);
        $query = $this->filters->apply($query);

        $participantes = $query->paginate($this->perPage);

        $this->participanteIdsOnPage = $participantes->map(fn ($participante) => (string) $participante->id)->toArray();

        return view('livewire.resultadouno.coordinador.participante.index.table', [
            'participantes' => $participantes
        ]);
    }

    public function selectParticipante(Participante $participante)
    {

        $this->selectedParticipante = $participante;

        $this->selectedParticipante->load([
            'estadosregistrosparticipantes:id,participante_id,estado_registro_id,created_at,created_by,comentario',
            'estadosregistrosparticipantes.estado_registro:id,nombre,color,icon,created_by',
            'estadosregistrosparticipantes.creator'
        ]);

        $this->openDrawer = true;

    }

    public function getMisGestores()
    {
        $miUsuarioCoordinador = \App\Models\CohorteProyectoUser::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                                ->where('user_id', auth()->id())
                                ->where('rol', 'coordinador')
                                ->first();


        $gestores = \App\Models\CoordinadorGestor::join('cohorte_proyecto_user', 'coordinador_gestores.gestor_id', '=', 'cohorte_proyecto_user.id')
                                ->where('coordinador_id', $miUsuarioCoordinador->id)
                                ->where('cohorte_proyecto_user.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                                ->pluck('cohorte_proyecto_user.user_id');

        return $gestores->unique()->toArray();
    }

    public function validarSelected(){
        Participante::whereIn('id', $this->selectedParticipanteIds)->each(function ($participante) {
            $estadoValidado = EstadoRegistro::VALIDADO;
            $participante->load('lastEstado.estado_registro:id,nombre,color,icon');

            if($participante->lastEstado->estado_registro_id != $estadoValidado){
                $participante->estados_registros()->attach($estadoValidado, [
                    'comentario' => 'El estado del participante ha sido actualizado a validado.',
                    'created_by' => auth()->id(), 
                ]);
            }
            
        });

        $this->selectedParticipanteIds = [];

        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-component');
    }

    public function deleteSelected()
    {
        Participante::whereIn('id', $this->selectedParticipanteIds)->each(function ($participante) {

            $participante->load('lastEstado.estado_registro:id,nombre,color,icon');
            if($participante->lastEstado->estado_registro_id == \App\Models\EstadoRegistro::DOCUMENTACION_PENDIENTE){
                $this->delete($participante);
            }

        });

        $this->selectedParticipanteIds = [];

        $this->showSuccessIndicator = true;
    }

    public function delete(Participante $participante)
    {
       // $this->authorize('update', $order);

        $participante->delete();

        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-component');
    }

}
