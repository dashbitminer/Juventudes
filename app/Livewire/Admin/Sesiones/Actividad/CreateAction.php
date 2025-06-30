<?php

namespace App\Livewire\Admin\Sesiones\Actividad;

use App\Models\Actividad;

trait CreateAction
{
    public function save()
    {
        $this->validate();

        Actividad::create([
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
