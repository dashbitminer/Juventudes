<?php

namespace App\Livewire\Resultadocuatro\Gestor\Directorio\Edit;

use Livewire\Component;
use App\Models\Directorio;
use App\Livewire\Resultadocuatro\Gestor\Directorio\Create\Page as CreateDirectorio;

class Page extends CreateDirectorio
{

    public $titulo = 'Editar Directorio';

    public function mount(?Directorio $directorio)
    {
        $this->form->setPais($this->pais);
        $this->form->setProyecto($this->proyecto);
        $this->form->setDirectorio($directorio);
        $this->form->init();

        if (!empty($directorio->departamento_id)) {
            $this->form->setCiudades($directorio->departamento_id);
        }

        if ($directorio->tipoApoyo()->count()) {
            $this->form->tipo_apoyo_id = $directorio->tipoApoyo()->pluck('tipo_apoyo_id')->toArray();
        }
    }

}
