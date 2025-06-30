<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Forms;

use Throwable;
use Livewire\Form;
use App\Models\Pais;
use App\Models\User;
use App\Enums\Country;
use App\Models\Ciudad;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\Departamento;
use App\Models\PaisProyecto;
use App\Models\Participante;
use App\Models\ProyectoVida;
use Livewire\WithFileUploads;
use App\Models\EstadoRegistro;
use App\Models\NivelEducativo;
use App\Rules\RangoEdadValido;
use App\Models\ComunidadEtnica;
use App\Models\GrupoEtnicoPais;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use App\Models\PaisProyectoSocio;
use Livewire\Attributes\Validate;
use App\Models\GrupoPerteneciente;
use Illuminate\Support\Facades\DB;
use App\Models\CohortePaisProyecto;
use Illuminate\Validation\Rules\File;
use App\Rules\UniqueDocumentoIdentidad;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Laravel\Facades\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use App\Services\ImageService;

class ParticipanteForm extends Form
{
    //public User $user;

    use WithFileUploads;

    public Participante $participante;

    public Cohorte $cohorte;

    public Proyecto $proyecto;

    public Pais $pais;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $nombres = '';
    public $apellidos = '';

    #[Validate]
    public $fecha_nacimiento = '';

    // NOMBRES BANCARIZACION PARTICIPANTE
    public $primer_nombre;
    public $segundo_nombre;
    public $tercer_nombre;
    public $primer_apellido;
    public $segundo_apellido;
    public $tercer_apellido;
    public $perfilSelected;

    // NOMBRES BANCARIZACION BENEFICIARIO
    public $primer_nombre_beneficiario;
    public $segundo_nombre_beneficiario;
    public $tercer_nombre_beneficiario;
    public $primer_apellido_beneficiario;
    public $segundo_apellido_beneficiario;
    public $tercer_apellido_beneficiario;

    public $nacionalidad;
    public $estado_civil_id;
    public $tipo_zona_residencia;

    public $departamentoSelected;
    public $ciudad_id;

    public $colonia;
    public $direccion;
    public $sexo;
    public $discapacidadesSelected = [];
    public $comunidadesLinguisticasSelected = [];
    //public $comunidadesLinguisticasSelectedPivot = [];

    // DIRECCION HONDURAS
    public $casa;
    public $bloque;
    public $calle;
    public $sector;

    // DIRECION GUATEMALA
    public $apartamento;
    public $zona;



    public $comunidad_etnica;

    public $proyectoVidaSelected = [];
    public $otroProyectoVidaEspecificar = ProyectoVida::ESPECIFICAR;
    public $proyecto_vida_descripcion;
    public $tiene_hijos;
    public $cantidad_hijos; /*TODO: HACER TIPO NUMBERIO EN MIGRACION ? O SOLO HACER CAST */
    public $responsabilidadHijosSelected = [];
    public $apoyoHijosSelected = [];

    public $estudia_actualmente;
    public $seccion_grado_id;
    public $turno_jornada_id;
    public $nivel_educativo_id;


    public $nivel_educativo_alcanzado_primaria;
    public $nivel_educativo_alcanzado_secundaria;
    public $nivel_educativo_alcanzado_bachillerato;

    public $nivel_academico_id;


    public $participo_actividades_glasswing;
    public $rol_participo;
    public $descripcion_participo;

    // Bancarización
    #[Validate]
    public $documento_identidad;
    public $email;
    public $telefono;

    public $departamentoNacimientoSelected;
    //public $departamento_nacimiento_id;
    public $municipio_nacimiento_id;

    public $departamento_nacimiento_extranjero;
    public $pais_nacimiento_extranjero;
    public $municipio_nacimiento_extranjero;

    // public $nombre_beneficiario;
    public $parentesco_id;
    public $parentesco_otro;

    public $showSuccessIndicator = false;
    public $showValidationErrorIndicator = false;

    // DOCUMENTOS
    public bool $uploaddui = false;
    public $file_documento_identidad_upload;
    public $file_documento_identidad_upload_reverso;
    public $comentario_documento_identidad_upload;

    public bool $uploadcertificado = false;
    public $file_copia_certificado_estudio_upload;
    public $comentario_copia_certificado_estudio_upload;

    public bool $uploadconsentimiento = false;
    public $file_formulario_consentimiento_programa_upload;
    public $comentario_formulario_consentimiento_programa_upload;

    public bool $uploadcompromisoestudio = false;
    public $file_compromiso_continuar_estudio_upload;
    public $comentario_file_compromiso_continuar_estudio_upload;


    public $copia_documento_identidad;
    public $copia_documento_identidad_reverso;
    public $copia_constancia_estudios;
    public $consentimientos_inscripcion_programa;
    public $copia_compromiso_continuar_estudio;

    public $readonly = false;

    public $pdf;

    public $participanteId = NULL;

    #[Validate]
    public $ultimo_anio_estudio;

    public $pariente_participo_jovenes_proposito;

    public $parentescos_parientes_participo;

    public $parentesco_pariente_parcicipo_jovenes_proposito;

    public $continuidad_tres_meses;

    public $tiempo_atender_actividades;

    public $pariente_participo_otros;


    public bool $participacion_voluntaria = true;
    public bool $recoleccion_uso_glasswing = true;
    public bool $compartir_para_investigaciones = true;
    public bool $compartir_para_bancarizacion = true;
    public bool $compartir_por_gobierno = true;
    public bool $voz_e_imagen = true;


    public function boot()
    {
        $this->withValidator(function ($validator) {

            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }


    public function rules()
    {
        return [
            'primer_nombre' => [
                'required',
                'min:2',
            ],
            // 'segundo_nombre' => [
            //     'required',
            //     'min:3',
            // ],
            // 'tercer_nombre' => [
            //     'required',
            //     'min:3',
            // ],
            'primer_apellido' => [
                'required',
                'min:2',
            ],
            // 'segundo_apellido' => [
            //     'required',
            //     'min:3',
            // ],
            // 'tercer_apellido' => [
            //     'required',
            //     'min:3',
            // ],
            'primer_nombre_beneficiario' => [
                'required',
                'min:2',
            ],
            'primer_apellido_beneficiario' => [
                'required',
                'min:2',
            ],
            'pariente_participo_jovenes_proposito' => [
                'required',
            ],
            'parentesco_pariente_parcicipo_jovenes_proposito' => [
                'required_if:pariente_participo_jovenes_proposito,true',
            ],
            'pariente_participo_otros' => [
                'required_if:parentesco_pariente_parcicipo_jovenes_proposito,4',
            ],

            // 'nombres' => [
            //     'required',
            //     'min:3',
            // ],
            // 'apellidos' => [
            //     'required',
            //     'min:3',
            // ],
            'comunidad_etnica' => [
                'required',
            ],
            'tiempo_atender_actividades' => [
                'required',
            ],
            'fecha_nacimiento' => [
                'required',
                'date',
                new RangoEdadValido($this->fecha_nacimiento, $this->cohortePaisProyecto),
            ],
            'nacionalidad' => [
                'required',
            ],
            'departamentoNacimientoSelected' => [
                'required_if:nacionalidad,1',
                'required_without:nacionalidad',
            ],
            'municipio_nacimiento_id' => [
                'required_if:nacionalidad,1',
                'required_without:nacionalidad',
            ],
            'departamento_nacimiento_extranjero' => [
                'required_if:nacionalidad,2',
            ],
            'pais_nacimiento_extranjero' => [
                'required_if:nacionalidad,2',
            ],
            'municipio_nacimiento_extranjero' => [
                'required_if:nacionalidad,2',
            ],
            'estado_civil_id' => [
                'required',
            ],
            'calle' => [
                Rule::requiredIf(function () {
                    return $this->pais->id == Pais::HONDURAS;
                })
            ],
            'tipo_zona_residencia' => [
                'required',
            ],
            'departamentoSelected' => [
                'required',
            ],
            'ciudad_id' => [
                'required',
            ],
            'colonia' => [
                'required',
            ],
            'direccion' => [
                'required',
                'min:5',
            ],
            'sexo' => [
                'required',
            ],
            'discapacidadesSelected' => [
                'required',
            ],
            // 'gruposSelected' => [
            //     'required',
            // ],
            // 'otro_grupo' => [
            //     'required_if:gruposSelected,4',
            // ],
            // 'etnia' => [
            //     'required',
            // ],
            'perfilSelected' => [
                'required',
            ],
            'comunidadesLinguisticasSelected' => [
                Rule::requiredIf(function () {
                    return $this->pais->id == Pais::GUATEMALA;
                })
                //'required',
            ],
            'proyectoVidaSelected' => [
                'required',
            ],
            'proyecto_vida_descripcion' => [
                Rule::requiredIf(function () {
                    return in_array(ProyectoVida::ESPECIFICAR, $this->proyectoVidaSelected);
                })
            ],
            'tiene_hijos' => [
                'required',
            ],
            'cantidad_hijos' => [
                'required_if:tiene_hijos,true',
            ],
            'responsabilidadHijosSelected' => [
                'required_if:tiene_hijos,true',
            ],
            'apoyoHijosSelected' => [
                'required_if:tiene_hijos,true',
            ],
            'estudia_actualmente' => [
                'required',
            ],
            'nivel_academico_id' => [
                'required_if:estudia_actualmente,true',
            ],
            'seccion_grado_id' => [
                'required_if:estudia_actualmente,true',
            ],
            'turno_jornada_id' => [
                'required_if:estudia_actualmente,true',
            ],
            'nivel_educativo_id' => [
                'required_if:estudia_actualmente,false',
            ],
            'ultimo_anio_estudio' => [
                'required_if:estudia_actualmente,false',
            ],
            'participo_actividades_glasswing' => [
                'required',
            ],
            'rol_participo' => [
                'required_if:participo_actividades_glasswing,true',
            ],
            'descripcion_participo' => [
                'required_if:participo_actividades_glasswing,true',
            ],
            'documento_identidad' => [
                'required',
                new UniqueDocumentoIdentidad($this->proyecto->id, $this->participante->id ?? NULL),
                new \App\Rules\DocumentoIdentidadRule($this->pais),
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
            ],
            'telefono' => [
                'required',
                'size:8',
            ],
            'parentesco_id' => [
                'required',
            ],
            'parentesco_otro' => [
                'required_if:parentesco_id,' . \App\Models\Parentesco::OTRO,
            ],

            // DOCUMENTOS
            'file_documento_identidad_upload' => [
                Rule::when($this->uploaddui == true && !$this->copia_documento_identidad, [
                    'required',
                    File::types(['pdf', 'docx', 'jpeg', 'png'])
                        ->min('1kb')
                        ->max('5mb'),
                ]),
            ],

            'file_documento_identidad_upload_reverso' => [
                Rule::when($this->uploaddui == true && !$this->copia_documento_identidad, [
                    'required',
                    File::types(['pdf', 'docx', 'jpeg', 'png'])
                        ->min('1kb')
                        ->max('5mb'),
                ]),
            ],

            'comentario_documento_identidad_upload' => [
                'required_if:uploaddui,false',
            ],

            'file_copia_certificado_estudio_upload' => [
                Rule::when($this->uploadcertificado == true && !$this->copia_constancia_estudios, [
                    'required',
                    File::types(['pdf', 'docx', 'jpeg', 'png'])
                        ->min('1kb')
                        ->max('5mb'),
                ]),
            ],
            'comentario_copia_certificado_estudio_upload' => [
                'required_if:uploadcertificado,false',
            ],

            'file_formulario_consentimiento_programa_upload' => [
                Rule::when($this->uploadconsentimiento == true && !$this->consentimientos_inscripcion_programa, [
                    'required',
                    File::types(['pdf', 'docx', 'jpeg', 'png'])
                        ->min('1kb')
                        ->max('5mb'),
                ]),
            ],
            'comentario_formulario_consentimiento_programa_upload' => [
                'required_if:uploadconsentimiento,false',
            ],

            'file_compromiso_continuar_estudio_upload' => [
                // Rule::when($this->continuidad_tres_meses == true && $this->uploadcompromisoestudio, [
                //     'required',
                //     File::types(['pdf', 'docx', 'jpeg', 'png'])
                //         ->min('1kb')
                //         ->max('5mb'),
                // ]),
                Rule::when($this->continuidad_tres_meses == true && $this->uploadcompromisoestudio && !$this->copia_compromiso_continuar_estudio, [
                    'required',
                    File::types(['pdf', 'docx', 'jpeg', 'png'])
                        ->min('1kb')
                        ->max('5mb'),
                ]),
            ],

            'comentario_file_compromiso_continuar_estudio_upload' => [
                Rule::when($this->continuidad_tres_meses == true && !$this->uploadcompromisoestudio, [
                    'required',
                ]),
            ],

        ];
    }


    public function messages()
    {
        return [
            'perfilSelected' => 'El campo perfil es requerido.',
            'primer_nombre.required' => 'El campo primer nombre es requerido.',
            'primer_nombre.min' => 'El campo primer nombre debe de ser de al menos 2 caracteres.',
            'segundo_nombre.required' => 'El campo segundo nombre es requerido.',
            'segundo_nombre.min' => 'El campo segundo nombre debe de ser de al menos 2 caracteres.',
            'tercer_nombre.required' => 'El campo tercer nombre es requerido.',
            'tercer_nombre.min' => 'El campo tercer nombre debe de ser de al menos 2 caracteres.',
            'primer_apellido.required' => 'El campo primer apellido es requerido.',
            'primer_apellido.min' => 'El campo primer apellido debe de ser de al menos 2 caracteres.',
            'segundo_apellido.required' => 'El campo segundo apellido es requerido.',
            'segundo_apellido.min' => 'El campo segundo apellido debe de ser de al menos 2 caracteres.',
            'tercer_apellido.required' => 'El campo tercer apellido es requerido.',
            'tercer_apellido.min' => 'El campo tercer apellido debe de ser de al menos 2 caracteres.',
            'tiempo_atender_actividades.required' => 'El campo tiempo necesario para atender las actividades asignadas por el programa es requerido.',

            'file_compromiso_continuar_estudio_upload.required' => 'El campo archivo de compromiso de continuar estudio es requerido cuando se selecciona "si" en la pregunta se inscribirá para continuar con sus estudios.',
            'comentario_file_compromiso_continuar_estudio_upload.required' => 'El campo comentario de archivo de compromiso de continuar estudio es requerido.',

            'pariente_participo_jovenes_proposito.required' => 'El campo pariente participó en Jóvenes con Propósito es requerido.',
            'parentesco_pariente_parcicipo_jovenes_proposito.required_if' => 'El campo parentesco de pariente que participó en Jóvenes con Propósito es requerido.',
            'pariente_participo_otros.required_if' => 'El campo otro parentesco de pariente que participó en Jóvenes con Propósito es requerido cuando se selecciona "Otros".',

            'nombres.required' => 'El campo nombres completos es requerido.',
            'nombres.min' => 'El campo nombres completos debe de ser de al menos 3 caracteres.',
            'apellidos.required' => 'El campo apellidos completos es requerido.',
            'apellidos.min' => 'El campo apellidos completos debe de ser de al menos 3 caracteres.',
            'fecha_nacimiento.required' => 'El campo fecha de nacimiento es requerido.',
            'feca_nacimiento.date' => 'El campo fecha de nacimiento debe de ser una fecha válida.',
            'nacionalidad.required' => 'El campo nacionalidad es requerido.',
            'departamentoNacimientoSelected.required_if' => 'El campo departamento de nacimiento es requerido cuando se ha seleccionado "nacional" como nacionalidad.',
            'departamentoNacimientoSelected.required_without' => 'El campo departamento de nacimiento es requerido cuando no se ha seleccionado una nacionalidad.',
            'municipio_nacimiento_id.required_if' => 'El campo municipio de nacimiento es requerido cuando se ha seleccionado "nacional" como nacionalidad.',
            'municipio_nacimiento_id.required_without' => 'El campo municipio de nacimiento es requerido cuando no se ha seleccionado una nacionalidad.',

            'ultimo_anio_estudio.required_if' => 'El campo último año de estudio es requerido cuando se ha seleccionado "no" como estudia actualmente.',

            'estado_civil_id.required' => 'El campo estado civil es requerido.',
            'tipo_zona_residencia.required' => 'El campo tipo de zona de residencia es requerido.',
            'departamentoSelected.required' => 'El campo departamento de residencia es requerido.',
            'ciudad_id.required' => 'El campo municipio de residencia es requerido.',
            'colonia.required' => 'El campo colonia o comunidad de residencia es requerido.',
            'direccion.required' => 'El campo dirección de residencia es requerido.',
            'direccion.min' => 'El campo dirección de residencia debe de ser de al menos 5 caracteres.',
            'sexo.required' => 'El campo sexo es requerido.',
            'discapacidadesSelected.required' => 'El campo discapacidades es requerido.',
            //'gruposSelected.required' => 'El campo grupo al que pertenece es requerido.',
            'otro_grupo.required_if' => 'El campo otro grupo es requerido cuando se ha seleccionado "otro" como grupo al que pertenece.',
            //'etnia.required' => 'El campo etnia es requerido.',

            //'comunidad_linguistica.required' => 'El campo idiomas que habla es requerido.',
            'comunidadesLinguisticasSelected.required' => 'El campo idiomas que habla es requerido.',

            'proyectoVidaSelected.required' => 'El campo proyecto de vida es requerido.',
            'proyecto_vida_descripcion.required_if' => 'El campo descripción de proyecto de vida es requerido cuando se ha seleccionado "especificar" como proyecto de vida.',
            'tiene_hijos.required' => 'El campo tiene hijos es requerido.',
            'cantidad_hijos.required_if' => 'El campo cantidad de hijos es requerido cuando se ha seleccionado "si" como tiene hijos.',
            'responsabilidadHijosSelected.required_if' => 'El campo responsabilidad de hijos es requerido.',
            'apoyoHijosSelected.required_if' => 'El campo apoyo a hijos es requerido.',
            'estudia_actualmente.required' => 'El campo estudia actualmente es requerido.',
            'nivel_academico_id.required_if' => 'El campo nivel académico es requerido cuando se ha seleccionado "si" como estudia actualmente.',
            'seccion_grado_id.required_if' => 'El campo sección de grado es requerido cuando se ha seleccionado "si" como estudia actualmente.',

            'turno_jornada_id.required_if' => 'El campo turno o jornada de estudio es requerido cuando se ha seleccionado "si" como estudia actualmente.',
            'nivel_educativo_id.required_if' => 'El campo último nivel educativo es requerido cuando selecciona "no" estudia actualmente.',

            'nivel_educativo_alcanzado_primaria.required_if' => 'El campo nivel educativo alcanzado es requerido cuando se ha seleccionado "primaria" como nivel educativo.',
            'nivel_educativo_alcanzado_secundaria.required_if' => 'El campo nivel educativo alcanzado es requerido cuando se ha seleccionado "secundaria" como nivel educativo.',
            'participo_actividades_glasswing.required' => 'El campo participó en actividades de Glasswing es requerido.',
            'rol_participo.required_if' => 'El campo rol en actividades de Glasswing es requerido cuando se ha seleccionado "si" como participó en actividades de Glasswing.',
            'descripcion_participo.required_if' => 'El campo descripción de participación en actividades de Glasswing es requerido cuando se ha seleccionado "si" como participó en actividades de Glasswing.',
            'documento_identidad.required' => 'El campo documento de identidad es requerido.',

            'documento_identidad.size' => 'El campo documento de identidad debe de tener 13 digitos.',
            'telefono.size' => 'El campo telefono debe de tener 8 digitos.',

            'email.required' => 'El campo correo electrónico es requerido.',
            'email.email' => 'El campo correo electrónico debe de ser un correo electrónico válido.',
            'telefono.required' => 'El campo teléfono es requerido.',

            'parentesco_id.required' => 'El campo parentesco de beneficiario es requerido.',
            'parentesco_otro.required_if' => 'El campo otro parentesco es requerido cuando se seleciona otro como parentesco.',

            'file_documento_identidad_upload.required' => 'El campo archivo de documento de identidad (frente) es requerido.',
            'file_documento_identidad_upload.mimes' => 'El archivo de documento de identidad (frente) debe de ser un archivo de tipo: pdf, docx, jpeg, png.',
            'file_documento_identidad_upload.min' => 'El archivo de documento de identidad (frente) debe de ser de al menos 1kb.',
            'file_documento_identidad_upload.max' => 'El archivo de documento de identidad (frente) debe de ser de máximo 5mb.',

            'file_documento_identidad_upload_reverso.required' => 'El campo archivo de documento de identidad (reverso) es requerido.',
            'file_documento_identidad_upload_reverso.mimes' => 'El archivo de documento de identidad (reverso) debe de ser un archivo de tipo: pdf, docx, jpeg, png.',
            'file_documento_identidad_upload_reverso.min' => 'El archivo de documento de identidad (reverso) debe de ser de al menos 1kb.',
            'file_documento_identidad_upload_reverso.max' => 'El archivo de documento de identidad (reverso) debe de ser de máximo 5mb.',

            'comentario_documento_identidad_upload.required_if' => 'El campo comentario de archivo de documento de identidad es requerido si no se ha subido un archivo.',
            'file_copia_certificado_estudio_upload.required' => 'El campo archivo de copia de certificado de estudio es requerido.',
            'file_copia_certificado_estudio_upload.mimes' => 'El archivo de copia de certificado de estudio debe de ser un archivo de tipo: pdf, docx, jpeg, png.',
            'file_copia_certificado_estudio_upload.min' => 'El archivo de copia de certificado de estudio debe de ser de al menos 1kb.',
            'file_copia_certificado_estudio_upload.max' => 'El archivo de copia de certificado de estudio debe de ser de máximo 5mb.',
            'comentario_copia_certificado_estudio_upload.required_if' => 'El campo comentario de archivo de copia de certificado de estudio es requerido si no se ha subido un archivo.',
            'file_formulario_consentimiento_programa_upload.required' => 'El campo archivo de formulario de consentimiento para inscripción al programa es requerido.',
            'file_formulario_consentimiento_programa_upload.mimes' => 'El archivo de formulario de consentimiento para inscripción al programa debe de ser un archivo de tipo: pdf, docx, jpeg, png.',
            'file_formulario_consentimiento_programa_upload.min' => 'El archivo de formulario de consentimiento para inscripción al programa debe de ser de al menos 1kb.',
            'file_formulario_consentimiento_programa_upload.max' => 'El archivo de formulario de consentimiento para inscripción al programa debe de ser de máximo 5mb.',
            'comentario_formulario_consentimiento_programa_upload.required_if' => 'El campo comentario de archivo de formulario de consentimiento para inscripción al programa es requerido si no se ha subido un archivo.',
            'pais_nacimiento_extranjero.required_if' => 'El campo pais de nacimiento es requerido cuando se selecciona nacionalidad extrajera.',
            'departamento_nacimiento_extranjero.required_if' => 'El campo departamento de nacimiento es requerido cuando se selecciona nacionalidad extrajera.',
            'municipio_nacimiento_extranjero.required_if' => 'El campo municipio de nacimiento es requerido cuando se selecciona nacionalidad extrajera.',
        ];
    }

    public function init($cohorte, $proyecto, $pais, $cohortePaisProyecto)
    {
        $this->setCohorte($cohorte);

        $this->setProyecto($proyecto);

        $this->setPais($pais);

        $this->setCohortePaisProyecto($cohortePaisProyecto);

        $this->parentescos_parientes_participo = collect(["1" => "Hermana/o", "2" => "Prima/o", "3" => "Tía/o", "4" => "Otros"]);
    }

    public function setCohorte(Cohorte $cohorte): void
    {
        $this->cohorte = $cohorte;
    }

    public function setProyecto(Proyecto $proyecto): void
    {
        $this->proyecto = $proyecto;
    }

    public function setPais(Pais $pais): void
    {
        $this->pais = $pais;
    }

    public function setCohortePaisProyecto($cohortePaisProyecto): void
    {
        $this->cohortePaisProyecto = $cohortePaisProyecto;

        // dd($this->cohortePaisProyecto);
    }

    public function setDepartamento($departamento): void
    {
        $this->departamentoSelected = $departamento;
    }

    public function setDepartamentoNacimiento($departamento): void
    {
        $this->departamentoNacimientoSelected = $departamento;
    }


    public function setParticipante(Participante $participante)
    {
        $this->participante = $participante->load([
            "discapacidades",
            "gruposPertenecientes",
            "cohortePaisProyecto",
            "grupoEtnicoPais",
            "comunidadEtnica",
            "apoyoHijos",
            "responsabilidadHijos",
            "proyectoVida",
            "comunidadesLinguisticas",
            "direccionGuatemala",
            "direccionHonduras",
        ]);

        // dd($this->participante);


        //permisos
        $this->participacion_voluntaria = $this->participante->cohortePaisProyecto[0]->pivot->participacion_voluntaria ?? FALSE;
        $this->recoleccion_uso_glasswing = $this->participante->cohortePaisProyecto[0]->pivot->recoleccion_uso_glasswing ?? FALSE;
        $this->compartir_para_investigaciones = $this->participante->cohortePaisProyecto[0]->pivot->compartir_para_investigaciones ?? FALSE;
        $this->compartir_para_bancarizacion = $this->participante->cohortePaisProyecto[0]->pivot->compartir_para_bancarizacion ?? FALSE;
        $this->compartir_por_gobierno = $this->participante->cohortePaisProyecto[0]->pivot->compartir_por_gobierno ?? FALSE;
        $this->voz_e_imagen = $this->participante->cohortePaisProyecto[0]->pivot->voz_e_imagen ?? FALSE;

        $this->participanteId = $this->participante->id;

        $this->continuidad_tres_meses = $this->participante->continuidad_tres_meses;

        // $this->nombres = $this->participante->nombres;
        // $this->apellidos = $this->participante->apellidos;

        $this->comunidad_etnica = $this->participante->grupoEtnicoPais[0]->pivot->selected ?? NULL;
        $this->comunidadesLinguisticasSelected = $this->participante->comunidadEtnica->pluck('id')->toArray();
        // dd($this->comunidadesLinguisticasSelected);

        $this->primer_nombre = $this->participante->primer_nombre;
        $this->segundo_nombre = $this->participante->segundo_nombre;
        $this->tercer_nombre = $this->participante->tercer_nombre;
        $this->primer_apellido = $this->participante->primer_apellido;
        $this->segundo_apellido = $this->participante->segundo_apellido;
        $this->tercer_apellido = $this->participante->tercer_apellido;

        $this->primer_nombre_beneficiario = $this->participante->primer_nombre_beneficiario;
        $this->segundo_nombre_beneficiario = $this->participante->segundo_nombre_beneficiario;
        $this->tercer_nombre_beneficiario = $this->participante->tercer_nombre_beneficiario;
        $this->primer_apellido_beneficiario = $this->participante->primer_apellido_beneficiario;
        $this->segundo_apellido_beneficiario = $this->participante->segundo_apellido_beneficiario;
        $this->tercer_apellido_beneficiario = $this->participante->tercer_apellido_beneficiario;


        $this->perfilSelected = $this->participante->cohortePaisProyecto[0]->pivot->cohorte_pais_proyecto_perfil_id ?? NULL;
        $this->tiempo_atender_actividades = $this->participante->tiempo_atender_actividades;

        $this->fecha_nacimiento = $this->participante->fecha_nacimiento
                                    ? $this->participante->fecha_nacimiento->format("Y-m-d")
                                    : '';

        $this->nacionalidad = $this->participante->nacionalidad;
        $this->estado_civil_id = $this->participante->estado_civil_id;
        $this->tipo_zona_residencia = $this->participante->tipo_zona_residencia;


        $this->ciudad_id = $this->participante->ciudad_id;
        $this->colonia = $this->participante->colonia;
        $this->direccion = $this->participante->direccion;


        if ($this->pais->id == Pais::HONDURAS) {
            $this->casa = $this->participante->direccionHonduras->casa ?? "";
            $this->bloque = $this->participante->direccionHonduras->bloque ?? "";
            $this->calle = $this->participante->direccionHonduras->calle ?? "";
            $this->sector = $this->participante->direccionHonduras->sector ?? "";
            $this->colonia = $this->participante->direccionHonduras->colonia ?? "";
            $this->ciudad_id = $this->participante->direccionHonduras->ciudad_id ?? "";
            $this->direccion = $this->participante->direccionHonduras->punto_referencia ?? "";
        }

        if ($this->pais->id == Pais::GUATEMALA) {
            $this->apartamento = $this->participante->direccionGuatemala->apartamento ?? "";
            $this->zona = $this->participante->direccionGuatemala->zona ?? "";
            $this->colonia = $this->participante->direccionGuatemala->colonia ?? "";
            $this->ciudad_id = $this->participante->direccionGuatemala->ciudad_id ?? "";
            $this->direccion = $this->participante->direccionGuatemala->direccion ?? "";
            $this->casa = $this->participante->direccionGuatemala->casa ?? "";
        }

        $this->sexo = $this->participante->sexo;
        $this->discapacidadesSelected = !empty($this->participante->discapacidades)
            ? $this->participante->discapacidades->pluck('id')->toArray()
            : [];

        $this->ultimo_anio_estudio = $this->participante->ultimo_anio_estudio;

        $this->pariente_participo_jovenes_proposito = $this->participante->pariente_participo_jovenes_proposito;
        $this->parentesco_pariente_parcicipo_jovenes_proposito = $this->participante->parentesco_pariente_parcicipo_jovenes_proposito;
        $this->pariente_participo_otros = $this->participante->pariente_participo_otros;


        // $this->gruposSelected = !empty($this->participante->gruposPertenecientes->count())
        //     ? $this->participante->gruposPertenecientes->first()->grupo_perteneciente_id
        //     : NULL;

        // $this->grupoSelectedPivot = !empty($this->participante->gruposPertenecientes->count())
        //     ? $this->participante->gruposPertenecientes->first()->id
        //     : NULL;

        // $this->otro_grupo = !empty($this->participante->gruposPertenecientes->count())
        //     ? $this->participante->gruposPertenecientes->first()->pivot->otro_grupo
        //     : NULL;

        //$this->etnia = $this->participante->etnias->count() ? $this->participante->etnias->first()->id : null;

        //$this->comunidad_linguistica = $this->participante->comunidad_linguistica;

        // $this->comunidadesLinguisticasSelected = $this->participante->comunidadesLinguisticas->count()
        //     ? $this->participante->comunidadesLinguisticas->pluck("id")->toArray()
        //     : [];

        $this->proyectoVidaSelected = $this->participante->proyectoVida->count()
            ? $this->participante->proyectoVida->pluck("id")->toArray()
            : [];

        $this->proyecto_vida_descripcion = $this->participante->proyecto_vida_descripcion;
        $this->tiene_hijos = $this->participante->tiene_hijos ?? NULL;
        $this->cantidad_hijos = $this->participante->cantidad_hijos;


        if ($this->participante->tiene_hijos) {
            $this->responsabilidadHijosSelected = $this->participante->responsabilidadHijos->count()
                ? $this->participante->responsabilidadHijos->pluck("id")->toArray()
                : [];
        } else {
            $this->responsabilidadHijosSelected = [];
        }


        if ($this->participante->tiene_hijos) {
            $this->apoyoHijosSelected = $this->participante->apoyoHijos->count()
                ? $this->participante->apoyoHijos->pluck("id")->toArray()
                : [];
        } else {
            $this->apoyoHijosSelected = [];
        }

        $this->estudia_actualmente = $this->participante->estudia_actualmente;
        $this->nivel_academico_id = $this->participante->nivel_academico_id;
        $this->seccion_grado_id = $this->participante->seccion_grado_id;
        $this->turno_jornada_id = $this->participante->turno_estudio_id;
        $this->nivel_educativo_id = $this->participante->nivel_educativo_id;

        // if ($this->participante->nivel_educativo_id == NivelEducativo::PRIMARIA) {
        //     $this->nivel_educativo_alcanzado_primaria = $this->participante->nivel_educativo_alcanzado;
        // } elseif ($this->participante->nivel_educativo_id == NivelEducativo::SECUNDARIA) {
        //     $this->nivel_educativo_alcanzado_secundaria = $this->participante->nivel_educativo_alcanzado;
        // } elseif ($this->participante->nivel_educativo_id == NivelEducativo::BACHILLERATO) {
        //     $this->nivel_educativo_alcanzado_bachillerato = $this->participante->nivel_educativo_alcanzado;
        // }

        //dd($this->nivel_educativo_alcanzado_bachillerato);

        $this->participo_actividades_glasswing = $this->participante->participo_actividades_glasswing ?? null;
        $this->rol_participo = $this->participante->rol_participo;
        $this->descripcion_participo = $this->participante->descripcion_participo;
        $this->documento_identidad = $this->participante->documento_identidad;
        $this->email = $this->participante->email;
        $this->telefono = $this->participante->telefono;
        // $this->departamento_nacimiento_id = $this->participante->departamento_nacimiento_id;
        $this->municipio_nacimiento_id = $this->participante->municipio_nacimiento_id;

        $this->departamento_nacimiento_extranjero = $this->participante->departamento_nacimiento_extranjero;
        $this->pais_nacimiento_extranjero = $this->participante->pais_nacimiento_extranjero;
        $this->municipio_nacimiento_extranjero = $this->participante->municipio_nacimiento_extranjero;

        // $this->nombre_beneficiario = $this->participante->nombre_beneficiario;
        $this->parentesco_id = $this->participante->parentesco_id;
        $this->parentesco_otro = $this->participante->parentesco_otro;

        $this->comentario_documento_identidad_upload = $this->participante->comentario_documento_identidad_upload;
        $this->comentario_copia_certificado_estudio_upload = $this->participante->comentario_copia_certificado_estudio_upload;
        $this->comentario_formulario_consentimiento_programa_upload = $this->participante->comentario_formulario_consentimiento_programa_upload;
        $this->comentario_file_compromiso_continuar_estudio_upload = $this->participante->comentario_compromiso_continuar_estudio;

        $this->uploaddui = $this->participante->copia_documento_identidad || $this->participante->copia_documento_identidad_reverso ? true : false;
        $this->uploadcertificado = $this->participante->copia_constancia_estudios ? true : false;
        $this->uploadconsentimiento = $this->participante->consentimientos_inscripcion_programa ? true : false;
        $this->uploadcompromisoestudio = $this->participante->copia_compromiso_continuar_estudio ? true : false;

        $this->copia_documento_identidad = $this->participante->copia_documento_identidad;
        $this->copia_documento_identidad_reverso = $this->participante->copia_documento_identidad_reverso;
        $this->copia_constancia_estudios = $this->participante->copia_constancia_estudios;
        $this->consentimientos_inscripcion_programa = $this->participante->consentimientos_inscripcion_programa;
        $this->copia_compromiso_continuar_estudio = $this->participante->copia_compromiso_continuar_estudio;


        // SELECCIONAR EL DEPARTAMENTO Y LA CIUDAD
        //$this->departamentoSelected = Ciudad::find($this->participante->ciudad_id)->pluck("departamento_id");
        //dd($this->participante->ciudad_id);

        if ($this->participante->ciudad_id) {
            $this->departamentoSelected = Ciudad::find($this->participante->ciudad_id)->departamento_id;
        }


        //$this->readonly = $this->participante->readonly_at ? true : false;

        $this->pdf = $this->participante->pdf;
    }

    public function update(?Participante $participante = null): void
    {

        if ($participante) {
            $this->participante = $participante;
        }

        DB::transaction(function () {


            $this->validate();


            $paisProyecto = \App\Models\PaisProyecto::where('pais_id', $this->pais->id)
                ->where('proyecto_id', $this->proyecto->id)
                ->first();

            $cohortePaisProyecto = \App\Models\CohortePaisProyecto::where('pais_proyecto_id', $paisProyecto->id)
                ->where('cohorte_id', $this->cohorte->id)
                ->first();

            //dd($this->pais->id, $this->proyecto->id, $paisProyecto->id, $cohortePaisProyecto->id);


            $this->participante->primer_nombre = $this->primer_nombre;
            $this->participante->segundo_nombre = $this->segundo_nombre;
            $this->participante->tercer_nombre = $this->tercer_nombre;
            $this->participante->primer_apellido = $this->primer_apellido;
            $this->participante->segundo_apellido = $this->segundo_apellido;
            $this->participante->tercer_apellido = $this->tercer_apellido;

            $this->participante->primer_nombre_beneficiario = $this->primer_nombre_beneficiario;
            $this->participante->segundo_nombre_beneficiario = $this->segundo_nombre_beneficiario;
            $this->participante->tercer_nombre_beneficiario = $this->tercer_nombre_beneficiario;
            $this->participante->primer_apellido_beneficiario = $this->primer_apellido_beneficiario;
            $this->participante->segundo_apellido_beneficiario = $this->segundo_apellido_beneficiario;
            $this->participante->tercer_apellido_beneficiario =  $this->tercer_apellido_beneficiario;


            $this->participante->continuidad_tres_meses = $this->continuidad_tres_meses;
            $this->participante->tiempo_atender_actividades = $this->tiempo_atender_actividades;

            $this->participante->fecha_nacimiento = $this->fecha_nacimiento;
            $this->participante->nacionalidad = $this->nacionalidad;
            $this->participante->estado_civil_id = $this->estado_civil_id;
            $this->participante->estudia_actualmente = $this->estudia_actualmente;
            $this->participante->nivel_academico_id = $this->nivel_academico_id;
            $this->participante->seccion_grado_id = $this->seccion_grado_id;
            $this->participante->turno_estudio_id = $this->turno_jornada_id;
            $this->participante->nivel_educativo_id = $this->nivel_educativo_id;


            $this->participante->parentesco_id = $this->parentesco_id;
            $this->participante->parentesco_otro = $this->parentesco_otro;
            $this->participante->tipo_zona_residencia = $this->tipo_zona_residencia;
            $this->participante->direccion = $this->direccion;
            $this->participante->ciudad_id = $this->ciudad_id;
            $this->participante->colonia = $this->colonia;
            $this->participante->sexo = $this->sexo;

            $this->participante->ultimo_anio_estudio = $this->ultimo_anio_estudio;

            $this->participante->proyecto_vida_descripcion = $this->proyecto_vida_descripcion;
            $this->participante->tiene_hijos = $this->tiene_hijos;
            $this->participante->cantidad_hijos = $this->cantidad_hijos;
            $this->participante->participo_actividades_glasswing = $this->participo_actividades_glasswing;
            $this->participante->rol_participo = $this->rol_participo;
            $this->participante->descripcion_participo = $this->descripcion_participo;
            $this->participante->documento_identidad = $this->documento_identidad;
            $this->participante->email = $this->email;
            $this->participante->telefono = $this->telefono;

            //$this->participante->departamento_nacimiento_id = $this->departamento_nacimiento_id;
            $this->participante->municipio_nacimiento_id = $this->municipio_nacimiento_id;
            $this->participante->departamento_nacimiento_extranjero = $this->departamento_nacimiento_extranjero;
            $this->participante->pais_nacimiento_extranjero = $this->pais_nacimiento_extranjero;
            $this->participante->municipio_nacimiento_extranjero = $this->municipio_nacimiento_extranjero;

            $this->participante->gestor_id = auth()->user()->id;


            $this->uploadFiles($cohortePaisProyecto);




            //$this->participante->cohorte_id = $this->cohorte->id; /* TODO: ARREGLAR ESTO */


            $this->participante->comentario_documento_identidad_upload = $this->comentario_documento_identidad_upload;
            $this->participante->comentario_copia_certificado_estudio_upload = $this->comentario_copia_certificado_estudio_upload;
            $this->participante->comentario_formulario_consentimiento_programa_upload = $this->comentario_formulario_consentimiento_programa_upload;
            $this->participante->comentario_compromiso_continuar_estudio = $this->comentario_file_compromiso_continuar_estudio_upload;


            $this->participante->pariente_participo_jovenes_proposito = $this->pariente_participo_jovenes_proposito;
            $this->participante->parentesco_pariente_parcicipo_jovenes_proposito = $this->parentesco_pariente_parcicipo_jovenes_proposito;
            $this->participante->pariente_participo_otros = $this->pariente_participo_otros;

            $this->participante->save();

            // Save direcciones
            if (Pais::HONDURAS == $this->pais->id) {
                $this->participante->direccionHonduras()->updateOrCreate(
                    ['participante_id' => $this->participante->id],
                    [
                        // 'departamento_id' => $this->departamentoSelected,
                        'ciudad_id'        => $this->ciudad_id,
                        'colonia'          => $this->colonia,
                        'calle'            => $this->calle,
                        'sector'           => $this->sector,
                        'bloque'           => $this->bloque,
                        'casa'             => $this->casa,
                        'punto_referencia' => $this->direccion
                    ]
                );
            } elseif (Pais::GUATEMALA == $this->pais->id) {
                $this->participante->direccionGuatemala()->updateOrCreate(
                    ['participante_id' => $this->participante->id],
                    [
                        'ciudad_id'   => $this->ciudad_id,
                        'colonia'     => $this->colonia,
                        'apartamento' => $this->apartamento,
                        'casa'        => $this->casa,
                        'direccion'   => $this->direccion,
                        'zona'        => $this->zona
                    ]
                );
            }


             $grupo = ComunidadEtnica::findOrFail($this->comunidad_etnica);
             $grupoEtnicoPais = GrupoEtnicoPais::where("pais_id", $this->pais->id)->where("grupo_etnico_id", $grupo->grupo_etnico_id)->firstOrFail();
          //   dd($grupo, $this->comunidad_etnica);
            $this->participante->grupoEtnicoPais()->sync([
                $grupoEtnicoPais->id => ['active_at' => now(), 'selected' => $this->comunidad_etnica]
            ]);


            // Save comunidades Linguisticas
            if ($this->pais->id == Pais::GUATEMALA) {

                $syncData = [];
                foreach ($this->comunidadesLinguisticasSelected as $id) {
                    $syncData[$id] = ['active_at' => now()];
                }
                $this->participante->comunidadEtnica()->sync($syncData);
            }


            //Save Discaapcidades
            $this->participante->discapacidades()->sync($this->discapacidadesSelected);

            //Save Proyecto Vida
            $auxiliar = [];
            foreach ($this->proyectoVidaSelected as $proyectoVidaId) {
                $auxiliar[$proyectoVidaId] = ($proyectoVidaId == ProyectoVida::ESPECIFICAR) ? ['comentario' => $this->proyecto_vida_descripcion] : ['comentario' => NULL];
            }
            $this->participante->proyectoVida()->sync($auxiliar);

            //Save Responsabilidad Hijos
            if ($this->tiene_hijos) {
                $this->participante->responsabilidadHijos()->sync($this->responsabilidadHijosSelected);
            }

            if ($this->tiene_hijos) {
                $this->participante->apoyohijos()->sync($this->apoyoHijosSelected);
            }

            //Create Socioeconomico for participante only for the first time
            if (!$this->participante->socioeconomico()->count()) {

                $this->participante->socioeconomico()->create([]);

                //Save Estado la primera vez
                $this->participante->estados_registros()->attach(EstadoRegistro::DOCUMENTACION_PENDIENTE);

                //Save Participante Cohorte
                $this->participante->cohortePaisProyecto()->attach($cohortePaisProyecto->id, [
                    'active_at' => now(),
                    'cohorte_pais_proyecto_perfil_id' => $this->perfilSelected,
                    'participacion_voluntaria' => $this->participacion_voluntaria,
                    'recoleccion_uso_glasswing' => $this->recoleccion_uso_glasswing,
                    'compartir_para_investigaciones' => $this->compartir_para_investigaciones,
                    'compartir_para_bancarizacion' => $this->compartir_para_bancarizacion,
                    'compartir_por_gobierno' => $this->compartir_por_gobierno,
                    'voz_e_imagen' => $this->voz_e_imagen,
                ]);
            } else {
                $this->participante->cohortePaisProyecto()->updateExistingPivot($cohortePaisProyecto->id, [
                    'cohorte_pais_proyecto_perfil_id' => $this->perfilSelected,
                    'participacion_voluntaria' => $this->participacion_voluntaria,
                    'recoleccion_uso_glasswing' => $this->recoleccion_uso_glasswing,
                    'compartir_para_investigaciones' => $this->compartir_para_investigaciones,
                    'compartir_para_bancarizacion' => $this->compartir_para_bancarizacion,
                    'compartir_por_gobierno' => $this->compartir_por_gobierno,
                    'voz_e_imagen' => $this->voz_e_imagen,
                ]);
            }

            // PDF
            $pdfcontent = $this->registropdf($this->proyecto, $this->cohorte, $paisProyecto, $this->participante);
            $pdfPath = 'resultadouno/' . $cohortePaisProyecto->id . '/registro/pdf/' . $this->proyecto->slug . '/' . $this->pais->slug . '/' . $this->cohorte->slug . '/' . $this->participante->id . '/registro_' . $this->participante->slug . '.pdf';
            Storage::disk('s3')->put($pdfPath, $pdfcontent);
            // Update the model's pdf field with the URL
            $this->participante->pdf = $pdfPath;

            $this->participante->save();
        });
    }

    public function registropdf(Proyecto $proyecto, Cohorte $cohorte, PaisProyecto $paisProyecto, Participante $participante)
    {

        //1. Get Nivel Academico
        $nivelAcademico = \App\Models\NivelAcademico::active()->get();
        $nivelAcademicoCategorias = $nivelAcademico->pluck('categoria')->unique()->toArray();
        $nivelconcategorias = [];
        foreach ($nivelAcademicoCategorias as $categoria) {
            $nivelconcategorias[$categoria] = $nivelAcademico->where('categoria', $categoria)->pluck('nombre', 'id');
        }


        $participante->loadCount('socioeconomico');

        $participante->load([
            "estadoCivil:id,nombre",
            "ciudad:id,nombre,departamento_id",
            "ciudad.departamento:id,nombre",
            "discapacidades",
            "etnias",
            "apoyohijos",
            "nivelAcademico",
            "proyectoVida",
            "responsabilidadHijos",
            "seccionGrado:id,nombre",
            "turnoEstudio:id,nombre",
            "nivelEducativo:id,nombre",
            "parentesco:id,nombre",
            "municipioNacimiento:id,nombre,departamento_id",
            "municipioNacimiento.departamento:id,nombre",
            "gestor.socioImplementador",
            "lastEstado.estado_registro",
            "lastEstado.coordinador",
            "comunidadEtnica.grupoEtnico",
        ]);

        $pdf = Pdf::loadView('registro', [
            'pais'         => $this->pais,
            'proyecto'     => $proyecto,
            'cohorte'      => $cohorte,
            'participante' => $participante,
            'paisProyecto' => $paisProyecto,
            'nivelconcategorias' => $nivelconcategorias,
        ]);

        $content = $pdf->download()->getOriginalContent();
        return $content;
    }

    private function uploadFiles($cohortePaisProyecto)
    {
        if ($this->uploaddui && $this->file_documento_identidad_upload) {
            $this->participante->copia_documento_identidad = $this->optimizeAndUpload($this->file_documento_identidad_upload, 'resultadouno/' . $cohortePaisProyecto->id . '/registro/duis/frente');
        }

        if ($this->uploaddui && $this->file_documento_identidad_upload_reverso) {
            $this->participante->copia_documento_identidad_reverso = $this->optimizeAndUpload($this->file_documento_identidad_upload_reverso, 'resultadouno/' . $cohortePaisProyecto->id . '/registro/duis/reverso');
        }

        if ($this->uploadcertificado && $this->file_copia_certificado_estudio_upload) {
            $this->participante->copia_constancia_estudios = $this->optimizeAndUpload($this->file_copia_certificado_estudio_upload, 'resultadouno/' . $cohortePaisProyecto->id . '/registro/certificados');
        }

        if ($this->uploadconsentimiento && $this->file_formulario_consentimiento_programa_upload) {
            $this->participante->consentimientos_inscripcion_programa = $this->optimizeAndUpload($this->file_formulario_consentimiento_programa_upload, 'resultadouno/' . $cohortePaisProyecto->id . '/registro/consentimientos');
        }

        if ($this->continuidad_tres_meses && $this->uploadcompromisoestudio && $this->file_compromiso_continuar_estudio_upload) {
            $this->participante->copia_compromiso_continuar_estudio = $this->optimizeAndUpload($this->file_compromiso_continuar_estudio_upload, 'resultadouno/' . $cohortePaisProyecto->id . '/registro/compromisos-continuar-estudios');
        }
    }

    private function optimizeAndUpload($file, $path)
    {
        if (in_array($file->getClientOriginalExtension(), ['jpeg', 'jpg', 'png', 'gif'])) {

            $imageService = new ImageService();

            $path = $imageService->compressAndUpload(
                $file,
                $path, // custom path
                80 // quality
            );

            return $path;

        } else {

            return Storage::disk('s3')->putFile($path, $file);
        }
    }


    private function uploadFiles2($cohortePaisProyecto)
    {
        $this->participante->copia_documento_identidad = ($this->uploaddui && $this->file_documento_identidad_upload)
            ? $this->file_documento_identidad_upload->store('resultadouno/' . $cohortePaisProyecto->id . '/registro/duis/frente', 's3')
            : $this->participante->copia_documento_identidad;

        $this->participante->copia_documento_identidad_reverso = ($this->uploaddui && $this->file_documento_identidad_upload_reverso)
            ? $this->file_documento_identidad_upload_reverso->store('resultadouno/' . $cohortePaisProyecto->id . '/registro/duis/reverso', 's3')
            : $this->participante->copia_documento_identidad_reverso;

        $this->participante->copia_constancia_estudios = ($this->uploadcertificado && $this->file_copia_certificado_estudio_upload)
            ? $this->file_copia_certificado_estudio_upload->store('resultadouno/' . $cohortePaisProyecto->id . '/registro/certificados', 's3')
            : $this->participante->copia_constancia_estudios;

        $this->participante->consentimientos_inscripcion_programa = ($this->uploadconsentimiento && $this->file_formulario_consentimiento_programa_upload)
            ? $this->file_formulario_consentimiento_programa_upload->store('resultadouno/' . $cohortePaisProyecto->id . '/registro/consentimientos', 's3')
            : $this->participante->consentimientos_inscripcion_programa;

        $this->participante->copia_compromiso_continuar_estudio = ($this->continuidad_tres_meses && $this->uploadcompromisoestudio && $this->file_compromiso_continuar_estudio_upload)
            ? $this->file_compromiso_continuar_estudio_upload->store('resultadouno/' . $cohortePaisProyecto->id . '/registro/compromisos-continuar-estudios', 's3')
            : $this->participante->copia_compromiso_continuar_estudio;
    }
}
