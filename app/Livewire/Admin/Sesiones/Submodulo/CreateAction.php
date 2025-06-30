<?php

namespace App\Livewire\Admin\Sesiones\Submodulo;

use App\Models\Submodulo;

trait CreateAction
{
    public function save()
    {
        $this->validate();

        Submodulo::create([
            'nombre' => $this->nombre,
            'comentario' => $this->comentario,
        ]);

        // Close the drawer
        $this->openDrawer = false;
        $this->showSuccessIndicator = true;

        $this->resetFields();

        $this->dispatch('refresh-sesiones');
    }
}
