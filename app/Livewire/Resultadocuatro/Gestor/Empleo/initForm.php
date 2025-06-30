<?php

namespace App\Livewire\Resultadocuatro\Gestor\Empleo;

use App\Models\Directorio;

trait initForm {
    public function getData()
    {
        $directorio = Directorio::active()
            ->orderBy("nombre", "asc")
            ->where('pais_id', $this->pais->id)
            ->pluck('nombre', 'id');

        $mediosVida = $this->pais->mediosVida()
            ->whereNotNull("medio_vidas.active_at")
            ->pluck("medio_vidas.nombre", "medio_vidas.id");

        $sectores = $this->pais->sectorEmpresaOrganizacion()
            ->whereNotNull("sector_empresa_organizaciones.active_at")
            ->pluck("sector_empresa_organizaciones.nombre", "sector_empresa_organizaciones.id");

        $empleos = $this->pais->tipoEmpleo()
            ->whereNotNull("tipo_empleos.active_at")
            ->pluck("tipo_empleos.nombre", "tipo_empleos.id");

        $salarios = $this->pais->salario()
            ->whereNotNull("salarios.active_at")
            ->pluck("salarios.nombre", "salarios.id");

        $mediosVerificacion = $this->pais->medioVerificacion()
            ->whereNotNull("medio_verificaciones.active_at")
            ->pluck("medio_verificaciones.nombre", "medio_verificaciones.id");

        return [
            'directorio' => $directorio,
            'medios_vida' => $mediosVida,
            'sectores' => $sectores,
            'empleos' => $empleos,
            'salarios' => $salarios,
            'medios_verificacion' => $mediosVerificacion,
        ];
    }
}
