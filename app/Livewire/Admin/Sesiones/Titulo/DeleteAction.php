<?php

namespace App\Livewire\Admin\Sesiones\Titulo;

use App\Models\Titulo;

trait DeleteAction
{
    public function delete(Titulo $model)
    {
        $model->delete();

        $this->dispatch('refresh-sesiones-titulos');

        $this->showSuccessIndicator = true;
    }

    public function deleteSelected()
    {
        Titulo::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-sesiones-titulos');

        $this->selectedIds = [];
    }
}
