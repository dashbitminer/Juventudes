<?php

namespace App\Livewire\Admin\Mantenimientos\Razones\Index;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

class Page extends Component
{
    #[Validate('required', message: 'La razon es obligatoria.')]
    public $razon;

    public $comentario;

    public $openDrawer = false;


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.mantenimientos.razones.index.page')
        ->layoutData([
            'admin' => true,
        ]);
    }


    public function save()
    {
        $this->validate();

        // Save the razon to the database
        // $razon = Razon::create([
        //     'nombre' => $this->nombre_razon,
        //     'descripcion' => $this->descripcion_razon,
        //     'categoria' => $this->categoriaSelected,
        // ]);

        // Reset form fields
        $this->reset(['razon', 'comentario']);

        // Close the drawer
        $this->openDrawer = false;

        // Optionally, you can add a success message or event
        session()->flash('message', 'Razon creada exitosamente.');
    }
}
