<?php

namespace App\Livewire\Admin\Sesiones\Nivel;

use Livewire\Attributes\On;
use App\Models\Titulo;

trait EditAction
{
    #[On('openEdit')]
    public function openEdit($id) {
        $this->resetFields();

        $this->titulo = Titulo::find($id);

        if ($this->titulo instanceof Titulo) {
            $this->nombre = $this->titulo->nombre;
            $this->comentario = $this->titulo->comentario;

            $this->openDrawerEdit = true;
        }
    }

    public function editTitulo()
    {
        $this->validate();

        if ($this->titulo) {
            $this->titulo->update([
                'nombre' => $this->nombre,
                'comentario' => $this->comentario,
            ]);
        }

        $this->resetFields();

        $this->openDrawerEdit = false;
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-sesiones-titulos');
    }
}
