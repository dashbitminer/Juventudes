<?php

namespace App\Livewire\Admin\Sesiones\Subactividad;

use Livewire\Attributes\On;
use App\Models\Subactividad;

trait EditAction
{
    #[On('openEdit')]
    public function openEdit($id) {
        $this->resetFields();

        $this->model = Subactividad::find($id);

        if ($this->model instanceof Subactividad) {
            $this->nombre = $this->model->nombre;
            $this->comentario = $this->model->comentario;

            $this->openDrawerEdit = true;
        }
    }

    public function editNivel()
    {
        $this->validate();

        if ($this->model) {
            $this->model->update([
                'nombre' => $this->nombre,
                'comentario' => $this->comentario,
            ]);
        }

        $this->resetFields();

        $this->openDrawerEdit = false;
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-sesiones');
    }
}
