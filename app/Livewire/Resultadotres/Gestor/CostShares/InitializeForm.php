<?php

namespace App\Livewire\Resultadotres\Gestor\CostShares;

use App\Enums\TipoOrganizacion;
use App\Models\Ciudad;
use App\Models\OrigenEmpresaPrivada;
use App\Models\TamanoEmpresaPrivada;
use App\Models\TipoSector;
use App\Models\TipoSectorAcademica;
use App\Models\TipoSectorComunitaria;
use App\Models\TipoSectorPrivado;
use App\Models\TipoSectorPublico;

trait InitializeForm
{
    public function initializeProperties(){

        $tipoOrganizaciones = collect(TipoOrganizacion::cases())
            ->mapWithKeys(function($tipo) {
            return [$tipo->value => $tipo->label()];
        });

        $tiposector = TipoSector::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_tipo_sector.pais_id', $this->pais->id);
            })
            ->pluck("nombre", "id");

        $tipoSectorPublico = TipoSectorPublico::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_tipo_sector_publico.pais_id', $this->pais->id);
            })
            ->pluck("nombre", "id");

        $tipoSectorPrivado = TipoSectorPrivado::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_tipo_sector_privado.pais_id', $this->pais->id);
            })
            ->select("id", \DB::raw("CONCAT(nombre, ' ', comentario) as nombre_comentario"))
            ->pluck("nombre_comentario", "id");

        $origenEmpresaPrivada = OrigenEmpresaPrivada::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_origen_empresa_privada.pais_id', $this->pais->id);
            })
            ->pluck("nombre", "id");

        $tamanoEmpresaPrivada = TamanoEmpresaPrivada::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_tamano_empresa_privada.pais_id', $this->pais->id);
            })
            ->select("id", \DB::raw("CONCAT(nombre, ' ', comentario) as nombre_comentario"))
            ->pluck("nombre_comentario", "id");

        $tipoSectorComunitaria = TipoSectorComunitaria::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_tipo_sector_comunitaria.pais_id', $this->pais->id);
            })
            ->pluck("nombre", "id");

        $tipoSectorAcademica = TipoSectorAcademica::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_tipo_sector_academica.pais_id', $this->pais->id);
            })
            ->pluck("nombre", "id");

        $categoria = $this->pais->costShareCategoria()
            ->whereNotNull('costshare_categorias.active_at')
            ->pluck('costshare_categorias.nombre', 'pais_costshare_categorias.id');

        $actividad = $this->pais->costShareActividad()
            ->whereNotNull('costshare_actividades.active_at')
            ->pluck('costshare_actividades.nombre', 'pais_costshare_actividades.id');

        $resultado = $this->pais->costShareResultado()
            ->whereNotNull('costshare_resultados.active_at')
            ->pluck('costshare_resultados.nombre', 'pais_costshare_resultados.id');

        $valoracion = $this->pais->costShareValoracion()
            ->whereNotNull('costshare_valoraciones.active_at')
            ->pluck('costshare_valoraciones.nombre', 'pais_costshare_valoraciones.id');


        return [
            'tipoOrganizaciones' => $tipoOrganizaciones,
            'tiposector' => $tiposector,
            'tipoSectorPublico' => $tipoSectorPublico,
            'tipoSectorPrivado' => $tipoSectorPrivado,
            'origenEmpresaPrivada' => $origenEmpresaPrivada,
            'tamanoEmpresaPrivada' => $tamanoEmpresaPrivada,
            'tipoSectorComunitaria' => $tipoSectorComunitaria,
            'tipoSectorAcademica' => $tipoSectorAcademica,
            'categorias' => $categoria,
            'actividades' => $actividad,
            'resultados' => $resultado,
            'valoraciones' => $valoracion
        ];
    }

    public function updated($property, $value) {

        if(str($property)->startsWith('form.departamentoSelected')) {
            $this->form->ciudades = Ciudad::active()->where('departamento_id', $value)
            ->pluck("nombre", "id");

        }elseif(str($property)->startsWith('form.coberturaSelected')) {

            $this->form->showCoberturaWarning = false;

            if(count($this->form->coberturaSelected) && $this->pais->id == \App\Models\Pais::GUATEMALA) {


                /**
                 * 7: Guatemala
                 * 8: Huehuetenango
                 * 13: Quetzaltenango
                 * 1: Alta Verapaz
                 */
                $areasGtCoberturas = [7,8,13,1];
                foreach ($this->form->coberturaSelected as $cobertura) {
                    if (!in_array($cobertura, $areasGtCoberturas)) {
                        $this->form->showCoberturaWarning = true;
                        break;
                    }
                }


            }

        }
        if (preg_match('/^form\.resultadoPorcentajes\.\d+$/', $property)) {
            if ($value < 0) {
                $this->form->resultadoPorcentajes[last(explode('.', $property))] = 0;
            }
        }

        if ($property === 'form.monto' && $value < 0) {
            $this->form->monto = 0;
        }
    }

    public function getSocioImplementador(){
        $user = auth()->user()->load('socioImplementador');

        return $user->socioImplementador;
    }
}
