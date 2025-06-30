<?php

namespace App\Livewire\Resultadotres\Gestor\CostShares\Forms;

use App\Livewire\Resultadotres\Gestor\CostShares\Traits\FormUtility;
use App\Models\Ciudad;
use App\Models\CostShare;
use App\Models\Departamento;
use App\Models\EstadoRegistro;
use App\Models\EstadoRegistroCostShare;
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

class CostShareForm extends Form
{
    use WithFileUploads, FormUtility, Organizaciones;

    public ?CostShare $costShare;

    public Proyecto $proyecto;

    public Pais $pais;

    public $departamentos;

    public $ciudades;

    public $ciudadSelected;

    public $departamentoSelected;

    public $nombre_organizacion;

    //public $tipoOrganizacion;

    public $organizacionSelected = [];

    public $organizaciones;

    public $coberturaSelected = [];

    public $tipoSectorPublica = 0;

    public $tipoSectorPrivada = 0;

    public $otroTipoSectorPrivado = 0;

    public $tipoSectorComunitaria = 0;

    public $tipoSectorAcademica = 0;

    public $otro_sector_privado;

    public $tipoSectorSelected;

    public $tipoSectorPublicoSelected;

    public $tipoSectorPrivadoSelected;

    public $tipoSectorComunitariaSelected;

    public $tipoSectorAcademicaSelected;

    public $tamanoEmpresaPrivadaSelected;

    public $origenEmpresaPrivadaSelected;

    public bool $readonly = false;

    public $showValidationErrorIndicator = false;

    public $showSuccessIndicator = false;

    public $showCoberturaWarning = false;

    public bool $openOrganizacionName = false;

    public $contribucion;

    public $categoriaSelected = [];

    public $actividadSelected = [];

    public $resultadoSelected = [];

    public $metodoValoracionSelected;

    public $monto;

    public $documento_respaldo;

    public $documento_respaldo_upload;

    public $resultadoPorcentajes = [];

    public $registrado_contablemente;




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
            /*'tipoOrganizacion' => [
                'required',
            ],*/
            'departamentoSelected' => [
                'required'
            ],
            'registrado_contablemente' => [
                'required'
            ],
            'ciudadSelected' => [
                'required'
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
            'otro_sector_privado' => [
                Rule::requiredIf(function () {
                    if ($this->pais->id == 1) {
                        return TipoSector::OPCION_PRIVADA_GT == $this->tipoSectorSelected && $this->tipoSectorPrivadoSelected == TipoSectorPrivado::OTRO_TIPO_SECTOR_PRIVADO;
                    }
                })
            ],
            'contribucion' => ['required'],
            'monto' => ['required', 'numeric', 'min:0'],
            'metodoValoracionSelected' => ['required'],
            'categoriaSelected' => ['required'],
            'actividadSelected' => ['required'],
            'resultadoSelected' => ['required'],
            'resultadoPorcentajes.*' => 'nullable|numeric|min:0|max:100',
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
            'organizacionSelected.required' => 'Debe seleccionar una organización.',
            'departamentoSelected.required' => 'Debe seleccionar un departamento.',
            'ciudadSelected.required' => 'Debe seleccionar una ciudad.',
            'tipoSectorSelected.required' => 'Debe seleccionar un tipo de sector.',
            'tipoSectorPublicoSelected.required' => 'Debe seleccionar un tipo de sector público.',
            'tipoSectorPrivadoSelected.required' => 'Debe seleccionar un tipo de sector privado.',
            'origenEmpresaPrivadaSelected.required' => 'Debe seleccionar el origen de la empresa privada.',
            'tamanoEmpresaPrivadaSelected.required' => 'Debe seleccionar el tamaño de la empresa privada.',
            'tipoSectorComunitariaSelected.required' => 'Debe seleccionar un tipo de sector comunitario.',
            'tipoSectorAcademicaSelected.required' => 'Debe seleccionar un tipo de sector académico.',
            'otro_sector_privado.required' => 'Debe especificar el otro tipo de sector privado.',
            'contribucion.required' => 'La contribución es obligatoria.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.min' => 'El monto debe ser mayor o igual a 0.',
            'metodoValoracionSelected.required' => 'Debe seleccionar un método de valoración.',
            'categoriaSelected.required' => 'Debe seleccionar al menos una categoría.',
            'actividadSelected.required' => 'Debe seleccionar al menos una actividad.',
            'resultadoSelected.required' => 'Debe seleccionar al menos un resultado.',
            'resultadoPorcentajes.*.numeric' => 'El porcentaje debe ser un número.',
            'resultadoPorcentajes.*.min' => 'El porcentaje debe ser mayor o igual a 0.',
            'resultadoPorcentajes.*.max' => 'El porcentaje debe ser menor o igual a 100.',
            'documento_respaldo_upload.required' => 'Debe subir un documento de respaldo.',
            'documento_respaldo_upload.file' => 'El documento de respaldo debe ser un archivo.',
            'documento_respaldo_upload.mimes' => 'El documento de respaldo debe ser un archivo de tipo: pdf, docx, jpeg, png.',
            'documento_respaldo_upload.min' => 'El documento de respaldo debe tener al menos 1KB.',
            'documento_respaldo_upload.max' => 'El documento de respaldo no debe exceder los 10MB.',
            'registrado_contablemente.required' => 'Debe seleccionar si el cost share está registrado contablemente.',
        ];
    }

    public function updatedMonto($value)
    {
        $this->validateOnly('numero');
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
    }

    public function setDepartamento($departamento) : void {
        $this->departamentoSelected = $departamento;
    }

    public function setCiudades() : void {
        $this->ciudades = Ciudad::active()
            ->where('departamento_id', $this->departamentoSelected)
            ->pluck("nombre", "id");
    }

    public function setCostShare($costShare){
        $this->costShare = $costShare->load(
            'socioImplementador:id,nombre',
            'areascoberturas:id,nombre',
            'tipoSectorSelected:id,pais_id,tipo_sector_id',
            'paisTipoSectorPublicoSelected:id,pais_id,tipo_sector_publico_id',
            'paisOrigenEmpresaPrivadaSelected:id,pais_id,origen_empresa_privada_id',
            'paisTamanoEmpresaPrivadaSelected:id,pais_id,tamano_empresa_privada_id',
        );

        $this->nombre_organizacion = $this->costShare->nombre_organizacion;
        //$this->tipoOrganizacion = $this->costShare->tipo_organizacion;
        $this->ciudadSelected = $this->costShare->ciudad_id;

        $this->coberturaSelected = $this->costShare->areascoberturas->pluck('id')->toArray();

        $this->tipoSectorSelected = $this->costShare->tipoSectorSelected->tipo_sector_id;

        $this->openOrganizacionName = $this->costShare->es_nueva_organizacion;

        $this->tipoSectorPublicoSelected = optional($this->costShare->paisTipoSectorPublicoSelected)->tipo_sector_publico_id;
        $this->tipoSectorPrivadoSelected = optional($this->costShare->paisTipoSectorPrivadoSelected)->tipo_sector_privado_id;
        $this->origenEmpresaPrivadaSelected = optional($this->costShare->paisOrigenEmpresaPrivadaSelected)->origen_empresa_privada_id;
        $this->tamanoEmpresaPrivadaSelected = optional($this->costShare->paisTamanoEmpresaPrivadaSelected)->tamano_empresa_privada_id;
        $this->tipoSectorComunitariaSelected = optional($this->costShare->paisTipoSectorComunitariaSelected)->tipo_sector_comunitaria_id;
        $this->tipoSectorAcademicaSelected = optional($this->costShare->paisTipoSectorAcademicaSelected)->pais_tipo_sector_academica_id;

        $this->contribucion = $this->costShare->descripcion_contribucion;

        $this->registrado_contablemente = $this->costShare->registrado_contablemente;

        $this->monto = $this->costShare->monto;
        $this->metodoValoracionSelected = $this->costShare->pais_costshare_valoracion_id;

        $this->documento_respaldo =  Storage::disk('s3')->temporaryUrl($this->costShare->documento_soporte, now()->addMinutes(10));

        //$this->documentoSoporte = $this->costShare->documento_respaldo;

        $this->categoriaSelected =  $this->costShare->categoria
        ->pluck('id')
        ->toArray();

        $this->actividadSelected =  $this->costShare->actividad
        ->pluck('id')
        ->toArray();

        $this->resultadoSelected =  $this->costShare->resultado
        ->pluck('id')
        ->toArray();

        $this->resultadoPorcentajes = $this->costShare->resultado
            ->mapWithKeys(function ($resultado) {
                return [$resultado->id => $resultado->pivot->porcentaje];
            })
            ->toArray();

        if( !$this->openOrganizacionName ){
            $this->organizacionSelected = [
                'value' => $this->costShare->pais_organizacion_alianza_id
            ];
        }else {
            $this->organizacionSelected = [];
        }

    }

  //  public function save(?Apalancamiento $apalancamiento = null): void {
    public function save(?CostShare $costShare = null): void {

        if($costShare){
            $this->costShare = $costShare;
        }

        \DB::transaction(function(){
            $this->validate();

            $paisOrganizacionID = null;

            $socioImplementador = $this->getSocioImplementador();

            if ($this->openOrganizacionName){
                $this->costShare->nombre_organizacion = $this->nombre_organizacion;
                $this->costShare->es_nueva_organizacion = 1;

                $paisOrganizacion = $this->createOrUpdateOrganizacion([
                    'nombre' => $this->nombre_organizacion,
                    'pais' => $this->pais,
                ]);

                $paisOrganizacionID = $paisOrganizacion->id;

            }else {

                $this->costShare->es_nueva_organizacion = 0;

                $paisOrganizacionAlianza = $this->getOrganizacionPorId($this->organizacionSelected['value']);

                $organizacionAlianza = $paisOrganizacionAlianza->organizacionAlianza;
                $paisOrganizacionID = $paisOrganizacionAlianza->id;

                $this->costShare->nombre_organizacion = $organizacionAlianza->nombre;
            }

            $this->costShare->pais_id = $this->pais->id;
            $this->costShare->proyecto_id = $this->proyecto->id;

            $this->costShare->pais_organizacion_alianza_id = $paisOrganizacionID;
            //$this->costShare->tipo_organizacion = $this->tipoOrganizacion;
            $this->costShare->socio_implementador_id       = $socioImplementador->id;
            $this->costShare->ciudad_id                    = $this->ciudadSelected;

            $this->costShare->pais_tipo_sector_id         = $this->getPaisTipoSectorId();
            $this->costShare->pais_tipo_sector_publico_id = $this->getPaisTipoSectorPublicoId();
            $this->costShare->pais_tipo_sector_privado_id = $this->getPaisTipoSectorPrivadaId();


            $this->costShare->otro_tipo_sector_privado        = $this->otro_sector_privado;
            $this->costShare->pais_origen_empresa_privada_id  = $this->getOrigenEmpresaPrivadaSelected();
            $this->costShare->pais_tamano_empresa_privada_id  = $this->getTamanoEmpresaPrivadaSelected();
            $this->costShare->pais_tipo_sector_comunitaria_id = $this->getTipoSectorComunitariaSelected();
            $this->costShare->pais_tipo_sector_academica_id   = $this->getTipoSectorAcademicaSelected();

            $this->costShare->descripcion_contribucion = $this->contribucion;
            $this->costShare->monto = $this->monto;

            $this->costShare->pais_costshare_valoracion_id = $this->metodoValoracionSelected;

            $this->costShare->gestor_id = auth()->user()->id;

            if ($this->documento_respaldo_upload) {
                $this->costShare->documento_soporte = $this->documento_respaldo_upload->store('resultado3/cost-shares/documento_respaldo', 's3');
            }

            $this->costShare->registrado_contablemente = $this->registrado_contablemente;

            $this->costShare->save();

            $this->costShare->areascoberturas()->sync($this->coberturaSelected);

            $this->updateCategorias();

            $this->updateActividades();

            $this->updateResultados();

            if (!$this->costShare->estados_registros()->count()) {
                $this->costShare->estados_registros()
                    ->attach(EstadoRegistroCostShare::PENDIENTE_REVISION);
            }
        });
    }

}
