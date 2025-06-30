<?php

namespace App\Livewire\Resultadotres\Gestor\Apalancamientos;

use App\Enums\RecursoTipoEspecie;
use App\Enums\TipoOrganizacion;
use App\Models\Ciudad;
use App\Models\FuenteRecurso;
use App\Models\OrigenEmpresaPrivada;
use App\Models\OrigenRecurso;
use App\Models\TamanoEmpresaPrivada;
use App\Models\TipoRecurso;
use App\Models\TipoSector;
use App\Models\TipoSectorAcademica;
use App\Models\TipoSectorComunitaria;
use App\Models\TipoSectorPrivado;
use App\Models\TipoSectorPublico;

trait InitializeApalancamientoForm
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

        $tipoRecurso =  TipoRecurso::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_tipo_recurso.pais_id', $this->pais->id);
            })
            ->pluck("nombre", "id");

        $origenRecurso =  OrigenRecurso::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_origen_recurso.pais_id', $this->pais->id);
            })
            ->pluck("nombre", "id");

        $fuenteRecurso =  FuenteRecurso::active()
            ->whereHas('pais', function($query) {
                $query->where('pais_fuente_recurso.pais_id', $this->pais->id);
            })
            ->pluck("nombre", "id");

        $modalidadEstrategiaAlianza = \App\Models\ModalidadEstrategiaAlianza::active()
            ->whereHas('pais', function($query) {
                $query->where('modalidad_estrategia_alianza_pais.pais_id', $this->pais->id)
                    ->whereNotNull('modalidad_estrategia_alianza_pais.active_at');
            })
            ->pluck("nombre", "id");

        $objetivoAsistenciaAlianza = \App\Models\ObjetivoAsistenciaAlianza::active()
            ->whereHas('pais', function($query) {
                $query->where('objetivo_asistencia_alianza_pais.pais_id', $this->pais->id);
            })
            ->pluck("nombre", "id");

        $tipoRecursoEspecie = collect(RecursoTipoEspecie::cases())->mapWithKeys(function($tipo) {
            return [$tipo->value => $tipo->label()];
        });

        return [
            'tipoOrganizaciones' => $tipoOrganizaciones,
            'tiposector' => $tiposector,
            'tipoSectorPublico' => $tipoSectorPublico,
            'tipoSectorPrivado' => $tipoSectorPrivado,
            'origenEmpresaPrivada' => $origenEmpresaPrivada,
            'tamanoEmpresaPrivada' => $tamanoEmpresaPrivada,
            'tipoSectorComunitaria' => $tipoSectorComunitaria,
            'tipoSectorAcademica' => $tipoSectorAcademica,
            'tipoRecurso' => $tipoRecurso,
            'origenRecurso' => $origenRecurso,
            'fuenteRecurso' => $fuenteRecurso,
            'tipoRecursoEspecie' => $tipoRecursoEspecie,
            'modalidadEstrategiaAlianza' => $modalidadEstrategiaAlianza,
            'objetivoAsistenciaAlianza' => $objetivoAsistenciaAlianza
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

        }
    }
}
