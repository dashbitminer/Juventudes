<?php

namespace App\Livewire\Admin\Sesiones\Nivel;

use App\Models\Titulo;

trait CreateAction
{
    public function save()
    {
        $this->validate();

        $titulo = Titulo::create([
            'nombre' => $this->nombre,
            'comentario' => $this->comentario,
        ]);

        // Close the drawer
        $this->openDrawer = false;
        $this->showSuccessIndicator = true;

        $this->resetFields();

        $this->dispatch('refresh-sesiones-titulos');
    }
}
