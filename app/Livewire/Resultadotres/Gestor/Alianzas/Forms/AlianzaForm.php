<?php

namespace App\Livewire\Resultadotres\Gestor\Alianzas\Forms;


use DB;
use Livewire\Form;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Alianza;
use App\Models\Proyecto;
use App\Models\TipoSector;
use App\Models\TipoAlianza;
use App\Models\Departamento;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\PropositoAlianza;
use App\Models\TipoSectorPrivado;
use App\Models\OrganizacionAlianza;
use App\Models\EstadoRegistroAlianza;
use Illuminate\Validation\Rules\File;
use App\Models\PaisOrganizacionAlianza;
use App\Models\ObjetivoAsistenciaAlianza;
use App\Models\PreAlianza;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Resultadotres\Gestor\Prealianzas\Organizaciones;

class AlianzaForm extends Form
{

    use WithFileUploads;

    use Organizaciones;

    public ?Alianza $alianza;

    public $departamentos;

    public $ciudades;

    public Proyecto $proyecto;

    public Pais $pais;

    public $departamentoSelected;

    public $ciudadSelected;

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

    public $propositoAlianzaSelected;
    public $propositoAlianzaSelectedPivot;

    public $modalidadEstrategiaAlianzaSelected;
    public $modalidadEstrategiaAlianzaSelectedPivot;

    public $objetivoAsistenciaAlianzaSelected;
    public $objetivoAsistenciaAlianzaSelectedPivot;

    public $coberturaSelected = [];

    public $tipoAlianzaOtro = 0;
    public $otrosPropositoAlianza = 0;
    public $otroObjetivoAsistenciaAlianza = 0;
    public $tipoSectorPublica = 1;
    public $tipoSectorPrivada = 2;
    public $tipoSectorComunitaria = 6;
    public $tipoSectorAcademica = 4;
    public $otroTipoSectorPrivado = 12;

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

    public $documento_respaldo;
    public $documento_respaldo_upload;
    public $comentario;

    public $otro_sector_privado;

    public $showValidationErrorIndicator = false;
    public $showSuccessIndicator = false;

    public $showCoberturaWarning = false;

    public $organizaciones;

    public $organizacionSelected = [];


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

            'nombre_organizacion' => [
                'required',
                'min:3',
            ],
            'departamentoSelected' => [
                'required'
            ],
            'ciudadSelected' => [
                'required'
            ],
            'coberturaSelected' => [
                'required'
            ],
            'nombre_contacto' => [
                'required',
                'min:3',
            ],
           /* 'contacto_email' => [
                'required',
                'email',
            ],*/
            'contacto_telefono' => [
                'required',
                'size:8',
            ],
            'tipoSectorSelected' => [
                'required'
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
            'tipoAlianzaSelected' => [
                'required'
            ],
            'otros_tipo_alianza' => [
                Rule::requiredIf(function () {
                    // if ($this->pais->id == 1) {
                    //     return TipoAlianza::TIPO_ALIANZA_OTROS_GT == $this->tipoAlianzaSelected;
                    // }
                    return $this->tipoAlianzaSelected == 5;
                })
            ],
            'otro_sector_privado' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoSector::OPCION_PRIVADA_GT == $this->tipoSectorSelected && $this->tipoSectorPrivadoSelected == TipoSectorPrivado::OTRO_TIPO_SECTOR_PRIVADO;
                    }
                })
            ],
            'otro_objetivo_asistencia_alianza' => [
                Rule::requiredIf(function () {
                    return $this->objetivoAsistenciaAlianzaSelected == 11;
                    // if ($this->pais->id == 1) {
                    //     return ObjetivoAsistenciaAlianza::OTRO_OBJETIVO_ASISTENCIA_GT == $this->objetivoAsistenciaAlianzaSelected;
                    // }
                })
            ],
            'otro_proposito_alianza' => [
                Rule::requiredIf(function () {
                //    if ($this->pais->id == 1) {
                       // return PropositoAlianza::PROPOSITO_OTRO_GT == $this->propositoAlianzaSelected;
                       return $this->propositoAlianzaSelected == 6;
              //      }
                })
            ],
            'propositoAlianzaSelected' => [
                'required'
            ],
            'modalidadEstrategiaAlianzaSelected' => [
                'required'
            ],
            'objetivoAsistenciaAlianzaSelected' => [
                'required'
            ],
            'fecha_inicio' => [
                'date',
                'required'
            ],
            'fecha_fin_tentativa' => [
                'date',
                'required',
                'after:fecha_inicio',
            ],
            'impacto_previsto_alianza' => [
                'required',
            ],
            'documento_respaldo_upload' => [
                Rule::when(!$this->documento_respaldo, [
                    'required',
                    File::types(['pdf', 'docx', 'jpeg', 'png'])
                        ->min('1kb')
                        ->max('10mb'),
                ]),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_organizacion.required' => 'El nombre de la organización es obligatorio.',
            'nombre_organizacion.min' => 'El nombre de la organización debe tener al menos 3 caracteres.',
            'departamentoSelected.required' => 'El departamento es obligatorio.',
            'ciudadSelected.required' => 'La ciudad es obligatoria.',
            'coberturaSelected.required' => 'La cobertura es obligatoria.',
            'nombre_contacto.required' => 'El nombre del contacto es obligatorio.',
            'nombre_contacto.min' => 'El nombre del contacto debe tener al menos 3 caracteres.',
            'contacto_email.required' => 'El correo electrónico del contacto es obligatorio.',
            'contacto_email.email' => 'El correo electrónico del contacto debe ser una dirección válida.',
            'contacto_telefono.required' => 'El teléfono del contacto es obligatorio.',
            'contacto_telefono.size' => 'El teléfono del contacto debe tener 8 dígitos.',
            'tipoSectorSelected.required' => 'El tipo de sector es obligatorio.',
            'tipoSectorPublicoSelected.required' => 'El tipo de sector público es obligatorio.',
            'tipoSectorPrivadoSelected.required' => 'El tipo de sector privado es obligatorio.',
            'origenEmpresaPrivadaSelected.required' => 'El origen de la empresa privada es obligatorio.',
            'tamanoEmpresaPrivadaSelected.required' => 'El tamaño de la empresa privada es obligatorio.',
            'tipoSectorComunitariaSelected.required' => 'El tipo de sector comunitario es obligatorio.',
            'tipoSectorAcademicaSelected.required' => 'El tipo de sector académico es obligatorio.',
            'tipoAlianzaSelected.required' => 'El tipo de alianza es obligatorio.',
            'otros_tipo_alianza.required' => 'Otros tipos de alianza son obligatorios.',
            'otro_sector_privado.required' => 'Otro tipo de sector privado es obligatorio.',
            'otro_objetivo_asistencia_alianza.required' => 'Otro objetivo de asistencia de la alianza es obligatorio.',
            'otro_proposito_alianza.required' => 'Otro propósito de la alianza es obligatorio.',
            'propositoAlianzaSelected.required' => 'El propósito de la alianza es obligatorio.',
            'modalidadEstrategiaAlianzaSelected.required' => 'La modalidad de estrategia de la alianza es obligatoria.',
            'objetivoAsistenciaAlianzaSelected.required' => 'El objetivo de asistencia de la alianza es obligatorio.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_fin_tentativa.date' => 'La fecha de fin tentativa debe ser una fecha válida.',
            'fecha_fin_tentativa.required' => 'La fecha de fin tentativa es obligatoria.',
            'fecha_fin_tentativa.after' => 'La fecha de fin tentativa debe ser posterior a la fecha de inicio.',
            'impacto_previsto_alianza.required' => 'El impacto previsto de la alianza es obligatorio.',
            'documento_respaldo_upload.required' => 'El documento de respaldo es obligatorio.',
            'documento_respaldo_upload.file' => 'El documento de respaldo debe ser un archivo válido.',
            'documento_respaldo_upload.mimes' => 'El documento de respaldo debe ser un archivo de tipo: pdf, docx, jpeg, png.',
            'documento_respaldo_upload.min' => 'El documento de respaldo debe tener al menos 1KB.',
            'documento_respaldo_upload.max' => 'El documento de respaldo no debe exceder los 10MB.',
        ];
    }


    public function setProyecto(Proyecto $proyecto): void
    {
        $this->proyecto = $proyecto;
    }

    public function setPais(Pais $pais): void
    {
        $this->pais = $pais;
    }

    public function init()
    {
        $this->departamentos = Departamento::active()->where('pais_id', $this->pais->id)->pluck("nombre", "id");
        $this->ciudades = [];

        /*$this->organizaciones = PreAlianza::active()
            ->where('pais_id', $this->pais->id)
            ->pluck("nombre_organizacion", "id");*/
           
        $this->organizaciones = $this->getOrganizaciones($this->pais)->pluck("organizacionAlianza.nombre", "id");

        if ($this->pais->id == 1) {
            $this->tipoAlianzaOtro = TipoAlianza::TIPO_ALIANZA_OTROS_GT;
            $this->otrosPropositoAlianza = PropositoAlianza::PROPOSITO_OTRO_GT;
            $this->otroObjetivoAsistenciaAlianza = ObjetivoAsistenciaAlianza::OTRO_OBJETIVO_ASISTENCIA_GT;
            $this->tipoSectorPublica = TipoSector::OPCION_PUBLICA_GT;
            $this->tipoSectorPrivada = TipoSector::OPCION_PRIVADA_GT;
            $this->tipoSectorComunitaria = TipoSector::OPCION_COMUNITARIA_GT;
            $this->tipoSectorAcademica = TipoSector::OPCION_ACADEMICA_GT;
            $this->otroTipoSectorPrivado = TipoSectorPrivado::OTRO_TIPO_SECTOR_PRIVADO;
        }
    }

    public function setDepartamento($departamento): void
    {
        $this->departamentoSelected = $departamento;
    }

    public function setCiudades(): void
    {
        $this->ciudades = Ciudad::active()->where('departamento_id', $this->departamentoSelected)->pluck("nombre", "id");
    }

    public function setAlianza(Alianza $alianza)
    {

        $this->alianza = $alianza->load([
            'socioImplementador:id,nombre',
            'areascoberturas:id,nombre',
            'tipoAlianzaSelected:id,pais_id,tipo_alianza_id',
            'tipoSectorSelected:id,pais_id,tipo_sector_id',
            "propositoAlianzaSelected:id,pais_id,proposito_alianza_id",
            "modalidadEstrategiaAlianzaSelected:id,pais_id,modalidad_estrategia_alianza_id",
            "paisTipoSectorPublicoSelected:id,pais_id,tipo_sector_publico_id",
            "paisTipoSectorPrivadoSelected:id,pais_id,tipo_sector_privado_id",
            "paisOrigenEmpresaPrivadaSelected:id,pais_id,origen_empresa_privada_id",
            "paisTamanoEmpresaPrivadaSelected:id,pais_id,tamano_empresa_privada_id",
            "paisObjetivoAsistenciaAlianzaSelected:id,pais_id,objetivo_asistencia_alianza_id",
        ]);


        $this->nombre_organizacion = $this->alianza->nombre_organizacion;
        // $this->socio_implementador_id = $alianza->socio_implementador_id;

        $this->ciudadSelected = $this->alianza->ciudad_id;

        $this->tipoAlianzaSelected = $this->alianza->tipoAlianzaSelected->tipo_alianza_id;
        $this->tipoAlianzaSelectedPivot = $this->alianza->tipoAlianzaSelected->id;

        $this->tipoSectorSelected = $this->alianza->tipoSectorSelected->tipo_sector_id;
        $this->tipoSectorSelectedPivot = $this->alianza->tipoSectorSelected->id;

        $this->coberturaSelected = $this->alianza->areascoberturas->pluck('id')->toArray();

        $this->propositoAlianzaSelected = $this->alianza->propositoAlianzaSelected->proposito_alianza_id;
        $this->propositoAlianzaSelectedPivot = $this->alianza->propositoAlianzaSelected->id;


        $this->modalidadEstrategiaAlianzaSelected = $this->alianza->modalidadEstrategiaAlianzaSelected->modalidad_estrategia_alianza_id;
        $this->modalidadEstrategiaAlianzaSelectedPivot = $this->alianza->modalidadEstrategiaAlianzaSelected->id;

        $this->tipoSectorPublicoSelected = optional($this->alianza->paisTipoSectorPublicoSelected)->tipo_sector_publico_id;
        $this->tipoSectorPublicoSelectedPivot   = optional($this->alianza->paisTipoSectorPublicoSelected)->id;

        $this->tipoSectorPrivadoSelected = optional($this->alianza->paisTipoSectorPrivadoSelected)->tipo_sector_privado_id;
        $this->tipoSectorPrivadoSelectedPivot = optional($this->alianza->paisTipoSectorPrivadoSelected)->id;

        $this->origenEmpresaPrivadaSelected = optional($this->alianza->paisOrigenEmpresaPrivadaSelected)->origen_empresa_privada_id;
        $this->origenEmpresaPrivadaSelectedPivot = optional($this->alianza->paisOrigenEmpresaPrivadaSelected)->id;

        $this->tamanoEmpresaPrivadaSelected = optional($this->alianza->paisTamanoEmpresaPrivadaSelected)->tamano_empresa_privada_id;
        $this->tamanoEmpresaPrivadaSelectedPivot = optional($this->alianza->paisTamanoEmpresaPrivadaSelected)->id;

        $this->tipoSectorComunitariaSelected = optional($this->alianza->paisTipoSectorComunitariaSelected)->tipo_sector_comunitaria_id;
        $this->tipoSectorComunitariaSelectedPivot = optional($this->alianza->paisTipoSectorComunitariaSelected)->id;

        $this->tipoSectorAcademicaSelected = optional($this->alianza->paisTipoSectorAcademicaSelected)->pais_tipo_sector_academica_id;
        $this->tipoSectorAcademicaSelectedPivot = optional($this->alianza->paisTipoSectorAcademicaSelected)->id;

        $this->objetivoAsistenciaAlianzaSelected = optional($this->alianza->paisObjetivoAsistenciaAlianzaSelected)->objetivo_asistencia_alianza_id;
        $this->objetivoAsistenciaAlianzaSelectedPivot = optional($this->alianza->paisObjetivoAsistenciaAlianzaSelected)->id;

        $this->nombre_contacto = $this->alianza->nombre_contacto;
        $this->contacto_telefono = $this->alianza->telefono_contacto;
        $this->contacto_email = $this->alianza->email_contacto;

        $this->otros_tipo_alianza = $this->alianza->otros_tipo_alianza;
        $this->fecha_inicio = $this->alianza->fecha_inicio;
        $this->fecha_fin_tentativa = $this->alianza->fecha_fin_tentativa;

        //$this->pais_proposito_alianza_id = $alianza->pais_proposito_alianza_id;
        $this->otro_proposito_alianza = $this->alianza->otro_proposito_alianza;

        // $this->modalidad_estrategia_alianza_pais_id = $alianza->modalidad_estrategia_alianza_pais_id;
        // $this->pais_objetivo_asistencia_alianza_id = $alianza->pais_objetivo_asistencia_alianza_id;
        $this->otro_objetivo_asistencia_alianza = $this->alianza->otro_objetivo_asistencia_alianza;

        $this->impacto_previsto_alianza = $this->alianza->impacto_previsto_alianza;

        if(!empty($this->alianza->documento_respaldo)){
            $this->documento_respaldo = Storage::disk('s3')->temporaryUrl($this->alianza->documento_respaldo, now()->addMinutes(10));
        }

        $this->comentario = $this->alianza->comentario;

        $preAlianza = PreAlianza::where('pais_organizacion_alianza_id' , $this->alianza->pais_organizacion_alianza_id)
                     ->first();

        $this->organizacionSelected = [
            'value' => $preAlianza->id ?? null
        ];
    }

    public function save(?Alianza $alianza = null): void
    {

        if ($alianza) {
            $this->alianza = $alianza;
        }


        DB::transaction(function () {

            $this->validate();

            $socioImplementador = $this->getSocioImplementador();

            $preAlianza = PreAlianza::find($this->organizacionSelected['value'] ?? null);

            $this->alianza->pais_id                    = $this->pais->id;
            $this->alianza->proyecto_id                 = $this->proyecto->id;


            $this->alianza->nombre_organizacion          = $this->nombre_organizacion;
            $this->alianza->socio_implementador_id       = $socioImplementador->id ?? null;
            $this->alianza->pais_organizacion_alianza_id = $preAlianza->pais_organizacion_alianza_id ?? null;
            $this->alianza->ciudad_id                    = $this->ciudadSelected;

            $this->alianza->pais_tipo_sector_id         = $this->tipoSectorSelectedPivot;

            $this->alianza->pais_tipo_sector_publico_id = $this->tipoSectorPublicoSelectedPivot;
            $this->alianza->pais_tipo_sector_privado_id = $this->tipoSectorPrivadoSelectedPivot;
            $this->alianza->otro_tipo_sector_privado        = $this->otro_sector_privado;
            $this->alianza->pais_origen_empresa_privada_id  = $this->origenEmpresaPrivadaSelectedPivot;


            $this->alianza->pais_tamano_empresa_privada_id  = $this->tamanoEmpresaPrivadaSelectedPivot;
            $this->alianza->pais_tipo_sector_comunitaria_id = $this->tipoSectorComunitariaSelectedPivot;

            $this->alianza->pais_tipo_sector_academica_id   = $this->tipoSectorAcademicaSelectedPivot;

            $this->alianza->nombre_contacto   = $this->nombre_contacto;
            $this->alianza->telefono_contacto = $this->contacto_telefono;
            $this->alianza->email_contacto    = $this->contacto_email;

            $this->alianza->pais_tipo_alianza_id = $this->tipoAlianzaSelectedPivot;

            $this->alianza->otros_tipo_alianza   = $this->otros_tipo_alianza;
            $this->alianza->fecha_inicio         = $this->fecha_inicio;
            $this->alianza->fecha_fin_tentativa  = $this->fecha_fin_tentativa;

            $this->alianza->pais_proposito_alianza_id = $this->propositoAlianzaSelectedPivot;
            $this->alianza->otro_proposito_alianza    = $this->otro_proposito_alianza;

            $this->alianza->modalidad_estrategia_alianza_pais_id = $this->modalidadEstrategiaAlianzaSelectedPivot;
            $this->alianza->objetivo_asistencia_alianza_pais_id  = $this->objetivoAsistenciaAlianzaSelectedPivot;
            $this->alianza->otro_objetivo_asistencia_alianza     = $this->otro_objetivo_asistencia_alianza;
            $this->alianza->impacto_previsto_alianza             = $this->impacto_previsto_alianza;
            $this->alianza->comentario                           = $this->comentario;

            if ($this->documento_respaldo_upload) {
                $this->alianza->documento_respaldo = $this->documento_respaldo_upload->store('resultado3/alianzas/documento_respaldo', 's3');
            }

            $this->alianza->gestor_id = auth()->user()->id;

            $this->alianza->save();

            $this->alianza->areascoberturas()->sync($this->coberturaSelected);

            //Create Socioeconomico for participante only for the first time
            if (!$this->alianza->estados_registros()->count()) {
                $estado = EstadoRegistroAlianza::DOCUMENTACION_PENDIENTE;

                if($this->alianza->documento_respaldo){
                    $estado = EstadoRegistroAlianza::PENDIENTE_REVISION;
                }

                $this->alianza->estados_registros()->attach($estado,
                    [
                        'created_by' => auth()->user()->id,
                    ]
                );
            }

            $this->createOrUpdateOrganizacion([
                'nombre' => $this->nombre_organizacion,
                'email' => $this->contacto_email,
                'telefono' => $this->contacto_telefono,
                'nombre_contacto' => $this->nombre_contacto,
                'telefono_contacto' => $this->contacto_telefono,
                'pais' => $this->pais,
            ]);
        });
    }

    public function getSocioImplementador(){
        $user = auth()->user()->load('socioImplementador');

        return $user->socioImplementador;
    }


}
