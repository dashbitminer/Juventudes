<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\PaisProyecto;
use App\Models\Participante;
use App\Models\ComunidadEtnica;
use App\Models\PaisProyectoSocio;
use App\Models\CohortePaisProyecto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ParticipantesExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection


     */
    // public function collection()
    // {
    //     return Participante::all();
    // }

    public $selectedParticipanteIds;

    public $cohorte;

    private $rowNumber = 1;

    private $socio;

    private $pais;

    private $proyecto;

    public $modalidad;

    public $cohortePaisProyecto;

    public function __construct(array $selectedParticipanteIds, $cohorte, $pais, $proyecto)
    {
        $this->selectedParticipanteIds = $selectedParticipanteIds;

        $this->cohorte = $cohorte;

        $this->pais = $pais;

        $this->proyecto = $proyecto;

        // $user = Auth::user()->load([
        //     "cohorteSocioImplementador" => function ($query) {
        //         $query->where("cohorte_id", $this->cohorte->id);
        //     }
        // ]);

        //$this->socio = $user->cohorteSocioImplementador->first()->nombre ?? '';

        $this->socio = auth()->user()->load('socioImplementador')->socioImplementador->nombre ?? "";

        $paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
        ->where('proyecto_id', $this->proyecto->id)
        ->firstOrFail();

        $this->cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $paisProyecto->id)
            ->firstOrFail();


    }

    public function query()
    {
        // return Participante::query()
        //             ->with(['ciudad:id,nombre,departamento_id','ciudad.departamento:id,nombre','lastEstado:id,estado_participante.participante_id,estado_id,estado_participante.created_at','lastEstado.estado:id,nombre,color,icon']);

        return Participante::with([
            'parentesco:id,nombre',
            'nivelEducativo:id,nombre',
            'turnoEstudio:id,nombre',
            'seccionGrado:id,nombre',
            'nivelAcademico:id,nombre',
            'proyectoVida:id,nombre',
            'estadoCivil:id,nombre',
            'comunidadEtnica',
            'grupoEtnicoPais',
            //'etnias:id,nombre',
            'apoyohijos:id,nombre',
            'responsabilidadHijos:id,nombre',
            //'gruposPertenecientes:id,nombre',
            'discapacidades:id,nombre',
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre',
            //'lastEstado:id,estado_registro_participante.participante_id,estado_registro_id,estado_registro_participante.created_at, estado_registro_participante.comentario',
            'lastEstado.estado_registro:id,nombre,color,icon',
            'creator',
            'municipioNacimiento:id,nombre,departamento_id',
            'municipioNacimiento.departamento:id,nombre',
            "cohortePaisProyectoPerfiles:id,cohorte_pais_proyecto_id,perfil_participante_id",
            "cohortePaisProyectoPerfiles.perfilesParticipante:id,nombre",
            'direccionGuatemala.ciudad',
            'direccionHonduras.ciudad'
        ])
            ->when(!empty($this->selectedParticipanteIds), function ($query) {
                return $query->whereIn('id', $this->selectedParticipanteIds);
            })
            ->whereHas('cohortePaisProyecto', function($query) {
                $query->where('cohorte_pais_proyecto.id', $this->cohortePaisProyecto->id)
                    ->whereNotNull('cohorte_participante_proyecto.active_at');
            })
            ->misRegistros();
    }

    public function headings(): array
    {

        $base = [
            '#',
            'N° de cohorte',
            'Socio Implementador',
            'Fecha de Registro',
            'Nombres completos',
            'Apellidos completos',
            'Estado',
            'Comentario Estado',
            'Fecha de nacimiento',
            'Nacionalidad',
            'Estado civil',
            'Perfil',
            'Tiempo necesario para atender las actividades',
            'Zona de residencia',
            // 'Departamento',
            // 'Municipio',
            // 'Dirección',
            // 'Casa',
            // 'Apartamento',
            // 'Zona',
            // 'Colonia',
        ];
        if($this->pais->id == 1){
            $direccion = [
                'Departamento',
                'Municipio',
                'Dirección',
                'Casa',
                'Apartamento',
                'Zona',
                'Colonia',
                '¿A cuál comunidad étnica pertenece?',
                '¿Qué idiomas habla?'
            ];
        }elseif($this->pais->id == 3){
            $direccion = [
                'Departamento',
                'Municipio',
                'Colonia',
                'Calle',
                'Sector',
                'Bloque',
                'Casa',
                'Punto de referencia'
            ];
        }else{
            $direccion = [
                'Departamento',
                'Municipio',
                'Colonia',
                'Dirección'
            ];
        }





        return array_merge($base, $direccion, [
                'Sexo',
                '¿Posee algún tipo de discapacidad',
                '¿Cuál es tu proyecto de vida principal? Marca la opción que mejor describa tu objetivo:',
                'Proyecto de vida principal (Otra)',
                '¿Tienes hijos y/o hijas?',
                '¿Cuántos hijos y/o hijas tienes?',
                '¿Con quién o quienes compartes la paternidad/maternidad de tus hijos?',
                '¿Tienes apoyo para cuidar a tus hijos o hijas mientras participas en el programa?',
                '¿Estudia actualmente?',
                'Nivel académico actual:',
                'Sección del grado actual:',
                'Turno o jornada en la que estudia:',
                'Último nivel educativo alcanzado:',
                '¿Cuál fue el último año en el que estudió?',
                '¿Se inscribirá para continuar con sus estudios en un lapso no mayor a 3 meses?',
                '¿Ha participado en años anteriores en actividades de Glasswing?',
                '¿Con qué rol ha participado?',
                '¿En qué participó?',
                '¿Algún miembro de su familia participa o ha participado en la Iniciativa Jóvenes con Propósito?',
                'Parentesco con joven participante',
                'Número de documento de identidad de participante',
                'Correo electrónico de participante',
                'Número de teléfono de participante',
                'Departamento de nacimiento',
                'Municipio de nacimiento',
                'Nombre completo de persona que asignan como beneficiaria de cuenta bancaria',
                'Parentesco con participante',
                'Copia de documento de identidad seleccionado de participante (Frente)',
                'Copia de documento de identidad seleccionado de participante (Reverso)',
                'Copia de documento de identidad seleccionado de participante (Comentario)',

                'Copia de certificado o constancia de estudios',
                'Copia de certificado o constancia de estudios (Comentario)',

                'Formulario de consentimientos y/o asentimientos para inscripción al programa',
                'Formulario de consentimientos y/o asentimientos para inscripción al programa (Comentario)',

                'Imagen del compromiso para continuar los estudios',
                'Imagen del compromiso para continuar los estudios (Comentario)',
        ]);





    }
    /**
     * @param Invoice $invoice
     */
    public function map($participante): array
    {
        $municipioNacimiento = "";
        $departamentoNacimiento = "";
        if($participante->nacionalidad == 1){
            $municipioNacimiento = optional($participante->municipioNacimiento)->nombre;
            $departamentoNacimiento = optional($participante->municipioNacimiento->departamento)->nombre;
        }else{
            $municipioNacimiento = $participante->municipio_nacimiento_extranjero;
            $departamentoNacimiento = $participante->departamento_nacimiento_extranjero;
        }

        $tiempoActividades = "";
        if($participante->tiempo_atender_actividades){
            if($participante->tiempo_atender_actividades == 1){
                $tiempoActividades = "Sí";
            }elseif($participante->tiempo_atender_actividades == 2){
                $tiempoActividades = "No";
            }elseif($participante->tiempo_atender_actividades == 3){
                $tiempoActividades = "No sabe";
            }
        }

        // DIRECCIONES
        if ($this->pais->id == 1) {

            $grupoEtnico = '';
            if($participante->grupoEtnicoPais && count($participante->grupoEtnicoPais) > 0){
                $comunidadEtnica = !empty($participante->grupoEtnicoPais) ? $participante->grupoEtnicoPais[0]->pivot->selected : NULL;
                if($comunidadEtnica){
                    $comunidad = ComunidadEtnica::with("grupoEtnico")->find($comunidadEtnica);
                    if ($comunidad) {
                        $grupoEtnico = $comunidad->nombre.' ('.$comunidad->grupoEtnico->nombre.')';
                    } else {
                        $grupoEtnico = '';
                    }
                }
            }


            $direccion = [
                $participante->direccionGuatemala->ciudad->departamento->nombre ?? '',
                $participante->direccionGuatemala->ciudad->nombre ?? '',
                $participante->direccionGuatemala->direccion ?? '',
                $participante->direccionGuatemala->casa ?? '',
                $participante->direccionGuatemala->apartamento ?? '',
                $participante->direccionGuatemala->zona ?? '',
                $participante->direccionGuatemala->colonia ?? '',
                $grupoEtnico,
                $participante->comunidadEtnica->pluck("nombre")->implode(", "),
            ];
        } elseif($this->pais->id == 3){
            $direccion = [
                $participante->direccionHonduras->ciudad->departamento->nombre ?? '',
                $participante->direccionHonduras->ciudad->nombre ?? '',
                $participante->direccionHonduras->colonia ?? '',
                $participante->direccionHonduras->calle ?? '',
                $participante->direccionHonduras->sector ?? '',
                $participante->direccionHonduras->bloque ?? '',
                $participante->direccionHonduras->casa ?? '',
                $participante->direccionHonduras->punto_referencia ?? '',
            ];
        } else{
            $direccion = [
                $participante->ciudad->departamento->nombre ?? "", // Departamento
                $participante->ciudad->nombre ?? "", // Municipio
                $participante->colonia,
                $participante->direccion,
            ];
        }

        $base = [
            $this->rowNumber++, // #
            $this->cohorte->nombre, // N° de cohorte
            $this->socio, // Socio Implementador
            $participante->created_at->format('d/m/Y'), // Fecha de Registro
            // $this->modalidad->modalidad->nombre, //Modalidad de programa
            trim($participante->primer_nombre.' '.$participante->segundo_nombre.' '.$participante->tercer_nombre), // Nombres completos
            trim($participante->primer_apellido.' '.$participante->segundo_apellido.' '.$participante->tercer_apellido), // Apellidos completos
            $participante->lastEstado->estado_registro->nombre,
            $participante->lastEstado->comentario,
            Carbon::parse($participante->fecha_nacimiento)->format('d/m/Y'), // Fecha de nacimiento
            $participante->nacionalidad ? ($participante->nacionalidad == 1 ? 'Nacional' : 'Extranjero')
                                        : '', // Nacionalidad
            $participante->estadoCivil->nombre ?? '', // Estado civil
            $participante->cohortePaisProyectoPerfiles->where('pivot.active_at', '!=', null)->first()->perfilesParticipante->nombre ?? '',
            $tiempoActividades,
            $participante->tipo_zona_residencia ? ($participante->tipo_zona_residencia == 1 ? "Urbana" : "Rural")
                                                : '', // Zona de residencia
            // $participante->ciudad->departamento->nombre ?? "", // Departamento
            // $participante->ciudad->nombre ?? "", // Municipio
        ];

        $parentescoFamiliarParticipante = '';
        if($participante->pariente_participo_jovenes_proposito){
            switch ($participante->pariente_participo_jovenes_proposito) {
                case 1:
                    $parentescoFamiliarParticipante = 'Hermana/o';
                    break;
                case 2:
                    $parentescoFamiliarParticipante = 'Prima/o';
                    break;
                case 3:
                    $parentescoFamiliarParticipante = 'Tía/o';
                    break;
                case 4:
                    $parentescoFamiliarParticipante = 'Otros';
                    break;
                default:
                    $parentescoFamiliarParticipante = '';
                    break;
            }
        }

        // Rango maximo para que el archivo expire sera de 7 dias.
        $fileExpirationDate = now()->addDays(7);

        return array_merge($base, $direccion,[
            $participante->sexo ? ($participante->sexo == 2 ? 'Masculino' : 'Femenino')
                                : '', // Sexo
            $participante->discapacidades->pluck('nombre')->implode(', '),
            $participante->proyectoVida->pluck('nombre')->implode(', '),
            $participante->proyecto_vida_descripcion,
            $participante->tiene_hijos ? ($participante->tiene_hijos == 1 ? 'Sí' : 'No') : '',
            $participante->cantidad_hijos,
            $participante->responsabilidadHijos->pluck('nombre')->implode(', '),
            $participante->apoyohijos->pluck('nombre')->implode(', '),
            $participante->estudia_actualmente ? ($participante->estudia_actualmente == 1 ? 'Sí' : 'No') : '',
            $participante->nivelAcademico->nombre ?? '',
            $participante->seccionGrado->nombre ?? '',
            $participante->turnoEstudio->nombre ?? '',
            $participante->nivelEducativo->nombre ?? '',
            $participante->ultimo_anio_estudio,
            $participante->continuidad_tres_meses ? ($participante->continuidad_tres_meses == 1 ? 'Sí' : 'No') : '',
            $participante->participo_actividades_glasswing ? ($participante->participo_actividades_glasswing == 1 ? 'Sí' : 'No') : '',
            $participante->rol_participo ? ($participante->rol_participo == 1 ? 'Voluntario/voluntaria' : 'Participante') : '',
            $participante->descripcion_participo,
            $participante->pariente_participo_jovenes_proposito ? ($participante->pariente_participo_jovenes_proposito == 1 ? 'Sí' : 'No') : '',
            $parentescoFamiliarParticipante,
            $participante->documento_identidad,
            $participante->email,
            $participante->telefono,
            $departamentoNacimiento,
            $municipioNacimiento,
            $participante->primer_nombre_beneficiario.' '.$participante->segundo_nombre_beneficiario.' '.$participante->tercer_nombre_beneficiario.' '.$participante->primer_apellido_beneficiario.' '.$participante->segundo_apellido_beneficiario.' '.$participante->tercer_apellido_beneficiario,
            $participante->parentesco->nombre ?? '',

            $participante->copia_documento_identidad ? Storage::disk('s3')->temporaryUrl($participante->copia_documento_identidad, $fileExpirationDate) : '',
            $participante->copia_documento_identidad_reverso ? Storage::disk('s3')->temporaryUrl($participante->copia_documento_identidad_reverso, $fileExpirationDate) : '',
            $participante->comentario_documento_identidad_upload,


            $participante->copia_constancia_estudios ? Storage::disk('s3')->temporaryUrl($participante->copia_constancia_estudios, $fileExpirationDate) : '',
            $participante->comentario_copia_certificado_estudio_upload,

            $participante->consentimientos_inscripcion_programa ? Storage::disk('s3')->temporaryUrl($participante->consentimientos_inscripcion_programa, $fileExpirationDate) : '',
            $participante->comentario_formulario_consentimiento_programa_upload,

            $participante->copia_compromiso_continuar_estudio ? Storage::disk('s3')->temporaryUrl($participante->copia_compromiso_continuar_estudio, $fileExpirationDate) : '',
            $participante->comentario_compromiso_continuar_estudio,

        ]);

    }
}
