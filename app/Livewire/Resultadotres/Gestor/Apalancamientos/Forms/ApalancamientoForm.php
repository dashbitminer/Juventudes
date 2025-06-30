<?php

namespace App\Livewire\Resultadotres\Gestor\Apalancamientos\Forms;

use App\Enums\TipoOrganizacion;
use App\Models\Apalancamiento;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\EstadoRegistroApalancamiento;
use App\Models\OrganizacionAlianza;
use App\Models\Pais;
use App\Models\PaisOrganizacionAlianza;
use App\Models\Proyecto;
use App\Models\TipoSector;
use App\Models\TipoSectorPrivado;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\Form;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Resultadotres\Gestor\Prealianzas\Organizaciones;

class ApalancamientoForm extends Form
{
    use WithFileUploads;

    use Organizaciones;

    public ?Apalancamiento $apalancamiento;

    public Proyecto $proyecto;

    public Pais $pais;

    /// Datos de la organización
    public $nombre_organizacion;

    public $tipoOrganizacion;

    public $departamentos;

    public $ciudades;

    public $departamentoSelected;

    public $ciudadSelected;

    public $coberturaSelected = [];

    public $tipoSectorSelected;

    public $tipoSectorPublicoSelected;

    public $tipoSectorPrivadoSelected;

    public $tipoSectorComunitariaSelected;

    public $tipoSectorAcademicaSelected;

    public $tipoSectorPublica = 0;

    public $tipoSectorPrivada = 0;

    public $tipoSectorComunitaria = 0;

    public $tipoSectorAcademica = 0;

    public $otroTipoSectorPrivado = 0;

    public $otroObjetivoAsistenciaAlianza = 11;

    public $otro_sector_privado;

    public $origenEmpresaPrivadaSelected;

    public $tamanoEmpresaPrivadaSelected;

    /// Apalancamiento
    public $tipoRecursoSelected;

    public $tipoRecursoEspecieSelected;

    public $modalidadEstrategiaSelected;
    public $objetivoAsistenciaSelected;

    public $origenRecursoSelected;

    public $fuenteRecursoSelected;

    public $conceptoRecurso;

    public $montoApalancado;

    public $nombreRegistra;

    public $documento_respaldo;

    public $documento_respaldo_upload;

    public $comentario;

    public $organizacionSelected = [];

    public $organizaciones;


    /// Form

    public bool $readonly = false;

    public $showValidationErrorIndicator = false;

    public $showSuccessIndicator = false;

    public $showCoberturaWarning = false;

    public bool $openOrganizacionName = false;

    public $otros_recursos_sector;

    public $otros_fuente_recursos_sector;

    public $otro_objetivo_asistencia_alianza;


    public function boot()
    {
        $this->withValidator(function ($validator) {

            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    public function rules(): array{
        return [
            'nombre_organizacion' => [
                Rule::requiredIf(function () {
                    return $this->openOrganizacionName;
                }),
            ],
            'organizacionSelected' => [
                Rule::requiredIf(function () {
                    return !$this->openOrganizacionName;
                }),
            ],
            'departamentoSelected' => [
                'required'
            ],
            'ciudadSelected' => [
                'required'
            ],
            'tipoSectorSelected' => [
                'required'
            ],
            'otros_recursos_sector' => [
                Rule::requiredIf(function () {
                    return $this->origenRecursoSelected == 4;
                })
            ],
            'otros_fuente_recursos_sector' => [
                Rule::requiredIf(function () {
                    return $this->fuenteRecursoSelected == 5;
                })
            ],
            'otro_objetivo_asistencia_alianza' => [
                Rule::requiredIf(function () {
                    return $this->objetivoAsistenciaSelected == $this->otroObjetivoAsistenciaAlianza;
                })
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
            'otro_sector_privado' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoSector::OPCION_PRIVADA_GT == $this->tipoSectorSelected && $this->tipoSectorPrivadoSelected == TipoSectorPrivado::OTRO_TIPO_SECTOR_PRIVADO;
                    }
                })
            ],
            'tipoRecursoSelected' => [
                'required'
            ],
            'tipoRecursoEspecieSelected' => [
                Rule::requiredIf(function () {
                   return $this->tipoRecursoSelected == 2;
                })
            ],
            'origenRecursoSelected' => [
                'required'
            ],
            'fuenteRecursoSelected' => [
                'required'
            ],
            'modalidadEstrategiaSelected' => [
                'required'
            ],
            'objetivoAsistenciaSelected' => [
                'required'
            ],

            'conceptoRecurso' => [
                'required'
            ],

            'montoApalancado' => [
                'required'
            ],

            'nombreRegistra' => [
                'required'
            ],

            'documento_respaldo_upload' => [
                Rule::when(!$this->documento_respaldo, [
                    'required',
                    File::types(['pdf', 'docx', 'jpeg', 'png'])
                        ->min('1kb')
                        ->max('2mb'),
                ]),
            ]

        ];
    }

    public function messages(): array
    {
        return [
            'nombre_organizacion.required_if' => 'El nombre de la organización es obligatorio cuando se selecciona una nueva organización.',
            'organizacionSelected.required_if' => 'Debe seleccionar una organización existente.',
            'departamentoSelected.required' => 'El departamento es obligatorio.',
            'ciudadSelected.required' => 'La ciudad es obligatoria.',
            'tipoSectorSelected.required' => 'El tipo de sector es obligatorio.',
            'tipoSectorPublicoSelected.required_if' => 'El tipo de sector público es obligatorio para el país seleccionado.',
            'tipoSectorPrivadoSelected.required_if' => 'El tipo de sector privado es obligatorio para el país seleccionado.',
            'origenEmpresaPrivadaSelected.required_if' => 'El origen de la empresa privada es obligatorio para el país seleccionado.',
            'tamanoEmpresaPrivadaSelected.required_if' => 'El tamaño de la empresa privada es obligatorio para el país seleccionado.',
            'tipoSectorComunitariaSelected.required_if' => 'El tipo de sector comunitario es obligatorio para el país seleccionado.',
            'tipoSectorAcademicaSelected.required_if' => 'El tipo de sector académico es obligatorio para el país seleccionado.',
            'otro_sector_privado.required_if' => 'Debe especificar el otro tipo de sector privado.',
            'tipoRecursoSelected.required' => 'El tipo de recurso es obligatorio.',
            'tipoRecursoEspecieSelected.required_if' => 'El tipo de recurso en especie es obligatorio cuando se selecciona el tipo de recurso correspondiente.',
            'origenRecursoSelected.required' => 'El origen del recurso es obligatorio.',
            'fuenteRecursoSelected.required' => 'La fuente del recurso es obligatoria.',
            'modalidadEstrategiaSelected.required' => 'La modalidad de estrategia es obligatoria.',
            'objetivoAsistenciaSelected.required' => 'El objetivo de asistencia es obligatorio.',
            'conceptoRecurso.required' => 'El concepto del recurso es obligatorio.',
            'montoApalancado.required' => 'El monto apalancado es obligatorio.',
            'nombreRegistra.required' => 'El nombre de la persona que registra es obligatorio.',
            'documento_respaldo_upload.required' => 'El documento de respaldo es obligatorio.',
            'documento_respaldo_upload.file' => 'El documento de respaldo debe ser un archivo válido.',
            'documento_respaldo_upload.mimes' => 'El documento de respaldo debe ser un archivo de tipo: pdf, docx, jpeg, png.',
            'documento_respaldo_upload.min' => 'El documento de respaldo debe tener un tamaño mínimo de 1KB.',
            'documento_respaldo_upload.max' => 'El documento de respaldo no debe exceder los 2MB.',
            'otros_recursos_sector.required_if' => 'El campo otros recursos del sector es obligatorio cuando el origen del recurso seleccionado es otro.',
            'otros_fuente_recursos_sector.required_if' => 'El campo otros fuente de recursos del sector es obligatorio cuando la fuente del recurso seleccionada es otra.',
            'otro_objetivo_asistencia_alianza.required_if' => 'El campo otro objetivo de asistencia de la alianza es obligatorio cuando el objetivo de asistencia seleccionado es otro.',
        ];
    }

    public function setProyecto(Proyecto $proyecto): void
    {
        $this->proyecto = $proyecto;
    }

    public function setPais(Pais $pais){
        $this->pais = $pais;
    }

    public function init(){
        $this->departamentos = Departamento::active()
            ->where('pais_id', $this->pais->id)->pluck('nombre', 'id');

        $this->organizaciones = OrganizacionAlianza::join('pais_organizacion_alianza', 'organizacion_alianzas.id', '=', 'pais_organizacion_alianza.organizacion_alianza_id')
            ->where('pais_organizacion_alianza.pais_id', $this->pais->id)
            ->pluck('organizacion_alianzas.nombre', 'pais_organizacion_alianza.id');

        $this->ciudades = [];

        if ($this->pais->id == 1) {
            $this->tipoSectorPublica = TipoSector::OPCION_PUBLICA_GT;
            $this->tipoSectorPrivada = TipoSector::OPCION_PRIVADA_GT;
            $this->tipoSectorComunitaria = TipoSector::OPCION_COMUNITARIA_GT;
            $this->tipoSectorAcademica = TipoSector::OPCION_ACADEMICA_GT;
            $this->otroTipoSectorPrivado = TipoSectorPrivado::OTRO_TIPO_SECTOR_PRIVADO;
        }
    }

    public function setDepartamento($departamento) : void {
        $this->departamentoSelected = $departamento;
    }

    public function setCiudades() : void {
        $this->ciudades = Ciudad::active()
            ->where('departamento_id', $this->departamentoSelected)
            ->pluck("nombre", "id");
    }

    public function setApalancamiento($apalancamiento){
        $this->apalancamiento = $apalancamiento->load(
            'socioImplementador:id,nombre',
            'areascoberturas:id,nombre',
            'tipoSectorSelected:id,pais_id,tipo_sector_id',
            'paisTipoSectorPublicoSelected:id,pais_id,tipo_sector_publico_id',
            'paisTipoSectorPrivadoSelected:id,pais_id,tipo_sector_privado_id',
            'paisTipoRecursoSelected:id,pais_id,tipo_recurso_id',
            'paisOrigenRecursoSelected:id,pais_id,origen_recurso_id',
            'paisFuenteRecursoSelected:id,pais_id,fuente_recurso_id',
            'paisOrigenEmpresaPrivadaSelected:id,pais_id,origen_empresa_privada_id',
            'paisTamanoEmpresaPrivadaSelected:id,pais_id,tamano_empresa_privada_id',
            'modalidadEstrategiaApalancamientoSelected:id,pais_id,modalidad_estrategia_alianza_id',
        );

        $this->nombre_organizacion = $this->apalancamiento->nombre_organizacion;
        $this->tipoOrganizacion = $this->apalancamiento->tipo_organizacion;
        $this->ciudadSelected = $this->apalancamiento->ciudad_id;
        $this->comentario = $this->apalancamiento->comentario;
        $this->coberturaSelected = $this->apalancamiento->areascoberturas->pluck('id')->toArray();

        $this->tipoSectorSelected = $this->apalancamiento->tipoSectorSelected->tipo_sector_id;

        $this->openOrganizacionName = $this->apalancamiento->es_nueva_organizacion;

       // dd($this->apalancamiento);

        $this->tipoSectorPublicoSelected = optional($this->apalancamiento->paisTipoSectorPublicoSelected)->tipo_sector_publico_id;
        $this->tipoSectorPrivadoSelected = optional($this->apalancamiento->paisTipoSectorPrivadoSelected)->tipo_sector_privado_id;
        $this->origenEmpresaPrivadaSelected = optional($this->apalancamiento->paisOrigenEmpresaPrivadaSelected)->origen_empresa_privada_id;
        $this->tamanoEmpresaPrivadaSelected = optional($this->apalancamiento->paisTamanoEmpresaPrivadaSelected)->tamano_empresa_privada_id;
        $this->tipoSectorComunitariaSelected = optional($this->apalancamiento->paisTipoSectorComunitariaSelected)->tipo_sector_comunitaria_id;
        $this->tipoSectorAcademicaSelected = optional($this->apalancamiento->paisTipoSectorAcademicaSelected)->pais_tipo_sector_academica_id;


        $this->tipoRecursoSelected = optional($this->apalancamiento->paisTipoRecursoSelected)->tipo_recurso_id; //$this->apalancamiento->pais_tipo_recurso_id;

        $this->tipoRecursoEspecieSelected = $this->apalancamiento->tipo_recurso_especie;

        $this->origenRecursoSelected = optional($this->apalancamiento->paisOrigenRecursoSelected)->origen_recurso_id;

        $this->fuenteRecursoSelected = optional($this->apalancamiento->paisFuenteRecursoSelected)->fuente_recurso_id;

        $this->conceptoRecurso = $this->apalancamiento->concepto_recurso;
        $this->montoApalancado = $this->apalancamiento->monto_apalancado;
        $this->nombreRegistra = $this->apalancamiento->nombre_persona_registra;

        $this->otro_sector_privado = $this->apalancamiento->otro_tipo_sector_privado;

        $this->documento_respaldo = $this->apalancamiento->documento_respaldo;

        $this->modalidadEstrategiaSelected = $this->apalancamiento->modalidadEstrategiaApalancamientoSelected->modalidad_estrategia_alianza_id;
        $this->objetivoAsistenciaSelected = optional($this->apalancamiento->paisObjetivoAsistenciaApalancamientoSelected)->objetivo_asistencia_alianza_id;

        if( !$this->openOrganizacionName ){
            $this->organizacionSelected = [
                'value' => $this->apalancamiento->pais_organizacion_alianza_id
            ];
        }else {
            $this->organizacionSelected = [];
        }

        $this->documento_respaldo = Storage::disk('s3')->temporaryUrl($this->apalancamiento->documento_respaldo, now()->addMinutes(10));

        $this->otros_recursos_sector = $this->apalancamiento->otros_recursos_sector;

        $this->otros_fuente_recursos_sector = $this->apalancamiento->otros_fuente_recursos_sector;

        $this->otro_objetivo_asistencia_alianza = $this->apalancamiento->otro_objetivo_asistencia_alianza;


    }

    public function save(?Apalancamiento $apalancamiento = null): void {


        if($apalancamiento){
            $this->apalancamiento = $apalancamiento;
        }
        \DB::transaction(function(){
            $this->validate();

            $paisOrganizacionID = null;

            if ($this->openOrganizacionName){
                $this->apalancamiento->nombre_organizacion = $this->nombre_organizacion;
                $this->apalancamiento->es_nueva_organizacion = 1;
                $this->tipoOrganizacion = TipoOrganizacion::Nueva;

                $paisOrganizacion = $this->createOrUpdateOrganizacion([
                    'nombre' => $this->nombre_organizacion,
                    'pais' => $this->pais,
                ]);

                $paisOrganizacionID = $paisOrganizacion->id;
            }else {

                $this->apalancamiento->es_nueva_organizacion = 0;

                $paisOrganizacionAlianza = $this->getOrganizacionPorId($this->organizacionSelected['value']);

                $organizacionAlianza = $paisOrganizacionAlianza->organizacionAlianza;
                $paisOrganizacionID = $paisOrganizacionAlianza->id;

                $this->apalancamiento->nombre_organizacion = $organizacionAlianza->nombre;
                $this->tipoOrganizacion = TipoOrganizacion::Existente;
            }

            

            $socioImplementador = $this->getSocioImplementador();

            $this->apalancamiento->pais_id = $this->pais->id;
            $this->apalancamiento->proyecto_id = $this->proyecto->id;

            $this->apalancamiento->pais_organizacion_alianza_id = $paisOrganizacionID;
            $this->apalancamiento->tipo_organizacion = $this->tipoOrganizacion;

            $this->apalancamiento->socio_implementador_id       = $socioImplementador->id;
            $this->apalancamiento->ciudad_id                    = $this->ciudadSelected;

            $this->apalancamiento->pais_tipo_sector_id         = $this->getPaisTipoSectorId();
            $this->apalancamiento->pais_tipo_sector_publico_id = $this->getPaisTipoSectorPublicoId();
            $this->apalancamiento->pais_tipo_sector_privado_id = $this->getPaisTipoSectorPrivadaId();


            $this->apalancamiento->otro_tipo_sector_privado        = $this->otro_sector_privado;
            $this->apalancamiento->pais_origen_empresa_privada_id  = $this->getOrigenEmpresaPrivadaSelected();
            $this->apalancamiento->pais_tamano_empresa_privada_id  = $this->getTamanoEmpresaPrivadaSelected();
            $this->apalancamiento->pais_tipo_sector_comunitaria_id = $this->getTipoSectorComunitariaSelected();
            $this->apalancamiento->pais_tipo_sector_academica_id   = $this->getTipoSectorAcademicaSelected();

            $this->apalancamiento->pais_tipo_recurso_id = $this->getTipoRecursoSelected();
            $this->apalancamiento->tipo_recurso_especie = $this->tipoRecursoEspecieSelected;
            $this->apalancamiento->pais_origen_recurso_id = $this->getOrigenRecursoSelected();
            $this->apalancamiento->pais_fuente_recurso_id = $this->getfuenteRecursoSelected();

            $this->apalancamiento->modalidad_estrategia_alianza_pais_id = $this->getModalidadEstrategiaPaisId();
            $this->apalancamiento->objetivo_asistencia_alianza_pais_id  = $this->getObjetivoAsistenciaSelected();

            $this->apalancamiento->concepto_recurso = $this->conceptoRecurso;

            $this->apalancamiento->monto_apalancado = $this->montoApalancado;

            $this->apalancamiento->nombre_persona_registra = $this->nombreRegistra;

            $this->apalancamiento->comentario = $this->comentario;

            if ($this->documento_respaldo_upload) {
                $this->apalancamiento->documento_respaldo = $this->documento_respaldo_upload->store('resultado3/apalancamientos/documento_respaldo', 's3');
            }

            $this->apalancamiento->gestor_id = auth()->user()->id;

            $this->apalancamiento->otros_recursos_sector = $this->otros_recursos_sector;

            $this->apalancamiento->otros_fuente_recursos_sector = $this->otros_fuente_recursos_sector;

            $this->apalancamiento->otro_objetivo_asistencia_alianza = $this->otro_objetivo_asistencia_alianza;

            $this->apalancamiento->save();

            $this->apalancamiento->areascoberturas()->sync($this->coberturaSelected);

            if (!$this->apalancamiento->estados_registros()->count()) {
                $this->apalancamiento->estados_registros()
                    ->attach(EstadoRegistroApalancamiento::PENDIENTE_REVISION);
            }


        });


    }

    public function getPaisTipoSectorId()  {
        return \DB::table('pais_tipo_sector')
            ->where('tipo_sector_id', $this->tipoSectorSelected)
            ->where('pais_id', $this->pais->id)
            ->value('id');
    }

    public function getPaisTipoSectorPublicoId() {

        return \DB::table('pais_tipo_sector_publico')
            ->where('pais_id', $this->pais->id)
            ->where('tipo_sector_publico_id', $this->tipoSectorPublicoSelected)
            ->value('id');
    }

    public function getPaisTipoSectorPrivadaId() {
        return \DB::table('pais_tipo_sector_privado')
            ->where('pais_id', $this->pais->id)
            ->where('tipo_sector_privado_id', $this->tipoSectorPrivadoSelected)
            ->value('id');
    }

    public function getTipoSectorAcademicaSelected()
    {

        return \DB::table('pais_tipo_sector_academica')
            ->where('pais_id', $this->pais->id)
            ->where('tipo_sector_academica_id', $this->tipoSectorAcademicaSelected)
            ->value('id');
    }

    public function getTipoSectorComunitariaSelected()
    {
        return \DB::table('pais_tipo_sector_comunitaria')
            ->where('pais_id', $this->pais->id)
            ->where('tipo_sector_comunitaria_id', $this->tipoSectorComunitariaSelected)
            ->value('id');
    }

    public function getTamanoEmpresaPrivadaSelected()
    {
        return \DB::table('pais_tamano_empresa_privada')
            ->where('pais_id', $this->pais->id)
            ->where('tamano_empresa_privada_id', $this->tamanoEmpresaPrivadaSelected)
            ->value('id');
    }

    public function getOrigenEmpresaPrivadaSelected()
    {
        return \DB::table('pais_origen_empresa_privada')
            ->where('pais_id', $this->pais->id)
            ->where('origen_empresa_privada_id', $this->origenEmpresaPrivadaSelected)
            ->value('id');

    }

    public function getTipoRecursoSelected(){
        return \DB::table('pais_tipo_recurso')
            ->where('tipo_recurso_id', $this->tipoRecursoSelected)
            ->where('pais_id', $this->pais->id)
            ->value('id');
    }

    public function getOrigenRecursoSelected(){
        return \DB::table('pais_origen_recurso')
            ->where('origen_recurso_id', $this->origenRecursoSelected)
            ->where('pais_id', $this->pais->id)
            ->value('id');
    }

    public function getFuenteRecursoSelected(){
        return \DB::table('pais_fuente_recurso')
            ->where('fuente_recurso_id', $this->fuenteRecursoSelected)
            ->where('pais_id', $this->pais->id)
            ->value('id');
    }

    public function getModalidadEstrategiaPaisId() {
        return \DB::table('modalidad_estrategia_alianza_pais')
            ->where('pais_id', $this->pais->id)
            ->where('modalidad_estrategia_alianza_id', $this->modalidadEstrategiaSelected)
            ->value('id');
    }

    public function getObjetivoAsistenciaSelected()
    {
        return \DB::table('objetivo_asistencia_alianza_pais')
            ->where('pais_id', $this->pais->id)
            ->where('objetivo_asistencia_alianza_id', $this->objetivoAsistenciaSelected)
            ->value('id');
    }

    public function getOrganizacionID($paisOrganizacionID)
    {
        $paisOrganizacionAlianza = PaisOrganizacionAlianza::find($paisOrganizacionID);
        return $paisOrganizacionAlianza->organizacion_alianza_id;

    }

    public function getSocioImplementador(){
        $user = auth()->user()->load('socioImplementador');

        return $user->socioImplementador;
    }
}
