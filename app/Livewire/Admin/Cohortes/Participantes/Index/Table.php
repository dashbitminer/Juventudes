<?php

namespace App\Livewire\Admin\Cohortes\Participantes\Index;

use App\Models\CohorteParticipanteProyecto;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use App\Livewire\Admin\Cohortes\Participantes\Index\Searchable;
use App\Livewire\Admin\Cohortes\Participantes\Index\Sortable;
use App\Models\User;
use App\Models\Pais;
use App\Models\SocioImplementador;
use App\Exports\UserExport;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\CoordinadorGestor;
use App\Models\Participante;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    const GESTOR = 2;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $selectedRecordIds = [];

    public $recordsIdsOnPage = [];

    public $selectedFormulario;

    public $perPage = 10;

    public $showSuccessIndicator;

    public Filters $filters;

    public $gestores = [];

    public function mount($cohortePaisProyecto)
    {
        $this->cohortePaisProyecto = $cohortePaisProyecto;
        $this->gestores = $this->getGestores();
    }

    #[Renderless]
    public function export()
    {
        return (new UserExport($this->selectedRecordIds, $this->filters, $this->search))
                ->download('users.xlsx');

    }

    #[On('refresh-participantes')]
    public function render()
    {
        
        $query  = CohorteParticipanteProyecto::with('participante')
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
            

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $query = $this->filters->apply($query);

        $cohorteProyectoPartipantes = $query->paginate($this->perPage);

        $this->recordsIdsOnPage = $cohorteProyectoPartipantes->map(fn($cohorteProyectoPartipante) => (string) $cohorteProyectoPartipante->id)->toArray();

        return view('livewire.admin.cohortes.participantes.index.table', [
            'cohorteProyectoPartipantes' => $cohorteProyectoPartipantes,
            /*'socioImplementadores' => SocioImplementador::where(function (Builder $builder) {
                $builder->whereNotNull('active_at')
                    ->orWhere('nombre', 'Glasswing');
                })->pluck("nombre", "id"),
            'roles' => Role::pluck("name", "id")*/
        ]);
    }

    public function deleteSelected()
    {
        foreach($this->selectedRecordIds as $userId){
            $user = User::find($userId)->first();
            $this->delete($user);
        }

        $this->dispatch('refresh-usuarios');
    }

    public function delete(User $user)
    {
        $cohorteProyectoUser = $user->cohorteProyectoUser()
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->firstOrFail();

        if(strtolower($cohorteProyectoUser->rol) == 'gestor'){
            $coordinadorGestor = CoordinadorGestor::where('gestor_id', $cohorteProyectoUser->id)
                ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->first();

            if($coordinadorGestor){
                $coordinadorGestor->delete();
            }
        }

        $cohorteProyectoUser->delete();

        $this->dispatch('refresh-usuarios');

        $this->showSuccessIndicator = true;
    }

    #[On('manual-reset-page')]
    public function manualResetPage()
    {
        $this->resetPage();
    }

    public function getGestores()
    {
        return User::with('roles')
            ->whereHas('cohorteProyectoUser', function ($query) {
                $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
            })
            ->whereHas('roles', function ($q) {
                $q->whereIn('roles.id', [self::GESTOR]);
            })
            ->pluck('username', 'id')
            ->toArray();
    }
}
