<?php

namespace App\Livewire\Admin\User\Index;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use App\Livewire\Admin\User\Index\Searchable;
use App\Livewire\Admin\User\Index\Sortable;
use App\Models\User;
use App\Models\Pais;
use App\Models\SocioImplementador;
use App\Exports\UserExport;

class Table extends Component
{
    use WithPagination, Searchable, Sortable;

    public $selectedRecordIds = [];

    public $recordsIdsOnPage = [];

    public $selectedFormulario;

    public $perPage = 10;

    public $showSuccessIndicator;

    public Filters $filters;

    #[Renderless]
    public function export()
    {
        return (new UserExport($this->selectedRecordIds, $this->filters, $this->search))
                ->download('users.xlsx');

    }

    #[On('refresh-usuarios')]
    public function render()
    {
        $query = User::with('roles', 'socioImplementador.pais:id,nombre')
            ->orderBy('id', 'DESC');

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $query = $this->filters->apply($query);

        $users = $query->paginate($this->perPage);

        $this->recordsIdsOnPage = $users->map(fn($user) => (string) $user->id)->toArray();

        return view('livewire.admin.user.index.table', [
            'users' => $users,
            'socioImplementadores' => SocioImplementador::where(function (Builder $builder) {
                $builder->whereNotNull('active_at')
                    ->orWhere('nombre', 'Glasswing');
                })->pluck("nombre", "id"),
            'roles' => Role::pluck("name", "id")
        ]);
    }

    public function deleteSelected()
    {
        User::whereIn('id', $this->selectedRecordIds)->delete();

        $this->dispatch('refresh-usuarios');
    }

    public function delete(User $user)
    {
        $user->delete();

        $this->dispatch('refresh-usuarios');

        $this->showSuccessIndicator = true;
    }

    #[On('manual-reset-page')]
    public function manualResetPage()
    {
        $this->resetPage();
    }
}
