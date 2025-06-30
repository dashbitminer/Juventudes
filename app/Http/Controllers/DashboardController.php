<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Modulo;
use App\Models\Actividad;
use App\Models\Submodulo;
use App\Imports\JLIImport;
use App\Models\Directorio;
use Illuminate\Support\Str;
use App\Models\PaisProyecto;
use App\Models\Subactividad;
use Illuminate\Http\Request;
use App\Imports\SesionesImport;
use App\Models\Ciudad;
use App\Models\Cohorte;
use App\Models\CohorteActividad;
use App\Models\GrupoParticipante;
use App\Models\EstadoParticipante;
use App\Models\SocioImplementador;
use Illuminate\Support\Facades\DB;
use App\Models\CohortePaisProyecto;
use App\Models\CohorteProyectoUser;
use App\Models\CohorteSubactividad;
use App\Models\PerfilesParticipante;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\LazyCollection;
use App\Models\CohorteSubactividadModulo;
use App\Models\CoordinadorGestor;
use App\Models\Departamento;
use App\Models\EstipendioAgrupacionParticipante;
use App\Models\EstipendioParticipante;
use App\Models\ModuloSubactividadSubmodulo;
use App\Models\Participante;
use App\Models\SesionTitulo;
use App\Models\SesionTipo;
use App\Models\Titulo;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DashboardController extends Controller
{

    public function index()
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');


        abort(404, 'File not found.');


        $filePath = public_path('data.xlsx');

        $lookupgrados = [
            "4 Bachillerato /Diversficado (13°)" => 13,
            "3 Bachillerato /Diversificado (12°)" => 12,
            "2 Bachillerato /Diversificado (11°)" => 11,
            "1 Bachillerato /Diversificado (10°)" => 10,
            "3 Bachillerato Técnico" => 15,
            "2  Bachillerato Técnico" => 14,
            "1  Bachillerato Técnico" => 13,
            "3° Basica(9°)" => 9,
            "2° Basica(8°)" => 8,
            "1° Basica(7°)" => 7,
            "6° Primaria" => 6,
            "5° Primaria" => 5,
            "4°  Primaria" => 4,
            "3° Primaria" => 3,
            "2° Primaria" => 2,
            "1° Primaria" => 1,
            "No estudia actualmente" => 0,
        ];

        $lookupestados = [
            "Activo"    => 1,
            "Desertado" => 5,
            "Pausa"     => 3,
            "Reingreso" => 4,
        ];

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );

        $data = [];

        foreach ($collection as $item) {
            // Process each row
            $id              = $item['id'];
            $cohorte         = ltrim(trim(Str::after($item['cohorte'], 'Cohorte')), '0');  // retorna solo el numbero cohorte 05 retorna 5
            $pais            = trim($item['pais']);
            $socio           = trim($item['sede']);

            //        $grupo           = substr(trim($item["grupo"]), 0, strpos(trim($item["grupo"]), "_"));

            // Take the first substring from $item["grupo"] where it finds the first "_" or " "
            $grupoParts = preg_split('/[_ ]/', trim($item["grupo"]));
            $grupo = $grupoParts[0];

            $dni             = trim($item['dni']);
            $nombres         = trim($item['nombres']);
            $apellidos       = trim($item['apellidos']);
            $sexo            = trim($item['sexo']) == 'Mujer' ? 1 : 2;
            $fechaNacimiento = trim($item['fechanac']);
            $grado           = trim($item['grado']);
            $estadoGlobal    = trim($item['estado_global']);
            $fechaEstado     = trim($item['date_state']);
            $causa           = trim($item['causa']);
            $categoria       = trim($item['categoria_nombre']);
            $comentario      = trim($item['observations']);

            if ($id) {

                if (!empty($fechaNacimiento)) {
                    $prefecha = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaNacimiento));
                    $fechaNacimiento = $prefecha->format('Y-m-d');
                }



                // PARA GENERAR USUARIO
                // 1. Socios: Tomar las iniciales de las palabras que tengan más de 4 letras
                $socioClean = trim(substr($socio, 0, strpos($socio, "(") ?: strlen($socio)));
                $socioInitials = '';
                $words = explode(' ', $socioClean);
                foreach ($words as $word) {
                    if (strlen($word) >= 4) {
                        $socioInitials .= strtoupper($word[0]);
                    }
                }

                $autoUser = "G.C0" . $cohorte . "." . $socioInitials . "." . $grupo;


                // 1 OBTENER EL PAIS PROYECTO
                if (strtolower($pais) == "guatemala") {
                    $paisProyecto = PaisProyecto::where('pais_id', 1)->where('proyecto_id', 2)->first();
                } elseif (strtolower($pais) == "honduras") {
                    $paisProyecto = PaisProyecto::where('pais_id', 3)->where('proyecto_id', 2)->first();
                }



                // 2. OBTENER EL PAIS PROYECTO COHORTE O CREARLO

                $cohortePaisProyecto = \App\Models\CohortePaisProyecto::firstOrCreate(
                    ['cohorte_id' => $cohorte, 'pais_proyecto_id' => $paisProyecto->id],
                    [
                        'active_at'      => now(),
                        'titulo_abierto' => false,
                        'fecha_inicio'   => now(),
                        'fecha_fin'      => now()->addMonths(9),
                    ]
                );



                //3. CREAR SOCIO IMPLEMENTADOR
                $socioImplementador = \App\Models\SocioImplementador::firstOrCreate(
                    ['nombre' => $socio],
                    [
                        'active_at' => now(),
                        'pais_id' => strtolower($pais) == "guatemala" ? 1 : 3,
                    ]
                );

                //4. CREAR USUARIO
                $password = Str::random(10);
                $usuario = \App\Models\User::where('username', $autoUser)->first();
                if (!$usuario) {
                    $usuario = \App\Models\User::create([
                        'username' => $autoUser,
                        'name' => $autoUser,
                        'email' => $autoUser . '@glasswing.org',
                        'email_verified_at' => now(),
                        'password' => \Illuminate\Support\Facades\Hash::make($password),
                        'socio_implementador_id' => $socioImplementador->id,
                        'remember_token' => Str::random(10),
                    ]);

                    $usuario->forceFill([
                        'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                        'remember_token' => Str::random(10),
                    ])->save();

                    $usuario->assignRole('gestor');

                    $usuario->sociosImplementadores()->sync($socioImplementador->id);

                    // 5. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
                    $usuario->cohorte()->sync([$cohortePaisProyecto->id => ['rol' => 'gestor', 'active_at' => now()]]);
                    // $usuario->cohorte()->sync($cohortePaisProyecto->id, ['rol' => 'gestor', 'active_at' => now()]);

                    $data[] = [
                        'id'       => $id,
                        'socio'    => $socio,
                        'cohorte'  => $cohorte,
                        'pais'     => $pais,
                        'grupo'    => $grupo,
                        'usuario'  => $autoUser,
                        'password' => $password,

                    ];
                }
                // Asign Roles

                //  $usuario = \App\Models\User::firstOrCreate(
                //      ['username' => $autoUser],
                //      [
                //          'name' => $autoUser,
                //          'email' => $autoUser.'@glasswing.org',
                //          'email_verified_at' => now(),
                //          'password' => \Illuminate\Support\Facades\Hash::make($password),
                //          'remember_token' => Str::random(10),
                //      ]
                //  )->assignRole('gestor');







                //6. CREAR PARTICIPANTE

                $participante = \App\Models\Participante::create([
                    'documento_identidad' => $dni,
                    'nombres'             => $nombres,
                    'apellidos'           => $apellidos,
                    'sexo'                => $sexo,
                    'fecha_nacimiento'    => !empty($fechaNacimiento) ? $fechaNacimiento : NULL,
                    'nivel_academico_id'  => !empty($grado) && $lookupgrados[$grado] != 0 ? $lookupgrados[$grado] : null,
                    'estudia_actualmente' => !empty($grado) ? 1 : 0,
                    // 'estado_global'       => $estadoGlobal,
                    // 'fecha_estado'        => $fechaEstado,
                    'gestor_id'  => $usuario->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => $usuario->id,
                    'updated_by' => $usuario->id,
                    //'active_at'  => now(),
                ]);

                $participante->estados_registros()->sync(4, ['comentario' => 'proceso automático de imporatción JLI']);

                //7. ASIGNAR PARTICIPANTE A LA COHORTE-PAIS-PROECTO
                $cohorteParticipanteProyecto = \App\Models\CohorteParticipanteProyecto::create([
                    'participante_id'            => $participante->id,
                    'cohorte_pais_proyecto_id'   => $cohortePaisProyecto->id,
                    'created_at'                 => now(),
                    'created_by'                 => $usuario->id,
                    'active_at'                  => now(),
                ]);
                // $participante->cohortePaisProyecto()->attach($cohortePaisProyecto->id, ['active_at' => now()]);
                // $pivotId = $participante->cohortePaisProyecto()->where('cohorte_pais_proyecto_id', $cohortePaisProyecto->id)->first()->pivot->id;


                //8. CREAR PARTICIPANTE GRUPO
                $grupo = GrupoParticipante::create([
                    'cohorte_participante_proyecto_id' => $cohorteParticipanteProyecto->id,
                    'grupo_id'                         => $grupo,
                    'user_id'                          => $usuario->id,
                    'created_at'                       => now(),
                    'created_by'                       => $usuario->id,
                    'active_at'                        => now(),
                ]);



                //9. CREAR ESTADO PARTICIPANTE

                // categoria razones:
                // 1: Razón de Desertado, 2: Razón de Pausa, 3: Razón de Reingreso

                $tipo = 0;
                if (strtolower($estadoGlobal) == "desertado") {
                    $tipo = 1;
                } elseif (strtolower($estadoGlobal) == "pausa") {
                    $tipo = 2;
                } elseif (strtolower($estadoGlobal) == "reingreso") {
                    $tipo = 3;
                }


                if (!empty($categoria) && !empty($causa)) {
                    $categoriaRazon = \App\Models\CategoriaRazon::firstOrCreate(
                        ['nombre' => $categoria, 'tipo' => $tipo],
                        ['created_at' => now(), 'created_by' => $usuario->id, 'active_at' => now()]
                    );

                    $razon = \App\Models\Razon::firstOrCreate(
                        ['nombre' => $causa, 'categoria_razon_id' => $categoriaRazon->id],
                        ['created_at' => now(), 'created_by' => $usuario->id, 'active_at' => now()]
                    );
                }

                if (!empty($fechaEstado)) {
                    $prefecha = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaEstado));
                    $fechaEstado = $prefecha->format('Y-m-d H:i:s');
                }

                EstadoParticipante::create([
                    'grupo_participante_id' => $grupo->id,
                    'estado_id'             => $lookupestados[$estadoGlobal],
                    'fecha'                 => !empty($fechaEstado) ? $fechaEstado : NULL,
                    'razon_id'              => !empty($categoria) && !empty($causa) ? $razon->id : null,
                    'comentario'            => $comentario,
                    'created_at'            => now(),
                    'created_by'            => $usuario->id,
                    'active_at'             => now(),
                ]);
            }
        }

        // Save $data array in CSV
        $csvFileName = public_path('data.csv');
        $csvFile = fopen($csvFileName, 'w');

        // Add headers to CSV
        fputcsv($csvFile, ['ID', 'Socio', 'Cohorte', 'Pais', 'Grupo', 'Usuario', 'Password']);

        // Add data rows to CSV
        foreach ($data as $row) {
            fputcsv($csvFile, $row);
        }

        fclose($csvFile);

        // Print $data array on the screen
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        // return view('dashboard');
    }

    public function importDirectorio()
    {
        abort(403, 'Forbidden.');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        abort(404, 'File not found.');

        $filePath = public_path('directorio_honduras.xlsx');




        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );

        $data = [];

        foreach ($collection as $item) {

            // dd($item);
            // Process each row
            $empresa = trim($item['nombre']);
            //$pais = 1; // Guatemala
            $pais = 3; // Honduras
            $descripcion = trim($item['descripcion_general_del_trabajo_de_la_organizacion']);
            $telefono = trim($item['telefono']);
            $tipo_institucion = isset($item['tipo_institucion']) && !empty($item['tipo_institucion']) ? trim($item['tipo_institucion']) : NULL;
            $tipo_insitucion_otros = trim($item['tipo_insitucion_otros']);
            $area_intervencion = trim($item['area_de_intervencion']);
            $area_intervencion_otros = trim($item['area_intervencion_otros']);
            $departamento = trim($item['departamento']);
            $municipio = trim($item['ciudad']);
            $direccion = trim($item['direccion']);
            $nombre_persona_enlace = trim($item['nombre_persona_enlace']);
            $cargo_persona_enlace = trim($item['cargo_persona_enlace']);
            $telefono_persona_enlace = trim($item['telefono_persona_enlace']);
            $email_persona_enlace = trim($item['email_persona_enlace']);
            $comentario = trim($item['comentario']);
            $tipo_apoyo = trim($item['tipo_apoyo']);


            // 2 FIND DEPARTAMENTO
            $departamentoObject = \App\Models\Departamento::where('nombre', $departamento)->where('pais_id', $pais)->firstOrFail();

            $ciudadObject = \App\Models\Ciudad::firstOrCreate(
                ['nombre' => $municipio, 'departamento_id' => $departamentoObject->id],
                ['created_at' => now(), 'created_by' => 1, 'active_at' => now()]
            );

            $data = [
                'nombre' => $empresa,
                'pais_id' => $pais,
                'descripcion' => $descripcion,
                'telefono' => $telefono,
                'tipo_institucion_id' => $tipo_institucion,
                'tipo_institucion_otros' => $tipo_insitucion_otros,
                'area_intervencion_id' => empty($area_intervencion) ? null : $area_intervencion,
                'area_intervencion_otros' => $area_intervencion_otros,
                'departamento_id' => $departamentoObject->id,
                'ciudad_id' => $ciudadObject->id,
                'direccion' => $direccion,
                'ref_nombre' => $nombre_persona_enlace,
                'ref_cargo' => $cargo_persona_enlace,
                'ref_celular' => $telefono_persona_enlace,
                'ref_email' => $email_persona_enlace,
                'comentario' => $comentario,
                'active_at' => now(),
            ];

            echo "<pre>";
            print_r($data);
            echo "</pre>";
            echo "<br>";

            $directorio = Directorio::create($data);

            if (!empty($tipo_apoyo)) {
                $tipoApoyoArray = array_map('trim', explode(',', $tipo_apoyo));
                $directorio->tipoApoyo()->sync($tipoApoyoArray);
            }


            echo "<pre>";
            print_r($item);
            echo "</pre>";
            echo "<br>";
        }
    }


    public function create()
    {
        return view('dashboard');
    }
    public function store()
    {
        return view('dashboard');
    }
    public function update()
    {
        return view('dashboard');
    }


    public function lookupGrados()
    {
        return [
            "4 Bachillerato /Diversficado (13°)" => 13,
            "3 Bachillerato /Diversificado (12°)" => 12,
            "2 Bachillerato /Diversificado (11°)" => 11,
            "1 Bachillerato /Diversificado (10°)" => 10,
            "3 Bachillerato Técnico" => 15,
            "2  Bachillerato Técnico" => 14,
            "1  Bachillerato Técnico" => 13,
            "3° Basica(9°)" => 9,
            "2° Basica(8°)" => 8,
            "1° Basica(7°)" => 7,
            "6° Primaria" => 6,
            "5° Primaria" => 5,
            "4°  Primaria" => 4,
            "3° Primaria" => 3,
            "2° Primaria" => 2,
            "1° Primaria" => 1,
            "No estudia actualmente" => 0,
        ];

        $nivel_academicos = [
            [1, "1° Grado"],
            [2, "2° Grado"],
            [3, "3° Grado"],
            [4, "4° Grado"],
            [5, "5° Grado"],
            [6, "6° Grado"],
            [7, "7° Grado"],
            [8, "8° Grado"],
            [9, "9° Grado"],
            [10, "1 Bachillerato/Diversificado (10 Grado)"],
            [11, "2 Bachillerato/Diversificado (11 Grado)"],
            [12, "3 Bachillerato/Diversificado (12 Grado)"],
            [13, "1 Bachillerato Técnico"],
            [14, "2 Bachillerato Técnico"],
            [15, "3 Bachillerato Técnico"],
            [16, "3 Bachillerato Técnico"],
            [17, "Universidad"],
        ];
    }


    public function generarmecla()
    {
        abort(403, 'Forbidden.');

        \App\Models\Role::firstOrCreate(['name' => 'MECLA']);
        \App\Models\Role::firstOrCreate(['name' => 'Staff']);
        // \App\Models\Role::create(['name' => 'MECLA']);
        // \App\Models\Role::create(['name' => 'Staff']);

        $socios = SocioImplementador::active()->get();
        $passwords = [
            'LLRavzNfEs',
            '3ULjrE0UJm',
            'cRT8dHHuYZ',
            'spOKJpI7NN',
            'crY5nAqOe4',
            'FDCwWjjpKK',
            'CbeQwLfFsn',
            'lxqJMR4TRH',
        ];
        $cuentas = [
            "ME.ACPDRO",
            "ME.CEIP",
            "ME.TN",
            "ME.ACBF",
            "ME.CRH",
            "ME.AFNV",
            "ME.CASM",
            "ME.FNPDH",
        ];
        $data = [];
        $i = 0;
        foreach ($socios as $socio) {
            // 1. Socios: Tomar las iniciales de las palabras que tengan más de 4 letras
            $socioClean = trim(substr($socio->nombre, 0, strpos($socio->nombre, "(") ?: strlen($socio->nombre)));
            $socioInitials = '';
            $words = explode(' ', $socioClean);
            foreach ($words as $word) {
                if (strlen($word) >= 4) {
                    $socioInitials .= strtoupper($word[0]);
                }
            }

            $autoUser = "ME." . $socioInitials;

            // dd($autoUser);

            $password = $passwords[$i];
            $usuario = \App\Models\User::create([
                'username' => $autoUser,
                'name' => $autoUser,
                'email' => $autoUser . '@glasswing.org',
                'email_verified_at' => now(),
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'socio_implementador_id' => $socio->id,
                'remember_token' => Str::random(10),
            ]);

            $usuario->forceFill([
                'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                'remember_token' => Str::random(10),
            ])->save();

            $usuario->assignRole('Staff');

            $data[] = [
                'socio'    => $socio->nombre,
                'pais'     => $socio->pais_id == 1 ? "Guatemala" : "Honduras",
                'usuario'  => $autoUser,
                'password' => $password,
                'rol'      => 'Staff'
            ];

            $i++;
        }

        $password = 'BhVyMu5t4T';
        $usuario = \App\Models\User::create([
            'username' => 'MECLA.GT',
            'name' => 'MECLA.GT',
            'email' => 'MECLA.GT@glasswing.org',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'socio_implementador_id' => 4, // Solo para obtener el pais
            'remember_token' => Str::random(10),
        ]);

        $usuario->forceFill([
            'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
            'remember_token' => Str::random(10),
        ])->save();

        $usuario->assignRole('MECLA');

        $data[] = [
            'socio'    => 'MECLA.GT',
            'pais'     => "Guatemala",
            'usuario'  => 'MECLA.GT',
            'password' => $password,
            'rol'      => 'MECLA'
        ];

        $password = 'tClJ1F9ZU1';
        $usuario = \App\Models\User::create([
            'username' => 'MECLA.HN',
            'name' => 'MECLA.HN',
            'email' => 'MECLA.HN@glasswing.org',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'socio_implementador_id' => 8, // Solo para obtener el pais
            'remember_token' => Str::random(10),
        ]);

        $usuario->forceFill([
            'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
            'remember_token' => Str::random(10),
        ])->save();

        $usuario->assignRole('MECLA');

        $data[] = [
            'socio'    => 'MECLA.HN',
            'pais'     => "Honduras",
            'usuario'  => 'MECLA.HN',
            'password' => $password,
            'rol'      => 'MECLA'
        ];



        // Save $data array in CSV
        $csvFileName = public_path('datamecla.csv');
        $csvFile = fopen($csvFileName, 'w');

        // Add headers to CSV
        fputcsv($csvFile, ['Socio', 'Pais', 'Usuario', 'Password']);

        // Add data rows to CSV
        foreach ($data as $row) {
            fputcsv($csvFile, $row);
        }

        fclose($csvFile);

        // Print $data array on the screen
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }


    public function permisosr4()
    {

        abort(403, 'Forbidden.');
        //abort(404, 'File not found.');

        // $categorias = [
        //     'Directorio',
        //     'Participantes R4',
        //     'Servicio comunitario',
        //     'Visualizador R4',
        // ];

        // PERMISOS  'Directorio',
        $permisosDirectorio = [
            'Listado directorio',
            'Ver directorio',
            'Crear directorio',
            'Editar directorio',
            'Eliminar directorio',
            'Exportar directorio'
        ];


        foreach ($permisosDirectorio as $permiso) {
            \App\Models\Permission::create([
                'name' => $permiso,
                'categoria' => 'Directorio',
            ]);
        }

        // PERMISOS  'Participantes',
        $permisosParticipantes = [
            'Listado participantes R4',
            'Ver mis participantes R4',
            'Ver participantes mi socio implementador R4',
            'Ver participantes mi pais R4',
            'Ver fichas R4',
            'Editar fichas R4',
            'Eliminar fichas R4',
            'Cambiar estado R4',
            'Exportar participantes R4',
            'Crear fichas R4',
        ];

        foreach ($permisosParticipantes as $permiso) {
            \App\Models\Permission::create([
                'name' => $permiso,
                'categoria' => 'Participantes R4',
            ]);
        }

        // PERMISOS  'Servicio comunitario',

        $permisosServicioComunitario = [
            'Listado servicios comunitarios',
            'Registrar servicio comunitario',
            'Editar servicio comunitario',
            'Eliminar servicio comunitario',
            'Agregar participantes servicio comunitario',
            'Seguimiento servicio comunitario',
            'Exportar servicios comunitarios',
        ];

        foreach ($permisosServicioComunitario as $permiso) {
            \App\Models\Permission::create([
                'name' => $permiso,
                'categoria' => 'Servicio comunitario',
            ]);
        }

        // PERMISOS  'Visualizador R4',

        $permisosVisualizador = [
            'Ver visualizador',
            'Exportar visualizador',
            'Filtrar registros por socio',
            'Filtrar registros por socios por pais',
        ];

        foreach ($permisosVisualizador as $permiso) {
            \App\Models\Permission::create([
                'name' => $permiso,
                'categoria' => 'Visualizador R4',
            ]);
        }

        /************************************************************** */
        $role = \App\Models\Role::where('name', 'Gestor')->first();

        foreach ($permisosDirectorio as $permission) {
            $role->givePermissionTo($permission);
        }

        $permisosParticipantesGestor = [
            'Listado participantes R4',
            'Ver mis participantes R4',
            'Ver fichas R4',
            'Editar fichas R4',
            'Eliminar fichas R4',
            'Cambiar estado R4',
            'Exportar participantes R4',
            'Crear fichas R4',
        ];

        foreach ($permisosParticipantesGestor as $permission) {
            $role->givePermissionTo($permission);
        }

        foreach ($permisosServicioComunitario as $permission) {
            $role->givePermissionTo($permission);
        }

        /************************************************************** */
        $role = \App\Models\Role::where('name', 'MECLA')->first();

        $permisosDirectorioMecla = [
            'Listado directorio',
            'Ver directorio',
            'Exportar directorio'
        ];

        foreach ($permisosDirectorio as $permission) {
            $role->givePermissionTo($permission);
        }

        // $permisosParticipantesMecla = [
        //    'Listado participantes R4',
        //    'Ver fichas R4',
        //    'Ver participantes mi pais R4',
        //    'Exportar participantes R4',
        // ];

        // foreach ($permisosParticipantesMecla as $permission) {
        //     $role->givePermissionTo($permission);
        // }

        // $permisosServicioComunitarioMecla = [
        //     'Listado servicios comunitarios',
        //     'Exportar servicios comunitarios',
        // ];

        // foreach ($permisosServicioComunitarioMecla as $permission) {
        //     $role->givePermissionTo($permission);
        // }

        $permisosVisualizadorMecla = [
            'Ver visualizador',
            'Exportar visualizador',
            'Filtrar registros por socios por pais',
        ];

        foreach ($permisosVisualizadorMecla as $permission) {
            $role->givePermissionTo($permission);
        }


        /************************************************************** */
        $role = \App\Models\Role::where('name', 'Staff')->first();

        $permisosDirectorioStaff = [
            'Listado directorio',
            'Ver directorio',
            'Exportar directorio'
        ];

        //foreach ($permisosDirectorioStaff as $permission) {
        foreach ($permisosDirectorio as $permission) {
            $role->givePermissionTo($permission);
        }

        $permisosParticipantesStaff = [
            'Listado participantes R4',
            'Ver fichas R4',
            'Ver participantes mi socio implementador R4',
            'Exportar participantes R4',
        ];


        foreach ($permisosParticipantesStaff as $permission) {
            $role->givePermissionTo($permission);
        }

        $permisosServicioComunitarioStaff = [
            'Listado servicios comunitarios',
            'Exportar servicios comunitarios',
        ];

        foreach ($permisosServicioComunitarioStaff as $permission) {
            $role->givePermissionTo($permission);
        }


        $permisosVisualizadorStaff = [
            'Ver visualizador',
            'Exportar visualizador',
            'Filtrar registros por socio',
        ];

        foreach ($permisosVisualizadorStaff as $permission) {
            $role->givePermissionTo($permission);
        }
    }

    public function permisosValidadorR4()
    {
        //abort(404);

        \App\Models\Permission::firstOrCreate([
            'name' => 'Validar R4',
            'categoria' => 'Resultado R4',
        ]);

        $permisosVisualizador = [
            'Ver visualizador',
            'Exportar visualizador',
            'Validar R4',
            'Ver mis participantes R4',
            'Filtrar registros por socio'
        ];

        $role = \App\Models\Role::where('name', 'Validación R4')->first();

        foreach ($permisosVisualizador as $permission) {
            $role->givePermissionTo($permission);
        }
    }

    public function permisosr3()
    {

        abort(404);

        $roleRegistroR3 = \App\Models\Role::where('name', 'Registro R3')
            ->first();

        \App\Models\Permission::create([
            'name' => 'Ver Resultado R3',
            'categoria' => 'Resultado R3',
        ]);

        $roleRegistroR3->givePermissionTo('Ver Resultado R3');

        $permisosPreAlianzas = [
            'Registrar Pre Alianza',
            'Ver Pre Alianzas',
            'Listado Pre Alianza',
            'Ver Pre Alianza',
            'Editar Pre Alianza',
            'Eliminar Pre Alianza',
            'Exportar Pre Alianza'
        ];

        foreach ($permisosPreAlianzas as $permiso) {
            \App\Models\Permission::create([
                'name' => $permiso,
                'categoria' => 'Pre Alianzas R3',
            ]);
        }

        foreach ($permisosPreAlianzas as $permission) {
            $roleRegistroR3->givePermissionTo($permission);
        }

        $permisosAlianzas = [
            'Registrar Alianza',
            'Ver Alianzas',
            'Listado Alianza',
            'Ver Alianza',
            'Editar Alianza',
            'Eliminar Alianza',
            'Exportar Alianza'
        ];

        foreach ($permisosAlianzas as $permiso) {
            \App\Models\Permission::create([
                'name' => $permiso,
                'categoria' => 'Alianzas R3',
            ]);
        }

        foreach ($permisosAlianzas as $permission) {
            $roleRegistroR3->givePermissionTo($permission);
        }

        $permisosApalancamientos = [
            'Registrar Apalancamiento',
            'Ver Apalancamientos',
            'Listado Apalancamiento',
            'Ver Apalancamiento',
            'Editar Apalancamiento',
            'Eliminar Apalancamiento',
            'Exportar Apalancamiento'
        ];

        foreach ($permisosApalancamientos as $permiso) {
            \App\Models\Permission::create([
                'name' => $permiso,
                'categoria' => 'Apalancamientos R3',
            ]);
        }

        foreach ($permisosApalancamientos as $permission) {
            $roleRegistroR3->givePermissionTo($permission);
        }

        $permisosCostoCompartidos = [
            'Registrar Costo Compartido',
            'Ver Costo Compartidos',
            'Listado Costo Compartido',
            'Ver Costo Compartido',
            'Editar Costo Compartido',
            'Eliminar Costo Compartido',
            'Exportar Costo Compartido'
        ];

        foreach ($permisosCostoCompartidos as $permiso) {
            \App\Models\Permission::create([
                'name' => $permiso,
                'categoria' => 'Costo Compartido R3',
            ]);
        }
        foreach ($permisosCostoCompartidos as $permission) {
            $roleRegistroR3->givePermissionTo($permission);
        }


        $roleValidacionR3 = \App\Models\Role::where('name', 'Validación R3')
            ->first();

        $permisosValidacion = [
            'Ver Visualizador R3',
            'Listar Visualizador R3',
            'Exportar Visualizador R3',
            'Validar R3',
            'Ver Ficha R3',
        ];

        foreach ($permisosValidacion as $permiso) {
            \App\Models\Permission::create([
                'name' => $permiso,
                'categoria' => 'Visualizador R3',
            ]);
        }
        foreach ($permisosValidacion as $permission) {
            $roleValidacionR3->givePermissionTo($permission);
        }
    }

    public function permisosr3Staff()
    {

        //abort(404);
        $roleValidacionStaff = \App\Models\Role::where('name', 'Staff')
            ->first();

        $permisosValidacion = [
            'Ver Visualizador R3',
            'Listar Visualizador R3',
            'Exportar Visualizador R3',
            'Validar R3',
            'Ver Ficha R3',
        ];

        foreach ($permisosValidacion as $permission) {
            $roleValidacionStaff->givePermissionTo($permission);
        }

        $roleValidacionMecla = \App\Models\Role::where('name', 'MECLA')
            ->first();

        $permisosValidacion = [
            'Ver Visualizador R3',
            'Listar Visualizador R3',
            'Exportar Visualizador R3',
            'Ver Ficha R3',
        ];

        foreach ($permisosValidacion as $permission) {
            $roleValidacionMecla->givePermissionTo($permission);
        }
    }



    public function importSesionesGrupoA()
    {

        //abort(403, 'Forbidden.');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filePath = public_path('ejemplo_estructura_de_asistencia.xlsx');

        // Using LazyCollection for memory efficiency
        $sesiones = new SesionesImport();
        // For testing only import first sheet
        $sesiones->onlySheets('Grupo A (15-18a)');

        Excel::import($sesiones, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection($sesiones, $filePath)->first()
        );

        $data = [];
        $perfilId = null;
        $userId = 5;

        $cohortePaisProyecto = CohortePaisProyecto::with('perfilesParticipante:id,nombre')
            ->where('cohorte_id', 5)
            ->get();

        $grupo_id = GrupoParticipante::whereIn('user_id', [$userId])
            //->groupBy('grupo_id')
            ->pluck('grupo_id')
            ->first();


        foreach ($cohortePaisProyecto->get(0)->perfilesParticipante as $perfil) {
            if ($perfil->nombre == 'Perfil A') {
                $perfilId = $perfil->pivot->id;
            }
        }


        // Asignar el perfil A a los grupos
        $grupos = GrupoParticipante::whereIn('user_id', [$userId])->get();

        foreach ($grupos as $grupo) {
            $grupo->cohorte_pais_proyecto_perfil_id = $perfilId;
            $grupo->save();
        }


        $now = Carbon::now();
        $future = Carbon::now()->addDays(7);    // Agrega un maximo de 7 dias para las sesiones


        $actividad = null;
        $subactividad = null;
        $modulo = null;
        $submodulo = null;

        foreach ($collection as $key => $item) {
            if ($key > 0) {

                // Save actividad (nivel 1)
                if (!empty($item['estructura_programatica_del_programa_jovenes_lideres_de_impacto_a_partir_de_la_sistematizacion_2024'])) {
                    $actividad = Actividad::firstOrCreate(
                        ['nombre' => $item['estructura_programatica_del_programa_jovenes_lideres_de_impacto_a_partir_de_la_sistematizacion_2024']],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $subactividad = null;
                    $modulo = null;
                    $submodulo = null;

                    foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                        CohorteActividad::firstOrCreate(
                            [
                                'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id,
                                'cohorte_pais_proyecto_perfil_id' => $perfilId,
                                'actividad_id' => $actividad->id,
                            ],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );
                    }
                }

                // Save subactividad (nivel 2)
                if (!empty($item['1'])) {
                    $subactividad = Subactividad::firstOrCreate(
                        ['nombre' => $item['1']],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $modulo = null;
                    $submodulo = null;

                    foreach (CohorteActividad::where('actividad_id', $actividad->id)->get() as $cohorte_actividad) {
                        CohorteSubactividad::firstOrCreate(
                            ['cohorte_actividad_id' => $cohorte_actividad->id, 'subactividad_id' => $subactividad->id],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );
                    }
                }

                // Save modulo (nivel 3)
                if (!empty($item['2'])) {
                    $modulo = Modulo::firstOrCreate(
                        ['nombre' => $item['2']],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $submodulo = null;

                    foreach (CohorteSubactividad::where('subactividad_id', $subactividad->id)->get() as $cohorte_subactividad) {
                        CohorteSubactividadModulo::firstOrCreate(
                            ['cohorte_subactividad_id' => $cohorte_subactividad->id, 'modulo_id' => $modulo->id],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );
                    }
                }

                // Save submodulo (nivel 4)
                if (!empty($item['3'])) {
                    $submodulo = Submodulo::firstOrCreate(
                        ['nombre' => $item['3']],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    foreach (CohorteSubactividadModulo::where('modulo_id', $modulo->id)->get() as $modulo_subactividad_submodulo) {
                        ModuloSubactividadSubmodulo::firstOrCreate(
                            ['cohorte_subactividad_modulo_id' => $modulo_subactividad_submodulo->id, 'submodulo_id' => $submodulo->id],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );
                    }
                }


                $sesion_titulo = \App\Models\SesionTitulo::CERRADO;
                $sesion_tipo = \App\Models\SesionTipo::SESION_GENERAL;

                if (empty($item['4']) || str_contains($item['4'], 'No aplica (registro diario)')) {
                    $sesion_titulo = \App\Models\SesionTitulo::ABIERTO;
                    $sesion_tipo = \App\Models\SesionTipo::HORAS_PARTICIPANTE;
                }


                if (!empty($item['4']) || !empty($item['5'])) {
                    $model = $submodulo ?? $modulo ?? $subactividad ?? $actividad ?? null;

                    if ($model) {

                        foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                            $model->tipoSesion()->updateOrCreate(
                                ['cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id, 'tipo' => $sesion_tipo],
                                ['tipo' => $sesion_tipo]
                            );
                        }


                        // Solo se guarda titulo para titulos cerrados
                        if ($sesion_titulo == \App\Models\SesionTitulo::CERRADO) {
                            $titulo = \App\Models\Titulo::firstOrCreate(
                                ['nombre' => trim($item['4'])],
                                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                            );

                            foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                                $model->tituloSesion()->updateOrCreate(
                                    ['cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id, 'titulo_id' => $titulo->id],
                                    ['titulo_abierto' => $sesion_titulo]
                                );
                            }
                        } else {
                            foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                                $model->tituloSesion()->updateOrCreate(
                                    ['cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id],
                                    ['titulo_abierto' => $sesion_titulo]
                                );
                            }
                        }

                        foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                            if ($perfilId) {
                                $columns = [
                                    'fecha' => $now,
                                    'hora' => $item['5'] ?? 0,
                                    'minuto' => 0,
                                    'modalidad' => 1,   // Presencial
                                ];

                                if ($sesion_titulo == \App\Models\SesionTitulo::ABIERTO) {
                                    $columns['fecha_fin'] = $future;
                                }

                                $model->sesiones()->updateOrCreate(
                                    [
                                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id,
                                        'cohorte_pais_proyecto_perfil_id' => $perfilId,
                                        'user_id' => $userId,
                                        'grupo_id' => $grupo_id,
                                        'titulo_id' => $titulo->id ?? null,
                                        'titulo' => $titulo?->id == null ? $item['4'] : null,
                                        'actividad_id' => $actividad->id ?? null,
                                        'subactividad_id' => $subactividad?->id ?? null,
                                        'modulo_id' => $modulo?->id ?? null,
                                        'submodulo_id' => $submodulo?->id ?? null,
                                        'active_at' => now(),
                                    ],
                                    $columns
                                );
                            }
                        }
                    }

                    $data[] = [
                        'actividad' => $actividad,
                        'subactividad' => $subactividad,
                        'modulo' => $modulo,
                        'submodulo' => $submodulo,
                        'titulo' => $item['4'],
                        'duracion' => $item['5'],
                        'sesion_titulo' => $sesion_titulo,
                        'sesion_tipo' => $sesion_tipo,
                    ];
                }
            }
        }

        dd($data);
    }

    public function importSesionesGrupoB()
    {

        //abort(403, 'Forbidden.');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filePath = public_path('ejemplo_estructura_de_asistencia.xlsx');

        // Using LazyCollection for memory efficiency
        $sesiones = new SesionesImport();
        // For testing only import first sheet
        $sesiones->onlySheets('Grupo B (18-22a)');

        Excel::import($sesiones, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection($sesiones, $filePath)->first()
        );

        $data = [];
        $perfilId = null;
        $userId = 6;

        $cohortePaisProyecto = \App\Models\CohortePaisProyecto::with('perfilesParticipante:id,nombre')
            ->where('cohorte_id', 5)
            ->get();

        $grupo_id = \App\Models\GrupoParticipante::whereIn('user_id', [$userId])
            ->groupBy('grupo_id')
            ->pluck('grupo_id')
            ->first();


        foreach ($cohortePaisProyecto->get(0)->perfilesParticipante as $perfil) {
            if ($perfil->nombre == 'Perfil B') {
                $perfilId = $perfil->pivot->id;
            }
        }


        // Asignar el perfil B a los grupos
        $grupos = GrupoParticipante::whereIn('user_id', [$userId])->get();

        foreach ($grupos as $grupo) {
            $grupo->cohorte_pais_proyecto_perfil_id = $perfilId;
            $grupo->save();
        }


        $now = Carbon::now();
        $future = Carbon::now()->addDays(7);    // Agrega un maximo de 7 dias para las sesiones


        $actividad = null;
        $subactividad = null;
        $modulo = null;
        $submodulo = null;

        foreach ($collection as $key => $item) {
            if ($key > 0) {

                // Save actividad (nivel 1)
                if (!empty($item['estructura_programatica_del_programa_jovenes_lideres_de_impacto_a_partir_de_la_sistematizacion_2024'])) {
                    $actividad = Actividad::firstOrCreate(
                        ['nombre' => $item['estructura_programatica_del_programa_jovenes_lideres_de_impacto_a_partir_de_la_sistematizacion_2024']],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $subactividad = null;
                    $modulo = null;
                    $submodulo = null;

                    foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                        CohorteActividad::firstOrCreate(
                            [
                                'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id,
                                'cohorte_pais_proyecto_perfil_id' => $perfilId,
                                'actividad_id' => $actividad->id,
                            ],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );
                    }
                }

                // Save subactividad (nivel 2)
                if (!empty($item['1'])) {
                    $subactividad = Subactividad::firstOrCreate(
                        ['nombre' => $item['1']],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $modulo = null;
                    $submodulo = null;

                    foreach (CohorteActividad::where('actividad_id', $actividad->id)->get() as $cohorte_actividad) {
                        CohorteSubactividad::firstOrCreate(
                            ['cohorte_actividad_id' => $cohorte_actividad->id, 'subactividad_id' => $subactividad->id],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );
                    }
                }

                // Save modulo (nivel 3)
                if (!empty($item['2'])) {
                    $modulo = Modulo::firstOrCreate(
                        ['nombre' => $item['2']],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $submodulo = null;

                    foreach (CohorteSubactividad::where('subactividad_id', $subactividad->id)->get() as $cohorte_subactividad) {
                        CohorteSubactividadModulo::firstOrCreate(
                            ['cohorte_subactividad_id' => $cohorte_subactividad->id, 'modulo_id' => $modulo->id],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );
                    }
                }

                // Save submodulo (nivel 4)
                if (!empty($item['3'])) {
                    $submodulo = Submodulo::firstOrCreate(
                        ['nombre' => $item['3']],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    foreach (CohorteSubactividadModulo::where('modulo_id', $modulo->id)->get() as $modulo_subactividad_submodulo) {
                        ModuloSubactividadSubmodulo::firstOrCreate(
                            ['cohorte_subactividad_modulo_id' => $modulo_subactividad_submodulo->id, 'submodulo_id' => $submodulo->id],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );
                    }
                }


                $sesion_titulo = \App\Models\SesionTitulo::CERRADO;
                $sesion_tipo = \App\Models\SesionTipo::SESION_GENERAL;

                if (empty($item['4']) || str_contains($item['4'], 'No aplica (registro diario)')) {
                    $sesion_titulo = \App\Models\SesionTitulo::ABIERTO;
                    $sesion_tipo = \App\Models\SesionTipo::HORAS_PARTICIPANTE;
                }


                if (!empty($item['4']) || !empty($item['5'])) {
                    $model = $submodulo ?? $modulo ?? $subactividad ?? $actividad ?? null;

                    if ($model) {

                        foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                            $model->tipoSesion()->updateOrCreate(
                                ['cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id, 'tipo' => $sesion_tipo],
                                ['tipo' => $sesion_tipo]
                            );
                        }


                        // Solo se guarda titulo para titulos cerrados
                        if ($sesion_titulo == \App\Models\SesionTitulo::CERRADO) {
                            $titulo = \App\Models\Titulo::firstOrCreate(
                                ['nombre' => trim($item['4'])],
                                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                            );

                            foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                                $model->tituloSesion()->updateOrCreate(
                                    ['cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id, 'titulo_id' => $titulo->id],
                                    ['titulo_abierto' => $sesion_titulo]
                                );
                            }
                        } else {
                            foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                                $model->tituloSesion()->updateOrCreate(
                                    ['cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id],
                                    ['titulo_abierto' => $sesion_titulo]
                                );
                            }
                        }

                        foreach ($cohortePaisProyecto as $cohorte_pais_proyecto_id) {
                            if ($perfilId) {
                                $columns = [
                                    'fecha' => $now,
                                    'hora' => $item['5'] ?? 0,
                                    'minuto' => 0,
                                    'modalidad' => 1,   // Presencial
                                ];

                                if ($sesion_titulo == \App\Models\SesionTitulo::ABIERTO) {
                                    $columns['fecha_fin'] = $future;
                                }

                                $model->sesiones()->updateOrCreate(
                                    [
                                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id->id,
                                        'cohorte_pais_proyecto_perfil_id' => $perfilId,
                                        'user_id' => $userId,
                                        'grupo_id' => $grupo_id,
                                        'titulo_id' => $titulo->id ?? null,
                                        'titulo' => $titulo?->id == null ? $item['4'] : null,
                                        'actividad_id' => $actividad->id ?? null,
                                        'subactividad_id' => $subactividad?->id ?? null,
                                        'modulo_id' => $modulo?->id ?? null,
                                        'submodulo_id' => $submodulo?->id ?? null,
                                        'active_at' => now(),
                                    ],
                                    $columns
                                );
                            }
                        }
                    }

                    $data[] = [
                        'actividad' => $actividad,
                        'subactividad' => $subactividad,
                        'modulo' => $modulo,
                        'submodulo' => $submodulo,
                        'titulo' => $item['4'],
                        'duracion' => $item['5'],
                        'sesion_titulo' => $sesion_titulo,
                        'sesion_tipo' => $sesion_tipo,
                    ];
                }
            }
        }

        dd($data);
    }

    public function importSesionesJLI()
    {
        //abort(403, 'Forbidden.');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filePath = public_path('estructura_de_cohortes_jli.xlsx');

        // Using LazyCollection for memory efficiency
        $sesiones = new SesionesImport();
        // For testing only import first sheet
        $sesiones->onlySheets('Sesiones GT');

        Excel::import($sesiones, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection($sesiones, $filePath)->first()
        );


        // Obtiene cohortePaisProyecto por Cohorte 8 y Cohorte Gestores para Guatemala
        $cohortePaisProyecto = CohortePaisProyecto::with([
            'perfilesParticipante:id,nombre',
            'paisProyecto.pais:id,nombre',
            'cohorte:id,nombre',
        ])
            ->where('pais_proyecto_id', 2)
            ->whereHas('cohorte', function ($query) {
                $query->whereIn('nombre', ['Cohorte 8', 'Cohorte Gestores']);
            })
            ->get();
        // dd($cohortePaisProyecto);

        $cohortes = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohortes[$value->paisProyecto->pais->nombre][$value->cohorte->nombre] = $value->id;
        }
        // dd($cohortes);


        // Obtiene todos las cohorte_pais_proyecto_perfil_id que tiene la cohortePaisProyecto
        $perfiles = [];

        foreach ($cohortePaisProyecto as $value) {
            foreach ($value->perfilesParticipante as $perfil) {
                $perfiles[$value->paisProyecto->pais->nombre][$value->cohorte->nombre][$perfil->nombre] = $perfil->pivot->id;
            }
        }


        // Obtiene todos los gestores pertenecientes a cohortePaisProyecto
        $users = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohorteProyectoUser = CohorteProyectoUser::where('cohorte_pais_proyecto_id', $value->id)
                ->where('rol', 'Gestor')
                ->pluck('user_id');

            foreach ($cohorteProyectoUser as $user) {
                $users[$value->id][] = $user;
            }
        }


        $actividad = null;
        $subactividad = null;
        $modulo = null;
        $submodulo = null;

        foreach ($collection as $key => $item) {
            if ($key > 0) {
                $cohorte_pais_proyecto_perfil_id = $perfiles[trim($item->first())][trim($item->get(1))][trim($item->get(2))];
                $cohorte_pais_proyecto_id = $cohortes[trim($item->first())][trim($item->get(1))];

                // Crea las actividades (nivel 1)
                $actividad = Actividad::firstOrCreate(
                    ['nombre' => $item->get(3)],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                $subactividad = null;
                $modulo = null;
                $submodulo = null;

                $cohorte_actividad = CohorteActividad::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'actividad_id' => $actividad->id,
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );


                // Save subactividad (nivel 2)
                if (!empty($item->get(4))) {
                    $subactividad = Subactividad::firstOrCreate(
                        ['nombre' => $item->get(4)],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $modulo = null;
                    $submodulo = null;

                    $cohorte_subactividad = CohorteSubactividad::firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'cohorte_actividad_id' => $cohorte_actividad->id,
                            'subactividad_id' => $subactividad->id
                        ],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );
                }


                // Save modulo (nivel 3)
                if (!empty($item->get(5))) {
                    $modulo = Modulo::firstOrCreate(
                        ['nombre' => $item->get(5)],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $submodulo = null;

                    $modulo_subactividad_submodulo = CohorteSubactividadModulo::firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'cohorte_subactividad_id' => $cohorte_subactividad->id,
                            'modulo_id' => $modulo->id
                        ],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );
                }


                // Save submodulo (nivel 4)
                if (!empty($item->get(6))) {
                    $submodulo = Submodulo::firstOrCreate(
                        ['nombre' => $item->get(6)],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    ModuloSubactividadSubmodulo::firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'cohorte_subactividad_modulo_id' => $modulo_subactividad_submodulo->id,
                            'submodulo_id' => $submodulo->id
                        ],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );
                }


                // Se define el tipo de la sesion por el tipo de asistencia, por defecto es cerrado (por checkbox)
                $sesion_titulo = SesionTitulo::CERRADO;
                $sesion_tipo = SesionTipo::SESION_GENERAL;
                $titulo = null;

                if (trim($item->get(9)) != 'Si') {
                    $sesion_titulo = SesionTitulo::ABIERTO;
                    $sesion_tipo = SesionTipo::HORAS_PARTICIPANTE;
                }


                $model = $submodulo ?? $modulo ?? $subactividad ?? $actividad ?? null;

                if ($model) {
                    $model->tipoSesion()->firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'actividad_id' => $actividad->id ?? null,
                            'subactividad_id' => $subactividad?->id ?? null,
                            'modulo_id' => $modulo?->id ?? null,
                            'submodulo_id' => $submodulo?->id ?? null,
                            'tipo' => $sesion_tipo
                        ]
                    );

                    // Solo se guarda titulo para titulos cerrados
                    if ($sesion_titulo == SesionTitulo::CERRADO) {
                        $titulo = Titulo::firstOrCreate(
                            ['nombre' => trim($item->get(7))],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );

                        $model->tituloSesion()->firstOrCreate(
                            [
                                'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                                'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                                'actividad_id' => $actividad->id ?? null,
                                'subactividad_id' => $subactividad?->id ?? null,
                                'modulo_id' => $modulo?->id ?? null,
                                'submodulo_id' => $submodulo?->id ?? null,
                                'titulo_id' => $titulo->id,
                                'titulo_abierto' => $sesion_titulo,
                            ]
                        );
                    } else {
                        $months = [
                            'Enero',
                            'Febrero',
                            'Marzo',
                            'Abril',
                            'Mayo',
                            'Junio',
                            'Julio',
                            'Agosto',
                            'Septiembre',
                            'Octubre',
                            'Noviembre',
                            'Diciembre'
                        ];

                        foreach ($months as $month) {
                            $titulo = Titulo::firstOrCreate(
                                ['nombre' => trim($month)],
                                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                            );

                            $model->tituloSesion()->firstOrCreate(
                                [
                                    'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                                    'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                                    'actividad_id' => $actividad->id ?? null,
                                    'subactividad_id' => $subactividad?->id ?? null,
                                    'modulo_id' => $modulo?->id ?? null,
                                    'submodulo_id' => $submodulo?->id ?? null,
                                    'titulo_id' => $titulo->id,
                                    'titulo_abierto' => $sesion_titulo,
                                ]
                            );
                        }
                    }


                    // Asignar las sesiones a todos los usuarios que perteneces a la cohortePaisProyecto
                    // foreach ($users[$cohorte_pais_proyecto_id] as $userId) {
                    //     $model->sesiones()->updateOrCreate(
                    //         [
                    //             'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                    //             'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                    //             'user_id' => $userId,
                    //             // 'grupo_id' => $grupo_id,
                    //             'titulo_id' => $sesion_titulo == SesionTitulo::CERRADO ? $titulo->id : null,
                    //             'titulo' => $sesion_titulo == SesionTitulo::ABIERTO ? trim($item->get(7)) : null,
                    //             'tipo' => $sesion_tipo,
                    //             'actividad_id' => $actividad->id ?? null,
                    //             'subactividad_id' => $subactividad?->id ?? null,
                    //             'modulo_id' => $modulo?->id ?? null,
                    //             'submodulo_id' => $submodulo?->id ?? null,
                    //             'active_at' => now(),
                    //         ],
                    //         [
                    //             'hora' => $item->get(8) ?? 0,
                    //             'minuto' => 0,
                    //             'modalidad' => 1,   // Presencial
                    //         ]
                    //     );
                    // }
                }
            }
        }


        dd('imported JLI!');
    }

    public function importSesionesJLIGt7()
    {
        //abort(403, 'Forbidden.');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filePath = public_path('estructura_de_cohortes_jli_gt_cohorte_7.xlsx');

        // Using LazyCollection for memory efficiency
        $sesiones = new SesionesImport();
        // For testing only import first sheet
        $sesiones->onlySheets('GT');

        Excel::import($sesiones, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection($sesiones, $filePath)->first()
        );
        // dd($collection);


        // Obtiene cohortePaisProyecto por Cohorte 8 y Cohorte Gestores para Guatemala
        $cohortePaisProyecto = CohortePaisProyecto::with([
            'perfilesParticipante:id,nombre',
            'paisProyecto.pais:id,nombre',
            'cohorte:id,nombre',
        ])
            ->where('pais_proyecto_id', 2)
            ->whereHas('cohorte', function ($query) {
                $query->whereIn('nombre', ['Cohorte 7']);
            })
            ->get();
        // dd($cohortePaisProyecto);

        $cohortes = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohortes[$value->paisProyecto->pais->nombre][$value->cohorte->nombre] = $value->id;
        }
        // dd($cohortes);


        // Obtiene todos las cohorte_pais_proyecto_perfil_id que tiene la cohortePaisProyecto
        $perfiles = [];

        foreach ($cohortePaisProyecto as $value) {
            foreach ($value->perfilesParticipante as $perfil) {
                $perfiles[$value->paisProyecto->pais->nombre][$value->cohorte->nombre][$perfil->nombre] = $perfil->pivot->id;
            }
        }


        // Obtiene todos los gestores pertenecientes a cohortePaisProyecto
        $users = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohorteProyectoUser = CohorteProyectoUser::where('cohorte_pais_proyecto_id', $value->id)
                ->where('rol', 'Gestor')
                ->pluck('user_id');

            foreach ($cohorteProyectoUser as $user) {
                $users[$value->id][] = $user;
            }
        }

        // dd($users);


        $actividad = null;
        $subactividad = null;
        $modulo = null;
        $submodulo = null;

        foreach ($collection as $key => $item) {

            $cohorte_pais_proyecto_perfil_id = $perfiles[trim($item->first())][trim($item->get('cohorte'))][trim($item->get('perfil'))];
            $cohorte_pais_proyecto_id = $cohortes[trim($item->first())][trim($item->get('cohorte'))];


            // Crea las actividades (nivel 1)
            $actividad = Actividad::firstOrCreate(
                ['nombre' => $item->get('nivel_1')],
                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
            );

            $subactividad = null;
            $modulo = null;
            $submodulo = null;

            $cohorte_actividad = CohorteActividad::firstOrCreate(
                [
                    'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                    'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                    'actividad_id' => $actividad->id,
                ],
                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
            );


            // Save subactividad (nivel 2)
            if (!empty($item->get('nivel_2'))) {
                $subactividad = Subactividad::firstOrCreate(
                    ['nombre' => $item->get('nivel_2')],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                $modulo = null;
                $submodulo = null;

                $cohorte_subactividad = CohorteSubactividad::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'cohorte_actividad_id' => $cohorte_actividad->id,
                        'subactividad_id' => $subactividad->id
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );
            }


            // Save modulo (nivel 3)
            if (!empty($item->get('nivel_3'))) {
                $modulo = Modulo::firstOrCreate(
                    ['nombre' => $item->get('nivel_3')],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                $submodulo = null;

                $modulo_subactividad_submodulo = CohorteSubactividadModulo::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'cohorte_subactividad_id' => $cohorte_subactividad->id,
                        'modulo_id' => $modulo->id
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );
            }


            // Save submodulo (nivel 4)
            if (!empty($item->get('nivel_4'))) {
                $submodulo = Submodulo::firstOrCreate(
                    ['nombre' => $item->get('nivel_4')],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                ModuloSubactividadSubmodulo::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'cohorte_subactividad_modulo_id' => $modulo_subactividad_submodulo->id,
                        'submodulo_id' => $submodulo->id
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );
            }


            // Se define el tipo de la sesion por el tipo de asistencia, por defecto es cerrado (por checkbox)
            $sesion_titulo = SesionTitulo::CERRADO;
            $sesion_tipo = SesionTipo::SESION_GENERAL;
            $titulo = null;

            if (strtolower(trim($item->get('por_asistencias'))) != 'si') {
                $sesion_titulo = SesionTitulo::ABIERTO;
                $sesion_tipo = SesionTipo::HORAS_PARTICIPANTE;
            }


            $model = $submodulo ?? $modulo ?? $subactividad ?? $actividad ?? null;

            if ($model) {
                $model->tipoSesion()->firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'actividad_id' => $actividad->id ?? null,
                        'subactividad_id' => $subactividad?->id ?? null,
                        'modulo_id' => $modulo?->id ?? null,
                        'submodulo_id' => $submodulo?->id ?? null,
                        'tipo' => $sesion_tipo
                    ]
                );

                // Solo se guarda titulo para titulos cerrados
                if ($sesion_titulo == SesionTitulo::CERRADO) {
                    $titulo = Titulo::firstOrCreate(
                        ['nombre' => trim($item->get('titulo'))],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $model->tituloSesion()->firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'actividad_id' => $actividad->id ?? null,
                            'subactividad_id' => $subactividad?->id ?? null,
                            'modulo_id' => $modulo?->id ?? null,
                            'submodulo_id' => $submodulo?->id ?? null,
                            'titulo_id' => $titulo->id,
                            'titulo_abierto' => $sesion_titulo,
                        ]
                    );
                } else {
                    $months = [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Junio',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'
                    ];

                    foreach ($months as $month) {
                        $titulo = Titulo::firstOrCreate(
                            ['nombre' => trim($month)],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );

                        $model->tituloSesion()->firstOrCreate(
                            [
                                'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                                'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                                'actividad_id' => $actividad->id ?? null,
                                'subactividad_id' => $subactividad?->id ?? null,
                                'modulo_id' => $modulo?->id ?? null,
                                'submodulo_id' => $submodulo?->id ?? null,
                                'titulo_id' => $titulo->id,
                                'titulo_abierto' => $sesion_titulo,
                            ]
                        );
                    }
                }
            }
        }


        dd('imported JLI Guatemala Cohorte 7!');
    }

    public function importSesionesJCP()
    {
        //abort(403, 'Forbidden.');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filePath = public_path('estructura_de_cohortes_jcp.xlsx');

        // Using LazyCollection for memory efficiency
        $sesiones = new SesionesImport();
        // For testing only import first sheet
        $sesiones->onlySheets('Sesiones');

        Excel::import($sesiones, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection($sesiones, $filePath)->first()
        );


        // Obtiene cohortePaisProyecto por Cohorte 8 y Cohorte Gestores para Guatemala
        $cohortePaisProyecto = CohortePaisProyecto::with([
            'perfilesParticipante:id,nombre',
            'paisProyecto.pais:id,nombre',
            'cohorte:id,nombre',
        ])
            ->where('pais_proyecto_id', 1)
            ->whereHas('cohorte', function ($query) {
                $query->whereIn('nombre', ['Cohorte Gestores', 'MAO Cohorte 2', 'Cohorte JCP - 01']);
            })
            ->get();
        // dd($cohortePaisProyecto);

        $cohortes = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohortes[$value->paisProyecto->pais->nombre][$value->cohorte->nombre] = $value->id;
        }
        // dd($cohortes);


        // Obtiene todos las cohorte_pais_proyecto_perfil_id que tiene la cohortePaisProyecto
        $perfiles = [];

        foreach ($cohortePaisProyecto as $value) {
            foreach ($value->perfilesParticipante as $perfil) {
                $perfiles[$value->paisProyecto->pais->nombre][$value->cohorte->nombre][$perfil->nombre] = $perfil->pivot->id;
            }
        }
        // dd($perfiles);


        // Obtiene todos los gestores pertenecientes a cohortePaisProyecto
        $users = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohorteProyectoUser = CohorteProyectoUser::where('cohorte_pais_proyecto_id', $value->id)
                ->where('rol', 'Gestor')
                ->pluck('user_id');

            foreach ($cohorteProyectoUser as $user) {
                $users[$value->id][] = $user;
            }
        }
        // dd($users);


        $actividad = null;
        $subactividad = null;
        $modulo = null;
        $submodulo = null;

        foreach ($collection as $key => $item) {
            if ($key > 0) {
                $cohorteName = trim($item->get(1));

                if ($cohorteName == 'Gestores') {
                    $cohorteName = 'Cohorte Gestores';
                }

                if ($cohorteName == 'Cohorte MAO - 02') {
                    $cohorteName = 'MAO Cohorte 2';
                }

                $cohorte_pais_proyecto_perfil_id = $perfiles[trim($item->first())][$cohorteName][trim($item->get(2))];
                $cohorte_pais_proyecto_id = $cohortes[trim($item->first())][$cohorteName];

                // Crea las actividades (nivel 1)
                $actividad = Actividad::firstOrCreate(
                    ['nombre' => $item->get(3)],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                $subactividad = null;
                $modulo = null;
                $submodulo = null;

                $cohorte_actividad = CohorteActividad::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'actividad_id' => $actividad->id,
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );


                // Save subactividad (nivel 2)
                if (!empty($item->get(4))) {
                    $subactividad = Subactividad::firstOrCreate(
                        ['nombre' => $item->get(4)],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $modulo = null;
                    $submodulo = null;

                    $cohorte_subactividad = CohorteSubactividad::firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'cohorte_actividad_id' => $cohorte_actividad->id,
                            'subactividad_id' => $subactividad->id
                        ],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );
                }


                // Save modulo (nivel 3)
                if (!empty($item->get(5))) {
                    $modulo = Modulo::firstOrCreate(
                        ['nombre' => $item->get(5)],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $submodulo = null;

                    $modulo_subactividad_submodulo = CohorteSubactividadModulo::firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'cohorte_subactividad_id' => $cohorte_subactividad->id,
                            'modulo_id' => $modulo->id
                        ],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );
                }


                // Save submodulo (nivel 4)
                if (!empty($item->get(6))) {
                    $submodulo = Submodulo::firstOrCreate(
                        ['nombre' => $item->get(6)],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    ModuloSubactividadSubmodulo::firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'cohorte_subactividad_modulo_id' => $modulo_subactividad_submodulo->id,
                            'submodulo_id' => $submodulo->id
                        ],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );
                }


                // Se define el tipo de la sesion por el tipo de asistencia, por defecto es cerrado (por checkbox)
                $sesion_titulo = SesionTitulo::CERRADO;
                $sesion_tipo = SesionTipo::SESION_GENERAL;
                $titulo = null;

                if (trim($item->get(9)) != 'Si') {
                    $sesion_titulo = SesionTitulo::ABIERTO;
                    $sesion_tipo = SesionTipo::HORAS_PARTICIPANTE;
                }


                $model = $submodulo ?? $modulo ?? $subactividad ?? $actividad ?? null;

                if ($model) {
                    $model->tipoSesion()->firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'actividad_id' => $actividad->id ?? null,
                            'subactividad_id' => $subactividad?->id ?? null,
                            'modulo_id' => $modulo?->id ?? null,
                            'submodulo_id' => $submodulo?->id ?? null,
                            'tipo' => $sesion_tipo
                        ]
                    );

                    // Solo se guarda titulo para titulos cerrados
                    if ($sesion_titulo == SesionTitulo::CERRADO) {
                        $titulo = Titulo::firstOrCreate(
                            ['nombre' => trim($item->get(7))],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );

                        $model->tituloSesion()->firstOrCreate(
                            [
                                'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                                'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                                'actividad_id' => $actividad->id ?? null,
                                'subactividad_id' => $subactividad?->id ?? null,
                                'modulo_id' => $modulo?->id ?? null,
                                'submodulo_id' => $submodulo?->id ?? null,
                                'titulo_id' => $titulo->id,
                                'titulo_abierto' => $sesion_titulo,
                            ]
                        );
                    } else {
                        if (trim($item->get(7) == '(Meses del año)')) {
                            $months = [
                                'Enero',
                                'Febrero',
                                'Marzo',
                                'Abril',
                                'Mayo',
                                'Junio',
                                'Julio',
                                'Agosto',
                                'Septiembre',
                                'Octubre',
                                'Noviembre',
                                'Diciembre'
                            ];

                            foreach ($months as $month) {
                                $titulo = Titulo::firstOrCreate(
                                    ['nombre' => trim($month)],
                                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                                );

                                $model->tituloSesion()->firstOrCreate(
                                    [
                                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                                        'actividad_id' => $actividad->id ?? null,
                                        'subactividad_id' => $subactividad?->id ?? null,
                                        'modulo_id' => $modulo?->id ?? null,
                                        'submodulo_id' => $submodulo?->id ?? null,
                                        'titulo_id' => $titulo->id,
                                        'titulo_abierto' => $sesion_titulo,
                                    ]
                                );
                            }
                        } else {
                            $titulo = Titulo::firstOrCreate(
                                ['nombre' => trim($item->get(7))],
                                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                            );

                            $model->tituloSesion()->firstOrCreate(
                                [
                                    'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                                    'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                                    'actividad_id' => $actividad->id ?? null,
                                    'subactividad_id' => $subactividad?->id ?? null,
                                    'modulo_id' => $modulo?->id ?? null,
                                    'submodulo_id' => $submodulo?->id ?? null,
                                    'titulo_id' => $titulo->id,
                                    'titulo_abierto' => $sesion_titulo,
                                ]
                            );
                        }
                    }
                }
            }
        }


        dd('imported JCP!');
    }

    public function importSesionesJLIHN()
    {
        //abort(403, 'Forbidden.');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filePath = public_path('estructura_de_cohortes_jli-hn.xlsx');

        // Using LazyCollection for memory efficiency
        $sesiones = new SesionesImport();
        // For testing only import first sheet
        $sesiones->onlySheets('HN');

        Excel::import($sesiones, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection($sesiones, $filePath)->first()
        );
        // dd($collection);


        // Obtiene cohortePaisProyecto por Cohorte 8 y Cohorte Gestores para Guatemala
        $cohortePaisProyecto = CohortePaisProyecto::with([
            'perfilesParticipante:id,nombre',
            'paisProyecto.pais:id,nombre',
            'cohorte:id,nombre',
        ])
            ->where('pais_proyecto_id', 3)
            ->whereHas('cohorte', function ($query) {
                $query->whereIn('nombre', ['Cohorte 8']);
            })
            ->get();
        // dd($cohortePaisProyecto);

        $cohortes = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohortes[$value->paisProyecto->pais->nombre][$value->cohorte->nombre] = $value->id;
        }
        // dd($cohortes);


        // Obtiene todos las cohorte_pais_proyecto_perfil_id que tiene la cohortePaisProyecto
        $perfiles = [];

        foreach ($cohortePaisProyecto as $value) {
            foreach ($value->perfilesParticipante as $perfil) {
                $perfiles[$value->paisProyecto->pais->nombre][$value->cohorte->nombre][$perfil->nombre] = $perfil->pivot->id;
            }
        }

        // dd($perfiles);


        // Obtiene todos los gestores pertenecientes a cohortePaisProyecto
        $users = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohorteProyectoUser = CohorteProyectoUser::where('cohorte_pais_proyecto_id', $value->id)
                ->where('rol', 'Gestor')
                ->pluck('user_id');

            foreach ($cohorteProyectoUser as $user) {
                $users[$value->id][] = $user;
            }
        }

        // dd($users);


        $actividad = null;
        $subactividad = null;
        $modulo = null;
        $submodulo = null;

        //dd($collection);

        foreach ($collection as $key => $item) {

            $cohorte_pais_proyecto_perfil_id = $perfiles[trim($item->first())][trim($item->get('cohorte'))][trim($item->get('perfil'))];
            $cohorte_pais_proyecto_id = $cohortes[trim($item->first())][trim($item->get('cohorte'))];


            // Crea las actividades (nivel 1)
            $actividad = Actividad::firstOrCreate(
                ['nombre' => $item->get('nivel_1')],
                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
            );

            $subactividad = null;
            $modulo = null;
            $submodulo = null;

            $cohorte_actividad = CohorteActividad::firstOrCreate(
                [
                    'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                    'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                    'actividad_id' => $actividad->id,
                ],
                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
            );


            // Save subactividad (nivel 2)
            if (!empty($item->get('nivel_2'))) {
                $subactividad = Subactividad::firstOrCreate(
                    ['nombre' => $item->get('nivel_2')],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                $modulo = null;
                $submodulo = null;

                $cohorte_subactividad = CohorteSubactividad::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'cohorte_actividad_id' => $cohorte_actividad->id,
                        'subactividad_id' => $subactividad->id
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );
            }


            // Save modulo (nivel 3)
            if (!empty($item->get('nivel_3'))) {
                $modulo = Modulo::firstOrCreate(
                    ['nombre' => $item->get('nivel_3')],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                $submodulo = null;

                $modulo_subactividad_submodulo = CohorteSubactividadModulo::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'cohorte_subactividad_id' => $cohorte_subactividad->id,
                        'modulo_id' => $modulo->id
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );
            }


            // Save submodulo (nivel 4)
            if (!empty($item->get('nivel_4'))) {
                $submodulo = Submodulo::firstOrCreate(
                    ['nombre' => $item->get('nivel_4')],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                ModuloSubactividadSubmodulo::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'cohorte_subactividad_modulo_id' => $modulo_subactividad_submodulo->id,
                        'submodulo_id' => $submodulo->id
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );
            }


            // Se define el tipo de la sesion por el tipo de asistencia, por defecto es cerrado (por checkbox)
            $sesion_titulo = SesionTitulo::CERRADO;
            $sesion_tipo = SesionTipo::SESION_GENERAL;
            $titulo = null;

            if (strtolower(trim($item->get('por_asistencias'))) != 'si') {
                $sesion_titulo = SesionTitulo::ABIERTO;
                $sesion_tipo = SesionTipo::HORAS_PARTICIPANTE;
            }


            $model = $submodulo ?? $modulo ?? $subactividad ?? $actividad ?? null;

            if ($model) {
                $model->tipoSesion()->firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'actividad_id' => $actividad->id ?? null,
                        'subactividad_id' => $subactividad?->id ?? null,
                        'modulo_id' => $modulo?->id ?? null,
                        'submodulo_id' => $submodulo?->id ?? null,
                        'tipo' => $sesion_tipo
                    ]
                );

                // Solo se guarda titulo para titulos cerrados
                if ($sesion_titulo == SesionTitulo::CERRADO) {
                    $titulo = Titulo::firstOrCreate(
                        ['nombre' => trim($item->get('titulo'))],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $model->tituloSesion()->firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'actividad_id' => $actividad->id ?? null,
                            'subactividad_id' => $subactividad?->id ?? null,
                            'modulo_id' => $modulo?->id ?? null,
                            'submodulo_id' => $submodulo?->id ?? null,
                            'titulo_id' => $titulo->id,
                            'titulo_abierto' => $sesion_titulo,
                        ]
                    );
                } else {
                    $months = [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Junio',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'
                    ];

                    foreach ($months as $month) {
                        $titulo = Titulo::firstOrCreate(
                            ['nombre' => trim($month)],
                            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                        );

                        $model->tituloSesion()->firstOrCreate(
                            [
                                'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                                'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                                'actividad_id' => $actividad->id ?? null,
                                'subactividad_id' => $subactividad?->id ?? null,
                                'modulo_id' => $modulo?->id ?? null,
                                'submodulo_id' => $submodulo?->id ?? null,
                                'titulo_id' => $titulo->id,
                                'titulo_abierto' => $sesion_titulo,
                            ]
                        );
                    }
                }
            }
        }


        dd('imported JLI Honduras!');
    }

    public function importSesionesJLIHN7()
    {
        //abort(403, 'Forbidden.');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filePath = public_path('estructura_de_cohortes_jli_hn_cohorte_7.xlsx');

        // Using LazyCollection for memory efficiency
        $sesiones = new SesionesImport();
        // For testing only import first sheet
        $sesiones->onlySheets('HN');

        Excel::import($sesiones, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection($sesiones, $filePath)->first()
        );
        // dd($collection);


        // Obtiene cohortePaisProyecto por Cohorte 8 y Cohorte Gestores para Guatemala
        $cohortePaisProyecto = CohortePaisProyecto::with([
            'perfilesParticipante:id,nombre',
            'paisProyecto.pais:id,nombre',
            'cohorte:id,nombre',
        ])
            ->where('pais_proyecto_id', 3)
            ->whereHas('cohorte', function ($query) {
                $query->whereIn('nombre', ['Cohorte 7']);
            })
            ->get();
        // dd($cohortePaisProyecto);

        $cohortes = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohortes[$value->paisProyecto->pais->nombre][$value->cohorte->nombre] = $value->id;
        }
        // dd($cohortes);


        // Obtiene todos las cohorte_pais_proyecto_perfil_id que tiene la cohortePaisProyecto
        $perfiles = [];

        foreach ($cohortePaisProyecto as $value) {
            foreach ($value->perfilesParticipante as $perfil) {
                $perfiles[$value->paisProyecto->pais->nombre][$value->cohorte->nombre][$perfil->nombre] = $perfil->pivot->id;
            }
        }

        // dd($perfiles);


        // Obtiene todos los gestores pertenecientes a cohortePaisProyecto
        $users = [];

        foreach ($cohortePaisProyecto as $value) {
            $cohorteProyectoUser = CohorteProyectoUser::where('cohorte_pais_proyecto_id', $value->id)
                ->where('rol', 'Gestor')
                ->pluck('user_id');

            foreach ($cohorteProyectoUser as $user) {
                $users[$value->id][] = $user;
            }
        }

        // dd($users);


        $actividad = null;
        $subactividad = null;
        $modulo = null;
        $submodulo = null;

        //dd($collection);

        foreach ($collection as $key => $item) {

            $cohorte_pais_proyecto_perfil_id = $perfiles[trim($item->first())][trim($item->get('cohorte'))][trim($item->get('perfil'))];
            $cohorte_pais_proyecto_id = $cohortes[trim($item->first())][trim($item->get('cohorte'))];


            // Crea las actividades (nivel 1)
            $actividad = Actividad::firstOrCreate(
                ['nombre' => $item->get('nivel_1')],
                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
            );

            $subactividad = null;
            $modulo = null;
            $submodulo = null;

            $cohorte_actividad = CohorteActividad::firstOrCreate(
                [
                    'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                    'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                    'actividad_id' => $actividad->id,
                ],
                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
            );


            // Save subactividad (nivel 2)
            if (!empty($item->get('nivel_2'))) {
                $subactividad = Subactividad::firstOrCreate(
                    ['nombre' => $item->get('nivel_2')],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                $modulo = null;
                $submodulo = null;

                $cohorte_subactividad = CohorteSubactividad::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'cohorte_actividad_id' => $cohorte_actividad->id,
                        'subactividad_id' => $subactividad->id
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );
            }


            // Save modulo (nivel 3)
            if (!empty($item->get('nivel_3'))) {
                $modulo = Modulo::firstOrCreate(
                    ['nombre' => $item->get('nivel_3')],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                $submodulo = null;

                $modulo_subactividad_submodulo = CohorteSubactividadModulo::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'cohorte_subactividad_id' => $cohorte_subactividad->id,
                        'modulo_id' => $modulo->id
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );
            }


            // Save submodulo (nivel 4)
            if (!empty($item->get('nivel_4'))) {
                $submodulo = Submodulo::firstOrCreate(
                    ['nombre' => $item->get('nivel_4')],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );

                ModuloSubactividadSubmodulo::firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'cohorte_subactividad_modulo_id' => $modulo_subactividad_submodulo->id,
                        'submodulo_id' => $submodulo->id
                    ],
                    ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                );
            }


            // Se define el tipo de la sesion por el tipo de asistencia, por defecto es cerrado (por checkbox)
            $sesion_titulo = SesionTitulo::CERRADO;
            $sesion_tipo = SesionTipo::SESION_GENERAL;
            $titulo = null;

            if (strtolower(trim($item->get('por_asistencias'))) != 'si') {
                $sesion_titulo = SesionTitulo::ABIERTO;
                $sesion_tipo = SesionTipo::HORAS_PARTICIPANTE;
            }


            $model = $submodulo ?? $modulo ?? $subactividad ?? $actividad ?? null;

            if ($model) {
                $model->tipoSesion()->firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                        'actividad_id' => $actividad->id ?? null,
                        'subactividad_id' => $subactividad?->id ?? null,
                        'modulo_id' => $modulo?->id ?? null,
                        'submodulo_id' => $submodulo?->id ?? null,
                        'tipo' => $sesion_tipo
                    ]
                );

                // Solo se guarda titulo para titulos cerrados
                if ($sesion_titulo == SesionTitulo::CERRADO) {
                    $titulo = Titulo::firstOrCreate(
                        ['nombre' => trim($item->get('titulo'))],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $model->tituloSesion()->firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'actividad_id' => $actividad->id ?? null,
                            'subactividad_id' => $subactividad?->id ?? null,
                            'modulo_id' => $modulo?->id ?? null,
                            'submodulo_id' => $submodulo?->id ?? null,
                            'titulo_id' => $titulo->id,
                            'titulo_abierto' => $sesion_titulo,
                        ]
                    );
                } else {
                    $titulo = Titulo::firstOrCreate(
                        ['nombre' => trim($item->get('titulo'))],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $model->tituloSesion()->firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $cohorte_pais_proyecto_perfil_id,
                            'actividad_id' => $actividad->id ?? null,
                            'subactividad_id' => $subactividad?->id ?? null,
                            'modulo_id' => $modulo?->id ?? null,
                            'submodulo_id' => $submodulo?->id ?? null,
                            'titulo_id' => $titulo->id,
                            'titulo_abierto' => $sesion_titulo,
                        ]
                    );
                }
            }
        }


        dd('imported JLI Honduras - Cohorte 7!');
    }


    public function updatepermisos()
    {
        abort(403, 'Forbidden.');

        $role = \App\Models\Role::where('name', 'MECLA')->first();
        dd($role->permissions->pluck('name'));

        // $role->revokePermissionTo('Listado participantes R4');
        // $role->givePermissionTo('Crear directorio');
        // $role->givePermissionTo('Editar directorio');
        // $role->givePermissionTo('Eliminar directorio');
        // $role->givePermissionTo('Exportar directorio');
    }

    public function updateNames()
    {
        abort(403, 'Forbidden.');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $perfiles = [
            'De 15 a 18 años' => 'Perfil A',
            'De 18 a 22 años' => 'Perfil B',
        ];

        $rangos = [
            'De 15 a 18 años' => [15, 18],
            'De 18 a 22 años' => [18, 22],
        ];

        $filePath = public_path('nombres.xlsx');

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );

        $actualizados = 0;
        foreach ($collection as $item) {

            //   dd($item);

            $perfil = trim($item['perfil']);
            $dni = trim($item['dni']);
            $primerNombre = trim($item['nombre_1']);
            $segundoNombre = trim($item['nombre_2']);

            if (empty(trim($item['nombre_4']))) {
                $tercerNombre = trim($item['nombre_3']);
            } else {
                $tercerNombre = trim($item['nombre_3']) . ' ' . trim($item['nombre_4']);
            }


            $primerApellido = trim($item['apellido_1']);
            $segundoApellido = trim($item['apellido_2']);
            $tercerApellido = trim($item['apellido_3']);

            $participante = \App\Models\Participante::where('documento_identidad', $dni)->first();

            if (!$participante) {
                echo 'Participante not found: ' . $dni;
                continue;
            }

            $participante->update([
                'primer_nombre' => $primerNombre,
                'segundo_nombre' => $segundoNombre,
                'tercer_nombre' => $tercerNombre,
                'primer_apellido' => $primerApellido,
                'segundo_apellido' => $segundoApellido,
                'tercer_apellido' => $tercerApellido,
            ]);

            $actualizados++;

            //Find cohorte_participante_proyecto
            $cohorteParticipanteProyecto = \App\Models\CohorteParticipanteProyecto::where('participante_id', $participante->id)->first();

            if ($cohorteParticipanteProyecto) {

                $perfilNombre = PerfilesParticipante::firstOrCreate(
                    ['nombre' => $perfiles[$perfil]]
                );

                $cohortePaisProyectoPerfil = \App\Models\CohortePaisProyectoPerfil::firstOrCreate(
                    ['cohorte_pais_proyecto_id' => $cohorteParticipanteProyecto->cohorte_pais_proyecto_id, 'perfil_participante_id' => $perfilNombre->id],
                    ['comentario' => $perfil, 'active_at' => now()]
                );

                $cohorteParticipanteProyecto->update([
                    'cohorte_pais_proyecto_perfil_id' => $cohortePaisProyectoPerfil->id,
                ]);

                // $rangos = [
                //     'De 15 a 18 años' => [15, 18],
                //     'De 18 a 22 años' => [18, 22],
                // ];

                \App\Models\CohortePaisProyectoRangoEdad::firstOrCreate(
                    ['cohorte_pais_proyecto_id' => $cohorteParticipanteProyecto->cohorte_pais_proyecto_id, 'edad_inicio' => $rangos[$perfil][0], 'edad_fin' => $rangos[$perfil][1]],
                    ['active_at' => now()]
                );
            }
        }

        echo "Update completed successfully: $actualizados records";
    }




    public function importarcohorte8()
    {
        abort(404);
        $filePath = public_path('COHORTE8HONDURAS.xlsx');

        \App\Models\Role::firstOrCreate(['name' => 'Registro R3']);
        \App\Models\Role::firstOrCreate(['name' => 'Validación R3']);
        \App\Models\Role::firstOrCreate(['name' => 'Validación R4']);

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );

        $data = [];
        $i = 1;
        foreach ($collection as $item) {
            $accion = strtolower($item["accion"]);
            $socio = $item["socio_id"];
            $user = $item["usuario_sin_formula"];
            $usuarioRol = strtolower($item["usuario_rol"]);
            $socioNombre = $item["socio_nombre"];
            $passExcel = $item["password"];

            $rol = "Gestor";
            if ($usuarioRol == "coordinador") {
                $rol = "Coordinador";
            } elseif ($usuarioRol == "registro r3") {
                $rol = "Registro R3";
            } elseif ($usuarioRol == "validación r3") {
                $rol = "Validación R3";
            } elseif ($usuarioRol == "validación r4") {
                $rol = "Validación R4";
            } elseif ($usuarioRol == "staff") {
                $rol = "Staff";
            } elseif ($usuarioRol == "mecla") {
                $rol = "MECLA";
            }

            //dd($user);

            if ($accion == "crear") {

                // 1. CREAR CUENTA DE USUARIO
                $password = Str::random(10);
                $usuario = \App\Models\User::where('username', $user)->first();
                if (!$usuario) {
                    $usuario = \App\Models\User::create([
                        'username' => $user,
                        'name' => $user,
                        'email' => $user . '@glasswing.org',
                        'email_verified_at' => now(),
                        'password' => \Illuminate\Support\Facades\Hash::make($password),
                        'socio_implementador_id' => $socio,
                        'remember_token' => Str::random(10),
                    ]);

                    $usuario->forceFill([
                        'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                        'remember_token' => Str::random(10),
                    ])->save();

                    // 2. ASIGNAR ROL
                    $usuario->assignRole($rol);

                    // 3. ASIGNAR SOCIO
                    $usuario->sociosImplementadores()->sync($socio);

                    // 4. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
                    $usuario->cohorte()->syncWithoutDetaching([10 => ['rol' => $usuarioRol, 'active_at' => now()]]);
                    $usuario->cohorte()->syncWithoutDetaching([11 => ['rol' => $usuarioRol, 'active_at' => now()]]);

                    $data[] = [
                        'socio'    => $socioNombre,
                        'socio_id' => $socio,
                        'pais'     => "Honduras",
                        'usuario'  => $user,
                        'password' => $password,
                        'rol'      => $rol
                    ];
                } else {
                    echo "Usuario ya existe: $usuario en la posicion $i";
                    echo "<br/>";
                }
            } else {
                // 1. ENCONTRAR USUARIO
                $usuario = \App\Models\User::where('username', $user)->first();
                if ($usuario) {
                    $usuario->cohorte()->syncWithoutDetaching([10 => ['rol' => $usuarioRol, 'active_at' => now()]]);
                    $usuario->cohorte()->syncWithoutDetaching([11 => ['rol' => $usuarioRol, 'active_at' => now()]]);

                    $data[] = [
                        'socio'    => $socioNombre,
                        'socio_id' => $socio,
                        'pais'     => "Honduras",
                        'usuario'  => $user,
                        'password' => $passExcel,
                        'rol'      => $rol
                    ];
                } else {
                    echo "Usuario no encontrado: $usuario en la posicion $i";
                    echo "<br/>";
                }
            }

            $i++;
        }






        // Save $data array in CSV
        $csvFileName = public_path('datacohorte8honduras.csv');
        $csvFile = fopen($csvFileName, 'w');

        // Add headers to CSV
        fputcsv($csvFile, ['Socio', 'Pais', 'Usuario', 'Password', 'Rol']);

        // Add data rows to CSV
        foreach ($data as $row) {
            fputcsv($csvFile, $row);
        }

        fclose($csvFile);

        // Print $data array on the screen
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }


    public function importarcohorte8array()
    {
        abort(404);
        $filePath = public_path('datacohorte8honduras.csv');

        \App\Models\Role::firstOrCreate(['name' => 'Registro R3']);
        \App\Models\Role::firstOrCreate(['name' => 'Validación R3']);
        \App\Models\Role::firstOrCreate(['name' => 'Validación R4']);

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );

        foreach ($collection as $item) {

            $usuario = User::where('username', $item['usuario'])->first();
            if ($usuario) {
                $usuario->cohorte()->syncWithoutDetaching([10 => ['rol' => $item['rol'], 'active_at' => now()]]);
                $usuario->cohorte()->syncWithoutDetaching([11 => ['rol' => $item['rol'], 'active_at' => now()]]);
            } else {
                // 1. CREAR CUENTA DE USUARIO
                $usuario = \App\Models\User::create([
                    'username' => $item['usuario'],
                    'name' => $item['usuario'],
                    'email' => $item['usuario'] . '@glasswing.org',
                    'email_verified_at' => now(),
                    'password' => $item["password"],
                    'socio_implementador_id' => $item['socio_id'],
                    'remember_token' => Str::random(10),
                ]);

                $usuario->forceFill([
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ])->save();

                // 2. ASIGNAR ROL
                $usuario->assignRole($item['rol']);

                // 3. ASIGNAR SOCIO
                $usuario->sociosImplementadores()->sync($item['socio_id']);

                // 4. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
                $usuario->cohorte()->syncWithoutDetaching([10 => ['rol' => $item['rol'], 'active_at' => now()]]);
                $usuario->cohorte()->syncWithoutDetaching([11 => ['rol' => $item['rol'], 'active_at' => now()]]);
            }
        }
    }

    public function importarcohorte8guatemala()
    {
        abort(404);

        $filePath = public_path('COHORTE8GUATEMALA.xlsx');

        \App\Models\Role::firstOrCreate(['name' => 'Registro R3']);
        \App\Models\Role::firstOrCreate(['name' => 'Validación R3']);
        \App\Models\Role::firstOrCreate(['name' => 'Validación R4']);

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );

        $data = [];
        $i = 1;
        foreach ($collection as $item) {
            $accion = strtolower($item["accion"]);
            $socio = $item["socio_id"];
            $user = $item["usuario_sin_formula"];
            $usuarioRol = strtolower($item["usuario_rol"]);
            $socioNombre = $item["socio_nombre"];
            $passExcel = $item["password"];

            $rol = "Gestor";
            if ($usuarioRol == "coordinador") {
                $rol = "Coordinador";
            } elseif ($usuarioRol == "registro r3") {
                $rol = "Registro R3";
            } elseif ($usuarioRol == "validación r3") {
                $rol = "Validación R3";
            } elseif ($usuarioRol == "validación r4") {
                $rol = "Validación R4";
            } elseif ($usuarioRol == "staff") {
                $rol = "Staff";
            } elseif ($usuarioRol == "mecla") {
                $rol = "MECLA";
            }

            //dd($user);

            if ($accion == "crear") {

                // 1. CREAR CUENTA DE USUARIO
                $password = Str::random(10);
                $usuario = \App\Models\User::where('username', $user)->first();
                if (!$usuario) {
                    $usuario = \App\Models\User::create([
                        'username' => $user,
                        'name' => $user,
                        'email' => $user . '@glasswing.org',
                        'email_verified_at' => now(),
                        'password' => \Illuminate\Support\Facades\Hash::make($password),
                        'socio_implementador_id' => $socio,
                        'remember_token' => Str::random(10),
                    ]);

                    $usuario->forceFill([
                        'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                        'remember_token' => Str::random(10),
                    ])->save();

                    // 2. ASIGNAR ROL
                    $usuario->assignRole($rol);

                    // 3. ASIGNAR SOCIO
                    $usuario->sociosImplementadores()->sync($socio);

                    // 4. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
                    $usuario->cohorte()->syncWithoutDetaching([10 => ['rol' => $usuarioRol, 'active_at' => now()]]);
                    $usuario->cohorte()->syncWithoutDetaching([11 => ['rol' => $usuarioRol, 'active_at' => now()]]);

                    $data[] = [
                        'socio'    => $socioNombre,
                        'socio_id' => $socio,
                        'pais'     => "Honduras",
                        'usuario'  => $user,
                        'password' => $password,
                        'rol'      => $rol
                    ];
                } else {
                    echo "Usuario ya existe: $usuario en la posicion $i";
                    echo "<br/>";
                }
            } else {
                // 1. ENCONTRAR USUARIO
                $usuario = \App\Models\User::where('username', $user)->first();
                if ($usuario) {
                    $usuario->cohorte()->syncWithoutDetaching([10 => ['rol' => $usuarioRol, 'active_at' => now()]]);
                    $usuario->cohorte()->syncWithoutDetaching([11 => ['rol' => $usuarioRol, 'active_at' => now()]]);

                    $data[] = [
                        'socio'    => $socioNombre,
                        'socio_id' => $socio,
                        'pais'     => "Honduras",
                        'usuario'  => $user,
                        'password' => $passExcel,
                        'rol'      => $rol
                    ];
                } else {
                    echo "Usuario no encontrado: $usuario en la posicion $i";
                    echo "<br/>";
                }
            }

            $i++;
        }






        // Save $data array in CSV
        $csvFileName = public_path('datacohorte8guatemala.csv');
        $csvFile = fopen($csvFileName, 'w');

        // Add headers to CSV
        fputcsv($csvFile, ['Socio', 'Pais', 'Usuario', 'Password', 'Rol']);

        // Add data rows to CSV
        foreach ($data as $row) {
            fputcsv($csvFile, $row);
        }

        fclose($csvFile);

        // Print $data array on the screen
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function importarcohorte8guatemalaarray()
    {

        abort(404);

        $filePath = public_path('datacohorte8guatemala.csv');

        \App\Models\Role::firstOrCreate(['name' => 'Registro R3']);
        \App\Models\Role::firstOrCreate(['name' => 'Validación R3']);
        \App\Models\Role::firstOrCreate(['name' => 'Validación R4']);

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );

        //dd($collection);
        foreach ($collection as $item) {
            $usuario = User::where('username', $item['usuario'])->first();
            if ($usuario) {
                $usuario->cohorte()->syncWithoutDetaching([10 => ['rol' => $item['rol'], 'active_at' => now()]]);
                $usuario->cohorte()->syncWithoutDetaching([11 => ['rol' => $item['rol'], 'active_at' => now()]]);
            } else {
                // 1. CREAR CUENTA DE USUARIO
                $usuario = \App\Models\User::create([
                    'username' => $item['usuario'],
                    'name' => $item['usuario'],
                    'email' => $item['usuario'] . '@glasswing.org',
                    'email_verified_at' => now(),
                    'password' => $item["password"],
                    'socio_implementador_id' => $item['socio_id'],
                    'remember_token' => Str::random(10),
                ]);

                $usuario->forceFill([
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ])->save();

                // 2. ASIGNAR ROL
                $usuario->assignRole($item['rol']);

                // 3. ASIGNAR SOCIO
                $usuario->sociosImplementadores()->sync($item['socio_id']);

                // 4. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
                $usuario->cohorte()->syncWithoutDetaching([10 => ['rol' => $item['rol'], 'active_at' => now()]]);
                $usuario->cohorte()->syncWithoutDetaching([11 => ['rol' => $item['rol'], 'active_at' => now()]]);
            }
        }
    }


    private function coordinadorgestorguatemala()
    {

        abort(404);

        $validadorR4 = \App\Models\User::where('username', 'V4.GT')->first();
        $validadorR4Id = CohorteProyectoUser::where('user_id', $validadorR4->id)->first()->id;

        // socio id 4
        $usernames = [
            'G.CO8.ACPDRO.1',
            'G.CO8.ACPDRO.2',
            'G.CO8.ACPDRO.3',
            'G.CO8.ACPDRO.4',
            'G.CO8.ACPDRO.5',
            'G.CO8.ACPDRO.6',
            'G.CO8.ACPDRO.7',
            'G.CO8.ACPDRO.8',
            'G.CO8.ACPDRO.9',
            'G.CO8.ACPDRO.10',
            'G.CO8.ACPDRO.11',
        ];

        $users = \App\Models\User::whereIn('username', $usernames)->get();
        $userIds = $users->pluck('id')->toArray();

        $gestores = CohorteProyectoUser::whereIn('user_id', $userIds)->get();
        $gestoresIds = $gestores->pluck('id')->toArray();


        $userCoordinador = \App\Models\User::where('username', 'C.ACPDRO')->first();
        $coordinadorId = CohorteProyectoUser::where('user_id', $userCoordinador->id)->first()->id;

        foreach ($gestoresIds as $gestor_id) {
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 8,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 9,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 8,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 9,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
        }


        // socio id 6
        $usernames = [
            'G.CO8.TN.1',
            'G.CO8.TN.2',
            'G.CO8.TN.3',
            'G.CO8.TN.4',
            'G.CO8.TN.5',
            'G.CO8.TN.6',
            'G.CO8.TN.7',
        ];

        $users = \App\Models\User::whereIn('username', $usernames)->get();
        $userIds = $users->pluck('id')->toArray();

        $gestores = CohorteProyectoUser::whereIn('user_id', $userIds)->get();
        $gestoresIds = $gestores->pluck('id')->toArray();


        $userCoordinador = \App\Models\User::where('username', 'C.TN')->first();
        $coordinadorId = CohorteProyectoUser::where('user_id', $userCoordinador->id)->first()->id;

        foreach ($gestoresIds as $gestor_id) {
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 8,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 9,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 8,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 9,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
        }

        // REGISTRO Y VALIDACION R3
        $usernames = [
            'R3.ACPDRO',
            'R3.CEIP',
            'R3.TN',
        ];

        $users = \App\Models\User::whereIn('username', $usernames)->get();
        $userIds = $users->pluck('id')->toArray();

        $gestores = CohorteProyectoUser::whereIn('user_id', $userIds)->get();
        $gestoresIds = $gestores->pluck('id')->toArray();

        $userCoordinador = \App\Models\User::where('username', 'V3.GT')->first();
        $coordinadorId = CohorteProyectoUser::where('user_id', $userCoordinador->id)->first()->id;

        foreach ($gestoresIds as $gestor_id) {
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 8,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 9,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
        }
    }

    private function coordinadorgestorhonduras()
    {

        abort(404);

        $validadorR4 = \App\Models\User::where('username', 'V4.HN')->first();
        $validadorR4Id = CohorteProyectoUser::where('user_id', $validadorR4->id)->first()->id;

        // socio id 8
        $usernames = [
            'G.CO8.CRH.1',
            'G.CO8.CRH.2',
            'G.CO8.CRH.3',
            'G.CO8.CRH.4',
            'G.CO8.CRH.5',
            'G.CO8.CRH.6',
            'G.CO8.CRH.7',
            'G.CO8.CRH.8',
            'G.CO8.CRH.9',
            'G.CO8.CRH.10',
            'G.CO8.CRH.11',
            'G.CO8.CRH.12',
        ];

        $users = \App\Models\User::whereIn('username', $usernames)->get();
        $userIds = $users->pluck('id')->toArray();

        $gestores = CohorteProyectoUser::whereIn('user_id', $userIds)->get();
        $gestoresIds = $gestores->pluck('id')->toArray();

        $userCoordinador = \App\Models\User::where('username', 'C.CRH')->first();
        $coordinadorId = CohorteProyectoUser::where('user_id', $userCoordinador->id)->first()->id;

        foreach ($gestoresIds as $gestor_id) {
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 10,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 11,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 10,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 11,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
        }

        // Socio id 9
        $usernames = [
            'G.CO8.AFNV.1',
            'G.CO8.AFNV.2',
            'G.CO8.AFNV.3',
            'G.CO8.AFNV.4',
            'G.CO8.AFNV.5',
            'G.CO8.AFNV.6',
            'G.CO8.AFNV.7',
            'G.CO8.AFNV.8',
            'G.CO8.AFNV.9',
            'G.CO8.AFNV.10',
            'G.CO8.AFNV.11',
            'G.CO8.AFNV.12',
        ];

        $users = \App\Models\User::whereIn('username', $usernames)->get();
        $userIds = $users->pluck('id')->toArray();

        $gestores = CohorteProyectoUser::whereIn('user_id', $userIds)->get();
        $gestoresIds = $gestores->pluck('id')->toArray();

        $userCoordinador = \App\Models\User::where('username', 'C.AFNV')->first();
        $coordinadorId = CohorteProyectoUser::where('user_id', $userCoordinador->id)->first()->id;

        foreach ($gestoresIds as $gestor_id) {
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 10,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 11,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 10,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 11,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
        }

        // Socio id 10
        $usernames = [
            'G.CO8.CASM.1',
            'G.CO8.CASM.2',
            'G.CO8.CASM.3',
            'G.CO8.CASM.4',
            'G.CO8.CASM.5',
            'G.CO8.CASM.6',
            'G.CO8.CASM.7',
            'G.CO8.CASM.8',
            'G.CO8.CASM.9',
            'G.CO8.CASM.10',
            'G.CO8.CASM.11',
            'G.CO8.CASM.12',
        ];

        $users = \App\Models\User::whereIn('username', $usernames)->get();
        $userIds = $users->pluck('id')->toArray();

        $gestores = CohorteProyectoUser::whereIn('user_id', $userIds)->get();
        $gestoresIds = $gestores->pluck('id')->toArray();

        $userCoordinador = \App\Models\User::where('username', 'C.CASM')->first();
        $coordinadorId = CohorteProyectoUser::where('user_id', $userCoordinador->id)->first()->id;

        foreach ($gestoresIds as $gestor_id) {
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 10,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 11,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 10,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 11,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
        }

        // Socio id 11
        $usernames = [
            'G.CO8.FNPDH.1',
            'G.CO8.FNPDH.2',
            'G.CO8.FNPDH.3',
            'G.CO8.FNPDH.4',
            'G.CO8.FNPDH.5',
            'G.CO8.FNPDH.6',
            'G.CO8.FNPDH.7',
            'G.CO8.FNPDH.8',
            'G.CO8.FNPDH.9',
            'G.CO8.FNPDH.10',
            'G.CO8.FNPDH.11',
            'G.CO8.FNPDH.12',
            'G.CO8.FNPDH.13',
            'G.CO8.FNPDH.14',
            'G.CO8.FNPDH.15',
            'G.CO8.FNPDH.16',
            'G.CO8.FNPDH.17',
            'G.CO8.FNPDH.18',
        ];

        $users = \App\Models\User::whereIn('username', $usernames)->get();
        $userIds = $users->pluck('id')->toArray();

        $gestores = CohorteProyectoUser::whereIn('user_id', $userIds)->get();
        $gestoresIds = $gestores->pluck('id')->toArray();

        $userCoordinador = \App\Models\User::where('username', 'C.FNPDH')->first();
        $coordinadorId = CohorteProyectoUser::where('user_id', $userCoordinador->id)->first()->id;

        foreach ($gestoresIds as $gestor_id) {
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 10,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 11,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 10,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);

            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 11,
                'coordinador_id' => $validadorR4Id,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
        }

        // REGISTRO Y VALIDACION R3
        $usernames = [
            'R3.CRH',
            'R3.AFNV',
            'R3.CASM',
            'R3.FNPDH',
        ];

        $users = \App\Models\User::whereIn('username', $usernames)->get();
        $userIds = $users->pluck('id')->toArray();

        $gestores = CohorteProyectoUser::whereIn('user_id', $userIds)->get();
        $gestoresIds = $gestores->pluck('id')->toArray();

        $userCoordinador = \App\Models\User::where('username', 'V3.HN')->first();
        $coordinadorId = CohorteProyectoUser::where('user_id', $userCoordinador->id)->first()->id;

        foreach ($gestoresIds as $gestor_id) {
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 10,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
            \App\Models\CoordinadorGestor::create([
                'cohorte_pais_proyecto_id' => 11,
                'coordinador_id' => $coordinadorId,
                'gestor_id' => $gestor_id,
                'active_at' => now(),
            ]);
        }
    }

    public function runasociaciones()
    {
        abort(404);

        $this->coordinadorgestorguatemala();

        $this->coordinadorgestorhonduras();
    }




    public function repararguate()
    {
        abort(404);

        $usernames = [
            'G.CO8.ACPDRO.1',
            'G.CO8.ACPDRO.2',
            'G.CO8.ACPDRO.3',
            'G.CO8.ACPDRO.4',
            'G.CO8.ACPDRO.5',
            'G.CO8.ACPDRO.6',
            'G.CO8.ACPDRO.7',
            'G.CO8.ACPDRO.8',
            'G.CO8.ACPDRO.9',
            'G.CO8.ACPDRO.10',
            'G.CO8.ACPDRO.11',
            'G.CO8.TN.1',
            'G.CO8.TN.2',
            'G.CO8.TN.3',
            'G.CO8.TN.4',
            'G.CO8.TN.5',
            'G.CO8.TN.6',
            'G.CO8.TN.7',
            'C.ACPDRO',
            'C.TN',
            'R3.ACPDRO',
            'R3.CEIP',
            'R3.TN',
            'R3.ACBF',
            'V3.GT',
            'V4.GT',
            'ME.ACPDRO',
            'ME.CEIP',
            'ME.TN',
            'ME.ACBF',
            'MECLA.GT',
        ];

        $users = \App\Models\User::whereIn('username', $usernames)->get();
        $userIds = $users->pluck('id')->toArray();

        foreach ($userIds as $key => $value) {
            CohorteProyectoUser::where('user_id', $value)->where('cohorte_pais_proyecto_id', 10)
                ->update(['cohorte_pais_proyecto_id' => 8]);

            CohorteProyectoUser::where('user_id', $value)->where('cohorte_pais_proyecto_id', 11)
                ->update(['cohorte_pais_proyecto_id' => 9]);
        }
    }

    public function importarjli()
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');


        $filePath = public_path('JLI14.xlsx');


        $lookupgrados = [
            "4 Bachillerato /Diversficado (13°)" => 13,
            "3 Bachillerato /Diversificado (12°)" => 12,
            "2 Bachillerato /Diversificado (11°)" => 11,
            "1 Bachillerato /Diversificado (10°)" => 10,
            "3 Bachillerato Técnico" => 15,
            "2  Bachillerato Técnico" => 14,
            "1  Bachillerato Técnico" => 13,
            "3° Basica(9°)" => 9,
            "2° Basica(8°)" => 8,
            "1° Basica(7°)" => 7,
            "6° Primaria" => 6,
            "5° Primaria" => 5,
            "4°  Primaria" => 4,
            "3° Primaria" => 3,
            "2° Primaria" => 2,
            "1° Primaria" => 1,
            "No estudia actualmente" => 0,
        ];

        $lookupestados = [
            "Activo"    => 1,
            "Desertado" => 5,
            "Pausa"     => 3,
            "Reingreso" => 4,
        ];

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );

        $duplicados = ['0801200517155', '0801200417124', '0501200511249', '3159050500804'];
        $aux = [];
        $i = 0;
        foreach ($collection as $item) {

            $documentoIdentidad = str_replace('-', '', trim($item['dni']));

            if (!$item["id"]) {
                continue;
            }

            if (in_array($documentoIdentidad, $duplicados)) {
                if (in_array($documentoIdentidad, $aux)) {
                    continue;
                } else {
                    array_push($aux, $documentoIdentidad);
                }
            }



            $recordId = $item["id"];
            $cohorte = 1;
            if ($item["cohorte"] == "Cohorte 2") {
                $cohorte = 2;
            } elseif ($item["cohorte"] == "Cohorte 3") {
                $cohorte = 3;
            } elseif ($item["cohorte"] == "Cohorte 4") {
                $cohorte = 4;
            }

            $paisId             = ($item["pais"] == "Honduras") ? 3 : 1;

            $primer_nombre      = $item['nombre_1'];
            $segundo_nombre     = $item['nombre_2'];
            $tercer_nombre      = $item['nombre_3'];
            $primer_apellido    = $item['apellido_1'];
            $segundo_apellido   = $item['apellido_2'];
            $tercer_apellido    = $item['apellido_3'];
            $sexo               = trim($item['sexo']) == 'Mujer' ? 1 : 2;
            $fechaNacimiento    = trim($item['fechanac']);
            $socio              = trim($item['sede']);
            $grado              = trim($item['grado']);
            $estadoGlobal       = trim($item['estadoglobal']);
            $fechaEstado        = trim($item['date_state']);
            $causa              = trim($item['causa']);
            $categoria          = trim($item['categoria_nombre']);
            $comentario         = trim($item['observations']);


            if (!empty($fechaNacimiento)) {
                $prefecha = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaNacimiento));
                $fechaNacimiento = $prefecha->format('Y-m-d');
            }


            // 1 OBTENER EL PAIS PROYECTO
            $paisProyecto = PaisProyecto::where('pais_id', $paisId)->where('proyecto_id', 2)->first();

            // 2. OBTENER EL PAIS PROYECTO COHORTE O CREARLO

            $cohortePaisProyecto = \App\Models\CohortePaisProyecto::firstOrCreate(
                ['cohorte_id' => $cohorte, 'pais_proyecto_id' => $paisProyecto->id],
                [
                    'active_at'      => now(),
                    'titulo_abierto' => false,
                    'fecha_inicio'   => now(),
                    'fecha_fin'      => now()->addMonths(9),
                ]
            );

            //3. CREAR SOCIO IMPLEMENTADOR
            $socioImplementador = \App\Models\SocioImplementador::firstOrCreate(
                ['nombre' => $socio],
                [
                    'active_at' => now(),
                    'pais_id' => $paisId,
                ]
            );


            // 1. Socios: Tomar las iniciales de las palabras que tengan más de 4 letras
            $socioClean = trim(substr($socio, 0, strpos($socio, "(") ?: strlen($socio)));
            $socioInitials = '';
            $words = explode(' ', $socioClean);
            foreach ($words as $word) {
                if (strlen($word) >= 4) {
                    $socioInitials .= strtoupper($word[0]);
                }
            }

            $autoUser = "jli14" . $socioInitials;

            $usuario = \App\Models\User::where('username', $autoUser)->first();
            if (!$usuario) {
                $usuario = \App\Models\User::create([
                    'username' => $autoUser,
                    'name' => $autoUser,
                    'email' => $autoUser . '@glasswing.org',
                    'email_verified_at' => now(),
                    'password' => \Illuminate\Support\Facades\Hash::make(Str::random(10)),
                    'socio_implementador_id' => $socioImplementador->id,
                    'remember_token' => Str::random(10),
                ]);

                $usuario->forceFill([
                    'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                    'remember_token' => Str::random(10),
                ])->save();

                $usuario->assignRole('gestor');

                $usuario->sociosImplementadores()->sync($socioImplementador->id);

                // 5. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
                $usuario->cohorte()->sync([$cohortePaisProyecto->id => ['rol' => 'gestor', 'active_at' => now()]]);
            }




            //6. CREAR PARTICIPANTE

            $datoGrado = null;
            if (!empty($grado) && isset($lookupgrados[$grado]) && $lookupgrados[$grado] != 0) {
                $datoGrado = $lookupgrados[$grado];
            }

            $participante = \App\Models\Participante::create([
                'documento_identidad' => $documentoIdentidad,
                'primer_nombre'       => $primer_nombre,
                'segundo_nombre'      => $segundo_nombre,
                'tercer_nombre'       => $tercer_nombre,
                'primer_apellido'     => $primer_apellido,
                'segundo_apellido'    => $segundo_apellido,
                'tercer_apellido'     => $tercer_apellido,
                'sexo'                => $sexo,
                'fecha_nacimiento'    => !empty($fechaNacimiento) ? $fechaNacimiento : NULL,
                'nivel_academico_id'  => $datoGrado,
                'estudia_actualmente' => !empty($grado) ? 1 : 0,
                // 'estado_global'       => $estadoGlobal,
                // 'fecha_estado'        => $fechaEstado,
                'gestor_id'  => $usuario->id,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => $usuario->id,
                'updated_by' => $usuario->id,
                //'active_at'  => now(),
            ]);

            $participante->estados_registros()->sync(4, ['comentario' => 'proceso automático de importación JLI 1-4']);

            //7. ASIGNAR PARTICIPANTE A LA COHORTE-PAIS-PROECTO
            $cohorteParticipanteProyecto = \App\Models\CohorteParticipanteProyecto::create([
                'participante_id'            => $participante->id,
                'cohorte_pais_proyecto_id'   => $cohortePaisProyecto->id,
                'created_at'                 => now(),
                'created_by'                 => $usuario->id,
                'active_at'                  => now(),
            ]);

            if (trim($item["grupo"]) != "") {

                $grupoParts = preg_split('/[_ ]/', trim($item["grupo"]));
                $grupo = $grupoParts[0];

                //8. CREAR PARTICIPANTE GRUPO
                $grupo = GrupoParticipante::create([
                    'cohorte_participante_proyecto_id' => $cohorteParticipanteProyecto->id,
                    'grupo_id'                         => $grupo,
                    'user_id'                          => $usuario->id,
                    'created_at'                       => now(),
                    'created_by'                       => $usuario->id,
                    'active_at'                        => now(),
                ]);
            }


            //9. CREAR ESTADO PARTICIPANTE

            // categoria razones:
            // 1: Razón de Desertado, 2: Razón de Pausa, 3: Razón de Reingreso

            $tipo = 0;
            if (strtolower($estadoGlobal) == "desertado") {
                $tipo = 1;
            } elseif (strtolower($estadoGlobal) == "pausa") {
                $tipo = 2;
            } elseif (strtolower($estadoGlobal) == "reingreso") {
                $tipo = 3;
            }


            if (!empty($categoria) && !empty($causa)) {
                $categoriaRazon = \App\Models\CategoriaRazon::firstOrCreate(
                    ['nombre' => $categoria, 'tipo' => $tipo],
                    ['created_at' => now(), 'created_by' => $usuario->id, 'active_at' => now()]
                );

                $razon = \App\Models\Razon::firstOrCreate(
                    ['nombre' => $causa, 'categoria_razon_id' => $categoriaRazon->id],
                    ['created_at' => now(), 'created_by' => $usuario->id, 'active_at' => now()]
                );
            }

            if (!empty($fechaEstado)) {
                $prefecha = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaEstado));
                $fechaEstado = $prefecha->format('Y-m-d H:i:s');
            }

            EstadoParticipante::create([
                'grupo_participante_id' => $grupo->id,
                'estado_id'             => isset($lookupestados[$estadoGlobal]) ? $lookupestados[$estadoGlobal] : 1,
                'fecha'                 => !empty($fechaEstado) ? $fechaEstado : NULL,
                'razon_id'              => !empty($categoria) && !empty($causa) ? $razon->id : null,
                'comentario'            => $comentario,
                'created_at'            => now(),
                'created_by'            => $usuario->id,
                'active_at'             => now(),
            ]);

            $i++;
        }

        echo "TOTAL IMPORTADOS : " . $i;
    }


    public function importarmao()
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $lookupgrados = [
            "4 Bachillerato /Diversficado (13°)" => 13,
            "3 Bachillerato /Diversificado (12°)" => 12,
            "2 Bachillerato /Diversificado (11°)" => 11,
            "1 Bachillerato /Diversificado (10°)" => 10,
            "3 Bachillerato Técnico" => 15,
            "2  Bachillerato Técnico" => 14,
            "2 Bachillerato Técnico" => 14,
            "1  Bachillerato Técnico" => 13,
            "1 Bachillerato Técnico" => 13,
            "3° Basica(9°)" => 9,
            "2° Basica(8°)" => 8,
            "1° Basica(7°)" => 7,
            "6° Primaria" => 6,
            "5° Primaria" => 5,
            "4°  Primaria" => 4,
            "4° Primaria" => 4,
            "3° Primaria" => 3,
            "2° Primaria" => 2,
            "1° Primaria" => 1,
            "No estudia actualmente" => 0,
        ];

        $lookupestados = [
            "Activo"    => 1,
            "Desertado" => 5,
            "Pausa"     => 3,
            "Reingreso" => 4,
        ];

        $filePath = public_path('MAO.xlsx');

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );


        $paisId = 1;
        $cohortePaisProyecto = 14;
        $socio = 1;

        $i = 0;
        foreach ($collection as $item) {
            $itemId           = $item["id"];
            $grupo            = $item["grupo"];
            $perfil           = $item["perfil"];
            $dni              = str_replace('-', '', trim($item['dni']));
            $primer_nombre    = $item["primer_nombre"];
            $segundo_nombre   = $item["segundo_nombre"];
            $tercer_nombre    = $item["tercer_nombre"];
            $primer_apellido  = $item["primer_apelllido"];
            $segundo_apellido = $item["segundo_apellido"];
            $tercer_apellido  = $item["tercer_apellido"];
            $sexo             = strtolower($item["sexo"]) == "mujer" ? 1 : 2;
            $fechaNacimiento  = $item["fecha_nacimiento"];
            $grado            = $item["grado"];
            $estadoGlobal     = $item["estado"];
            $fechaEstado      = $item["date_state"];
            $causa            = $item["causa"];
            $departamento     = $item["departamento"];
            $municipio        = $item["ciudad"];
            $direccion        = $item["direccion"];
            $casa             = $item["casa"];
            $apartamento      = $item["apartamento"];
            $zona             = $item["zona"];
            $colonia          = $item["colonia"];

            if (!$item["id"]) {
                continue;
            }

            if (!empty($fechaNacimiento)) {
                $prefecha = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaNacimiento));
                $fechaNacimiento = $prefecha->format('Y-m-d');
            }

            //crear usuario
            $autoUser = "jcpmaoglasswing";
            $usuario = User::where('username', $autoUser)->first();
            if (!$usuario) {
                $usuario = \App\Models\User::create([
                    'username' => $autoUser,
                    'name' => $autoUser,
                    'email' => $autoUser . '@glasswing.org',
                    'email_verified_at' => now(),
                    'password' => \Illuminate\Support\Facades\Hash::make(Str::random(10)),
                    'socio_implementador_id' => $socio,
                    'remember_token' => Str::random(10),
                ]);

                $usuario->forceFill([
                    'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                    'remember_token' => Str::random(10),
                ])->save();

                $usuario->assignRole('gestor');

                $usuario->sociosImplementadores()->sync($socio);

                // 5. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
                $usuario->cohorte()->sync([$cohortePaisProyecto => ['rol' => 'gestor', 'active_at' => now()]]);
            }


            $datoGrado = null;
            if (!empty($grado) && isset($lookupgrados[$grado]) && $lookupgrados[$grado] != 0) {
                $datoGrado = $lookupgrados[$grado];
            }

            $participante = \App\Models\Participante::create([
                'documento_identidad' => $dni,
                'primer_nombre'       => $primer_nombre,
                'segundo_nombre'      => $segundo_nombre,
                'tercer_nombre'       => $tercer_nombre,
                'primer_apellido'     => $primer_apellido,
                'segundo_apellido'    => $segundo_apellido,
                'tercer_apellido'     => $tercer_apellido,
                'sexo'                => $sexo,
                'fecha_nacimiento'    => !empty($fechaNacimiento) ? $fechaNacimiento : NULL,
                'nivel_academico_id'  => $datoGrado,
                'estudia_actualmente' => !empty($grado) ? 1 : 0,
                // 'estado_global'       => $estadoGlobal,
                // 'fecha_estado'        => $fechaEstado,
                'gestor_id'  => $usuario->id,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => $usuario->id,
                'updated_by' => $usuario->id,
                //'active_at'  => now(),
            ]);

            $participante->estados_registros()->sync(4, ['comentario' => 'proceso automático de importación JCP MAO COHORTE 1']);

            $depto = Departamento::where('nombre', $departamento)->where('pais_id', 1)->first();
            if ($depto) {
                $muni = Ciudad::where('nombre', $municipio)->where('departamento_id', $depto->id)->first();
                if ($muni) {
                    $participante->direccionGuatemala()->create([
                        // 'departamento' => $depto->id,
                        'ciudad_id' => $muni->id,
                        'direccion' => $direccion,
                        'casa' => $casa,
                        'apartamento' => $apartamento,
                        'zona' => $zona,
                        'colonia' => $colonia,
                        'created_at' => now(),
                        'created_by' => $usuario->id,
                        // 'active_at' => now(),
                    ]);
                }
            }

            //7. ASIGNAR PARTICIPANTE A LA COHORTE-PAIS-PROECTO
            $cohorteParticipanteProyecto = \App\Models\CohorteParticipanteProyecto::create([
                'participante_id'            => $participante->id,
                'cohorte_pais_proyecto_id'   => $cohortePaisProyecto,
                'created_at'                 => now(),
                'created_by'                 => $usuario->id,
                'active_at'                  => now(),
            ]);

            if (trim($item["grupo"]) != "") {
                //8. CREAR PARTICIPANTE GRUPO
                $grupo = GrupoParticipante::create([
                    'cohorte_participante_proyecto_id' => $cohorteParticipanteProyecto->id,
                    'grupo_id'                         => $grupo,
                    'user_id'                          => $usuario->id,
                    'created_at'                       => now(),
                    'created_by'                       => $usuario->id,
                    'active_at'                        => now(),
                ]);



                //9. CREAR ESTADO PARTICIPANTE

                // categoria razones:
                // 1: Razón de Desertado, 2: Razón de Pausa, 3: Razón de Reingreso

                $tipo = 0;
                if (strtolower($estadoGlobal) == "desertado") {
                    $tipo = 1;
                } elseif (strtolower($estadoGlobal) == "pausa") {
                    $tipo = 2;
                } elseif (strtolower($estadoGlobal) == "reingreso") {
                    $tipo = 3;
                }


                // if (!empty($categoria) && !empty($causa)) {
                //     $categoriaRazon = \App\Models\CategoriaRazon::firstOrCreate(
                //         ['nombre' => $categoria, 'tipo' => $tipo],
                //         ['created_at' => now(), 'created_by' => $usuario->id, 'active_at' => now()]
                //     );

                //     $razon = \App\Models\Razon::firstOrCreate(
                //         ['nombre' => $causa, 'categoria_razon_id' => $categoriaRazon->id],
                //         ['created_at' => now(), 'created_by' => $usuario->id, 'active_at' => now()]
                //     );
                // }


                if (!empty($fechaEstado)) {
                    $prefecha = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaEstado));
                    $fechaEstado = $prefecha->format('Y-m-d H:i:s');
                }

                EstadoParticipante::create([
                    'grupo_participante_id' => $grupo->id,
                    'estado_id'             => isset($lookupestados[$estadoGlobal]) ? $lookupestados[$estadoGlobal] : 1,
                    'fecha'                 => !empty($fechaEstado) ? $fechaEstado : NULL,
                    //'razon_id'              => !empty($categoria) && !empty($causa) ? $razon->id : null,
                    'created_at'            => now(),
                    'created_by'            => $usuario->id,
                    'active_at'             => now(),
                ]);
            }




            $i++;
        }

        echo "TOTAL IMPORTADOS: " . $i;
    }


    public function importarmao2()
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filePath = public_path('MAO2.xlsx');

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );


        //\App\Models\Role::firstOrCreate(['name' => 'MECLA']);

        $paisId = 1;
        // $cohortePaisProyecto = 14;
        $socio = 1;

        $i = 0;
        $data = [];
        foreach ($collection as $item) {
            $itemId = trim($item["id"]);
            if (!$itemId) {
                continue;
            }

            $username = $item["usuario_texto"];
            $cohorteTipo = $item["cohorte_tipo"];
            $rol = $item["usuario_rol"];
            $password = $item["password"];
            $cohortes = $item["cohortes"];


            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                $usuario = \App\Models\User::create([
                    'username' => $username,
                    'name' => $username,
                    'email' => $username . '@glasswing.org',
                    'email_verified_at' => now(),
                    'password' => \Illuminate\Support\Facades\Hash::make($password),
                    'socio_implementador_id' => $socio,
                    'remember_token' => Str::random(10),
                ]);

                $usuario->forceFill([
                    'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                    'remember_token' => Str::random(10),
                ])->save();
            }


            $usuario->assignRole($rol);

            $usuario->sociosImplementadores()->sync($socio);

            // 5. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
            $usuario->cohorte()->sync([16 => ['rol' => strtolower($rol), 'active_at' => now()]]);
            if ($cohorteTipo == 1) {
                $usuario->cohorte()->sync([15 => ['rol' => strtolower($rol), 'active_at' => now()]]);
            } elseif ($cohorteTipo == 2) {
                $usuario->cohorte()->sync([17 => ['rol' => strtolower($rol), 'active_at' => now()]]);
            } else {
                $usuario->cohorte()->sync([15 => ['rol' => strtolower($rol), 'active_at' => now()]]);
                $usuario->cohorte()->sync([17 => ['rol' => strtolower($rol), 'active_at' => now()]]);
            }

            $data[] = [
                'id' => $itemId,
                'usuariotexto' => $username,
                'password' => $password,
                'usuario_rol' => $rol,
                'cohortes' => $cohortes,
            ];

            $i++;
        }

        // $csvFileName = public_path('mao2jcp.csv');
        // $csvFile = fopen($csvFileName, 'w');

        // // Add headers to CSV
        // fputcsv($csvFile, ['Id', 'Username', 'Password', 'Rol', 'Cohortes']);

        // // Add data rows to CSV
        // foreach ($data as $row) {
        //     fputcsv($csvFile, $row);
        // }

        // fclose($csvFile);

        // Print $data array on the screen
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        echo "TOTAL IMPORTADOS : " . $i;
    }


    public function fixlinkjcp()
    {

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filePath = public_path('MAO2.xlsx');

        // Using LazyCollection for memory efficiency
        Excel::import(new JLIImport, $filePath);

        $collection = (new JLIImport)->collection(
            Excel::toCollection(new JLIImport, $filePath)->first()
        );


        //\App\Models\Role::firstOrCreate(['name' => 'MECLA']);

        $paisId = 1;
        // $cohortePaisProyecto = 14;
        $socio = 1;

        $i = 0;
        $data = [];
        foreach ($collection as $item) {
            $itemId = trim($item["id"]);
            if (!$itemId) {
                continue;
            }

            $username = $item["usuario_texto"];
            $cohorteTipo = $item["cohorte_tipo"];
            $rol = $item["usuario_rol"];
            $password = $item["password"];
            $cohortes = $item["cohortes"];



            $usuario = User::where('username', $username)->first();


            // 5. DAR ACCESO AL USARIO AL PAIS PROYECTO COHORTE
            if ($cohorteTipo == 1) {
                $usuario->cohorte()->sync([
                    15 => ['rol' => strtolower($rol), 'active_at' => now()],
                    16 => ['rol' => strtolower($rol), 'active_at' => now()],
                ]);
            } elseif ($cohorteTipo == 2) {
                $usuario->cohorte()->sync([
                    16 => ['rol' => strtolower($rol), 'active_at' => now()],
                    17 => ['rol' => strtolower($rol), 'active_at' => now()],
                ]);
            } else {
                $usuario->cohorte()->sync([
                    15 => ['rol' => strtolower($rol), 'active_at' => now()],
                    16 => ['rol' => strtolower($rol), 'active_at' => now()],
                    17 => ['rol' => strtolower($rol), 'active_at' => now()],
                ]);
            }
        }
    }


    public function asociarmao2parteuno()
    {

        // GUATEMALA
        $cuentas = [
            'G.CO.GU.1',
            'G.CO.GU.2',
            'G.CO.GU.3',
            'G.CO.GU.4',
            'G.CO.GU.5',
            'G.CO.GU.6',
            'G.CO.GU.7',
            'G.CO.GU.8',
            'G.CO.GU.9',
            'G.CO.GU.10',
            'G.CO.GU.11',
            'G.CO.GU.12',
            'G.CO.GU.13',
            'G.CO.GU.14',
            'G.CO.GU.15',
            'G.CO.GU.16',
            'G.CO.GU.17',
            'G.CO.GU.18',
            'G.CO.GU.19',
            'G.CO.GU.20',
            'G.CO.GU.21',
            'G.CO.GU.22',
            'G.CO.GU.23',
            'G.CO.GU.24',
            'G.CO.GU.25',
        ];

        $cohortePaisProyectos = [
            15,
            16,
        ];

        $coordinadorUsuario = User::where('username', 'C.JCP.GU')->first();
        $validadorR4Usuario = User::where('username', 'V4.ECO.GU')->first();
        $validadorR4UsuarioB = User::where('username', 'V4.APS.GU')->first();


        foreach ($cuentas as $username) {

            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            foreach ($cohortePaisProyectos as $cohortePaisProyecto) {

                $miValidadorR4 = CohorteProyectoUser::where('user_id', $validadorR4Usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miValidadorR4B = CohorteProyectoUser::where('user_id', $validadorR4UsuarioB->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miCoordinador = CohorteProyectoUser::where('user_id', $coordinadorUsuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $cohortesConPermisos = CohorteProyectoUser::where('user_id', $usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miCoordinador->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4B->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);
            }
        }


        // huehuetenando
        $coordinadorUsuario = User::where('username', 'C.JCP.HU')->first();
        $validadorR4Usuario = User::where('username', 'V4.ECO.HU')->first();
        $validadorR4UsuarioB = User::where('username', 'V4.APS.HU')->first();

        $cuentas = [
            'G.CO.HU.1',
            'G.CO.HU.2',
            'G.CO.HU.3',
            'G.CO.HU.4',
            'G.CO.HU.5',
            'G.CO.HU.6',
            'G.CO.HU.7',
            'G.CO.HU.8',
            'G.CO.HU.9',
            'G.CO.HU.10',
            'G.CO.HU.11',
            'G.CO.HU.12',
            'G.CO.HU.13',
            'G.CO.HU.14',
            'G.CO.HU.15',
            'G.CO.HU.16',
            'G.CO.HU.17',
            'G.CO.HU.18',
            'G.CO.HU.19',
            'G.CO.HU.20',
            'G.CO.HU.21',
            'G.CO.HU.22',
            'G.CO.HU.23',
            'G.CO.HU.24',
            'G.CO.HU.25',
        ];

        foreach ($cuentas as $username) {

            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            foreach ($cohortePaisProyectos as $cohortePaisProyecto) {

                $miValidadorR4 = CohorteProyectoUser::where('user_id', $validadorR4Usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miValidadorR4B = CohorteProyectoUser::where('user_id', $validadorR4UsuarioB->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miCoordinador = CohorteProyectoUser::where('user_id', $coordinadorUsuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $cohortesConPermisos = CohorteProyectoUser::where('user_id', $usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miCoordinador->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4B->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);
            }
        }

        //Quetzaltenango
        $coordinadorUsuario = User::where('username', 'C.JCP.QE')->first();
        $validadorR4Usuario = User::where('username', 'V4.ECO.QE')->first();
        $validadorR4UsuarioB = User::where('username', 'V4.APS.QE')->first();
        $cuentas = [
            'G.CO.QE.1',
            'G.CO.QE.2',
            'G.CO.QE.3',
            'G.CO.QE.4',
            'G.CO.QE.5',
            'G.CO.QE.6',
            'G.CO.QE.7',
            'G.CO.QE.8',
            'G.CO.QE.9',
            'G.CO.QE.10',
            'G.CO.QE.11',
            'G.CO.QE.12',
            'G.CO.QE.13',
            'G.CO.QE.14',
            'G.CO.QE.15',
            'G.CO.QE.16',
            'G.CO.QE.17',
            'G.CO.QE.18',
            'G.CO.QE.19',
            'G.CO.QE.20',
            'G.CO.QE.21',
            'G.CO.QE.22',
            'G.CO.QE.23',
            'G.CO.QE.24',
            'G.CO.QE.25',
        ];

        foreach ($cuentas as $username) {

            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            foreach ($cohortePaisProyectos as $cohortePaisProyecto) {

                $miValidadorR4 = CohorteProyectoUser::where('user_id', $validadorR4Usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miValidadorR4B = CohorteProyectoUser::where('user_id', $validadorR4UsuarioB->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miCoordinador = CohorteProyectoUser::where('user_id', $coordinadorUsuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $cohortesConPermisos = CohorteProyectoUser::where('user_id', $usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miCoordinador->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4B->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);
            }
        }


        //Alta Verapaz
        $coordinadorUsuario = User::where('username', 'C.JCP.AV')->first();
        $validadorR4Usuario = User::where('username', 'V4.ECO.AV')->first();
        $validadorR4UsuarioB = User::where('username', 'V4.APS.AV')->first();
        $cuentas = [
            'G.CO.AV.1',
            'G.CO.AV.2',
            'G.CO.AV.3',
            'G.CO.AV.4',
            'G.CO.AV.5',
            'G.CO.AV.6',
            'G.CO.AV.7',
            'G.CO.AV.8',
            'G.CO.AV.9',
            'G.CO.AV.10',
            'G.CO.AV.11',
            'G.CO.AV.12',
            'G.CO.AV.13',
            'G.CO.AV.14',
            'G.CO.AV.15',
            'G.CO.AV.16',
            'G.CO.AV.17',
            'G.CO.AV.18',
            'G.CO.AV.19',
            'G.CO.AV.20',
            'G.CO.AV.21',
            'G.CO.AV.22',
            'G.CO.AV.23',
            'G.CO.AV.24',
            'G.CO.AV.25',
        ];

        foreach ($cuentas as $username) {

            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            foreach ($cohortePaisProyectos as $cohortePaisProyecto) {

                $miValidadorR4 = CohorteProyectoUser::where('user_id', $validadorR4Usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miValidadorR4B = CohorteProyectoUser::where('user_id', $validadorR4UsuarioB->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miCoordinador = CohorteProyectoUser::where('user_id', $coordinadorUsuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $cohortesConPermisos = CohorteProyectoUser::where('user_id', $usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miCoordinador->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4B->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);
            }
        }
    }

    public function asociarmao2partedos()
    {
        //HUEHUETENANGO
        $cuentas = [
            'G.MAO.HU.1',
            'G.MAO.HU.2',
            'G.MAO.HU.3',
            'G.MAO.HU.4',
            'G.MAO.HU.5',
            'G.MAO.HU.6',
            'G.MAO.HU.7',
            'G.MAO.HU.8',
            'G.MAO.HU.9',
        ];

        $cohortePaisProyectos = [
            16,
            17,
        ];

        $coordinadorUsuario = User::where('username', 'C.JCP.HU')->first();
        $validadorR4Usuario = User::where('username', 'V4.ECO.HU')->first();
        $validadorR4UsuarioB = User::where('username', 'V4.APS.HU')->first();

        foreach ($cuentas as $username) {

            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            foreach ($cohortePaisProyectos as $cohortePaisProyecto) {

                $miValidadorR4 = CohorteProyectoUser::where('user_id', $validadorR4Usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miValidadorR4B = CohorteProyectoUser::where('user_id', $validadorR4UsuarioB->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miCoordinador = CohorteProyectoUser::where('user_id', $coordinadorUsuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $cohortesConPermisos = CohorteProyectoUser::where('user_id', $usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miCoordinador->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4B->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);
            }
        }


        //QUEZALTENANGO

        $cuentas = [
            'G.MAO.QE.1',
            'G.MAO.QE.2',
            'G.MAO.QE.3',
            'G.MAO.QE.4',
            'G.MAO.QE.5',
            'G.MAO.QE.6',
            'G.MAO.QE.7',
            'G.MAO.QE.8',
            'G.MAO.QE.9',
        ];

        $coordinadorUsuario = User::where('username', 'C.JCP.QE')->first();
        $validadorR4Usuario = User::where('username', 'V4.ECO.QE')->first();
        $validadorR4UsuarioB = User::where('username', 'V4.APS.QE')->first();

        foreach ($cuentas as $username) {

            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            foreach ($cohortePaisProyectos as $cohortePaisProyecto) {

                $miValidadorR4 = CohorteProyectoUser::where('user_id', $validadorR4Usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miValidadorR4B = CohorteProyectoUser::where('user_id', $validadorR4UsuarioB->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miCoordinador = CohorteProyectoUser::where('user_id', $coordinadorUsuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $cohortesConPermisos = CohorteProyectoUser::where('user_id', $usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miCoordinador->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4B->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);
            }
        }

        //GUATEMALA

        $cuentas = [
            'G.MAO.GU.1',
            'G.MAO.GU.2',
            'G.MAO.GU.3',
            'G.MAO.GU.4',
            'G.MAO.GU.5',
            'G.MAO.GU.6',
            'G.MAO.GU.7',
            'G.MAO.GU.8',
            'G.MAO.GU.9',
        ];

        $coordinadorUsuario = User::where('username', 'C.JCP.GU')->first();
        $validadorR4Usuario = User::where('username', 'V4.ECO.GU')->first();
        $validadorR4UsuarioB = User::where('username', 'V4.APS.GU')->first();

        foreach ($cuentas as $username) {

            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            foreach ($cohortePaisProyectos as $cohortePaisProyecto) {

                $miValidadorR4 = CohorteProyectoUser::where('user_id', $validadorR4Usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miValidadorR4B = CohorteProyectoUser::where('user_id', $validadorR4UsuarioB->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miCoordinador = CohorteProyectoUser::where('user_id', $coordinadorUsuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $cohortesConPermisos = CohorteProyectoUser::where('user_id', $usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miCoordinador->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4B->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);
            }
        }


        //ALTA VERAPAZ
        $cuentas = [
            'G.MAO.AV.1',
            'G.MAO.AV.2',
            'G.MAO.AV.3',
            'G.MAO.AV.4',
            'G.MAO.AV.5',
            'G.MAO.AV.6',
            'G.MAO.AV.7',
            'G.MAO.AV.8',
            'G.MAO.AV.9',
        ];

        $coordinadorUsuario = User::where('username', 'C.JCP.AV')->first();
        $validadorR4Usuario = User::where('username', 'V4.ECO.AV')->first();
        $validadorR4UsuarioB = User::where('username', 'V4.APS.AV')->first();

        foreach ($cuentas as $username) {

            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            foreach ($cohortePaisProyectos as $cohortePaisProyecto) {

                $miValidadorR4 = CohorteProyectoUser::where('user_id', $validadorR4Usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miValidadorR4B = CohorteProyectoUser::where('user_id', $validadorR4UsuarioB->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $miCoordinador = CohorteProyectoUser::where('user_id', $coordinadorUsuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $cohortesConPermisos = CohorteProyectoUser::where('user_id', $usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miCoordinador->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR4B->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);
            }
        }
    }

    public function fixrelacionregistro3()
    {
        $usuarios = [
            'R3.GU',
            'R3.HU',
            'R3.QE',
            'R3.AV'
        ];

        $cohortePaisProyectos = [
            15,
            16,
            17,
        ];

        $validadorR3 = User::where('username', 'V3.JCP')->first();

        foreach ($usuarios as $usuario) {
            $usuario = User::where('username', $usuario)->first();
            if (!$usuario) {
                continue;
            }


            foreach ($cohortePaisProyectos as $cohortePaisProyecto) {

                $miValidadorR3 = CohorteProyectoUser::where('user_id', $validadorR3->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                $cohortesConPermisos = CohorteProyectoUser::where('user_id', $usuario->id)
                    ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto)
                    ->first();

                CoordinadorGestor::create([
                    'cohorte_pais_proyecto_id' => $cohortePaisProyecto,
                    'coordinador_id' => $miValidadorR3->id,
                    'gestor_id' => $cohortesConPermisos->id,
                    'active_at' => now(),
                ]);
            }
        }
    }


    public function nuevosgestorescohorte8jli()
    {
        $usuariosCedro = [
            'G.C06.ACPDRO.4',
            'G.C05.ACPDRO.4',
            'G.C05.ACPDRO.2',
            'G.C06.ACPDRO.2',
            'G.C07.ACPDRO.6',
            'G.C05.ACPDRO.1',
            'G.C07.ACPDRO.3',
            'G.C06.ACPDRO.8',
            'G.C06.ACPDRO.3',
            'G.C07.ACPDRO.5',
            'G.CO8.ACPDRO.1',
            'G.CO8.ACPDRO.2',
            'G.CO8.ACPDRO.3',
            'G.CO8.ACPDRO.4',
            'G.CO8.ACPDRO.5',
            'G.CO8.ACPDRO.6',
            'G.CO8.ACPDRO.7',
            'G.CO8.ACPDRO.8',
            'G.CO8.ACPDRO.9',
            'G.CO8.ACPDRO.10',
            'G.CO8.ACPDRO.11',
        ];

        foreach ($usuariosCedro as $username) {
            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            $cohorteUserId = CohorteProyectoUser::create([
                'user_id' => $usuario->id,
                'cohorte_pais_proyecto_id' => 8,
                'rol' => 'gestor',
                'active_at' => now(),
            ]);

            CoordinadorGestor::firstOrCreate(
                [
                    'cohorte_pais_proyecto_id' => 8,
                    'coordinador_id' => 385,
                    'gestor_id' => $cohorteUserId->id,
                ],
                [
                    'active_at' => now(),
                ]
            );
        }

        $usuariosTN = [
            'G.C06.TN.6',
            'G.C07.TN.8',
            'G.C05.TN.6',
            'G.C06.TN.4',
            'G.C05.TN.4',
            'G.C05.TN.3',
            'G.C07.TN.6',
            'G.C06.TN.3',
            'G.C07.TN.1',
            'G.C07.TN.2',
            'G.C05.TN.13',
            'G.C05.TN.12',
            'G.C06.TN.8',
            'G.C06.TN.11',
            'G.C07.TN.10',
            'G.C05.TN.8',
            'G.C05.TN.10',
            'G.C05.TN.1',
            'G.C07.TN.3',
            'G.C06.TN.1',
            'G.C06.TN.4',
            'G.C07.TN.9',
            'G.C05.TN.7',
            'G.CO8.TN.1',
            'G.CO8.TN.2',
            'G.CO8.TN.3',
            'G.CO8.TN.4',
            'G.CO8.TN.5',
            'G.CO8.TN.6',
            'G.CO8.TN.7',

        ];

        foreach ($usuariosTN as $username) {
            $usuario = User::where('username', $username)->first();
            if (!$usuario) {
                continue;
            }

            $cohorteUserId = CohorteProyectoUser::firstOrCreate(
                [
                    'user_id' => $usuario->id,
                    'cohorte_pais_proyecto_id' => 8,
                ],
                [
                    'rol' => 'gestor',
                    'active_at' => now(),
                ]
            );

            CoordinadorGestor::firstOrCreate(
                [
                    'cohorte_pais_proyecto_id' => 8,
                    'coordinador_id' => 387,
                    'gestor_id' => $cohorteUserId->id,
                ],
                [
                    'active_at' => now(),
                ]
            );
        }
    }

    public function mover3actors()
    {
        $records = CohorteProyectoUser::with("cohortePaisProyecto")
            ->whereIn("rol", ["registro r3", "validación r3"])
            ->get();

        foreach ($records as $record) {
            \App\Models\PeriodoProyectoUser::firstOrCreate(
                [
                    'pais_proyecto_id' => $record->cohortePaisProyecto->pais_proyecto_id,
                    'user_id' => $record->user_id,
                    'rol' => $record->rol,
                ],
                [
                    'active_at' => now(),
                ]
            );
        }
    }

    public function estipendiosfix()
    {
        $registros = Participante::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'lastEstado.estado_registro:id,nombre,color,icon',
            'grupoactivo.lastEstadoParticipante.estado',
            'grupoactivo.grupo',
            //"grupoParticipante.lastEstadoParticipante.estado",
        ])
            ->whereHas('estipendioParticipantes')
            ->get();

        $rechazados = [];
        foreach ($registros as $registro) {
            if($registro->lastEstado->estado_registro->id != \App\Models\EstadoRegistro::VALIDADO){
                $rechazados[] = [
                    'id' => $registro->id,
                    'nombre' => $registro->full_name,
                ];
            }
        }

        foreach($rechazados as $rechazado){
            EstipendioParticipante::where('participante_id', $rechazado['id'])->delete();
            EstipendioAgrupacionParticipante::where('participante_id', $rechazado['id'])->delete();
        }

        echo "<pre>";
        print_r($rechazados);
        echo "</pre>";
    }
}
