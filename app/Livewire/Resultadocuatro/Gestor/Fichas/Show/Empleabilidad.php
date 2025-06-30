<?php

namespace App\Livewire\Resultadocuatro\Gestor\Fichas\Show;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Cohorte;
use App\Models\Participante;
use App\Models\PracticaEmpleabilidad;

class Empleabilidad extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;

    #[On('resultadocuatro-practica-empleabilidad')]
    public function render()
    {
        $cohorte_participante_proyecto_id = $this->participante
            ->cohortePaisProyecto()
            ->pluck('cohorte_participante_proyecto.id')
            ->first();

        $empleabilidades = PracticaEmpleabilidad::where('cohorte_participante_proyecto_id', $cohorte_participante_proyecto_id)
            ->get();

        return view('livewire.resultadocuatro.gestor.fichas.show.empleabilidad', [
            'empleabilidades' => $empleabilidades,
        ]);
    }

    public function delete(PracticaEmpleabilidad $empleabilidad)
    {
        $empleabilidad->delete();
        $this->dispatch('resultadocuatro-practica-empleabilidad');
    }
}
