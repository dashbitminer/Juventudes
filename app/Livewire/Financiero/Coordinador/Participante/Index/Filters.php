<?php

namespace App\Livewire\Financiero\Coordinador\Participante\Index;

use Livewire\Form;
use App\Models\Estado;
use Livewire\Attributes\Url;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Livewire\Financiero\Coordinador\Participante\Index\Range;
use App\Models\CohortePaisProyecto;
use App\Models\CohorteParticipanteProyecto;
use App\Models\EstadoRegistro;
use App\Models\EstadoRegistroParticipante;

class Filters extends Form
{

    use CoordinadorTrait;

    public $estados;

    public $status = 0;

    public $updatepage = false;

    #[Url]
    public Range $range = Range::All_Time;

    #[Url]
    public $start;

    #[Url]
    public $end;

    #[Url(as: 'estados')]
    public $selectedEstadosIds = [];

    public $selectedPerfilesIds = [];

    public $selectedSexosIds = [];

    public $selectedGruposIds = [];

    public $selectedDepartamentosIds = [];

    public $selectedGestoresIds = [];

    public $selectedMunicipiosIds = [];

    public $listOfMunicipios;

    public $cohortePaisProyecto;



    public function init($selectedCohortePaisProyecto = null)
    {

        $this->cohortePaisProyecto = CohortePaisProyecto::find($selectedCohortePaisProyecto);

        $this->initRange();

        $this->initSelectedPerfilesIds();

        $this->initSelectedSexosIds();

        $this->initSelectedGruposIds();

        $this->initSelectedDepartamentosIds();

        $this->initSelectedGestoresIds();

        $this->initSelectedMunicipiosIds();

        $this->listOfMunicipios = $this->municipios();
    }


    public function initSelectedGruposIds()
    {
        if (empty($this->selectedGruposIds)) {
            $this->selectedGruposIds = $this->grupos()->pluck('grupo_id')->toArray();
        }
    }

    public function initSelectedDepartamentosIds()
    {
        if (empty($this->selectedDepartamentosIds)) {
            $this->selectedDepartamentosIds = $this->departamentos()->pluck('departamento_id')->toArray();
        }
    }

    public function initSelectedMunicipiosIds()
    {
        if (empty($this->selectedMunicipiosIds)) {
            $this->selectedMunicipiosIds = $this->municipios()->pluck('ciudad_id')->toArray();
        }
    }

    public function initSelectedGestoresIds()
    {
        if (empty($this->selectedGestoresIds)) {
            $this->selectedGestoresIds = $this->gestores()->pluck('gestor_id')->toArray();
        }
    }

    public function grupos()
    {
        if (!$this->cohortePaisProyecto) {
            return collect([]);
        }

        $cohortePaisProyectoId = $this->cohortePaisProyecto->id;

        $records = \App\Models\Participante::query()
            ->leftJoin('bancarizacion_grupo_participantes', 'participantes.id', '=', 'bancarizacion_grupo_participantes.participante_id')
            ->leftJoin('bancarizacion_grupos', 'bancarizacion_grupo_participantes.bancarizacion_grupo_id', '=', 'bancarizacion_grupos.id')
            ->leftJoin('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $cohortePaisProyectoId)
            ->whereNotNull('bancarizacion_grupo_participantes.active_at')
            ->whereNull('bancarizacion_grupo_participantes.deleted_at')
            ->whereNull('bancarizacion_grupos.deleted_at')
            ->whereIn("gestor_id", $this->getMisGestores())
            ->with('lastEstado')
            // ->whereHas('lastEstado', function ($q) {
            //     $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
            // })
            ->when(!empty($this->selectedPerfilesIds), function ($query) {
                return $query->whereHas('cohortePaisProyecto', function ($q) {
                    $q->whereIn('cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', $this->selectedPerfilesIds);
                });
            })
            ->when(!empty($this->selectedSexosIds), function ($query) {
                return $query->whereIn('sexo', $this->selectedSexosIds);
            })
            ->select('bancarizacion_grupo_participantes.bancarizacion_grupo_id', DB::raw('COUNT(DISTINCT bancarizacion_grupo_participantes.participante_id) as count'))
            ->groupBy('bancarizacion_grupo_participantes.bancarizacion_grupo_id')
            ->get();

        // $arrayaux = [];
        // foreach ($records as $record) {
        //     if( $record->lastEstado->estado_registro_id != \App\Models\EstadoRegistro::VALIDADO){
        //         $arrayaux[] = [
        //             'recordid' => $record->id,
        //             'estado' => $record->lastEstado->estado_registro_id
        //         ];
        //     }
        // }

        //dd(count($records), $arrayaux);

        $grupos = $records->map(function ($record) {
            $grupo = DB::table('bancarizacion_grupos')
                ->where('id', $record->bancarizacion_grupo_id)
                ->first(['nombre']);

            return [
                'grupo_id' => $record->bancarizacion_grupo_id,
                'nombre' => $grupo->nombre,
                'count' => $record->count,
            ];
        });

        //return $grupos;
        $totalParticipantes = \App\Models\Participante::query()
            ->leftJoin('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $cohortePaisProyectoId)
            ->whereIn("gestor_id", $this->getMisGestores())
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
            })
            ->when(!empty($this->selectedPerfilesIds), function ($query) {
                return $query->whereHas('cohortePaisProyecto', function ($q) {
                    $q->whereIn('cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', $this->selectedPerfilesIds);
                });
            })
            ->when(!empty($this->selectedSexosIds), function ($query) {
                return $query->whereIn('sexo', $this->selectedSexosIds);
            })
            ->count();

        $participantesConGrupo = $records->sum('count');

        $participantesSinGrupo = $totalParticipantes - $participantesConGrupo;

        $grupos->prepend([
            'grupo_id' => 0,
            'nombre' => 'Sin Grupo',
            'count' => $participantesSinGrupo,
        ]);

        return $grupos;
    }

    public function initSelectedSexosIds()
    {
        if (empty($this->selectedSexosIds)) {
            $this->selectedSexosIds = $this->sexos()->pluck('sexo_id')->toArray();
        }
    }

    public function departamentos()
    {
        if (!$this->cohortePaisProyecto) {
            return collect([]);
        }

        $cohortePaisProyectoId = $this->cohortePaisProyecto->id;

        $records = \App\Models\Participante::query()
            ->leftJoin('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
            })
            ->when(!empty($this->selectedGruposIds), function ($query) {

                if (in_array(0, $this->selectedGruposIds)) {
                    return $query->where(function ($q) {
                        $q->whereDoesntHave('bancarizacionGrupos')
                            ->orWhereHas('bancarizacionGrupos', function ($q) {
                                $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', array_diff($this->selectedGruposIds, [0]));
                            });
                    });
                }

                return $query->whereHas('bancarizacionGrupos', function ($q) {
                    $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', $this->selectedGruposIds);
                });
            })
            ->when(!empty($this->selectedPerfilesIds), function ($query) {
                return $query->whereHas('cohortePaisProyecto', function ($q) {
                    $q->whereIn('cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', $this->selectedPerfilesIds);
                });
            })
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $cohortePaisProyectoId)
            ->whereIn("gestor_id", $this->getMisGestores())
            ->select('ciudad_id', DB::raw('COUNT(*) as count'))
            ->groupBy('ciudad_id')
            ->get();

            //dd($records);

        $departamentos = $records->map(function ($record) {

            $departamento = DB::table('ciudades')
                ->leftJoin('departamentos', 'ciudades.departamento_id', '=', 'departamentos.id')
                ->where('ciudades.id', $record->ciudad_id)
                ->groupBy('ciudades.departamento_id')
                ->first(['departamentos.nombre', 'departamentos.id']);

            return [
                'departamento_id' => $departamento->id,
                'nombre' => $departamento->nombre,
                'count' => $record->count,
            ];
        });

        $departamentos = $departamentos->groupBy('departamento_id')->map(function ($items) {
            return [
                'departamento_id' => $items->first()['departamento_id'],
                'nombre' => $items->first()['nombre'],
                'count' => $items->sum('count'),
            ];
        })->values();

        //dd($departamentos);

        return $departamentos;
    }

    public function municipios()
    {
        if (!$this->cohortePaisProyecto) {
            return collect([]);
        }

        $cohortePaisProyectoId = $this->cohortePaisProyecto->id;

        $records = \App\Models\Participante::query()
            ->leftJoin('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
            ->leftJoin('ciudades', 'participantes.ciudad_id', '=', 'ciudades.id')
            ->leftJoin('departamentos', 'ciudades.departamento_id', '=', 'departamentos.id')
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
            })
            ->when(!empty($this->selectedGruposIds), function ($query) {

                if (in_array(0, $this->selectedGruposIds)) {
                    return $query->where(function ($q) {
                        $q->whereDoesntHave('bancarizacionGrupos')
                            ->orWhereHas('bancarizacionGrupos', function ($q) {
                                $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', array_diff($this->selectedGruposIds, [0]));
                            });
                    });
                }

                return $query->whereHas('bancarizacionGrupos', function ($q) {
                    $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', $this->selectedGruposIds);
                });
            })
            ->when(!empty($this->selectedPerfilesIds), function ($query) {
                return $query->whereHas('cohortePaisProyecto', function ($q) {
                    $q->whereIn('cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', $this->selectedPerfilesIds);
                });
            })
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $cohortePaisProyectoId)
            ->whereIn("gestor_id", $this->getMisGestores())
            ->whereIn("ciudades.departamento_id", $this->selectedDepartamentosIds)
            ->select('ciudad_id', DB::raw('COUNT(*) as count'))
            ->groupBy('ciudad_id')
            ->get();

        $ciudades = $records->map(function ($record) {

            $ciudad = DB::table('ciudades')
                ->leftJoin('departamentos', 'ciudades.departamento_id', '=', 'departamentos.id')
                ->where('ciudades.id', $record->ciudad_id)
                ->first(['ciudades.nombre', 'ciudades.id']);

            return [
                'ciudad_id' => $ciudad->id,
                'nombre' => $ciudad->nombre,
                'count' => $record->count,
            ];
        });

        return $ciudades;
    }

    public function gestores()
    {
        if (!$this->cohortePaisProyecto) {
            return collect([]);
        }

        $cohortePaisProyectoId = $this->cohortePaisProyecto->id;

        $records = \App\Models\Participante::query()
            ->leftJoin('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
            })
            ->when(!empty($this->selectedGruposIds), function ($query) {

                if (in_array(0, $this->selectedGruposIds)) {
                    return $query->where(function ($q) {
                        $q->whereDoesntHave('bancarizacionGrupos')
                            ->orWhereHas('bancarizacionGrupos', function ($q) {
                                $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', array_diff($this->selectedGruposIds, [0]));
                            });
                    });
                }

                return $query->whereHas('bancarizacionGrupos', function ($q) {
                    $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', $this->selectedGruposIds);
                });
            })
            ->when(!empty($this->selectedPerfilesIds), function ($query) {
                return $query->whereHas('cohortePaisProyecto', function ($q) {
                    $q->whereIn('cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', $this->selectedPerfilesIds);
                });
            })
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $cohortePaisProyectoId)
            ->whereIn("gestor_id", $this->getMisGestores())
            ->select('gestor_id', DB::raw('COUNT(*) as count'))
            ->groupBy('gestor_id')
            ->get();

        $gestores = $records->map(function ($record) {

            $gestor = DB::table('users')
                ->where('id', $record->gestor_id)
                ->first(['name', 'id']);

            return [
                'gestor_id' => $gestor->id,
                'gestor' => $gestor->name,
                'count' => $record->count,
            ];
        });

        return $gestores;
    }

    public function sexos()
    {
        if (!$this->cohortePaisProyecto) {
            return collect([]);
        }

        $cohortePaisProyectoId = $this->cohortePaisProyecto->id;

        $records = \App\Models\Participante::query()
            ->leftJoin('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
            })
            ->when(!empty($this->selectedGruposIds), function ($query) {

                if (in_array(0, $this->selectedGruposIds)) {
                    return $query->where(function ($q) {
                        $q->whereDoesntHave('bancarizacionGrupos')
                            ->orWhereHas('bancarizacionGrupos', function ($q) {
                                $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', array_diff($this->selectedGruposIds, [0]));
                            });
                    });
                }

                return $query->whereHas('bancarizacionGrupos', function ($q) {
                    $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', $this->selectedGruposIds);
                });
            })
            ->when(!empty($this->selectedPerfilesIds), function ($query) {
                return $query->whereHas('cohortePaisProyecto', function ($q) {
                    $q->whereIn('cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', $this->selectedPerfilesIds);
                });
            })
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $cohortePaisProyectoId)
            ->whereIn("gestor_id", $this->getMisGestores())
            ->select('sexo', DB::raw('COUNT(*) as count'))
            ->groupBy('sexo')
            ->get();

        $sexos = $records->map(function ($record) {
            return [
                'sexo_id' => $record->sexo,
                'sexo' => $record->sexo == 1 ? 'Mujer' : 'Hombre',
                'count' => $record->count,
            ];
        });

        return $sexos;
    }

    public function perfiles()
    {

        if (!$this->cohortePaisProyecto) {
            return collect([]);
        }

        $cohortePaisProyectoId = $this->cohortePaisProyecto->id;

        $records = \App\Models\Participante::whereHas('lastEstado', function ($q) {
            $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
        })
            ->leftJoin('cohorte_participante_proyecto', 'participantes.id', '=', 'cohorte_participante_proyecto.participante_id')
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $cohortePaisProyectoId)
            ->when(!empty($this->selectedSexosIds), function ($query) {
                return $query->whereIn('sexo', $this->selectedSexosIds);
            })
            ->when(!empty($this->selectedGruposIds), function ($query) {

                if (in_array(0, $this->selectedGruposIds)) {
                    return $query->where(function ($q) {
                        $q->whereDoesntHave('bancarizacionGrupos')
                            ->orWhereHas('bancarizacionGrupos', function ($q) {
                                $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', array_diff($this->selectedGruposIds, [0]));
                            });
                    });
                }

                return $query->whereHas('bancarizacionGrupos', function ($q) {
                    $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', $this->selectedGruposIds);
                });
            })
            ->whereIn("gestor_id", $this->getMisGestores())
            ->select('cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', DB::raw('COUNT(*) as count'))
            ->groupBy('cohorte_pais_proyecto_perfil_id')
            ->get();

           // dd($records);

        $perfiles = $records->map(function ($record) {
            $perfil = DB::table('cohorte_pais_proyecto_perfil')
                ->leftJoin('perfiles_participantes', 'cohorte_pais_proyecto_perfil.perfil_participante_id', '=', 'perfiles_participantes.id')
                ->where('cohorte_pais_proyecto_perfil.id', $record->cohorte_pais_proyecto_perfil_id)
                ->first(['perfiles_participantes.nombre']);

            return [
                'perfil_id' => $record->cohorte_pais_proyecto_perfil_id,
                'nombre' => $perfil->nombre,
                'count' => $record->count,
            ];
        });



        return $perfiles;
    }


    public function estados()
    {
        $subquery = EstadoRegistroParticipante::select('participante_id', DB::raw('MAX(estado_registro_participante.id) as last_id'))
            ->join('participantes', 'estado_registro_participante.participante_id', '=', 'participantes.id')
            ->where('participantes.gestor_id', auth()->id())
            ->whereNull('participantes.deleted_at')
            ->groupBy('participante_id');

        $estados = EstadoRegistroParticipante::query()
            ->joinSub($subquery, 'last_erp', function ($join) {
                $join->on('estado_registro_participante.id', '=', 'last_erp.last_id');
            })
            ->join('estado_registros as er', 'estado_registro_participante.estado_registro_id', '=', 'er.id')
            ->select('er.id', 'er.nombre', 'er.color', DB::raw('COUNT(estado_registro_participante.participante_id) as total'))
            ->groupBy('er.id', 'er.nombre', 'er.color')
            ->orderBy('er.id')
            ->get();

        return $estados;
    }

    public function initSelectedPerfilesIds()
    {
        if (empty($this->selectedPerfilesIds)) {
            $this->selectedPerfilesIds = $this->perfiles()->pluck('perfil_id')->toArray();
        }
    }

    public function initSelectedEstadosIds()
    {
        if (empty($this->selectedEstadosIds)) {
            $this->selectedEstadosIds = $this->estados()->pluck('id')->toArray();
        }
    }

    public function initRange()
    {
        if ($this->range !== Range::Custom) {
            $this->start = null;
            $this->end = null;
        }
    }

    public function apply($query)
    {
        //$query = $this->applyEstado($query);
        //$query = $this->applyStatusCards($query);

        $query = $this->applyPerfiles($query);

        $query = $this->applyRange($query);

        $query = $this->applySexos($query);

        $query = $this->applyGrupos($query);

        $query = $this->applyGestores($query);

        $query = $this->applyMunicipios($query);

        return $query;
    }

    public function applyGrupos($query)
    {

        if (count($this->selectedGruposIds) === 1 && $this->selectedGruposIds[0] == 0) {
            return $query->whereDoesntHave('bancarizacionGrupos')
                ->orWhereHas('bancarizacionGrupos', function ($q) {
                    $q->whereNotNull('bancarizacion_grupo_participantes.deleted_at');
                });
        }


        if (empty($this->selectedGruposIds)) {
            return $query;
        }


        if (in_array(0, $this->selectedGruposIds)) {
            return $query->where(function ($q) {
                $q->whereDoesntHave('bancarizacionGrupos')
                    ->orWhereHas('bancarizacionGrupos', function ($q) {
                        $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', array_diff($this->selectedGruposIds, [0]));
                    });
            });
        }

        return $query->whereHas('bancarizacionGrupos', function ($q) {
            //dd($this->selectedGruposIds);
            $q->whereIn('bancarizacion_grupo_participantes.bancarizacion_grupo_id', $this->selectedGruposIds);
        });
    }


    public function applySexos($query)
    {

        if (empty($this->selectedSexosIds)) {
            return $query->where('sexo', -5);
        }

        return $query->whereIn('sexo', $this->selectedSexosIds);
    }

    public function applyMunicipios($query)
    {

        if (empty($this->selectedMunicipiosIds)) {
            return $query->where('ciudad_id', -5);
        }

        return $query->whereIn('ciudad_id', $this->selectedMunicipiosIds);
    }

    public function applyGestores($query)
    {

        if (empty($this->selectedGestoresIds)) {
            return $query->where('gestor_id', -5);
        }

        return $query->whereIn('gestor_id', $this->selectedGestoresIds);
    }


    public function applyPerfiles($query)
    {

        if (empty($this->selectedPerfilesIds)) {
            return $query->whereHas('cohortePaisProyecto', function ($q) {
                $q->whereIn('cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', [-1]);
            });
            // return $query;
        }

        return $query->whereHas('cohortePaisProyecto', function ($q) {
            $q->whereIn('cohorte_participante_proyecto.cohorte_pais_proyecto_perfil_id', $this->selectedPerfilesIds);
        });
    }

    public function applyRange($query)
    {
        //dump($this->range);
        if ($this->range === Range::All_Time) {
            //  dump('All_Time');
            return $query;
        }

        if ($this->range === Range::Custom) {
            $start = Carbon::createFromFormat('Y-m-d', $this->start)->startOfDay();
            $end = Carbon::createFromFormat('Y-m-d', $this->end)->endOfDay();

            //return $query->whereBetween(DB::raw('CONVERT_TZ(created_at, "+00:00", "-06:00")'), [$start, $end]);

            return $query->whereBetween('created_at', [$start, $end]);
        }

        return $query->whereBetween('created_at', $this->range->dates());
    }
}
