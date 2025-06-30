<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Forms;

use App\Models\Ciudad;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\Pais;
use App\Models\PaisProyecto;
use App\Models\Proyecto;
use App\Models\RecursoPrevisto;
use App\Models\RecursoPrevistoCostShare;
use App\Models\RecursoPrevistoLeverage;
use App\Models\ServicioComunitario;
use App\Models\ServicioComunitarioHistorico;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ServicioComunitarioForm extends Form
{

    public $showValidationErrorIndicator = false;

    public $showSuccessIndicator = false;

    public $readonly = false;

    public $ciudades;

    public Pais $pais;

    public ?ServicioComunitario $servicioComunitario;

    public $socioImplementador;

    public $personal_socio_seguimiento;

    public $nombre;

    public $total_jovenes;

    public $total_adultos_jovenes;

    public $departamento_id;

    public $ciudad_id;

    public $comunidad;

    public $descripcion;

    public $objetivos;

    public $riesgos_potenciales;

    public $describir_calificaciones;

    public $capacitacion;

    public $recursos_previstos;

    public $recursos_previstos_usaid;

    public $recursos_previstos_cost_share;

    public $recursos_previstos_leverage;

    public $recursos_previstos_especifique;

    public $monto_local;

    public $monto_dolar;

    public $fecha_entrega;

    public $proyeccion_pedagogica;

    public $retroalimentacion;

    public $sostenibilidad;

    public $alcance;

    public $area;

    public $poblacion_beneficiada;

    public $poblacion_directa = [];

    public $total_poblacion_directa;

    public $poblacion_indirecta = [];

    public $total_poblacion_indirecta;

    public $comunidad_colabora;

    public $gobierno_colabora;

    public $empresa_privada_colabora;

    public $organizaciones_juveniles_colabora;

    public $ong_colabora;

    public $posee_carta_entendimiento;

    public $estado;

    public $observaciones;

    public $apoyos_requeridos;

    public $progreso;

    public $nombre_reporta;

    public $cargo_reporta;

    public $fecha_elaboracion;

    public $nombre_valida;

    public $cargo_valida;

    public $fecha_valida;

    public $cohorte;

    public $proyecto;

    public $pais_proyecto;

    public $cohortePaisProyecto;

    public $cohorteStartDate;

    public $cohorteEndDate;

    public function setPais(Pais $pais) {
        $this->pais = $pais;
    }


    public function setCiudades($departamento_id)
    {
        $this->ciudades = Ciudad::active()
            ->where('departamento_id', $departamento_id)
            ->pluck("nombre", "id");
    }

    public function setCohorte(Cohorte $cohorte) : void{
        $this->cohorte = $cohorte;
    }

    public function setProyecto(Proyecto $proyecto) : void{
        $this->proyecto = $proyecto;
    }

    public function setCohortePaisProyecto(){
        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->firstOrFail();
        $this->cohorteEndDate = $this->cohortePaisProyecto->fecha_fin;
        $this->cohorteStartDate = $this->cohortePaisProyecto->fecha_inicio;
    }

    public function setSocioImplementador($socioImplementador) {
        $this->socioImplementador = $socioImplementador;
    }


    public function setServicioComunitario(ServicioComunitario $servicioComunitario)
    {
        $this->servicioComunitario = $servicioComunitario;

        $this->personal_socio_seguimiento = $this->servicioComunitario->personal_socio_seguimiento;
        $this->nombre = $this->servicioComunitario->nombre;
        $this->total_jovenes = $this->servicioComunitario->total_jovenes;
        $this->total_adultos_jovenes = $this->servicioComunitario->total_adultos_jovenes;
        $this->departamento_id = $this->servicioComunitario->departamento_id;
        $this->ciudad_id = $this->servicioComunitario->ciudad_id;
        $this->comunidad = $this->servicioComunitario->comunidad;
        $this->descripcion = $this->servicioComunitario->descripcion;
        $this->objetivos = $this->servicioComunitario->objetivos;
        $this->riesgos_potenciales = $this->servicioComunitario->riesgos_potenciales;

        $this->describir_calificaciones = $this->servicioComunitario->describir_calificaciones;
        $this->capacitacion = $this->servicioComunitario->capacitacion;
        $this->recursos_previstos = $this->servicioComunitario->pais_recurso_previsto_id;

        if ($this->servicioComunitario->pais_usaid_recurso_previsto_id !== null) {
            $this->recursos_previstos_usaid = $this->servicioComunitario->pais_usaid_recurso_previsto_id;
        }
        if ($this->servicioComunitario->pais_cs_recurso_previsto_id !== null) {
            $this->recursos_previstos_cost_share = $this->servicioComunitario->pais_cs_recurso_previsto_id;
        }
        if ($this->servicioComunitario->pais_lev_recurso_previsto_id !== null) {
            $this->recursos_previstos_leverage = $this->servicioComunitario->pais_lev_recurso_previsto_id;
        }
        $this->recursos_previstos_especifique = $this->servicioComunitario->recursos_previstos_especifique;


        $this->monto_local = $this->servicioComunitario->monto_local;
        $this->monto_dolar = $this->servicioComunitario->monto_dolar;

        $this->fecha_entrega = $this->servicioComunitario->fecha_entrega;
        $this->proyeccion_pedagogica = $this->servicioComunitario->proyeccion_pedagogica;
        $this->retroalimentacion = $this->servicioComunitario->retroalimentacion;
        $this->sostenibilidad = $this->servicioComunitario->pais_pcj_sostenibilidad_id;
        $this->alcance = $this->servicioComunitario->pais_pcj_alcance_id;
        $this->area = $this->servicioComunitario->pais_pcj_fortalece_area_id;
        $this->poblacion_beneficiada = $this->servicioComunitario->tipo_poblacion_beneficiada;

        if( in_array($this->poblacion_beneficiada, [1,2]) ){
            $this->poblacion_directa = $this->servicioComunitario->poblacionesBeneficiadasDirecta->map(function ($poblacionDirecta) {
                return $poblacionDirecta->paisPoblacionBeneficiada->id;
            })->toArray();

            /*$this->poblacion_directa =  $this->servicioComunitario->poblacionBeneficiadaDirecta
                ->pluck('id')
                ->toArray();*/

            $this->total_poblacion_directa = $this->servicioComunitario->total_poblacion;
        }

        if( in_array($this->poblacion_beneficiada, [0,2]) ){
            $this->poblacion_indirecta = $this->servicioComunitario->poblacionesBeneficiadasIndirecta->map(function ($poblacionDirecta) {
                return $poblacionDirecta->paisPoblacionBeneficiada->id;
            })->toArray();

            /*$this->poblacion_indirecta =  $this->servicioComunitario->poblacionBeneficiadaIndirecta
                ->pluck('id')
                ->toArray();*/
            $this->total_poblacion_indirecta = $this->servicioComunitario->total_poblacion_indirecta;
        }

        $this->comunidad_colabora = $this->servicioComunitario->comunidad_colabora;
        $this->gobierno_colabora = $this->servicioComunitario->gobierno_colabora;
        $this->empresa_privada_colabora = $this->servicioComunitario->empresa_privada_colabora;
        $this->organizaciones_juveniles_colabora = $this->servicioComunitario->organizaciones_juveniles_colabora;
        $this->ong_colabora = $this->servicioComunitario->ong_colabora;
        $this->posee_carta_entendimiento = $this->servicioComunitario->posee_carta_entendimiento;
        $this->estado = $this->servicioComunitario->estado;
        $this->observaciones = $this->servicioComunitario->observaciones;
        $this->apoyos_requeridos = $this->servicioComunitario->apoyos_requeridos;
        $this->progreso = $this->servicioComunitario->progreso;

        $this->nombre_valida = $this->servicioComunitario->nombre_valida;
        $this->cargo_valida = $this->servicioComunitario->cargo_valida;
        $this->fecha_valida = $this->servicioComunitario->fecha_valida;

        $this->nombre_reporta = $this->servicioComunitario->nombre_reporta;
        $this->cargo_reporta = $this->servicioComunitario->cargo_reporta;
        $this->fecha_elaboracion = $this->servicioComunitario->fecha_elaboracion;
    }

    public function init()
    {
        $this->ciudades = [];
    }

    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    public function rules(): array
    {
        return [
            'personal_socio_seguimiento' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^\d+$/', $value)) {
                        return $fail('El campo no puede contener solo números.');
                    }
                }
            ],
            'nombre' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^\d+$/', $value)) {
                        return $fail('El campo no puede contener solo números.');
                    }
                }
            ],
            'total_jovenes' => ['required', 'numeric', 'min:0'],
            'total_adultos_jovenes' => ['required', 'numeric', 'min:0'],
            'departamento_id' => ['required'],
            'ciudad_id' => ['required'],
            'comunidad' => ['required'],
            'descripcion' => ['required'],
            'objetivos' => ['required'],
            'riesgos_potenciales' => ['required'],
            'describir_calificaciones' => ['required'],
            'capacitacion' => ['required'],
            'recursos_previstos' => ['required'],
            'recursos_previstos_usaid' => [
                Rule::requiredIf(function () {
                    return in_array($this->recursos_previstos, RecursoPrevisto::USAID);
                 })
            ],
            'recursos_previstos_cost_share' => [
                Rule::requiredIf(function () {
                    return in_array($this->recursos_previstos, RecursoPrevisto::COST_SHARE);
                 })
            ],
            'recursos_previstos_leverage' => [
                Rule::requiredIf(function () {
                    return in_array($this->recursos_previstos, RecursoPrevisto::LEVERAGE);
                 })
            ],
            'recursos_previstos_especifique' => [
                Rule::requiredIf(function () {
                    return in_array($this->recursos_previstos_cost_share, RecursoPrevistoCostShare::OTRO)
                    || in_array($this->recursos_previstos_leverage, RecursoPrevistoLeverage::OTRO);
                 })
            ],
            'monto_local' => ['required', 'numeric', 'min:0'],
            'monto_dolar' => ['required', 'numeric', 'min:0'],
            'fecha_entrega' => 'required|date|after_or_equal:'.$this->cohorteStartDate.'|before_or_equal:' . $this->cohorteEndDate,
            'proyeccion_pedagogica' => ['required'],
            'retroalimentacion' => ['required'],
            'sostenibilidad' => ['required'],
            'alcance' => ['required'],
            'area' => ['required'],
            'poblacion_beneficiada' => ['required'],
            'poblacion_directa' => [
                Rule::requiredIf(function () {
                    return in_array( $this->poblacion_beneficiada, [1,2]);
                 })
            ],
            'total_poblacion_directa' => [
                Rule::when(
                    in_array( $this->poblacion_beneficiada, [1,2]),
                    ['required', 'numeric', 'min:0']
                )
            ],
            'poblacion_indirecta' => [
                Rule::requiredIf(function () {
                    return in_array( $this->poblacion_beneficiada, [0,2]);
                 })
            ],
            'total_poblacion_indirecta' => [
                Rule::when(
                    in_array( $this->poblacion_beneficiada, [0,2]),
                    ['required', 'numeric', 'min:0']
                )
            ],
            'comunidad_colabora' => ['required'],
            'gobierno_colabora' => ['required'],
            'empresa_privada_colabora' => ['required'],
            'organizaciones_juveniles_colabora' => ['required'],
            'ong_colabora' => ['required'],
            'posee_carta_entendimiento' => ['required'],
            'estado' => ['required'],
            'observaciones' => ['required'],
            'apoyos_requeridos' => ['required'],
            'progreso' => ['required', 'numeric', 'min:0'],
            'nombre_reporta' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^\d+$/', $value)) {
                        return $fail('El campo no puede contener solo números.');
                    }
                }
            ],
            'cargo_reporta' => ['required'],
            'fecha_elaboracion' => 'required|date',
            'nombre_valida' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^\d+$/', $value)) {
                        return $fail('El campo no puede contener solo números.');
                    }
                }
            ],
            'cargo_valida' => ['required'],
            'fecha_valida' => 'required|date',
        ];
    }



    public function save()
    {
        /*if($servicioComunitario){
            $this->servicioComunitario = $servicioComunitario;
        }*/

        $this->validate();


        \DB::transaction(function(){
            $this->servicioComunitario->socio_implementador_id = $this->socioImplementador->id;

            $this->servicioComunitario->cohorte_pais_proyecto_id  = $this->cohortePaisProyecto->id;

            $this->servicioComunitario->personal_socio_seguimiento = $this->personal_socio_seguimiento;
            $this->servicioComunitario->nombre = $this->nombre;
            $this->servicioComunitario->total_jovenes = $this->total_jovenes;
            $this->servicioComunitario->total_adultos_jovenes = $this->total_adultos_jovenes;
            $this->servicioComunitario->pais_id = $this->pais->id;
            $this->servicioComunitario->departamento_id = $this->departamento_id;
            $this->servicioComunitario->ciudad_id = $this->ciudad_id;
            $this->servicioComunitario->comunidad = $this->comunidad;
            $this->servicioComunitario->descripcion = $this->descripcion;
            $this->servicioComunitario->objetivos = $this->objetivos;
            $this->servicioComunitario->riesgos_potenciales = $this->riesgos_potenciales;
            $this->servicioComunitario->describir_calificaciones = $this->describir_calificaciones;
            $this->servicioComunitario->capacitacion = $this->capacitacion;

            $this->servicioComunitario->pais_recurso_previsto_id = $this->recursos_previstos;

            if(in_array($this->recursos_previstos, RecursoPrevisto::USAID))
            {
                $this->servicioComunitario->pais_usaid_recurso_previsto_id = $this->recursos_previstos_usaid;
                $this->servicioComunitario->pais_cs_recurso_previsto_id = NULL;
                $this->servicioComunitario->pais_lev_recurso_previsto_id = NULL;
                $this->servicioComunitario->recursos_previstos_especifique = '';
            }

            if(in_array($this->recursos_previstos, RecursoPrevisto::COST_SHARE))
            {
                $this->servicioComunitario->pais_usaid_recurso_previsto_id = NULL;
                $this->servicioComunitario->pais_cs_recurso_previsto_id = $this->recursos_previstos_cost_share;
                $this->servicioComunitario->pais_lev_recurso_previsto_id = NULL;
                if(in_array($this->recursos_previstos_cost_share, RecursoPrevistoCostShare::OTRO)){
                    $this->servicioComunitario->recursos_previstos_especifique = $this->recursos_previstos_especifique;
                }
            }

            if(in_array($this->recursos_previstos, RecursoPrevisto::LEVERAGE))
            {
                $this->servicioComunitario->pais_usaid_recurso_previsto_id = NULL;
                $this->servicioComunitario->pais_cs_recurso_previsto_id = NULL;
                $this->servicioComunitario->pais_lev_recurso_previsto_id = $this->recursos_previstos_leverage;
                if(in_array($this->recursos_previstos_leverage, RecursoPrevistoLeverage::OTRO)){
                    $this->servicioComunitario->recursos_previstos_especifique = $this->recursos_previstos_especifique;
                }
            }

            $this->servicioComunitario->monto_local = $this->monto_local;
            $this->servicioComunitario->monto_dolar = $this->monto_dolar;

            $this->servicioComunitario->fecha_entrega = $this->fecha_entrega;
            $this->servicioComunitario->proyeccion_pedagogica = $this->proyeccion_pedagogica;
            $this->servicioComunitario->retroalimentacion = $this->retroalimentacion;


            $this->servicioComunitario->pais_pcj_sostenibilidad_id = $this->sostenibilidad;
            $this->servicioComunitario->pais_pcj_alcance_id = $this->alcance;
            $this->servicioComunitario->pais_pcj_fortalece_area_id = $this->area;

            $this->servicioComunitario->tipo_poblacion_beneficiada = $this->poblacion_beneficiada;

            if( in_array($this->poblacion_beneficiada, [1,2]) ){
                $this->servicioComunitario->total_poblacion = $this->total_poblacion_directa;
            }

            if( in_array($this->poblacion_beneficiada, [0,2]) ){
                $this->servicioComunitario->total_poblacion_indirecta = $this->total_poblacion_indirecta;
            }

            $this->servicioComunitario->comunidad_colabora = $this->comunidad_colabora;
            $this->servicioComunitario->gobierno_colabora = $this->gobierno_colabora;
            $this->servicioComunitario->empresa_privada_colabora = $this->empresa_privada_colabora;
            $this->servicioComunitario->organizaciones_juveniles_colabora = $this->organizaciones_juveniles_colabora;
            $this->servicioComunitario->ong_colabora = $this->ong_colabora;
            $this->servicioComunitario->posee_carta_entendimiento = $this->posee_carta_entendimiento;
            $this->servicioComunitario->estado = $this->estado;
            $this->servicioComunitario->observaciones = $this->observaciones;
            $this->servicioComunitario->apoyos_requeridos = $this->apoyos_requeridos;
            $this->servicioComunitario->progreso = $this->progreso;

            $this->servicioComunitario->nombre_reporta = $this->nombre_reporta;
            $this->servicioComunitario->cargo_reporta = $this->cargo_reporta;
            $this->servicioComunitario->fecha_elaboracion = $this->fecha_elaboracion;
            $this->servicioComunitario->nombre_valida = $this->nombre_valida;
            $this->servicioComunitario->cargo_valida = $this->cargo_valida;
            $this->servicioComunitario->fecha_valida = $this->fecha_valida;

            $this->servicioComunitario->save();

            if( in_array($this->poblacion_beneficiada, [1,2]) ){
                $this->servicioComunitario->poblacionesBeneficiadasDirecta()->delete();
                //$this->servicioComunitario->poblacionesBeneficiadasDirecta()->sync($this->poblacion_directa);

                foreach ($this->poblacion_directa as $paisPoblacionId) {
                    $this->servicioComunitario->poblacionesBeneficiadasDirecta()->create([
                        'pais_poblacion_beneficiada_id' => $paisPoblacionId,
                    ]);
                }

            }

            if( in_array($this->poblacion_beneficiada, [0,2]) ){
                $this->servicioComunitario->poblacionesBeneficiadasIndirecta()->delete();
                //$this->servicioComunitario->poblacionesBeneficiadasIndirecta()->sync($this->poblacion_indirecta);
                foreach ($this->poblacion_indirecta as $paisPoblacionId) {
                    $this->servicioComunitario->poblacionesBeneficiadasIndirecta()->create([
                        'pais_poblacion_beneficiada_id' => $paisPoblacionId,
                    ]);
                }
            }

           ServicioComunitarioHistorico::create([
                'servicio_comunitario_id' => $this->servicioComunitario->id,
                'estado' => $this->estado,
                'comentario' => 'Se ha asignado un estado para  el servicio comunitario',
            ]);
        });

    }
}
