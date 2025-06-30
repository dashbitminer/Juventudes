<?php

namespace App\Livewire\Resultadotres\Gestor\Alianzas;


use App\Models\Ciudad;
use App\Models\OrganizacionAlianza;
use App\Models\PaisOrganizacionAlianza;
use App\Models\PreAlianza;
use Illuminate\Support\Facades\DB;



trait InitializeAlianzaForm
{
    public function initializeProperties()  {


        $tiposector = $this->pais->tipoSector()->whereNotNull("tipo_sectores.active_at")->select("tipo_sectores.nombre", "tipo_sectores.id", "pais_tipo_sector.id as pivotid")->get();

        $tipoSectorPublico = $this->pais->tipoSectorPublico()->whereNotNull("tipo_sector_publicos.active_at")->select("tipo_sector_publicos.nombre", "tipo_sector_publicos.id", "pais_tipo_sector_publico.id as pivotid")->get();

        $tipoSectorPrivado = $this->pais->tipoSectorPrivado()->whereNotNull("tipo_sector_privados.active_at")->select("tipo_sector_privados.nombre", "tipo_sector_privados.id", "pais_tipo_sector_privado.id as pivotid")->get();

        $tamanoEmpresaPrivada = $this->pais->tamanoEmpresaPrivada()->whereNotNull("tamano_empresa_privadas.active_at")->select("tamano_empresa_privadas.nombre", "tamano_empresa_privadas.id", "pais_tamano_empresa_privada.id as pivotid")->get();

        $origenEmpresaPrivada = $this->pais->origenEmpresaPrivada()->whereNotNull("origen_empresa_privadas.active_at")->select("origen_empresa_privadas.nombre", "origen_empresa_privadas.id", "pais_origen_empresa_privada.id as pivotid")->get();

        $tipoSectorComunitaria = $this->pais->tipoSectorComunitaria()->whereNotNull("tipo_sector_comunitarias.active_at")->select("tipo_sector_comunitarias.nombre", "tipo_sector_comunitarias.id", "pais_tipo_sector_comunitaria.id as pivotid")->get();

        $tipoSectorAcademica = $this->pais->tipoSectorAcademica()->whereNotNull("tipo_sector_academicas.active_at")->select("tipo_sector_academicas.nombre", "tipo_sector_academicas.id", "pais_tipo_sector_academica.id as pivotid")->get();

        $tipoAlianza = $this->pais->tipoAlianza()->whereNotNull("tipo_alianzas.active_at")->select("tipo_alianzas.nombre", "tipo_alianzas.id", "pais_tipo_alianza.id as pivotid")->get();

        $propositoAlianza = $this->pais->propositoAlianza()->whereNotNull("proposito_alianzas.active_at")->select("proposito_alianzas.nombre", "proposito_alianzas.id", "pais_proposito_alianza.id as pivotid")->get();

        $modalidadEstrategiaAlianza = $this->pais->modalidadEstrategiaAlianza()->whereNotNull("modalidad_estrategia_alianzas.active_at")->select("modalidad_estrategia_alianzas.nombre", "modalidad_estrategia_alianzas.id", "modalidad_estrategia_alianza_pais.id as pivotid")->get();

        $objetivoAsistenciaAlianza = $this->pais->objetivoAsistenciaAlianza()->whereNotNull("objetivo_asistencia_alianzas.active_at")->select("objetivo_asistencia_alianzas.nombre", "objetivo_asistencia_alianzas.id", "objetivo_asistencia_alianza_pais.id as pivotid")->get();

        // $tipoAlianza = \App\Models\TipoAlianza::active()
        //         ->whereHas('pais', function($query) {
        //             $query->where('pais_tipo_alianza.pais_id', $this->pais->id);
        //         })
        //         ->pluck("nombre", "id");

        // $propositoAlianza = \App\Models\PropositoAlianza::active()
        //         ->whereHas('pais', function($query) {
        //             $query->where('pais_proposito_alianza.pais_id', $this->pais->id);
        //         })
        //         ->pluck("nombre", "id");

        // $modalidadEstrategiaAlianza = \App\Models\ModalidadEstrategiaAlianza::active()
        //         ->whereHas('pais', function($query) {
        //             $query->where('modalidad_estrategia_alianza_pais.pais_id', $this->pais->id)
        //                 ->whereNotNull('modalidad_estrategia_alianza_pais.active_at');
        //         })
        //         ->pluck("nombre", "id");

        // $objetivoAsistenciaAlianza = \App\Models\ObjetivoAsistenciaAlianza::active()
        //         ->whereHas('pais', function($query) {
        //             $query->where('objetivo_asistencia_alianza_pais.pais_id', $this->pais->id);
        //         })
        //         ->pluck("nombre", "id");


        return [
            'tiposector' => $tiposector,
            'tipoSectorPublico' => $tipoSectorPublico,
            'tipoSectorPrivado' => $tipoSectorPrivado,
            'tamanoEmpresaPrivada' => $tamanoEmpresaPrivada,
            'origenEmpresaPrivada' => $origenEmpresaPrivada,
            'tipoSectorComunitaria' => $tipoSectorComunitaria,
            'tipoSectorAcademica' => $tipoSectorAcademica,
            'tipoAlianza' => $tipoAlianza,
            'propositoAlianza' => $propositoAlianza,
            'modalidadEstrategiaAlianza' => $modalidadEstrategiaAlianza,
            'objetivoAsistenciaAlianza' => $objetivoAsistenciaAlianza,
            // 'subsectores' => [],
            // 'subsectoresSelected' => [],
            // 'sectorSelected' => null,
            // 'subsectorSelected' => null,
            // 'departamentoSelected' => null,
            // 'ciudadSelected' => null,
            // 'readonly' => false,
        ];
    }

    public function updated($property, $value) {


        if(str($property)->startsWith('form.departamentoSelected')) {
            $this->form->ciudades = Ciudad::active()->where('departamento_id', $value)->pluck("nombre", "id");
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

        }elseif(str($property)->startsWith('form.organizacionSelected')){
            $organizacion = PaisOrganizacionAlianza::with('organizacionAlianza')->find($value);

            $this->form->nombre_organizacion = $organizacion->organizacionAlianza->nombre;
            $this->form->nombre_contacto = $organizacion->nombre_contacto;
            $this->form->contacto_telefono = $organizacion->telefono;
            $this->form->contacto_email = $organizacion->email;
        }
    }

}
