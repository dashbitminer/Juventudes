<?php

namespace App\Livewire\Financiero\Mecla\Estipendios\Detail;

use App\Models\Sesion;
use App\Models\Estipendio;
use App\Models\Actividad;
use App\Models\Subactividad;
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Enums\ParticipanteAlertaNivel;
use Carbon\Carbon;

trait SesionTrait
{

    public function loadSesionByDate()
    {
        $actividades = [];

        $sesiones = Sesion::with('cohortePaisProyectoPerfil')
            ->active()
            ->where('cohorte_pais_proyecto_id', $this->estipendio->cohorte_pais_proyecto_id)
            ->where('cohorte_pais_proyecto_perfil_id', $this->estipendio->cohorte_pais_proyecto_perfil_id)
            ->whereBetween('fecha', [$this->estipendio->fecha_inicio, $this->estipendio->fecha_fin])
            ->get();

        foreach ($sesiones as $sesion) {
            $actividades[] = $sesion->actividad_id;
        }

        $this->actividades = Actividad::select('id', 'nombre')->whereIn('id', $actividades)->orderBy('nombre')->get();
    }

    public function loadSubactividadesByActividad()
    {
        $subactividades = [];

        $sesiones = Sesion::with('cohortePaisProyectoPerfil')
            ->active()
            ->where('cohorte_pais_proyecto_id', $this->estipendio->cohorte_pais_proyecto_id)
            ->where('cohorte_pais_proyecto_perfil_id', $this->estipendio->cohorte_pais_proyecto_perfil_id)
            ->whereIn('actividad_id', $this->actividad_agrupacion)
            ->whereBetween('fecha', [$this->estipendio->fecha_inicio, $this->estipendio->fecha_fin])
            ->get();

        foreach ($sesiones as $sesion) {
            $subactividades[] = $sesion->subactividad_id;
        }

        $this->subactividades = Subactividad::select('id', 'nombre')->whereIn('id', $subactividades)->orderBy('nombre')->get();
    }

    public function loadModulosBySubactividad()
    {
        $modulos = [];

        $sesiones = Sesion::with('cohortePaisProyectoPerfil')
            ->active()
            ->where('cohorte_pais_proyecto_id', $this->estipendio->cohorte_pais_proyecto_id)
            ->where('cohorte_pais_proyecto_perfil_id', $this->estipendio->cohorte_pais_proyecto_perfil_id)
            ->whereIn('actividad_id', $this->actividad_agrupacion)
            // ->whereIn('subactividad_id', $this->subactividad_agrupacion)
            ->when($this->subactividad_agrupacion, function ($subquery) {
                $subquery->whereIn('subactividad_id', $this->subactividad_agrupacion);
            })
            ->whereBetween('fecha', [$this->estipendio->fecha_inicio, $this->estipendio->fecha_fin])
            ->get();

        foreach ($sesiones as $sesion) {
            $modulos[] = $sesion->modulo_id;
        }

        $this->modulos = Modulo::select('id', 'nombre')->whereIn('id', $modulos)->orderBy('nombre')->get();
    }

    public function loadSubmodulosByModulo()
    {
        $submodulos = [];

        $sesiones = Sesion::with('cohortePaisProyectoPerfil')
            ->active()
            ->where('cohorte_pais_proyecto_id', $this->estipendio->cohorte_pais_proyecto_id)
            ->where('cohorte_pais_proyecto_perfil_id', $this->estipendio->cohorte_pais_proyecto_perfil_id)
            ->whereIn('actividad_id', $this->actividad_agrupacion)
            ->whereIn('subactividad_id', $this->subactividad_agrupacion)
            ->whereIn('modulo_id', $this->modulo_agrupacion)
            ->whereBetween('fecha', [$this->estipendio->fecha_inicio, $this->estipendio->fecha_fin])
            ->get();

        foreach ($sesiones as $sesion) {
            $submodulos[] = $sesion->submodulo_id;
        }

        $this->submodulos = Submodulo::select('id', 'nombre')->whereIn('id', $submodulos)->orderBy('nombre')->get();
    }

    public function loadAllSesiones()
    {
        $actividades = [];
        $subactividades = [];
        $modulos = [];
        $submodulos = [];

        $sesiones = Sesion::with('cohortePaisProyectoPerfil')
            ->active()
            ->where('cohorte_pais_proyecto_id', $this->estipendio->cohorte_pais_proyecto_id)
            ->where('cohorte_pais_proyecto_perfil_id', $this->estipendio->cohorte_pais_proyecto_perfil_id)
            ->when($this->actividad_agrupacion, function ($subquery) {
                $subquery->whereIn('actividad_id', $this->actividad_agrupacion);
            })
            ->when($this->subactividad_agrupacion, function ($subquery) {
                $subquery->whereIn('subactividad_id', $this->subactividad_agrupacion);
            })
            ->when($this->modulo_agrupacion, function ($subquery) {
                $subquery->whereIn('modulo_id', $this->modulo_agrupacion);
            })
            ->when($this->submodulo_agrupacion, function ($subquery) {
                $subquery->whereIn('submodulo_id', $this->submodulo_agrupacion);
            })
            ->whereBetween('fecha', [$this->estipendio->fecha_inicio, $this->estipendio->fecha_fin])
            ->get();

        foreach ($sesiones as $sesion) {
            $actividades[] = $sesion->actividad_id;
            $subactividades[] = $sesion->subactividad_id;
            $modulos[] = $sesion->modulo_id;
            $submodulos[] = $sesion->submodulo_id;
        }

        $this->actividades = Actividad::select('id', 'nombre')->whereIn('id', $actividades)->orderBy('nombre')->get();
        $this->subactividades = Subactividad::select('id', 'nombre')->whereIn('id', $subactividades)->orderBy('nombre')->get();
        $this->modulos = Modulo::select('id', 'nombre')->whereIn('id', $modulos)->orderBy('nombre')->get();
        $this->submodulos = Submodulo::select('id', 'nombre')->whereIn('id', $submodulos)->orderBy('nombre')->get();
    }

    public function getTotalHorasPorSesiones()
    {
        $results = [];

        $sesiones = Sesion::with([
            'cohortePaisProyectoPerfil',
            'sesionParticipantes',
            'sesionParticipantes.tracking',
            ])
            ->active()
            ->where('cohorte_pais_proyecto_id', $this->estipendio->cohorte_pais_proyecto_id)
            ->where('cohorte_pais_proyecto_perfil_id', $this->estipendio->cohorte_pais_proyecto_perfil_id)
            // ->whereHas('cohortePaisProyectoPerfil', function ($subquery) {
            //     $subquery->where('perfil_participante_id', $this->estipendio->perfil_participante_id);
            // })
            ->whereHas('sesionParticipantes', function ($subquery) {
                $subquery->whereIn('participante_id', $this->participantesIdsTotal);
            })
            ->when($this->actividad_agrupacion, function ($subquery) {
                $subquery->whereIn('actividad_id', $this->actividad_agrupacion);
            })
            ->when($this->subactividad_agrupacion, function ($subquery) {
                $subquery->where(function ($q) {
                    $q->whereIn('subactividad_id', $this->subactividad_agrupacion)
                      ->orWhereNull('subactividad_id');
                });
            })
            ->when($this->modulo_agrupacion, function ($subquery) {
                $subquery->where(function ($q) {
                    $q->whereIn('modulo_id', $this->modulo_agrupacion)
                      ->orWhereNull('modulo_id');
                });
            })
            ->when($this->submodulo_agrupacion, function ($subquery) {
                $subquery->where(function ($q) {
                    $q->whereIn('submodulo_id', $this->submodulo_agrupacion)
                      ->orWhereNull('submodulo_id');
                });
            })
            ->whereBetween('fecha', [$this->estipendio->fecha_inicio, $this->estipendio->fecha_fin])
            // ->where('id', 4306)  // Probar para una sesion en especifico
            ->get();

        // dd($sesiones);

        // Obtener el total de horas por participante en cada sesion
        $sesiones->each(function ($sesion) use (&$results) {
            $sesion->sesionParticipantes->each(function ($participante) use (&$results, $sesion) {

                $results[$participante->participante_id]['suma'] = $results[$participante->participante_id]['suma'] ?? 0;

                // Para las sesiones con tracking se suma el total de horas, caso contrario,
                // se toma la hora de la sesion ya que es sesion por asistencia
                if ($participante->tracking->count() > 1) {
                    $participante->tracking->each(function ($tracking) use (&$results, $participante) {
                        $trackingFecha = Carbon::parse($tracking->fecha);

                        if ($trackingFecha->lt($this->estipendio->fecha_fin) || $trackingFecha->eq($this->estipendio->fecha_fin)) {
                            $results[$participante->participante_id]['suma'] += (int) $tracking->hora + ((int) $tracking->minuto / 60);
                        }
                    });
                }
                else {
                    $results[$participante->participante_id]['suma'] += (int) $sesion->hora + ((int) $sesion->minuto / 60);
                }

            });
        });

        // dd($results);

        // Obtener el porcentaje de la formacion si el denominador es mayor a 0
        if ($this->denominador_agrupacion > 0) {
            foreach ($results as $participante_id => $result) {
                $results[$participante_id]['porcentaje'] = ($result['suma'] / $this->denominador_agrupacion) * 100;

                $alert = ParticipanteAlertaNivel::fromPercentage($results[$participante_id]['porcentaje']);
                $results[$participante_id]['alerta'] = $alert->value;
            }
        }

        // dd($results);

        return $results;
    }

}
