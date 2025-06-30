<?php

namespace App\Livewire\Admin\User\Edit;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Livewire\Admin\User\Forms\UserForms;
use App\Models\User;
use App\Models\Pais;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SocioImplementador;

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
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.user.edit.page');
    }

    #[On('openEdit')]
    public function openEdit($id){
        $this->form->isEdit = true;
        $this->form->setUser($id);

        $this->openDrawer = true;
    }

    public function save()
    {
        $this->form->save();
        $this->showSuccessIndicator = true;
        $this->openDrawer = false;


        $this->form->unsetUser();
        $this->form->clearFields();

        $this->dispatch('refresh-usuarios');
    }
}
