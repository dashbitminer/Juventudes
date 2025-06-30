<?php

namespace App\Livewire\Resultadocuatro\Gestor\Fichas\Show;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Cohorte;
use App\Models\Participante;
use App\Models\AprendizajeServicio;

class Servicio extends Component
{
    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;

    #[On('resultadocuatro-aprendizaje-servicio')]
    public function render()
    {
        $cohorte_participante_proyecto_id = $this->participante
            ->cohortePaisProyecto()
            ->pluck('cohorte_participante_proyecto.id')
            ->first();

        $servicios = AprendizajeServicio::where('cohorte_participante_proyecto_id', $cohorte_participante_proyecto_id)
            ->get();

        return view('livewire.resultadocuatro.gestor.fichas.show.servicio', [
            'servicios' => $servicios,
        ]);
    }

    public function delete(AprendizajeServicio $servicio)
    {
        $servicio->delete();
        $this->dispatch('resultadocuatro-aprendizaje-servicio');
    }
}
