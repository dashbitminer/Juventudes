<?php

namespace App\Livewire\Admin\Roles\Index;

use App\Models\Permission;
use Livewire\Component;
use App\Models\Role;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Page extends Component
{
    #[Validate('required', message: 'El nombre del rol es obligatorio.')]
    public $nombre_rol;

    #[Validate('required', message: 'Debe de seleccionar al menos un permiso para asignar al nuevo rol.')]
    public $selectedPermissions = [];

    public $descripcion_rol;

    // #[Validate('required', message: 'Debe de seleccionar una categoría para el rol.')]
    public $categoriaSelected;

    public $openDrawer = false;

    public $openDrawerEdit = false;

    public $showSuccessIndicator = false;

    public Role $role;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.roles.index.page', [
            'permisos' => Permission::all(),
            'categorias' =>  Permission::select('categoria')->distinct()->pluck('categoria')->toArray(),
        ]);
    }

    public function save()
    {
        $this->validate();

        // Save the role to the database
        $role = Role::firstOrCreate([
            'name' => $this->nombre_rol,
            'descripcion' => $this->descripcion_rol,
            //'categoria' => $this->categoriaSelected,
        ]);

        foreach ($this->selectedPermissions as $permission) {
            $permission = Permission::find($permission);
            $role->givePermissionTo($permission);
        }

        // Reset form fields
        $this->reset(['nombre_rol', 'descripcion_rol', 'categoriaSelected', 'selectedPermissions']);

        // Close the drawer
        $this->openDrawer = false;
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-roles');
    }

    #[On('openEdit')]
    public function openEdit($id) {
        $this->role = Role::find($id);

        if ($this->role instanceof Role) {
            $this->nombre_rol = $this->role->name;
            $this->descripcion_rol = $this->role->description;

            $this->selectedPermissions = Permission::with('roles')
                ->whereHas('roles', function ($builder) use ($id) {
                    $builder->where('id', '=', $id);
                })
                ->pluck('id')
                ->toArray();

            $this->openDrawerEdit = true;
        }
    }

    public function editRole()
    {
        $this->validate();

        $this->role->name = $this->nombre_rol;
        $this->role->descripcion = $this->descripcion_rol;
        $this->role->save();

        $permisos = Permission::whereIn('id', $this->selectedPermissions)
            ->pluck('name');

        $this->role->syncPermissions($permisos);

        $this->reset(['nombre_rol', 'descripcion_rol', 'categoriaSelected', 'selectedPermissions']);

        $this->openDrawerEdit = false;
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-roles');
    }
}
