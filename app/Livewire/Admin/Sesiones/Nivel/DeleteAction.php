<?php

namespace App\Livewire\Admin\Sesiones\Nivel;

use App\Models\Actividad;
use App\Models\Subactividad;
use App\Models\Modulo;
use App\Models\Submodulo;

trait DeleteAction
{
    public function deleteActividad($id)
    {
        $this->selectedIds[] = $id;

        $this->deleteSelectedActividad();
    }

    public function deleteSelected()
    {
        Titulo::whereIn('id', $this->selectedIds)->delete();

        $this->dispatch('refresh-sesiones-titulos');

        $this->selectedIds = [];
    }
}
