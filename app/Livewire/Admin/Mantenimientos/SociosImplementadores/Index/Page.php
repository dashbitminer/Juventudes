<?php

namespace App\Livewire\Admin\Mantenimientos\SociosImplementadores\Index;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

class Page extends Component
{
    #[Validate('required', message: 'El nombre del rol es obligatorio.')]
    public $nombre_rol;

    #[Validate('required', message: 'Debe de seleccionar al menos un permiso para asignar al nuevo rol.')]
    public $selectedPermissions = [];

    public $descripcion_rol;

    #[Validate('required', message: 'Debe de seleccionar una categoría para el rol.')]
    public $categoriaSelected;

    public $openDrawer = false;


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.mantenimientos.socios-implementadores.index.page')
        ->layoutData([
            'admin' => true,
        ]);
    }


    public function save()
    {
        $this->validate();

        // Save the role to the database
        // $role = Role::create([
        //     'nombre' => $this->nombre_rol,
        //     'descripcion' => $this->descripcion_rol,
        //     'categoria' => $this->categoriaSelected,
        // ]);

        // foreach ($this->selectedPermissions as $permission) {
        //     $permission = Permission::find($permission);
        //     $role->givePermissionTo($permission);
        // }

        // Reset form fields
        $this->reset(['nombre_rol', 'descripcion_rol', 'categoriaSelected', 'selectedPermissions']);

        // Close the drawer
        $this->openDrawer = false;

        // Optionally, you can add a success message or event
        session()->flash('message', 'Rol creado exitosamente.');
    }
}
