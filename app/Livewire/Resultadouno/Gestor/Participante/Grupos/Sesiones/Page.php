<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos\Sesiones;

use App\Models\Pais;
use App\Models\Grupo;
use App\Models\Modulo;
use App\Models\Sesion;
use Livewire\Component;
use App\Models\Actividad;
use App\Models\Submodulo;
use App\Models\SesionTipo;
use Livewire\Attributes\On;
use App\Models\SesionTitulo;
use App\Models\Subactividad;
use App\Models\GrupoParticipante;
use App\Models\SesionParticipante;
use Illuminate\Support\Facades\DB;
use App\Models\CohortePaisProyecto;

class Page extends Component
{
    public CohortePaisProyecto $cohortePaisProyecto;

    public Grupo $grupo;

    public Actividad $actividad;

    public ?Subactividad $subactividad = null;

    public ?Modulo $modulo = null;

    public ?Submodulo $submodulo = null;

    public Actividad | Subactividad | Modulo | Submodulo $model;

    public $showSuccessIndicator = false;

    public $titulo_abierto;

    public $tipo_sesion;

    public function mount()
    {
        $this->model = $this->submodulo ?? $this->modulo ?? $this->subactividad ?? $this->actividad;
    }

    #[On('refresh-sesiones')]
    public function render()
    {
        // dd($this->model->tituloSesion);
        $tituloSesion = $this->model->tituloSesion()
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->first();

        $tipoSesion = $this->model->tipoSesion()
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->first();

        $this->titulo_abierto = $tituloSesion->titulo_abierto ?? SesionTitulo::CERRADO;;
        $this->tipo_sesion = $tipoSesion->tipo ?? SesionTipo::SESION_GENERAL;

        $grupoParticipante = GrupoParticipante::whereHas('cohorteParticipanteProyecto', function ($query) {
            $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
        })
            ->active()
            ->select('cohorte_pais_proyecto_perfil_id')
            ->where('user_id', auth()->id())
            ->where('grupo_id', $this->grupo->id)
            ->whereNotNull('cohorte_pais_proyecto_perfil_id')
            ->groupBy("grupo_id")
            ->first();

        $sesiones = $this->model->sesiones()->with([
            'getTitulo',
            'sesionParticipantesAsistencia',
            'sesionParticipantes.tracking',
        ])
            ->active()
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->where('cohorte_pais_proyecto_perfil_id', $grupoParticipante->cohorte_pais_proyecto_perfil_id)
            ->where('user_id', auth()->id())
            ->where('grupo_id', $this->grupo->id)
            ->when($this->actividad, function ($query) {
                $query->where('actividad_id', $this->actividad->id);
            })
            ->when($this->subactividad, function ($query) {
                $query->where('subactividad_id', $this->subactividad->id);
            })
            ->when($this->modulo, function ($query) {
                $query->where('modulo_id', $this->modulo->id);
            })
            ->when($this->submodulo, function ($query) {
                $query->where('submodulo_id', $this->submodulo->id);
            })
            ->select([
                'id',
                'cohorte_pais_proyecto_id',
                'cohorte_pais_proyecto_perfil_id',
                'user_id',
                'actividad_id',
                'subactividad_id',
                'modulo_id',
                'submodulo_id',
                'grupo_id',
                'modalidad',
                'fecha',
                'fecha_fin',
                'titulo_id',
                'titulo',
                'hora',
                'minuto',
                'modelable_id',
                'modelable_type',
                DB::raw('DATEDIFF(fecha_fin, fecha) as total_dias'),
            ])
            ->get();

        $sesiones = $sesiones->map(function ($sesion) {
            $totalHours = collect();
            $totalMinutes = collect();

            if ($this->tipo_sesion == SesionTipo::HORAS_PARTICIPANTE) {
                $sesion->sesionParticipantes->each(function ($participante) use ($totalHours, $totalMinutes) {
                    $totalTime = collect();

                    $participante->tracking->each(function ($traking) use ($totalTime) {
                        $totalTime->push(($traking->hora * 60) + $traking->minuto);
                    });

                    try {
                        $averageMinutes = $totalTime->sum() / $totalTime->count();
                    }
                    catch(\DivisionByZeroError $e) {
                        $averageMinutes = 0;
                    }

                    $totalHours->push(floor($averageMinutes / 60));
                    $totalMinutes->push($averageMinutes % 60);
                });
            }
            else {
                $totalHours->push(0);
                $totalMinutes->push(0);
            }

            $sesion->total_horas = floor($totalHours->average());
            $sesion->total_minutos = $totalMinutes->average();

            return $sesion;
        });

        return view('livewire.resultadouno.gestor.participante.grupos.sesiones.page', [
            'sesiones' => $sesiones,
        ]);
    }

    public function deleteSesion(Sesion $sesion)
    {
        $sesion->delete();

        $this->dispatch('refresh-sesiones');
        $this->showSuccessIndicator = true;
    }
}
