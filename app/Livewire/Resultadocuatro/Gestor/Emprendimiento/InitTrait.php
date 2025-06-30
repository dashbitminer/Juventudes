<?php

namespace App\Livewire\Resultadocuatro\Gestor\Emprendimiento;

trait InitTrait
{
    public function getData()
    {
        $mediosVida = $this->pais->mediosVida()
            ->whereNotNull("medio_vidas.active_at")
            ->pluck("medio_vidas.nombre", "medio_vidas.id");

        $rubros = $this->pais->rubroEmprendimiento()
            ->whereNotNull("rubro_emprendimientos.active_at")
            ->pluck("rubro_emprendimientos.nombre", "rubro_emprendimientos.id");

        $etapas = $this->pais->etapaEmprendimiento()
            ->whereNotNull("etapa_emprendimientos.active_at")
            ->pluck("etapa_emprendimientos.nombre", "etapa_emprendimientos.id");

        $tiene_capital_semilla = collect(['No', 'Si']);

        $capitalSemillas = $this->pais->capitalSemilla()
            ->whereNotNull("capital_semillas.active_at")
            ->pluck("capital_semillas.nombre", "capital_semillas.id");

        $tiene_red_emprendimiento = collect(['No', 'Si']);

        $mediosVerificacion = $this->pais->medioVerificacionEmprendimiento()
            ->whereNotNull("medio_verificacion_emprendimientos.active_at")
            ->pluck("medio_verificacion_emprendimientos.nombre", "medio_verificacion_emprendimientos.id");

        $ingresosPromedios = $this->pais->ingresosPromedio()
            ->whereNotNull("ingresos_promedios.active_at")
            ->pluck("ingresos_promedios.nombre", "ingresos_promedios.id");

        return [
            'medios_vida' => $mediosVida,
            'rubros' => $rubros,
            'etapas' => $etapas,
            'tiene_capital_semilla' => $tiene_capital_semilla,
            'capital_semillas' => $capitalSemillas,
            'tiene_red_emprendimiento' => $tiene_red_emprendimiento,
            'medios_verificacion' => $mediosVerificacion,
            'ingresos_promedios' => $ingresosPromedios,
        ];
    }
}
