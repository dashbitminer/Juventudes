<?php

namespace App\Livewire\Resultadocuatro\Gestor\Formacion\Traits;

use App\Models\Directorio;
use App\Models\TipoInstitucion;

trait FormacionTrait
{
    public function initializeProperties()  {

        $mediosvida = $this->pais->mediosVida()->whereNotNull("medio_vidas.active_at")
            ->whereNotNull("pais_medio_vidas.active_at")
            ->select("medio_vidas.nombre", "medio_vidas.id", "pais_medio_vidas.id as pivotid")->get();

        $directorio = Directorio::where('pais_id', $this->pais->id)->orderBy("nombre", "asc")->active()->pluck('nombre', 'id');

        $tipoEstudio = $this->pais->tipoEstudios()->whereNotNull("tipo_estudios.active_at")
            ->whereNotNull("pais_tipo_estudio.active_at")
            ->select("tipo_estudios.nombre", "tipo_estudios.id", "pais_tipo_estudio.id as pivotid")->get();


        $areas = $this->pais->areaFormaciones()->whereNotNull("area_formaciones.active_at")
            ->whereNotNull("pais_area_formaciones.active_at")
            ->select("area_formaciones.nombre", "area_formaciones.id", "pais_area_formaciones.id as pivotid")->get();


        $nivelEducativo = $this->pais->nivelEducativoFormaciones()->whereNotNull("nivel_educativo_formaciones.active_at")
            ->whereNotNull("pais_nivel_educativo_formaciones.active_at")
            ->select("nivel_educativo_formaciones.nombre", "nivel_educativo_formaciones.id", "pais_nivel_educativo_formaciones.id as pivotid")->get();

        $mediosVerificacion = $this->pais->medioVerificacionFormaciones()->whereNotNull("medio_verificacion_formaciones.active_at")
            ->whereNotNull("pais_medio_verificacion_formaciones.active_at")
            ->select("medio_verificacion_formaciones.nombre", "medio_verificacion_formaciones.id", "pais_medio_verificacion_formaciones.id as pivotid")->get();


        return [
            'mediosvida' => $mediosvida,
            'directorio' => $directorio,
            'tipoEstudio' => $tipoEstudio,
            'areas' => $areas,
            'nivelEducativo' => $nivelEducativo,
            'mediosVerificacion' => $mediosVerificacion,
            'tipomodalidades' => collect(["1" => "Virtual", "2" => "Presencial", "3" => "Virtual y presencial"]),
        ];
    }

    // public function updated($property, $value)
    // {
    //     if ($property === 'form.directorioSelected') {
    //         $this->form->setDirectorio($value);
    //     }
    // }


}
