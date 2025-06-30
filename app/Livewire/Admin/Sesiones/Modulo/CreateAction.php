<?php

namespace App\Livewire\Admin\Sesiones\Modulo;

use App\Models\Modulo;

trait CreateAction
{
    public function save()
    {
        $this->validate();

        Modulo::create([
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
