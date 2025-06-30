<?php

namespace App\Livewire\Resultadocuatro\Gestor\Fichas\Show;

use App\Models\Cohorte;
use App\Models\Pais;
use App\Models\Participante;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Models\FichaVoluntario;
use App\Models\FichaEmpleo;
use App\Models\FichaEmprendimiento;
use App\Models\PracticaEmpleabilidad;
use App\Models\FichaFormacion;
use App\Models\AprendizajeServicio;

class Page extends Component
{

    public Pais $pais;

    public Cohorte $cohorte;

    public Participante $participante;

    public Proyecto $proyecto;

    public $cohorte_participante_proyecto_id;

    public $empleos;

    public $voluntariados;

    public $empleabilidades;

    public $formaciones;

    public $emprendimientos;

    public $servicios;

    public function mount()
    {
        $this->cohorte_participante_proyecto_id = $this->participante
            ->cohortePaisProyecto()
            ->pluck('cohorte_participante_proyecto.id')
            ->first();

        $this->empleos = 0;
        $this->voluntariados = 0;
        $this->empleabilidades = 0;
        $this->formaciones = 0;
        $this->emprendimientos = 0;
        $this->servicios = 0;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->empleoCount();
        $this->voluntariadoCount();
        $this->empleabilidadCount();
        $this->formacionCount();
        $this->emprendimientoCount();
        $this->serviciosCount();

        return view('livewire.resultadocuatro.gestor.fichas.show.page')
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte,
                'participante' => $this->participante,
                'ficha' => true,
                'resultadocuatro' => true,
            ]);
    }

    #[On('resultadocuatro-ficha-empleo')]
    public function empleoCount()
    {
        $this->empleos = FichaEmpleo::where('cohorte_participante_proyecto_id', $this->cohorte_participante_proyecto_id)
            ->count();
    }

    #[On('resultadocuatro-ficha-voluntariado')]
    public function voluntariadoCount()
    {
        $this->voluntariados = FichaVoluntario::where('cohorte_participante_proyecto_id', $this->cohorte_participante_proyecto_id)
            ->count();
    }

    #[On('resultadocuatro-practica-empleabilidad')]
    public function empleabilidadCount()
    {
        $this->empleabilidades = PracticaEmpleabilidad::where('cohorte_participante_proyecto_id', $this->cohorte_participante_proyecto_id)
            ->count();
    }

    #[On('resultadocuatro-ficha-formacion')]
    public function formacionCount()
    {
        $this->formaciones = FichaFormacion::where('cohorte_participante_proyecto_id', $this->cohorte_participante_proyecto_id)
            ->count();
    }

    #[On('resultadocuatro-ficha-emprendimiento')]
    public function emprendimientoCount()
    {
        $this->emprendimientos = FichaEmprendimiento::where('cohorte_participante_proyecto_id', $this->cohorte_participante_proyecto_id)
            ->count();
    }

    #[On('resultadocuatro-aprendizaje-servicio')]
    public function serviciosCount()
    {
        $this->servicios = AprendizajeServicio::where('cohorte_participante_proyecto_id', $this->cohorte_participante_proyecto_id)
            ->count();
    }
}
