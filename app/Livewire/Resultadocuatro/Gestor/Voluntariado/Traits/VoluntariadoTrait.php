<?php

namespace App\Livewire\Resultadocuatro\Gestor\Voluntariado\Traits;

use App\Models\Directorio;
use App\Models\TipoInstitucion;

trait VoluntariadoTrait
{
    public function initializeProperties()  {

        $mediosvida = $this->pais->mediosVida()->whereNotNull("medio_vidas.active_at")
            ->whereNotNull("pais_medio_vidas.active_at")
            ->select("medio_vidas.nombre", "medio_vidas.id", "pais_medio_vidas.id as pivotid")->get();

        $directorio = Directorio::where('pais_id', $this->pais->id)->orderBy("nombre", "asc")->active()->pluck('nombre', 'id');

        $vinculado = $this->pais->vinculado()->whereNotNull("vinculado_debido.active_at")
            ->whereNotNull("pais_vinculado_debido.active_at")
            ->select("vinculado_debido.nombre", "vinculado_debido.id", "pais_vinculado_debido.id as pivotid")->get();

        $areas = $this->pais->areaIntervenciones()->whereNotNull("area_intervenciones.active_at")
            ->whereNotNull("pais_area_intervenciones.active_at")
            ->select("area_intervenciones.nombre", "area_intervenciones.id", "pais_area_intervenciones.id as pivotid")->get();

        $serviciosDesarrollar = $this->pais->serviciosDesarrollar()->whereNotNull("servicios_desarrollar.active_at")
            ->whereNotNull("pais_servicio_desarrollar.active_at")
            ->select("servicios_desarrollar.nombre", "servicios_desarrollar.id", "pais_servicio_desarrollar.id as pivotid")->get();

        $mediosVerificacionVoluntario = $this->pais->mediosVerificacionVoluntario()->whereNotNull("medio_verificacion_voluntarios.active_at")
            ->whereNotNull("pais_medio_verificacion_voluntario.active_at")
            ->select("medio_verificacion_voluntarios.nombre", "medio_verificacion_voluntarios.id", "pais_medio_verificacion_voluntario.id as pivotid")->get();

        $tipoInstituciones = TipoInstitucion::active()->pluck('nombre', 'id');

        return [
            'mediosvida' => $mediosvida,
            'directorio' => $directorio,
            'vinculado' => $vinculado,
            'areas' => $areas,
            'serviciosDesarrollar' => $serviciosDesarrollar,
            'mediosVerificacionVoluntario' => $mediosVerificacionVoluntario,
            'tipoInstituciones' => $tipoInstituciones
        ];
    }

    public function updated($property, $value)
    {
       //dd($property);
        if ($property === 'form.directorioSelected') {
            $this->form->setDirectorio($value);
         //   $this->form->tipoInstitucionSelected = Directorio::find($this->form->directorioSelected)->tipo_institucion_id;
        }
    }


}
