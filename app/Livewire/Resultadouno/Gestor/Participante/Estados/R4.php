<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Estados;

use Livewire\Attributes\Layout;

class R4 extends Page
{
    #[Layout('layouts.app')]
    public function render()
    {
        $this->resultado = 4;

        return view('livewire.resultadouno.gestor.participante.estados.page')
            ->layoutData([
                'cohorte' => $this->cohorte,
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'resultadocuatro' => true,
            ]);
    }
}
