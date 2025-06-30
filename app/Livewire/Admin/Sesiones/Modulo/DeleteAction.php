<?php

namespace App\Livewire\Admin\Sesiones\Modulo;

use App\Models\Modulo;

trait DeleteAction
{
    public function delete(Modulo $model)
    {
        $model->delete();

        $this->dispatch('refresh-sesiones');

        $this->showSuccessIndicator = true;
    }

    public function deleteSelected()
    {
        Modulo::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-sesiones');

        $this->selectedIds = [];
    }
}
