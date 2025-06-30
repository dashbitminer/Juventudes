<?php

namespace App\Livewire\Resultadotres\Gestor\Prealianzas\Forms;

use App\Enums\TipoActor;
use Livewire\Form;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Alianza;
use App\Models\Proyecto;
use App\Models\PreAlianza;
use App\Models\TipoSector;
use App\Models\TipoAlianza;
use App\Models\Departamento;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\PropositoAlianza;
use App\Models\TipoSectorPrivado;
use Illuminate\Support\Facades\DB;
use App\Models\CoberturaGeografica;
use App\Models\OrganizacionAlianza;
use App\Models\EstadoRegistroAlianza;
use Illuminate\Validation\Rules\File;
use App\Models\PaisOrganizacionAlianza;
use App\Models\ObjetivoAsistenciaAlianza;
use App\Models\SectorProductivo;

class PrealianzaForm extends Form
{

    use WithFileUploads;

    public ?PreAlianza $prealianza;

    public $departamentos;

    public $ciudades;

    public Proyecto $proyecto;

    public Pais $pais;

    public $departamentoSelected;

    public $ciudadSelected;

    public $consideraciones_generales;

    public $cargo_contacto;

    public $tipo_contacto;
    
    public $pertenece_cpa;

    public $responsable_glasswing;

    public $capacidad_operativa;

    public $coberturaGeograficaSelectedPivot;
    public $cobertura_geografica;
    public $cobertura_geografica_options;

    public $coberturaNacionalSelected = [];
    public $cobertura_internacional;

    public $nivel_colaboracion;
    public $servicios_posibles;
    public $espera_de_alianza;
    public $aporte_espera_alianza;
    public $monto_esperado;

    public $monto_especie;

    public $impacto_pontencial;
    public $tipo_impacto_potencial;
    public $anio_fiscal_firma;
    public $trimestre_aproximado_firma;
    public $proximos_pasos;
    public $observaciones;
    public $nivel_inversion;
   // public $sector;
    public $resultados_esperados;
    public $tipo_actor = [];

    public $fecha_estado_alianza;
    public $estado_prealianza;

    public bool $readonly = false;

    public $tipoSectorSelected;
    public $tipoSectorSelectedPivot;

    public $tipoSectorPublicoSelected;
    public $tipoSectorPublicoSelectedPivot;

    public $tipoSectorPrivadoSelected;
    public $tipoSectorPrivadoSelectedPivot;

    public $origenEmpresaPrivadaSelected;
    public $origenEmpresaPrivadaSelectedPivot;

    public $tamanoEmpresaPrivadaSelected;
    public $tamanoEmpresaPrivadaSelectedPivot;

    public $tipoSectorComunitariaSelected;
    public $tipoSectorComunitariaSelectedPivot;

    public $tipoSectorAcademicaSelected;
    public $tipoSectorAcademicaSelectedPivot;


    public $tipoAlianzaSelected;
    public $tipoAlianzaSelectedPivot;

    public $coberturaSelected = [];

    public $tipoAlianzaOtro = 0;
    public $otrosPropositoAlianza = 0;
    public $otroObjetivoAsistenciaAlianza = 0;
    public $tipoSectorPublica = 0;
    public $tipoSectorPrivada = 0;
    public $tipoSectorComunitaria = 0;
    public $tipoSectorAcademica = 0;
    public $otroTipoSectorPrivado = 0;

    public $nombre_contacto;
    public $nombre_organizacion;
    public $otros_tipo_alianza;
    public $fecha_inicio;
    public $fecha_fin_tentativa;
    public $otro_proposito_alianza;
    public $otro_objetivo_asistencia_alianza;
    public $impacto_previsto_alianza;
    public $contacto_email;
    public $contacto_telefono;
    public $otro_sector_privado;

    public $showValidationErrorIndicator = false;
    public $showSuccessIndicator = false;

    public $showCoberturaWarning = false;
    public $validationErrors = [];

    public $impactoPotencialSelected = [];

    public $tiposector;

    public $tipoActores = [];

    public $sectorProductivos = [];

    public $sector_productivo;

    public function rules(): array
    {
        return [
            'fecha_estado_alianza' => [
                'required',
            ],
            'estado_prealianza' => [
                'required',
            ],
            'nombre_organizacion' => [
                'required',
                'min:3',
            ],
            'coberturaSelected' => [
                'required'
            ],
            'tipoSectorSelected' => [
                'required'
            ],
            'tipo_actor' => [
                'required', 
                'array', 
                'min:1'
            ],
            'tipoSectorPublicoSelected' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoSector::OPCION_PUBLICA_GT == $this->tipoSectorSelected;
                    }
                })
            ],
            'tipoSectorPrivadoSelected' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoSector::OPCION_PRIVADA_GT == $this->tipoSectorSelected;
                    }
                })
            ],
            'origenEmpresaPrivadaSelected' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoSector::OPCION_PRIVADA_GT == $this->tipoSectorSelected;
                    }
                })
            ],
            'tamanoEmpresaPrivadaSelected' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoSector::OPCION_PRIVADA_GT == $this->tipoSectorSelected;
                    }
                })
            ],
            'tipoSectorComunitariaSelected' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoSector::OPCION_COMUNITARIA_GT == $this->tipoSectorSelected;
                    }
                })
            ],
            'tipoSectorAcademicaSelected' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoSector::OPCION_ACADEMICA_GT == $this->tipoSectorSelected;
                    }
                })
            ],
            'nombre_contacto' => [
                'required',
                'min:3',
            ],
            'cargo_contacto' => [
                'required',
                'min:3',
            ],
            'tipo_contacto' => [
                'required'
            ],
            'sector_productivo' => [ 'required' ],
            'pertenece_cpa' => [
                'required'
            ],
            'contacto_email' => [
                'email',
                'required',
            ],
            'contacto_telefono' => [
                'required',
            ],
            'responsable_glasswing' => [
                'required',
            ],
            'consideraciones_generales' => [
                'required',
            ],
            /*'tipoAlianzaSelected' => [
                'required'
            ],
            'otros_tipo_alianza' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoAlianza::TIPO_ALIANZA_OTROS_GT == $this->tipoAlianzaSelected;
                    }
                })
            ],*/
            'cobertura_geografica' => [
                'required'
            ],
            'cobertura_internacional' => [
                Rule::requiredIf(function () {
                    return \App\Models\CoberturaGeografica::INTERNACIONAL == $this->cobertura_geografica || \App\Models\CoberturaGeografica::NACIONAL_INTERNACIONAL == $this->cobertura_geografica;
                })
            ],
            'coberturaNacionalSelected' => [
                Rule::requiredIf(function () {
                    return \App\Models\CoberturaGeografica::NACIONAL == $this->cobertura_geografica || \App\Models\CoberturaGeografica::NACIONAL_INTERNACIONAL == $this->cobertura_geografica;
                })
            ],
            'capacidad_operativa' => [
                'required'
            ],
            'nivel_inversion' => [
                'required', 'numeric', 'min:0'
            ],
            'nivel_colaboracion' => [
                'required'
            ],
            'servicios_posibles' => [
                'required'
            ],
            /*'sector' => [
                'required'
            ],*/
            'espera_de_alianza' => [
                'required'
            ],
            'aporte_espera_alianza' => [
                'required'
            ],
            'monto_esperado' => [
                Rule::requiredIf(function(){
                    return in_array($this->aporte_espera_alianza, ['1','3']);
                })
            ],
            'monto_especie' => [
                Rule::requiredIf(function(){
                    return in_array($this->aporte_espera_alianza, ['2','3']);
                })
            ],
            'impacto_pontencial' => [
                'required', 'numeric', 'min:0', 'max:100'
            ],
            'tipo_impacto_potencial' => [
                'required'
            ],
            'resultados_esperados' => [
                'required'
            ],
            'anio_fiscal_firma' => [
                'required'
            ],
            'trimestre_aproximado_firma' => [
                'required'
            ],
            'proximos_pasos' => [
                'required'
            ],
            'observaciones' => [
                'required'
            ],
            'impactoPotencialSelected' => [ 'required' ]

        ];
    }

    public function messages(): array
    {
        return[

        ];
    }

    public function boot()
    {
        $this->withValidator(function ($validator) {

            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
               // $this->validationErrors = $validator->errors()->all();
            }
        });
    }


    public function init()
    {
        $this->departamentos = Departamento::active()->where('pais_id', $this->pais->id)->pluck("nombre", "id");
        $this->ciudades = [];
        $this->cobertura_geografica_options = collect(["1" => "Nacional", "2" => "Internacional", "3" => "No definido"]);

        $this->tipoActores = TipoActor::cases();

        $this->sectorProductivos = $this->pais->sectorProductivo()
            ->whereNotNull('sector_productivos.active_at')
            ->pluck('sector_productivos.nombre', 'pais_sector_productivos.id');

       // if ($this->pais->id == 1) {
            $this->tipoAlianzaOtro = TipoAlianza::where('slug', 'otros')->value('id');
            $this->otrosPropositoAlianza = PropositoAlianza::where('slug', 'otro')->value('id');
            $this->otroObjetivoAsistenciaAlianza = ObjetivoAsistenciaAlianza::where('slug', 'otro')->value('id');
            $this->tipoSectorPublica = TipoSector::where('slug', 'publico')->value('id');
            $this->tipoSectorPrivada = TipoSector::where('slug', 'privado')->value('id');
            $this->tipoSectorComunitaria = TipoSector::where('slug', 'comunitario')->value('id');
            $this->tipoSectorAcademica = TipoSector::where('slug', 'academia-y-de-investigacion')->value('id');
            $this->otroTipoSectorPrivado = TipoSectorPrivado::where('slug', 'otro')->value('id');
        //}
    }

    public function setProyecto(Proyecto $proyecto): void
    {
        $this->proyecto = $proyecto;
    }

    public function setPais(Pais $pais): void
    {
        $this->pais = $pais;
    }

    public function setTipoSector($tiposector): void
    {
        $this->tiposector = $tiposector;
    }

    public function setDepartamento($departamento): void
    {
        $this->departamentoSelected = $departamento;
    }

    public function setCiudades(): void
    {
        $this->ciudades = Ciudad::active()->where('departamento_id', $this->departamentoSelected)->pluck("nombre", "id");
    }

    public function setPreAlianza($prealianza)
    {
        $prealianza->load(
            'areascoberturas',
            'coberturanacional',
            'socioImplementador:id,nombre',
            'tipoSector:id,tipo_sector_id',
            'tipoSectorPublico:id,pais_id,tipo_sector_publico_id',
            'tipoSectorPrivado:id,pais_id,tipo_sector_privado_id',
            'tamanoEmpresaPrivada:id,pais_id,tamano_empresa_privada_id',
            'origenEmpresaPrivada:id,pais_id,origen_empresa_privada_id',
            'tipoSectorComunitaria:id,pais_id,tipo_sector_comunitaria_id',
            'tipoSectorAcademica:id,pais_id,tipo_sector_academica_id',
            'tipoAlianza:id,pais_id,tipo_alianza_id',
            'coberturaGeografica:id,pais_id,cobertura_geografica_id'
        );
        // dd($prealianza);

        foreach ($prealianza->areascoberturas as $areaCobertura) {
            $this->coberturaSelected[] = $areaCobertura->id;
        }

        foreach ($prealianza->coberturanacional as $coberturaNacional) {
            $this->coberturaNacionalSelected[] = $coberturaNacional->id;
        }

        $this->prealianza = $prealianza;

        $this->tipoSectorSelectedPivot = $this->prealianza->pais_tipo_sector_id;
        $this->tipoSectorSelected = $this->prealianza->tipoSector->tipo_sector_id;
        // $this->tipoSectorSelected

        $this->tipoSectorPublicoSelectedPivot    = $this->prealianza->pais_tipo_sector_publico_id;
        $this->tipoSectorPublicoSelected   = optional($this->prealianza->tipoSectorPublico)->tipo_sector_publico_id;


        $this->tipoSectorPrivadoSelectedPivot    = $this->prealianza->pais_tipo_sector_privado_id;
        $this->tipoSectorPrivadoSelected   = optional($this->prealianza->tipoSectorPrivado)->tipo_sector_privado_id;
        $this->otro_sector_privado               = $this->prealianza->otro_tipo_sector_privado;

        $this->origenEmpresaPrivadaSelectedPivot = $this->prealianza->pais_origen_empresa_privada;
        $this->origenEmpresaPrivadaSelected       = optional($this->prealianza->origenEmpresaPrivada)->origen_empresa_privada_id;

        $this->tamanoEmpresaPrivadaSelectedPivot = $this->prealianza->pais_tamano_empresa_privada_id;
        $this->tamanoEmpresaPrivadaSelected       = optional($this->prealianza->tamanoEmpresaPrivada)->tamano_empresa_privada_id;

        $this->tipoSectorComunitariaSelectedPivot = $this->prealianza->pais_tipo_sector_comunitaria_id;
        $this->tipoSectorComunitariaSelected       = optional($this->prealianza->tipoSectorComunitaria)->tipo_sector_comunitaria_id;

        $this->tipoSectorAcademicaSelectedPivot = $this->prealianza->pais_tipo_sector_academica_id;
        $this->tipoSectorAcademicaSelected       = optional($this->prealianza->tipoSectorAcademica)->tipo_sector_academica_id;

        $this->nombre_organizacion       = $this->prealianza->nombre_organizacion;
        $this->nombre_contacto           = $this->prealianza->nombre_contacto;
        $this->cargo_contacto            = $this->prealianza->cargo_contacto;
        $this->tipo_contacto            = $this->prealianza->tipo_contacto;
        $this->contacto_email            = $this->prealianza->email_contacto;
        $this->contacto_telefono         = $this->prealianza->telefono_contacto;
        $this->responsable_glasswing     = $this->prealianza->responsable_glasswing;
        $this->consideraciones_generales = $this->prealianza->consideraciones_generales;
        $this->pertenece_cpa = $this->prealianza->pertenece_cpa;
        $this->sector_productivo = $this->prealianza->pais_sector_productivo_id;
        $this->tipo_impacto_potencial = $this->prealianza->tipo_impacto_potencial;

        $this->capacidad_operativa              = $this->prealianza->capacidad_operativa;

        $this->coberturaGeograficaSelectedPivot = $this->prealianza->pais_cobertura_geografica_id;
        $this->cobertura_geografica             = optional($this->prealianza->coberturaGeografica)->cobertura_geografica_id;

        $this->cobertura_geografica             = $this->prealianza->cobertura_geografica;
        $this->cobertura_internacional          = $this->prealianza->cobertura_internacional;
        $this->nivel_inversion                  = $this->prealianza->nivel_inversion;

        $this->tipo_actor                       = $this->prealianza->tipoActores->pluck('tipo_actor')->toArray();

        $this->nivel_colaboracion               = $this->prealianza->nivel_colaboracion;
        $this->servicios_posibles               = $this->prealianza->servicios_posibles;

        $this->espera_de_alianza          = $this->prealianza->espera_de_alianza;
        $this->aporte_espera_alianza      = $this->prealianza->aporte_espera_alianza;
        $this->monto_esperado             = $this->prealianza->monto_esperado;
        $this->monto_especie             = $this->prealianza->monto_especie;
        
        $this->impacto_pontencial         = $this->prealianza->impacto_pontencial;
        $this->resultados_esperados       = $this->prealianza->resultados_esperados;
        $this->anio_fiscal_firma          = $this->prealianza->anio_fiscal_firma;
        $this->trimestre_aproximado_firma = $this->prealianza->trimestre_aproximado_firma;
        $this->proximos_pasos             = $this->prealianza->proximos_pasos;
        $this->observaciones              = $this->prealianza->observaciones;

        $this->fecha_estado_alianza = $this->prealianza->fecha_estado_alianza;
        $this->estado_prealianza = $this->prealianza->estado_alianza;

        $this->impactoPotencialSelected = $this->prealianza->impactoPotencial
        ->pluck('id')
        ->toArray();

    }

    public function save(?PreAlianza $prealianza = null): void
    {
        if ($prealianza) {
            $this->prealianza = $prealianza;
        }


        DB::transaction(function () {

            $this->validate();

            $organizacion = OrganizacionAlianza::firstOrNew(['nombre' =>  $this->nombre_organizacion]);
            $organizacion->active_at = now();
            $organizacion->save();


            $paisOrganizacionAlianza = PaisOrganizacionAlianza::firstOrNew([
                'organizacion_alianza_id' => $organizacion->id,
                'pais_id' => $this->pais->id,
            ]);

            $paisOrganizacionAlianza->active_at = now();
            $paisOrganizacionAlianza->telefono = $this->contacto_telefono;
            $paisOrganizacionAlianza->email = $this->contacto_email;
            $paisOrganizacionAlianza->nombre_contacto = $this->nombre_contacto;
            $paisOrganizacionAlianza->save();

            $socioImplementador = $this->getSocioImplementador();

            //$user = auth()->user()->load('lastestSocioImplementador');


            $this->prealianza->gestor_id              = auth()->user()->id;
            $this->prealianza->socio_implementador_id = $socioImplementador->id ?? null;
            $this->prealianza->pais_tipo_sector_id    = $this->tipoSectorSelectedPivot;
            $this->prealianza->pais_id                = $this->pais->id;
            $this->prealianza->proyecto_id            = $this->proyecto->id;


            $this->prealianza->pais_organizacion_alianza_id = $paisOrganizacionAlianza->id;

            $this->prealianza->pais_tipo_sector_publico_id    = $this->tipoSectorPublicoSelectedPivot;
            $this->prealianza->pais_tipo_sector_privado_id    = $this->tipoSectorPrivadoSelectedPivot;
            $this->prealianza->otro_tipo_sector_privado       = $this->otro_sector_privado;
            $this->prealianza->pais_origen_empresa_privada_id = $this->origenEmpresaPrivadaSelectedPivot;

            $this->prealianza->pais_tamano_empresa_privada_id  = $this->tamanoEmpresaPrivadaSelectedPivot;
            $this->prealianza->pais_tipo_sector_comunitaria_id = $this->tipoSectorComunitariaSelectedPivot;
            $this->prealianza->pais_tipo_sector_academica_id   = $this->tipoSectorAcademicaSelectedPivot;

           // $this->prealianza->sector = $this->sector;


            $this->prealianza->nombre_organizacion = $this->nombre_organizacion;
            $this->prealianza->nombre_contacto = $this->nombre_contacto;
            $this->prealianza->cargo_contacto = $this->cargo_contacto;
            $this->prealianza->tipo_contacto = $this->tipo_contacto;
            $this->prealianza->email_contacto = $this->contacto_email;
            $this->prealianza->telefono_contacto = $this->contacto_telefono;
            $this->prealianza->responsable_glasswing = $this->responsable_glasswing;
            $this->prealianza->consideraciones_generales = $this->consideraciones_generales;
            $this->prealianza->pertenece_cpa = $this->pertenece_cpa;
            $this->prealianza->pais_sector_productivo_id = $this->sector_productivo;

            //$this->prealianza->pais_tipo_alianza_id = $this->tipoAlianzaSelectedPivot;
            //$this->prealianza->otros_tipo_alianza   = $this->otros_tipo_alianza;

            $this->prealianza->capacidad_operativa = $this->capacidad_operativa;

            $this->prealianza->pais_cobertura_geografica_id  = $this->coberturaGeograficaSelectedPivot;
            $this->prealianza->cobertura_geografica = $this->cobertura_geografica;

            $this->prealianza->cobertura_internacional = $this->cobertura_internacional;

            $this->prealianza->nivel_inversion = $this->nivel_inversion;
           // $this->prealianza->tipo_actor = $this->tipo_actor;
            $this->prealianza->nivel_colaboracion = $this->nivel_colaboracion;
            $this->prealianza->servicios_posibles = $this->servicios_posibles;

            $this->prealianza->espera_de_alianza = $this->espera_de_alianza;
            $this->prealianza->aporte_espera_alianza = $this->aporte_espera_alianza;

            $this->prealianza->monto_esperado = $this->monto_esperado;
            $this->prealianza->monto_especie = $this->monto_especie;
            
            $this->prealianza->impacto_pontencial = $this->impacto_pontencial;
            $this->prealianza->resultados_esperados = $this->resultados_esperados;

            $this->prealianza->tipo_impacto_potencial = $this->tipo_impacto_potencial;

            $this->prealianza->anio_fiscal_firma = $this->anio_fiscal_firma;
            $this->prealianza->trimestre_aproximado_firma = $this->trimestre_aproximado_firma;
            $this->prealianza->proximos_pasos = $this->proximos_pasos;
            $this->prealianza->observaciones = $this->observaciones;
            $this->prealianza->active_at = now();

            $this->prealianza->fecha_estado_alianza =  $this->fecha_estado_alianza;
            $this->prealianza->estado_alianza = $this->estado_prealianza;

            $this->prealianza->save();

            $areasCoberturasData = [];
            foreach ($this->coberturaSelected as $coberturaId) {
                $areasCoberturasData[$coberturaId] = [
                    'active_at' => now(),
                    // Add other extra fields here
                ];
            }
            $this->prealianza->areascoberturas()->sync($areasCoberturasData);

            if (in_array($this->cobertura_geografica, [CoberturaGeografica::NACIONAL, CoberturaGeografica::NACIONAL_INTERNACIONAL])) {
                $coberturaNacionalData = [];
                foreach ($this->coberturaNacionalSelected as $coberturaNacionalId) {
                    $coberturaNacionalData[$coberturaNacionalId] = [
                        'active_at' => now(),
                        // Add other extra fields here
                    ];
                }
                $this->prealianza->coberturanacional()->sync($coberturaNacionalData);
            }

            $this->prealianza->impactoPotencial()->detach();
            $this->prealianza->impactoPotencial()->sync($this->impactoPotencialSelected);

            $this->prealianza->tipoActores()->delete();

            foreach ($this->tipo_actor as $tipo) {
                $this->prealianza->tipoActores()->create([
                    'tipo_actor' => $tipo,
                ]);
            }
        });
    }

    public function getSocioImplementador(){
        $user = auth()->user()->load('socioImplementador');

        return $user->socioImplementador;
    }
}
