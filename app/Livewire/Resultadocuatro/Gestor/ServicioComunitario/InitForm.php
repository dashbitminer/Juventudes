<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario;

use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\TipoPoblacion;
use App\Models\CohortePaisProyecto;
use App\Models\Departamento;
use App\Models\GrupoParticipante;
use App\Models\PaisProyecto;
use App\Models\ServicioComunitarioHistorico;
use App\Models\SocioImplementador;

trait InitForm
{
    public $cohortePaisProyecto;

    public function getData():array
    {
        $socioImplementador = $this->getSocioImplementador();

        $departamentos = Departamento::active()
            ->where('pais_id', $this->pais->id)
            ->pluck("nombre", "id");

        $recursoPrevistos = $this->pais->recursoPrevisto()
            ->whereNotNull('recurso_previstos.active_at')
            ->pluck('recurso_previstos.nombre', 'pais_recurso_previstos.id');

        $recursoPrevistosUsaid = $this->pais->recursoPrevistoUsaid()
            ->whereNotNull('usaid_recurso_previstos.active_at')
            ->pluck('usaid_recurso_previstos.nombre', 'pais_usaid_recurso_previstos.id');

        $recursoPrevistosCostShare = $this->pais->recursoPrevistoCostShare()
            ->whereNotNull('cs_recurso_previstos.active_at')
            ->pluck('cs_recurso_previstos.nombre', 'pais_cs_recurso_previstos.id');

        $recursoPrevistosLeverage = $this->pais->recursoPrevistoLeverage()
            ->whereNotNull('lev_recurso_previstos.active_at')
            ->pluck('lev_recurso_previstos.nombre', 'pais_lev_recurso_previstos.id');

        $pcjSostenibilidad = $this->pais->PcjSostenibilidad()
            ->whereNotNull('pcj_sostenibilidades.active_at')
            ->pluck('pcj_sostenibilidades.nombre', 'pais_pcj_sostenibilidades.id');

        $pcjAlcance = $this->pais->PcjAlcance()
            ->whereNotNull('pcj_alcances.active_at')
            ->pluck('pcj_alcances.nombre', 'pais_pcj_alcances.id');

        $pcjFortaleceArea = $this->pais->pcjFortaleceArea()
            ->whereNotNull('pcj_fortalece_areas.active_at')
            ->pluck('pcj_fortalece_areas.nombre', 'pais_pcj_fortalece_areas.id');

        $poblacionBeneficiada = $this->pais->poblacionBeneficiada()
            ->whereNotNull('poblacion_beneficiadas.active_at')
            ->pluck('poblacion_beneficiadas.nombre', 'pais_poblacion_beneficiadas.id');

        $tipoPoblacion = collect(TipoPoblacion::cases())->mapWithKeys(function($tipo) {
            return [$tipo->value => $tipo->label()];
        });

        $estados = collect(Estados::cases())->mapWithKeys(function($tipo) {
            return [$tipo->value => $tipo->label()];
        });

        return [
            'departamentos' => $departamentos,
            'recurso_previstos' => $recursoPrevistos,
            'recurso_previstos_usaid' => $recursoPrevistosUsaid,
            'recurso_previstos_cost_share' => $recursoPrevistosCostShare,
            'recurso_previstos_leverage' => $recursoPrevistosLeverage,
            'pcj_sostenibilidad' => $pcjSostenibilidad,
            'pcj_alcance' => $pcjAlcance,
            'pc_fortalece_area' => $pcjFortaleceArea,
            'poblacion_beneficiada' => $poblacionBeneficiada,
            'tipo_poblacion' => $tipoPoblacion,
            'estados' => $estados,
            'socioImplementador' => $socioImplementador,
        ];
    }

    public function getParticipantesData() {

        $this->paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();
        
        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $this->paisProyecto->id)
            ->firstOrFail();

        $grupos = GrupoParticipante::with('grupo:id,nombre,slug')
            ->join('grupos', 'grupo_participante.grupo_id', '=', 'grupos.id')
            ->whereHas('cohorteParticipanteProyecto', function($query){
                $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
            })
            ->where('user_id', auth()->id())
            ->groupBy('grupo_id')
            ->pluck("grupos.nombre", "grupo_participante.grupo_id");

        return [
            'grupos' => $grupos
        ];
    }

    public function getSocioImplementador(){
        $user = auth()->user()->load('socioImplementador');

        return $user->socioImplementador;
    }

    public function getHistoricoServicioComunitario($servicioComunitarioId)
    {
        return ServicioComunitarioHistorico::where('servicio_comunitario_id', $servicioComunitarioId)
            ->get();
    }

}
