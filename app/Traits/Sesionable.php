<?php

namespace App\Traits;

use App\Models\SesionTitulo;
use App\Models\SesionTipo;

trait Sesionable
{
    /**
     * Por defecto todos los titulos seran cerrados.
     */
    public function getTituloDeSesion($paisId, $morphId = null, $morphType = null): mixed {
        $tituloAbierto = SesionTitulo::CERRADO;

        $sesionTitulo = SesionTitulo::where('titleable_id', $morphId)
            ->where('titleable_type', $morphType)
            ->where('pais_id', $paisId)
            ->first();

        if (!empty($sesionTitulo)) {
            $tituloAbierto = $sesionTitulo->titulo_abierto;
        }

        return $tituloAbierto;
    }

    /**
     * Por defecto todos son Sesiones Generales
     */
    public function getTipoDeSesion($paisId, $morphId = null, $morphType = null): mixed {
        $tipo = SesionTipo::SESION_GENERAL;

        $sesionTipo = SesionTipo::where('typesable_id', $morphId)
            ->where('typesable_type', $morphType)
            ->where('pais_id', $paisId)
            ->first();

        if (!empty($sesionTipo)) {
            $tipo = $sesionTipo->tipo;
        }

        return $tipo;
    }
}
