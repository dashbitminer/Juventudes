<?php

namespace App\Livewire\Admin\Sesiones\Subactividad;

use App\Models\Subactividad;

trait DeleteAction
{
    public function delete(Subactividad $model)
    {
        $model->delete();

        $this->dispatch('refresh-sesiones');

        $this->showSuccessIndicator = true;
    }

    public function deleteSelected()
    {
        Subactividad::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-sesiones');

        $this->selectedIds = [];
    }
}
