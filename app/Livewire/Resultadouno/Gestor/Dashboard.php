<?php

namespace App\Livewire\Resultadouno\Gestor;

use App\Models\CohorteProyectoUser;
use App\Models\PaisProyecto;
use App\Models\PeriodoProyectoUser;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        $periodo_proyectos = null;

        if(auth()->user()->can('Ver participantes mi socio implementador R4')) { /// STAFF
//dd("1");
            $misocio = auth()->user()->socio_implementador_id;

            $proyectos = User::where('socio_implementador_id', $misocio)
                ->join('grupo_participante', 'users.id', '=', 'grupo_participante.user_id')
                ->join('cohorte_participante_proyecto', 'grupo_participante.cohorte_participante_proyecto_id', '=', 'cohorte_participante_proyecto.id')
                ->join('cohorte_pais_proyecto', 'cohorte_participante_proyecto.cohorte_pais_proyecto_id', '=', 'cohorte_pais_proyecto.id')
                ->join('pais_proyecto', 'pais_proyecto.id', '=', 'cohorte_pais_proyecto.pais_proyecto_id')
                ->join('paises', 'pais_proyecto.pais_id', '=', 'paises.id')
                ->join('proyectos', 'pais_proyecto.proyecto_id', '=', 'proyectos.id')
                ->join('cohortes', 'cohorte_pais_proyecto.cohorte_id', '=', 'cohortes.id')
                ->select(
                    'cohorte_pais_proyecto.id as cohorte_pais_proyecto_id',
                    'proyectos.nombre as proyecto_nombre',
                    'paises.nombre as pais_nombre',
                    'proyectos.slug as proyecto_slug',
                    'paises.slug as pais_slug',
                    'cohortes.slug as cohorte_slug'
                )
                ->groupBy('pais_proyecto.id')
                ->get();

            foreach ($proyectos as $proyecto) {
                $proyecto->grupo_count = \DB::table('cohorte_participante_proyecto')
                    ->join('cohorte_pais_proyecto', 'cohorte_pais_proyecto.id', '=', 'cohorte_participante_proyecto.cohorte_pais_proyecto_id')
                    ->join('grupo_participante', 'cohorte_participante_proyecto.id', '=', 'grupo_participante.cohorte_participante_proyecto_id')
                    ->where('grupo_participante.user_id', auth()->user()->id)
                    ->where("cohorte_participante_proyecto.cohorte_pais_proyecto_id", $proyecto->cohorte_pais_proyecto_id)
                    ->distinct()
                    ->count('grupo_participante.grupo_id');
            }


        } elseif(auth()->user()->can('Filtrar registros por socios por pais')) {
          //  dd("2");
            $mipais = auth()->user()->socioImplementador->pais_id;

            $proyectos = User::whereHas('socioImplementador', function ($query) use ($mipais) {
                $query->where('pais_id', $mipais);
            })
            ->join('grupo_participante', 'users.id', '=', 'grupo_participante.user_id')
            ->join('cohorte_participante_proyecto', 'grupo_participante.cohorte_participante_proyecto_id', '=', 'cohorte_participante_proyecto.id')
            ->join('cohorte_pais_proyecto', 'cohorte_participante_proyecto.cohorte_pais_proyecto_id', '=', 'cohorte_pais_proyecto.id')
            ->join('pais_proyecto', 'pais_proyecto.id', '=', 'cohorte_pais_proyecto.pais_proyecto_id')
            ->join('paises', 'pais_proyecto.pais_id', '=', 'paises.id')
            ->join('proyectos', 'pais_proyecto.proyecto_id', '=', 'proyectos.id')
            ->join('cohortes', 'cohorte_pais_proyecto.cohorte_id', '=', 'cohortes.id')
            ->select(
                'cohorte_pais_proyecto.id as cohorte_pais_proyecto_id',
                'proyectos.nombre as proyecto_nombre',
                'paises.nombre as pais_nombre',
                'proyectos.slug as proyecto_slug',
                'paises.slug as pais_slug',
                'cohortes.slug as cohorte_slug'
            )
            ->groupBy('pais_proyecto.id')
            ->get();
// dd($proyectos);
            foreach ($proyectos as $proyecto) {
                $proyecto->grupo_count = \DB::table('cohorte_participante_proyecto')
                    ->join('cohorte_pais_proyecto', 'cohorte_pais_proyecto.id', '=', 'cohorte_participante_proyecto.cohorte_pais_proyecto_id')
                    ->join('grupo_participante', 'cohorte_participante_proyecto.id', '=', 'grupo_participante.cohorte_participante_proyecto_id')
                    ->where('grupo_participante.user_id', auth()->user()->id)
                    ->where("cohorte_participante_proyecto.cohorte_pais_proyecto_id", $proyecto->cohorte_pais_proyecto_id)
                    ->distinct()
                    ->count('grupo_participante.grupo_id');
            }


        }
        else{ // auth()->user()->can('Ver mis participantes R4')

            $proyectos = [];
            $user = User::find(auth()->user()->id);

            if(auth()->user()->hasRole('Validación R4')){

                $proyectos = DB::table('cohorte_proyecto_user')
                    ->join('cohorte_pais_proyecto', 'cohorte_pais_proyecto.id', '=', 'cohorte_proyecto_user.cohorte_pais_proyecto_id')
                    ->join(
                        "pais_proyecto",
                        "pais_proyecto.id",
                        "=",
                        "cohorte_pais_proyecto.pais_proyecto_id"
                    )
                    ->join("paises", "pais_proyecto.pais_id", "=", "paises.id")
                    ->join("proyectos", "pais_proyecto.proyecto_id", "=", "proyectos.id")
                    ->join("cohortes", "cohorte_pais_proyecto.cohorte_id", "=", "cohortes.id")
                    ->where('cohorte_proyecto_user.user_id', $user->id)
                    ->select(
                        "cohorte_pais_proyecto.id as cohorte_pais_proyecto_id",
                        "proyectos.nombre as proyecto_nombre",
                        "paises.nombre as pais_nombre",
                        "cohortes.nombre as cohorte_nombre",
                        "proyectos.slug as proyecto_slug",
                        "paises.slug as pais_slug",
                        "cohortes.slug as cohorte_slug"
                    )
                    ->groupBy("cohorte_pais_proyecto.id")
                    ->get();
            }else{
                //dd("3");
                $proyectos = $user
                    ->cohorte()
                    ->join(
                        "pais_proyecto",
                        "pais_proyecto.id",
                        "=",
                        "cohorte_pais_proyecto.pais_proyecto_id"
                    )
                    ->join("paises", "pais_proyecto.pais_id", "=", "paises.id")
                    ->join("proyectos", "pais_proyecto.proyecto_id", "=", "proyectos.id")
                    ->join("cohortes", "cohorte_pais_proyecto.cohorte_id", "=", "cohortes.id")
                    ->select(
                        "cohorte_pais_proyecto.id as cohorte_pais_proyecto_id",
                        "proyectos.nombre as proyecto_nombre",
                        "paises.nombre as pais_nombre",
                        "cohortes.nombre as cohorte_nombre",
                        "proyectos.slug as proyecto_slug",
                        "paises.slug as pais_slug",
                        "cohortes.slug as cohorte_slug"
                    )
                    ->groupBy("cohorte_pais_proyecto.id")
                    ->get();

            }

            foreach ($proyectos as $proyecto) {
                $proyecto->grupo_count = \DB::table("cohorte_participante_proyecto")
                    ->join(
                    "cohorte_pais_proyecto",
                    "cohorte_pais_proyecto.id",
                    "=",
                    "cohorte_participante_proyecto.cohorte_pais_proyecto_id"
                    )
                    ->join(
                    "grupo_participante",
                    "cohorte_participante_proyecto.id",
                    "=",
                    "grupo_participante.cohorte_participante_proyecto_id"
                    )
                ->whereNull('grupo_participante.deleted_at')
                ->where("grupo_participante.user_id", auth()->user()->id)
                ->where("cohorte_participante_proyecto.cohorte_pais_proyecto_id", $proyecto->cohorte_pais_proyecto_id)
                ->distinct()
                ->count("grupo_participante.grupo_id");
            }
        }

        if(auth()->user()->can('Ver Visualizador R3' ) ||
            auth()->user()->can('Ver Resultado R3')){


            if(auth()->user()->hasRole('Validación R3') ||
                auth()->user()->hasRole('Registro R3')){ /// V


                $proyectos = [];
                $periodo_proyectos = DB::table('periodo_proyecto_user')
                ->join('pais_proyecto', 'periodo_proyecto_user.pais_proyecto_id', '=', 'pais_proyecto.id')
                ->join("paises", "pais_proyecto.pais_id", "=", "paises.id")
                ->join("proyectos", "pais_proyecto.proyecto_id", "=", "proyectos.id")
                ->where('user_id', auth()->user()->id)
                ->select(
                    "proyectos.nombre as proyecto_nombre",
                    "paises.nombre as pais_nombre",
                    "proyectos.slug as proyecto_slug",
                    "paises.slug as pais_slug"
                )
                ->get();


               // dd("periodo_proyectos", $periodo_proyectos);


            }else if(auth()->user()->hasRole('Staff')){

                $periodo_proyectos = $proyectos;

            }else if(auth()->user()->hasRole('MECLA')){

                // $proyectos =  auth()->user()
                //     ->cohorte()
                //     ->join(
                //         "pais_proyecto",
                //         "pais_proyecto.id",
                //         "=",
                //         "cohorte_pais_proyecto.pais_proyecto_id"
                //     )
                //     ->join("paises", "pais_proyecto.pais_id", "=", "paises.id")
                //     ->join("proyectos", "pais_proyecto.proyecto_id", "=", "proyectos.id")
                //     ->join("cohortes", "cohorte_pais_proyecto.cohorte_id", "=", "cohortes.id")
                //     ->select(
                //         "cohorte_pais_proyecto.id as cohorte_pais_proyecto_id",
                //         "proyectos.nombre as proyecto_nombre",
                //         "paises.nombre as pais_nombre",
                //         "cohortes.nombre as cohorte_nombre",
                //         "proyectos.slug as proyecto_slug",
                //         "paises.slug as pais_slug",
                //         "cohortes.slug as cohorte_slug"
                //     )
                //     ->groupBy("cohorte_pais_proyecto.id")
                //     ->get();


                $mipais = auth()->user()->socioImplementador->pais_id;

                $proyectos =  \App\Models\CohortePaisProyecto::join(
                        "pais_proyecto",
                        "pais_proyecto.id",
                        "=",
                        "cohorte_pais_proyecto.pais_proyecto_id"
                    )
                    ->join("paises", "pais_proyecto.pais_id", "=", "paises.id")
                    ->join("proyectos", "pais_proyecto.proyecto_id", "=", "proyectos.id")
                    ->join("cohortes", "cohorte_pais_proyecto.cohorte_id", "=", "cohortes.id")
                    ->where("paises.id", $mipais)
                    ->select(
                        "cohorte_pais_proyecto.id as cohorte_pais_proyecto_id",
                        "proyectos.nombre as proyecto_nombre",
                        "paises.nombre as pais_nombre",
                        "cohortes.nombre as cohorte_nombre",
                        "proyectos.slug as proyecto_slug",
                        "paises.slug as pais_slug",
                        "cohortes.slug as cohorte_slug"
                    )
                    ->groupBy("cohorte_pais_proyecto.id")
                    ->get();

                

                $periodo_proyectos = PaisProyecto::join('paises', 'pais_proyecto.pais_id', '=', 'paises.id')
                    ->join('proyectos', 'pais_proyecto.proyecto_id', '=', 'proyectos.id')
                    ->where('paises.id', $mipais)
                    ->select(
                        "proyectos.nombre as proyecto_nombre",
                        "paises.nombre as pais_nombre",
                        "proyectos.slug as proyecto_slug",
                        "paises.slug as pais_slug"
                    )
                    ->get();
            }
        }


        if(auth()->user()->hasRole("Financiero")){

            $proyectos = CohorteProyectoUser::with([
                "cohortePaisProyecto.paisProyecto"
                ])
                ->whereHas('cohortePaisProyecto', function ($query) {
                    $query->whereNotNull('active_at');
                })
                ->where("user_id", auth()->id())
                ->get();

            $periodo_proyectos = [];

        }

     // dd($proyectos, auth()->user()->id);

        return view('livewire.resultadouno.gestor.dashboard', [
            'proyectos' => $proyectos,
            'periodo_proyectos' => $periodo_proyectos
        ]);
    }
}
