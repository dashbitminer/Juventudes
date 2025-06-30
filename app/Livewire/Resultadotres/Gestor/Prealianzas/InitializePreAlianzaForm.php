<?php

namespace App\Livewire\Resultadotres\Gestor\Prealianzas;


use App\Models\Ciudad;
use Illuminate\Support\Facades\DB;



trait InitializePreAlianzaForm
{


    public function initializeProperties()  {


       // $tiposector = $this->pais->tiposector()->whereNotNull('active_at')->select("nombre", "id");

       $tiposector = $this->pais->tipoSector()->whereNotNull("tipo_sectores.active_at")->select("tipo_sectores.nombre", "tipo_sectores.id", "pais_tipo_sector.id as pivotid")->get();

       $tipoSectorPublico = $this->pais->tipoSectorPublico()->whereNotNull("tipo_sector_publicos.active_at")->select("tipo_sector_publicos.nombre", "tipo_sector_publicos.id", "pais_tipo_sector_publico.id as pivotid")->get();

       $tipoSectorPrivado = $this->pais->tipoSectorPrivado()->whereNotNull("tipo_sector_privados.active_at")->select("tipo_sector_privados.nombre", "tipo_sector_privados.id", "pais_tipo_sector_privado.id as pivotid")->get();

       $tamanoEmpresaPrivada = $this->pais->tamanoEmpresaPrivada()->whereNotNull("tamano_empresa_privadas.active_at")->select("tamano_empresa_privadas.nombre", "tamano_empresa_privadas.id", "pais_tamano_empresa_privada.id as pivotid")->get();

       $origenEmpresaPrivada = $this->pais->origenEmpresaPrivada()->whereNotNull("origen_empresa_privadas.active_at")->select("origen_empresa_privadas.nombre", "origen_empresa_privadas.id", "pais_origen_empresa_privada.id as pivotid")->get();

       $tipoSectorComunitaria = $this->pais->tipoSectorComunitaria()->whereNotNull("tipo_sector_comunitarias.active_at")->select("tipo_sector_comunitarias.nombre", "tipo_sector_comunitarias.id", "pais_tipo_sector_comunitaria.id as pivotid")->get();

       $tipoSectorAcademica = $this->pais->tipoSectorAcademica()->whereNotNull("tipo_sector_academicas.active_at")->select("tipo_sector_academicas.nombre", "tipo_sector_academicas.id", "pais_tipo_sector_academica.id as pivotid")->get();

       $tipoAlianza = $this->pais->tipoAlianza()->whereNotNull("tipo_alianzas.active_at")->select("tipo_alianzas.nombre", "tipo_alianzas.id", "pais_tipo_alianza.id as pivotid")->get();

      // dd($this->pais->load('tipoSectorComunitaria'));

    //    $tipoSectorComunitaria = $this->pais->tipoSectorComunitaria()->whereNotNull("tipo_sector_comunitarias.active_at")->select("tipo_sector_comunitarias.nombre", "tipo_sector_comunitarias.id", "pais_tipo_sector_comunitaria.id as pivotid")->get();

    //    $propositoAlianza = $this->pais->propositoAlianza()->whereNotNull("proposito_alianzas.active_at")->select("proposito_alianzas.nombre", "proposito_alianzas.id", "pais_proposito_alianza.id as pivotid")->get();

    //    $modalidadEstrategiaAlianza = $this->pais->modalidadEstrategiaAlianza()->whereNotNull("modalidad_estrategia_alianzas.active_at")->select("modalidad_estrategia_alianzas.nombre", "modalidad_estrategia_alianzas.id", "modalidad_estrategia_alianza_pais.id as pivotid")->get();

    //    $objetivoAsistenciaAlianza = $this->pais->objetivoAsistenciaAlianza()->whereNotNull("objetivo_asistencia_alianzas.active_at")->select("objetivo_asistencia_alianzas.nombre", "objetivo_asistencia_alianzas.id", "objetivo_asistencia_alianza_pais.id as pivotid")->get();

        $coberturaGeografica = $this->pais->coberturaGeografica()->whereNotNull("cobertura_geograficas.active_at")->select("cobertura_geograficas.nombre", "cobertura_geograficas.id", "pais_cobertura_geografica.id as pivotid")->get();

        $impactoPotencial = $this->pais->impactoPotencial()
            ->whereNotNull('impacto_potenciales.active_at')
            ->pluck('impacto_potenciales.nombre', 'pais_impacto_potenciales.id');

        return [
            'tiposector' => $tiposector,
            'tipoSectorPublico' => $tipoSectorPublico,
            'tipoSectorPrivado' => $tipoSectorPrivado,
            'tamanoEmpresaPrivada' => $tamanoEmpresaPrivada,
            'origenEmpresaPrivada' => $origenEmpresaPrivada,
            'tipoSectorComunitaria' => $tipoSectorComunitaria,
            'tipoSectorAcademica' => $tipoSectorAcademica,
            'tipoAlianza' => $tipoAlianza,
            // 'propositoAlianza' => $propositoAlianza,
            // 'modalidadEstrategiaAlianza' => $modalidadEstrategiaAlianza,
            // 'objetivoAsistenciaAlianza' => $objetivoAsistenciaAlianza,
            'coberturaGeografica' => $coberturaGeografica,
            'impactoPotenciales' => $impactoPotencial
        ];
    }

    public function updated($property, $value) {

        //dd($property, $value);

        if(str($property)->startsWith('form.departamentoSelected')) {
            $this->form->ciudades = Ciudad::active()->where('departamento_id', $value)->pluck("nombre", "id");
        }elseif(str($property)->startsWith('form.coberturaSelected')) {

            $this->form->showCoberturaWarning = false;

            if(count($this->form->coberturaSelected)) {


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



        if ($property === 'form.nivel_inversion' && $value < 0) {
            $this->form->nivel_inversion = 0;
        }

        if ($property === 'form.impacto_pontencial' && $value < 0) {
            $this->form->impacto_pontencial = 0;
        }

        if ($property === 'form.monto_esperado' && $value < 0) {
            $this->form->monto_esperado = 0;
        }


    }



}
