<?php

namespace App\Livewire\Resultadocuatro\Gestor\Fichas\Show;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Cohorte;
use App\Models\Participante;
use App\Models\FichaVoluntario;

class Voluntariados extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;

    #[On('resultadocuatro-ficha-voluntariado')]
    public function render()
    {
        $cohorte_participante_proyecto_id = $this->participante
            ->cohortePaisProyecto()
            ->pluck('cohorte_participante_proyecto.id')
            ->first();

        $voluntariados = FichaVoluntario::where('cohorte_participante_proyecto_id', $cohorte_participante_proyecto_id)
            ->get();

        return view('livewire.resultadocuatro.gestor.fichas.show.voluntariados', [
            'voluntariados' => $voluntariados,
        ]);
    }

    public function delete(FichaVoluntario $voluntariado)
    {
        $voluntariado->delete();
        $this->dispatch('resultadocuatro-ficha-voluntariado');
    }
}
