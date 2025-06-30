<?php

namespace App\Livewire\Resultadouno\Coordinador;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;

class Dashboard extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        $proyectos = User::where('users.id', auth()->user()->id)
            ->leftJoin('cohorte_proyecto_user', 'cohorte_proyecto_user.user_id', '=', 'users.id')
            ->whereNotNull('cohorte_proyecto_user.active_at')
            ->leftJoin('cohorte_pais_proyecto', 'cohorte_proyecto_user.cohorte_pais_proyecto_id', '=', 'cohorte_pais_proyecto.id')
            ->whereNotNull('cohorte_pais_proyecto.active_at')
            ->leftJoin('cohortes', 'cohortes.id', '=', 'cohorte_pais_proyecto.cohorte_id')
            ->leftJoin('pais_proyecto', 'pais_proyecto.id', '=', 'cohorte_pais_proyecto.pais_proyecto_id')
            ->leftJoin('pais_proyecto_socios', 'pais_proyecto_socios.pais_proyecto_id', '=', 'pais_proyecto.id')
            ->leftJoin('socios_implementadores', 'socios_implementadores.id', '=', 'pais_proyecto_socios.socio_implementador_id')
            ->leftJoin('proyectos', 'proyectos.id', '=', 'pais_proyecto.proyecto_id')
            ->leftJoin('paises', 'paises.id', '=', 'pais_proyecto.pais_id')
            ->leftJoin('modalidades', 'modalidades.id', '=', 'pais_proyecto_socios.modalidad_id')
            ->groupBy('cohorte_pais_proyecto.id')
            ->select('proyectos.id as proyecto_id',
                'proyectos.nombre as proyecto_nombre',
                'cohortes.id as cohorte_id',
                'cohortes.slug as cohorte_slug',
                'cohortes.nombre as cohorte_nombre',
                'socios_implementadores.id as socio_id',
                'socios_implementadores.nombre as socio_nombre',
                'paises.id as pais_id', 'paises.nombre as pais_nombre',
                'pais_proyecto_socios.pais_proyecto_id',
                'pais_proyecto.active_at as proyecto_active_at',
                'paises.slug as pais_slug', 'proyectos.slug as proyecto_slug',
                'modalidades.id as modalidad_id', 'modalidades.nombre as modalidad_nombre')
            ->get();



        return view('livewire.resultadouno.coordinador.dashboard', [
            'proyectos' => $proyectos,
        ]);
    }
}
