<?php

namespace App\Livewire\Admin\Sesiones\Actividad;

use App\Models\Actividad;

trait DeleteAction
{
    public function delete(Actividad $model)
    {
        $model->delete();

        $this->dispatch('refresh-sesiones');

        $this->showSuccessIndicator = true;
    }

    public function deleteSelected()
    {
        Actividad::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-sesiones');

        $this->selectedIds = [];
    }
}
