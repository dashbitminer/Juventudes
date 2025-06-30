<?php

namespace App\Livewire\Admin\Permisos\Index;

use App\Models\Role;
use Livewire\Component;
use App\Models\Permission;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Page extends Component
{

    #[Validate('required', message: 'El nombre del permiso es obligatorio.')]
    public $nombre_permiso;

    public $selectedRoles = [];

    public $descripcion_permiso;

    #[Validate('required', message: 'Debe de seleccionar una categoría para el permiso.')]
    public $categoriaSelected;

    public $openDrawer = false;

    public $openDrawerEdit = false;

    public $showSuccessIndicator = false;

    public Permission $permiso;


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.permisos.index.page',[
            'categorias' => Permission::CATEGORIAS,
        ]);
    }

    public function save()
    {
        $this->validate();

        // Save the permission to the database
        $permiso = Permission::create([
            'name' => $this->nombre_permiso,
            'descripcion' => $this->descripcion_permiso,
            'categoria' => Permission::CATEGORIAS[$this->categoriaSelected],
        ]);

        // Reset form fields
        $this->reset(['nombre_permiso', 'descripcion_permiso', 'categoriaSelected']);

        // Close the drawer
        $this->openDrawer = false;
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-permisos');
    }

    #[On('openEdit')]
    public function openEdit($id) {
        $this->permiso = Permission::find($id);

        if ($this->permiso instanceof Permission) {
            $this->nombre_permiso = $this->permiso->name;
            $this->descripcion_permiso = $this->permiso->descripcion;

            $this->categoriaSelected = array_search($this->permiso->categoria, Permission::CATEGORIAS);

            $this->openDrawerEdit = true;
        }
    }

    public function editPermiso()
    {
        $this->validate();

        $this->permiso->name = $this->nombre_permiso;
        $this->permiso->descripcion = $this->descripcion_permiso;
        $this->permiso->categoria = Permission::CATEGORIAS[$this->categoriaSelected];
        $this->permiso->save();

        $this->reset(['nombre_permiso', 'descripcion_permiso', 'categoriaSelected']);

        $this->openDrawerEdit = false;
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-permisos');
    }
}
