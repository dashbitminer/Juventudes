<?php

namespace App\Livewire\Resultadocuatro\Gestor\Directorio;

use App\Models\Departamento;

trait initForm
{
    public function getData()
    {
        $instituciones = $this->pais->tipoInstituciones()
            ->whereNotNull('tipo_instituciones.active_at')
            ->pluck('tipo_instituciones.nombre', 'tipo_instituciones.id');

        $areas = $this->pais->areaIntervenciones()
            ->whereNotNull('area_intervenciones.active_at')
            ->pluck('area_intervenciones.nombre', 'area_intervenciones.id');

        $apoyos = $this->pais->tipoApoyo()
            ->whereNotNull('tipo_apoyos.active_at')
            ->pluck('tipo_apoyos.nombre', 'tipo_apoyos.id');

        $departamentos = Departamento::active()
            ->where('pais_id', $this->pais->id)
            ->pluck("nombre", "id");

        return [
            'instituciones' => $instituciones,
            'areas' => $areas,
            'apoyos' => $apoyos,
            'departamentos' => $departamentos,
        ];
    }
}
