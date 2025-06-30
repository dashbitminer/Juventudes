<?php

namespace App\Livewire\Resultadocuatro\Gestor\Empleo\Edit;

use Livewire\Component;
use App\Models\FichaEmpleo;
use App\Livewire\Resultadocuatro\Gestor\Empleo\Create\Page as CreatePage;
use Storage;

class Page extends CreatePage
{
    public $titulo = 'Editar Ficha de Empleo';

    public function mount(?FichaEmpleo $empleo)
    {
        $empleo->load(["cohorteParticipanteProyecto.participante", "mediosVerificacion"]);

        $this->participante = $empleo->cohorteParticipanteProyecto->participante;

        $this->form->init($this->pais, $this->participante);

        $this->form->setFichaEmpleo($empleo);

        if ($empleo->mediosVerificacion()->count()) {
            $this->form->medio_verificacion_archivos = $empleo->mediosVerificacion()
                ->pluck('documento', 'medio_verificacion_id')
                ->toArray();

            $this->form->medio_verificacion_id = $empleo->mediosVerificacion->modelKeys();
        }
    }
}
