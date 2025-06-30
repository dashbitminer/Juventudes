<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fomrulario Registro de Participantes Guatemala

        for ($i = 1; $i <= 2; $i++) {
            // Your code here


            $pais = \App\Models\Pais::find($i);

            $primeraParte = [
                [
                    'id'       => 1,
                    'type'     => 'text', // boolean
                    'label'    => 'Nombres completos',
                    'name'     => 'form.nombres',
                    'field'    => 'nombres',
                    'required' => true,
                    'condition' => []
                ],
                [
                    'id'       => 2,
                    'type'     => 'text', // boolean
                    'label'    => 'Apellidos completos',
                    'name'     => 'form.apellidos',
                    'field'    => 'apellidos',
                    'required' => true,
                    'condition' => []
                ],
                [
                    'id'       => 3,
                    'type'     => 'date', // boolean
                    'label'    => 'Fecha de nacimiento',
                    'name'     => 'form.fecha_nacimiento',
                    'field'    => 'fecha_nacimiento',
                    'required' => true,
                    'condition' => []
                ],
                [
                    'id'       => 4,
                    'type'     => 'radiobutton', //'smallInteger',
                    'label'    => 'Nacionalidad',
                    'name'     => 'form.nacionalidad',
                    'field'    => 'nacionalidad',
                    'options' => [
                        ['label' => 'Nacional', 'value' => 1],
                        ['label' => 'Extranjero', 'value' => 2],
                    ],
                    'required' => true,
                    'condition' => []
                ],
                [
                    'id'        => 5,
                    'type'      => 'radiobutton', //'smallInteger',
                    'label'     => 'Estado civil',
                    'name'      => 'form.estado_civil_id',
                    'field'     => 'estado_civil_id',
                    'options'   => \App\Models\EstadoCivil::active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                    'required'  => true,
                    'condition' => []
                ],
                [
                    'id'        => 6,
                    'type'      => 'radiobutton', //'smallInteger',
                    'label'     => '¿En qué tipo de zona resides?',
                    'name'      => 'form.tipo_zona_residencia',
                    'field'     => 'tipo_zona_residencia',
                    'options' => [
                        ['label' => 'Zona urbana (Ciudad, áreas metropolitanas)', 'value' => 1],
                        ['label' => 'Zona rural (Pueblos, aldeas, áreas agrícolas)', 'value' => 2],
                    ],
                    'required'  => true,
                    'condition' => []
                ],
                [
                    'id'        => 7,
                    'type'      => 'dropdown',
                    'label'     => 'Departamento',
                    'name'      => 'form.departamentoSelected',
                    'field'     => '',
                    'options'   => $pais->departamentos()->active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                    'required'  => true,
                    'condition' => []
                ],
                [
                    'id'        => 8,
                    'type'      => 'dropdown',
                    'label'     => 'Municipio',
                    'name'      => 'form.ciudad_id',
                    'field'     => 'ciudad_id',
                    'options'   => [],
                    'required'  => true,
                    'condition' => [],
                    'cascade' => array(
                        array(
                            array(
                                'field' => '7',
                            )
                        ),
                    )
                ],
                [
                    'id'        => 9,
                    'type'      => 'text',
                    'label'     => 'Comunidad / Colonia',
                    'name'      => 'form.colonia',
                    'field'     => 'colonia',
                    'required'  => true,
                    'condition' => [],
                ],
                [
                    'id'        => 10,
                    'type'      => 'textarea',
                    'label'     => 'Dirección completa con puntos de referencia',
                    'name'      => 'form.direccion',
                    'field'     => 'direccion',
                    'required'  => true,
                    'condition' => [],
                ],
                [
                    'id'        => 11,
                    'type'      => 'radiobutton',
                    'label'     => 'Sexo según registro nacional',
                    'name'      => 'form.sexo',
                    'field'     => 'sexo',
                    'options' => [
                        ['label' => 'Mujer', 'value' => 1],
                        ['label' => 'Hombre', 'value' => 2],
                    ],
                    'required'  => true,
                    'condition' => [],
                ],
                [
                    'id'             => 12,
                    'type'           => 'checkbox',
                    'label'          => '¿Posee algún tipo de discapacidad?',
                    'name'           => 'form.discapacidadesSelected',
                    'field'          => '',
                    'pivot_table'    => 'discapacidad_participante',
                    'relation_table' => 'discapacidades',
                    'options'        => \App\Models\Discapacidad::active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                    'required'       => true,
                    'condition'      => [],
                ],
                [
                    'id'             => 13,
                    'type'           => 'radiobutton',
                    'label'          => '¿A cuál de los siguientes grupos cree que pertenece?',
                    'name'           => 'form.gruposSelected',
                    'field'          => '',
                    'pivot_table'    => 'grupo_perteneciente_pais_participante',
                    'relation_table' => 'grupo_perteneciente_pais',
                    'options'        => $pais->grupoPertenecientes()->whereNotNull('grupo_pertenecientes.active_at')
                        ->whereNotNull('grupo_perteneciente_pais.active_at')
                        ->select("grupo_pertenecientes.nombre", "grupo_pertenecientes.id", "grupo_perteneciente_pais.id as pivotid")->get()->map(function ($item) {
                            return ['label' => $item->nombre, 'value' => $item->id, 'pivotid' => $item->pivotid];
                        })->toArray(),
                    'required'       => true,
                    'condition'      => [],
                ],
                [
                    'id'             => 14,
                    'type'           => 'textarea',
                    'label'          => 'Otro grupo',
                    'name'           => 'form.otro_grupo',
                    'field'          => '',
                    'pivot_table'    => 'grupo_perteneciente_pais_participante',
                    'relation_table' => 'grupo_perteneciente_pais',
                    'required'       => true,
                    'condition' => array(
                        array(
                            array(
                                'field' => '13',
                                'operator' => '==',
                                'value' => \App\Models\GrupoPerteneciente::OTRO,
                            ),
                        )
                    )
                ],
                [
                    'id'             => 15,
                    'type'           => 'radiobutton',
                    'label'          => '¿A qué pueblo indígena o comunidad étnica perteneces?',
                    'name'           => 'form.etnia',
                    'field'          => '',
                    'pivot_table'    => 'etnia_pais_participante',
                    'relation_table' => 'etnia_pais',
                    'options'        => $pais->etnias()->whereNotNull('etnias.active_at')
                        ->whereNotNull('etnia_pais.active_at')
                        ->select("etnias.nombre", "etnias.id", "etnia_pais.id as pivotid")->get()->map(function ($item) {
                            return ['label' => $item->nombre, 'value' => $item->id, 'pivotid' => $item->pivotid];
                        })->toArray(),
                    'required'  => true,
                    'condition' => []
                ],
                [
                    'id'             => 16,
                    'type'           => 'checkbox',
                    'label'          => '¿Con qué comunidad lingüística se identifica?',
                    'name'           => 'form.comunidadesLinguisticasSelected',
                    'field'          => '',
                    'pivot_table'    => 'comunidad_linguistica_pais_participante',
                    'relation_table' => 'comunidad_linguistica_pais',
                    'required'       => true,
                    'condition'      => [],
                    'options'        => $pais->comunidadesLinguisticas()->whereNotNull('comunidad_linguisticas.active_at')
                        ->whereNotNull('comunidad_linguistica_pais.active_at')
                        ->select("comunidad_linguisticas.nombre", "comunidad_linguisticas.id", "comunidad_linguistica_pais.id as pivotid")->get()->map(function ($item) {
                            return ['label' => $item->nombre, 'value' => $item->id, 'pivotid' => $item->pivotid];
                        })->toArray(),
                ],
                [
                    'id'             => 17,
                    'type'           => 'checkbox',
                    'label'          => '¿Cuál es tu proyecto de vida principal? Marca la opción que mejor describa tu objetivo: ',
                    'name'           => 'form.proyectoVidaSelected',
                    'field'          => '',
                    'pivot_table'    => 'participante_proyecto_vida',
                    'relation_table' => 'proyecto_vidas',
                    'required'       => true,
                    'condition'      => [],
                    'options'        => \App\Models\ProyectoVida::active()->get(["id", "nombre", "comentario"])->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id, 'comentario' => $item->comentario];
                    })->toArray(),
                ],
                [
                    'id'             => 18,
                    'type'           => 'text',
                    'label'          => 'Especifique otro proyecto de vida:',
                    'name'           => 'form.proyecto_vida_descripcion',
                    'field'          => '',
                    'pivot_table'    => 'participante_proyecto_vida',
                    'relation_table' => 'proyecto_vidas',
                    'required'       => true,
                    'condition' => array(
                        array(
                            array(
                                'field' => '17',
                                'operator' => '==',
                                'value' => [\App\Models\ProyectoVida::ESPECIFICAR]
                            ),
                        )
                    )
                ],
                [
                    'id'             => 19,
                    'type'           => 'radiobutton',
                    'label'          => '¿Tienes hijos y/o hijas?',
                    'name'           => 'form.tiene_hijos',
                    'field'          => 'tiene_hijos',
                    'required'       => true,
                    'condition'      => [],
                    'options'        => [
                        ['label' => 'Sí', 'value' => 1],
                        ['label' => 'No', 'value' => 0],
                    ],
                ],
                [
                    'id'             => 20,
                    'type'           => 'number',
                    'label'          => '¿Cuántos hijos y/o hijas tienes?',
                    'name'           => 'form.cantidad_hijos',
                    'field'          => 'cantidad_hijos',
                    'required'       => true,
                    'condition'      => array(
                        array(
                            array(
                                'field' => '19',
                                'operator' => '==',
                                'value' => 1,
                            ),
                        )
                    ),
                ],
                [
                    'id'             => 21,
                    'type'           => 'checkbox',
                    'label'          => '¿Con quién o quienes compartes la paternidad/maternidad de tus hijos?',
                    'name'           => 'form.responsabilidadHijosSelected',
                    'field'          => '',
                    'pivot_table'    => 'participante_responsabilidad_hijo',
                    'relation_table' => 'comparte_responsabilidad_hijos',
                    'required'       => true,
                    'options'        => \App\Models\ComparteResponsabilidadHijo::active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                    'condition'      => array(
                        array(
                            array(
                                'field' => '19',
                                'operator' => '==',
                                'value' => 1,
                            ),
                        )
                    ),
                ],
                [
                    'id'             => 22,
                    'type'           => 'checkbox',
                    'label'          => '¿Tienes apoyo para cuidar a tus hijos o hijas mientras participas en el programa?',
                    'name'           => 'form.apoyoHijosSelected',
                    'field'          => '',
                    'pivot_table'    => 'apoyo_hijo_participante',
                    'relation_table' => 'apoyo_hijos',
                    'required'       => true,
                    'options'        => \App\Models\ApoyoHijo::active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                    'condition'      => array(
                        array(
                            array(
                                'field' => '19',
                                'operator' => '==',
                                'value' => 1,
                            ),
                        )
                    ),
                ],
            ];

            $segundaParte = [
                [
                    'id'             => 23,
                    'type'           => 'radiobutton',
                    'label'          => '¿Estudia actualmente?',
                    'name'           => 'form.estudia_actualmente',
                    'field'          => 'estudia_actualmente',
                    'required'       => true,
                    'condition'      => [],
                    'options' => [
                        ['label' => 'Si', 'value' => 1],
                        ['label' => 'No', 'value' => 0],
                    ],
                ],
                [
                    'id'        => 24,
                    'type'      => 'radiobutton',
                    'label'     => '¿Estudia actualmente?',
                    'name'      => 'form.nivel_academico_id',
                    'field'     => 'nivel_academico_id',
                    'required'  => true,
                    'condition' => [],
                    'options'   => \App\Models\NivelAcademico::active()->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id, 'categoria' => $item->categoria];
                    })->toArray(),
                ],
                [
                    'id'        => 25,
                    'type'      => 'radiobutton',
                    'label'     => 'Sección del grado actual:',
                    'name'      => 'form.seccion_grado_id',
                    'field'     => 'seccion_grado_id',
                    'required'  => true,
                    'condition' => [],
                    'options'   => \App\Models\SeccionGrado::active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                ],
                [
                    'id'        => 26,
                    'type'      => 'radiobutton',
                    'label'     => 'Turno o jornada en la que estudia:',
                    'name'      => 'form.turno_jornada_id',
                    'field'     => 'turno_jornada_id',
                    'required'  => true,
                    'condition' => [],
                    'options'   => \App\Models\TurnoEstudio::active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                ],
                [
                    'id'        => 30,
                    'type'      => 'radiobutton',
                    'label'     => 'Último nivel educativo alcanzado:',
                    'name'      => 'form.nivel_educativo_id',
                    'field'     => 'nivel_educativo_id',
                    'required'  => true,
                    'condition' => [],
                    'options'   => \App\Models\NivelEducativo::active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                    'subfields' => [
                        [
                            'id'        => 31,
                            'type'      => 'radiobutton',
                            'label'     => '',
                            'name'      => 'form.estudio_formal',
                            'field'     => 'estudio_formal',
                            'required'  => true,
                            'condition' => array(
                                array(
                                    array(
                                        'field' => '30',
                                        'operator' => '==',
                                        'value' => \App\Models\NivelEducativo::PRIMARIA,
                                    ),
                                )
                            ),
                            'options'   => [
                                ['label' => '1 grado', 'value' => 1],
                                ['label' => '2 grado', 'value' => 2],
                                ['label' => '3 grado', 'value' => 3],
                                ['label' => '4 grado', 'value' => 4],
                                ['label' => '5 grado', 'value' => 5],
                                ['label' => '6 grado', 'value' => 6],
                            ],
                        ],
                        [
                            'id'        => 32,
                            'type'      => 'radiobutton',
                            'label'     => '',
                            'name'      => 'form.estudio_no_formal',
                            'field'     => 'estudio_no_formal',
                            'required'  => true,
                            'condition' => array(
                                array(
                                    array(
                                        'field' => '30',
                                        'operator' => '==',
                                        'value' => \App\Models\NivelEducativo::SECUNDARIA,
                                    ),
                                )
                            ),
                            'options'   => [
                                ['label' => '7 grado', 'value' => 7],
                                ['label' => '8 grado', 'value' => 8],
                                ['label' => '9 grado', 'value' => 9],
                            ],
                        ],
                    ]
                ],
            ];

            $terceraParte = [
                [
                    'id'             => 33,
                    'type'           => 'radiobutton',
                    'label'          => '¿Ha participado en años anteriores en actividades de Glasswing?',
                    'name'           => 'form.participo_actividades_glasswing',
                    'field'          => 'participo_actividades_glasswing',
                    'required'       => true,
                    'condition'      => [],
                    'options' => [
                        ['label' => 'Si', 'value' => 1],
                        ['label' => 'No', 'value' => 0],
                    ],
                ],
                [
                    'id'             => 34,
                    'type'           => 'radiobutton',
                    'label'          => '¿Con qué rol ha participado?',
                    'name'           => 'form.rol_participo',
                    'field'          => 'rol_participo',
                    'required'       => true,
                    'condition' => array(
                        array(
                            array(
                                'field' => '33',
                                'operator' => '==',
                                'value' => 1,
                            ),
                        )
                    ),
                    'options' => [
                        ['label' => 'Voluntario/voluntaria', 'value' => 1],
                        ['label' => 'Participante', 'value' => 2],
                    ],
                ],
                [
                    'id'             => 35,
                    'type'           => 'text',
                    'label'          => '¿Con qué rol ha participado?',
                    'name'           => 'form.descripcion_participo',
                    'field'          => 'descripcion_participo',
                    'required'       => true,
                    'condition' => array(
                        array(
                            array(
                                'field' => '33',
                                'operator' => '==',
                                'value' => 1,
                            ),
                        )
                    ),
                ],
            ];

            $cuartaParte = [
                [
                    'id'             => 36,
                    'type'           => 'text',
                    'label'          => 'Número de documento de identidad de participante',
                    'name'           => 'form.documento_identidad',
                    'field'          => 'documento_identidad',
                    'required'       => true,
                    'condition'      => [],
                ],
                [
                    'id'             => 37,
                    'type'           => 'email',
                    'label'          => 'Correo electrónico de participante  (Opcional)',
                    'name'           => 'form.email',
                    'field'          => 'email',
                    'required'       => false,
                    'condition'      => [],
                ],
                [
                    'id'             => 38,
                    'type'           => 'text',
                    'label'          => 'Número de teléfono de participante',
                    'name'           => 'form.telefono',
                    'field'          => 'telefono',
                    'required'       => true,
                    'condition'      => [],
                ],
                [
                    'id'             => 39,
                    'type'           => 'dropdown',
                    'label'          => 'Departamento de nacimiento',
                    'name'           => 'form.departamentoNacimientoSelected',
                    'field'          => '',
                    'required'       => true,
                    'condition'      => [],
                    'options'        => $pais->departamentos()->active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                ],
                [
                    'id'             => 40,
                    'type'           => 'dropdown',
                    'label'          => 'Municipio de nacimiento',
                    'name'           => 'form.municipio_nacimiento_id',
                    'field'          => 'municipio_nacimiento_id',
                    'required'       => true,
                    'condition'      => [],
                    'options'        => [],
                    'cascade' => array(
                        array(
                            array(
                                'field' => '39',
                            )
                        ),
                    )
                ],
                [
                    'id'             => 41,
                    'type'           => 'text',
                    'label'          => 'Nombre completo de persona que asignan como beneficiaria de cuenta bancaria en caso de fallecimiento (Persona mayor de edad)',
                    'name'           => 'form.nombre_beneficiario',
                    'field'          => 'nombre_beneficiario',
                    'required'       => true,
                    'condition'      => [],
                ],
                [
                    'id'             => 42,
                    'type'           => 'radiobutton',
                    'label'          => 'Parentesco con participante',
                    'name'           => 'form.parentesco_id',
                    'field'          => 'parentesco_id',
                    'required'       => true,
                    'condition'      => [],
                    'options'        => \App\Models\Parentesco::active()->select("nombre", "id")->get()->map(function ($item) {
                        return ['label' => $item->nombre, 'value' => $item->id];
                    })->toArray(),
                ],
                [
                    'id'             => 43,
                    'type'           => 'text',
                    'label'          => 'Otro parentesco:',
                    'name'           => 'form.parentesco_otro',
                    'field'          => 'parentesco_otro',
                    'required'       => true,
                    'condition' => array(
                        array(
                            array(
                                'field' => '42',
                                'operator' => '==',
                                'value' => \App\Models\Parentesco::OTRO,
                            ),
                        )
                    ),
                ],
            ];

            $quintaParte = [
                [
                    'id'             => 44,
                    'type'           => 'checkbox',
                    'label'          => 'Copia de documento de identidad seleccionado de participante',
                    'name'           => 'form.uploaddui',
                    'field'          => '',
                    'required'       => false,
                    'condition'      => [],
                ],
                [
                    'id'             => 45,
                    'type'           => 'textarea',
                    'label'          => 'Comentario/observación',
                    'name'           => 'form.comentario_documento_identidad_upload',
                    'field'          => 'comentario_documento_identidad_upload',
                    'required'       => false,
                    'condition' => array(
                        array(
                            array(
                                'field' => '44',
                                'operator' => '==',
                                'value' => false,
                            ),
                        )
                    ),
                ],
                [
                    'id'             => 46,
                    'type'           => 'file',
                    'label'          => 'Subir documento',
                    'name'           => 'form.file_documento_identidad_upload',
                    'field'          => 'copia_documento_identidad',
                    'required'       => false,
                    'condition' => array(
                        array(
                            array(
                                'field' => '44',
                                'operator' => '==',
                                'value' => true,
                            ),
                        )
                    ),
                ],
                [
                    'id'             => 47,
                    'type'           => 'checkbox',
                    'label'          => 'Copia de certificado o constancia de estudios',
                    'name'           => 'form.uploadcertificado',
                    'field'          => '',
                    'required'       => false,
                    'condition'      => [],
                ],
                [
                    'id'             => 48,
                    'type'           => 'textarea',
                    'label'          => 'Comentario/observación',
                    'name'           => 'form.comentario_copia_certificado_estudio_upload',
                    'field'          => 'comentario_copia_certificado_estudio_upload',
                    'required'       => false,
                    'condition' => array(
                        array(
                            array(
                                'field' => '44',
                                'operator' => '==',
                                'value' => false,
                            ),
                        )
                    ),
                ],
                [
                    'id'             => 49,
                    'type'           => 'file',
                    'label'          => 'Subir documento',
                    'name'           => 'form.file_copia_certificado_estudio_upload',
                    'field'          => 'copia_constancia_estudios',
                    'required'       => false,
                    'condition' => array(
                        array(
                            array(
                                'field' => '44',
                                'operator' => '==',
                                'value' => true,
                            ),
                        )
                    ),
                ],
                [
                    'id'             => 50,
                    'type'           => 'checkbox',
                    'label'          => 'Formulario de consentimientos y/o asentimientos para inscripción al programa',
                    'name'           => 'form.uploadconsentimiento',
                    'field'          => '',
                    'required'       => false,
                    'condition'      => [],
                ],
                [
                    'id'             => 51,
                    'type'           => 'textarea',
                    'label'          => 'Comentario/observación',
                    'name'           => 'form.comentario_formulario_consentimiento_programa_upload',
                    'field'          => 'comentario_formulario_consentimiento_programa_upload',
                    'required'       => false,
                    'condition' => array(
                        array(
                            array(
                                'field' => '50',
                                'operator' => '==',
                                'value' => false,
                            ),
                        )
                    ),
                ],
                [
                    'id'             => 52,
                    'type'           => 'file',
                    'label'          => 'Subir documento',
                    'name'           => 'form.file_formulario_consentimiento_programa_upload',
                    'field'          => 'consentimientos_inscripcion_programa',
                    'required'       => false,
                    'condition' => array(
                        array(
                            array(
                                'field' => '50',
                                'operator' => '==',
                                'value' => true,
                            ),
                        )
                    ),
                ],
            ];



            $estructura = json_encode([
                [
                    'id'     => '1_container',
                    'titulo' => 'SECCIÓN II',
                    'texto'  => 'DATOS GENERALES DE PARTICIPANTE',
                    'campos' => $primeraParte
                ],
                [
                    'id'     => '2_container',
                    'titulo' => 'SECCIÓN III',
                    'texto'  => 'DATOS SOBRE EDUCACIÓN DE PARTICIPANTE',
                    'campos' => $segundaParte
                ],
                [
                    'id'     => '3_container',
                    'titulo' => 'SECCIÓN IV',
                    'texto'  => 'ADICIONAL',
                    'campos' => $terceraParte
                ],
                [
                    'id'     => '4_container',
                    'titulo' => 'SECCIÓN V',
                    'texto'  => 'BANCARIZACIÓN',
                    'campos' => $cuartaParte
                ],
                [
                    'id'     => '5_container',
                    'titulo' => 'SECCIÓN VI',
                    'texto'  => 'ESTATUS DE DOCUMENTACIÓN',
                    'campos' => $quintaParte
                ],
            ]);


            // Formulario Registro de Participantes Guatemala
            $formulario = \App\Models\Formulario::create([
                'nombre' => 'Formulario Registro de Participantes ' . $pais->nombre.' '. now()->format('Y'),
                'descripcion' => 'Formulario de registro de participantes en ' . $pais->nombre .' '. now()->format('Y'),
                'tipo_formulario_id' => 1,
                'version' => '1.0.0',
                'estructura' => $estructura,
                'active_at' => now(),
            ]);

            $formulario->pais()->attach($i, ['active_at' => now()]);
        }
    }
}
