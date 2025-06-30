<?php

namespace App\Livewire\Admin\Sesiones\Sesion;

use App\Models\SesionTitulo;

trait DeleteAction
{
    public function delete(SesionTitulo $model)
    {
        $model->delete();

        //$this->dispatch('refresh-sesiones');

        $this->showSuccessIndicator = true;
    }

    public function deleteSelected()
    {
        SesionTitulo::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-sesiones');

        $this->selectedIds = [];
    }
}
