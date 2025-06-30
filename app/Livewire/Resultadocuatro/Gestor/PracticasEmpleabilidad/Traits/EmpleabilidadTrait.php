<?php

namespace App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Traits;

use App\Models\Ciudad;
use App\Models\Directorio;

trait EmpleabilidadTrait
{
    public function initializeProperties()  {

        $motivoscambio = $this->pais->motivosCambio()->whereNotNull("motivos_cambio_organizacion.active_at")
            ->whereNotNull("pais_motivo_cambio_organizacion.active_at")
            ->select("motivos_cambio_organizacion.nombre", "motivos_cambio_organizacion.id", "pais_motivo_cambio_organizacion.id as pivotid")->get();

        $directorio = Directorio::where('pais_id', $this->pais->id)->orderBy("nombre", "asc")->active()->pluck('nombre', 'id');

        $departamentos = $this->pais->departamentos()->whereNotNull("departamentos.active_at")->pluck("departamentos.nombre", "departamentos.id");

        $serviciosDesarrollar = $this->pais->serviciosDesarrollar()->whereNotNull("servicios_desarrollar.active_at")
            ->whereNotNull("pais_servicio_desarrollar.active_at")
            ->select("servicios_desarrollar.nombre", "servicios_desarrollar.id", "pais_servicio_desarrollar.id as pivotid")->get();

        $habilidades = $this->pais->habilidades()->whereNotNull("habilidades_adquirir.active_at")
            ->whereNotNull("pais_habilidad_adquirir.active_at")
            ->select("habilidades_adquirir.nombre", "habilidades_adquirir.id", "pais_habilidad_adquirir.id as pivotid")->get();

        return [
            'motivoscambio' => $motivoscambio,
            'directorio'    => $directorio,
            'departamentos' => $departamentos,
            'serviciosDesarrollar' => $serviciosDesarrollar,
            'habilidades' => $habilidades,
            // 'areas' => $areas,
            // 'serviciosDesarrollar' => $serviciosDesarrollar,
            // 'mediosVerificacionVoluntario' => $mediosVerificacionVoluntario,
        ];
    }

    public function updated($property, $value)
    {
        if ($property == 'form.directorioSelected') {
            $this->form->setDirectorio($value);
        }

        //dd($property, $value);
    }

    public function updatedFormDepartamentoSelected()
    {
        $this->ciudades = [];
        if (!empty($this->form->departamentoSelected)) {
            $this->ciudades = Ciudad::where('departamento_id', $this->form->departamentoSelected)->orderBy('nombre', 'asc')->pluck('nombre', 'id');
        }
    }
}
