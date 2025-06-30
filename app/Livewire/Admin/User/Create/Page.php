<?php

namespace App\Livewire\Admin\User\Create;

use App\Models\Pais;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SocioImplementador;
use Illuminate\Support\Facades\Hash;
use App\Livewire\Admin\User\Forms\UserForms;

class Page extends Component
{
    public UserForms $form;

    public $openDrawer = false;

    public $showSuccessIndicator = false;

    public $roles = [];

    public $paises = [];

    public $socioImplementadores = [];

    public function mount(){
        $this->roles = Role::orderBy('id', 'asc')->pluck('name', 'id')->toArray();
        $this->socioImplementadores = SocioImplementador::where(function (Builder $builder) {
            $builder->whereNotNull('active_at')
                ->orWhere('nombre', 'Glasswing');
        })
            ->pluck('nombre', 'id')
            ->toArray();

        $this->form->clearFields();
        $this->form->is_active_at = true;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.user.create.page');
    }

    #[On('openCreate')]
    public function openCreate(){
        $this->openDrawer = true;
    }

    public function save()
    {
        $this->form->save();
        $this->showSuccessIndicator = true;
        $this->openDrawer = false;
        $this->form->clearFields();

        $this->dispatch('refresh-usuarios');
    }
}
