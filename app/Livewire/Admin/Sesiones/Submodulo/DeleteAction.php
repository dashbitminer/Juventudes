<?php

namespace App\Livewire\Admin\Sesiones\Submodulo;

use App\Models\Submodulo;

trait DeleteAction
{
    public function delete(Submodulo $model)
    {
        $model->delete();

        $this->dispatch('refresh-sesiones');

        $this->showSuccessIndicator = true;
    }

    public function deleteSelected()
    {
        Submodulo::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-sesiones');

        $this->selectedIds = [];
    }
}
