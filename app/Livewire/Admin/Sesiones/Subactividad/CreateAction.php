<?php

namespace App\Livewire\Admin\Sesiones\Subactividad;

use App\Models\Subactividad;

trait CreateAction
{
    public function save()
    {
        $this->validate();

        Subactividad::create([
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
