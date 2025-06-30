<?php

namespace App\Livewire\Resultadotres\Gestor\Prealianzas\Actualizacion;

use App\Models\Pais;
use App\Models\PreAlianza;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;

class Page extends Component
{

    public Pais $pais;

    public Proyecto $proyecto;

    public PreAlianza $prealianza;

    public $nivel_inversion;
    public $tipo_actor;
    public $nivel_colaboracion;
    public $servicios_posibles;
    public $espera_de_alianza;
    public $aporte_espera_alianza;
    public $monto_esperado;
    public $impacto_pontencial;
    public $tipo_impacto_potencial;
    public $resultados_esperados;
    public $estado_alianza;
    public $anio_fiscal_firma;
    public $trimestre_aproximado_firma;
    public $proximos_pasos;
    public $observaciones;

    public $readonly = false;


    public function mount()
    {
        $this->nivel_inversion = $this->prealianza->nivel_inversion;
        $this->tipo_actor = $this->prealianza->tipo_actor;
        $this->nivel_colaboracion = $this->prealianza->nivel_colaboracion;
        $this->servicios_posibles = $this->prealianza->servicios_posibles;
        $this->espera_de_alianza = $this->prealianza->espera_de_alianza;
        $this->aporte_espera_alianza = $this->prealianza->aporte_espera_alianza;
        $this->monto_esperado = $this->prealianza->monto_esperado;
        $this->impacto_pontencial = $this->prealianza->impacto_pontencial;
        $this->tipo_impacto_potencial = $this->prealianza->tipo_impacto_potencial;
        $this->resultados_esperados = $this->prealianza->resultados_esperados;
        $this->estado_alianza = $this->prealianza->estado_alianza;
        $this->anio_fiscal_firma = $this->prealianza->anio_fiscal_firma;
        $this->trimestre_aproximado_firma = $this->prealianza->trimestre_aproximado_firma;
        $this->proximos_pasos = $this->prealianza->proximos_pasos;
        $this->observaciones = $this->prealianza->observaciones;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadotres.gestor.prealianzas.actualizacion.page');
    }
}
