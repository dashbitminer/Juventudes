<?php

namespace App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Edit;

use App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Create\Page as CreatePage;
use App\Models\FichaEmprendimiento;

class Page extends CreatePage
{
    public $titulo = 'Editar Ficha de Emprendimiento';

    public function mount(?FichaEmprendimiento $emprendimiento)
    {
        $this->form->init($this->pais, $this->participante);
        $this->form->medio_verificacion_required = false;

        $this->form->setEmprendimiento($emprendimiento);
    }
}
