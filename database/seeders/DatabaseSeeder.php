<?php

namespace Database\Seeders;

use App\Models\CategoriaRazon;
use App\Models\Cohorte;
use App\Models\CohorteProyectoSocio;
use App\Models\CohorteUser;
use App\Models\CoordinadorGestor;
use App\Models\Pais;
use App\Models\User;
use App\Models\Etnia;
use App\Models\Modalidad;
use App\Models\Parentesco;
use App\Models\Departamento;
use App\Models\Estado;
use App\Models\EstadoCivil;
use App\Models\Formulario;
use App\Models\FuenteIngreso;
use App\Models\Grupo;
use App\Models\ModalidadPaisProyecto;
use App\Models\Modulo;
use App\Models\ProyectoVida;
use App\Models\NivelAcademico;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\NivelEducativo;
use App\Models\ObjetivoAsistenciaAlianza;
use App\Models\OrigenEmpresaPrivada;
use App\Models\Participante;
use App\Models\Proyecto;
use App\Models\SocioImplementador;
use App\Models\Subactividad;
use App\Models\TipoEstudio;
use App\Models\TipoFormulario;
use App\Models\Titulo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



        $this->call([
            PaisSeeder::class,
            DepartamentoSeeder::class,
            CiudadSeeder::class,
            EstadoCivilSeeder::class,
            DiscapacidadSeeder::class,
            EtniaSeeder::class,
            GrupoPertenecienteSeeder::class,
            ModalidadSeeder::class,
            ProyectoVidaSeeder::class,
            ComparteResponsabilidadHijoSeeder::class,
            NivelAcademicoSeeder::class,
            NivelEducativoSeeder::class,
            SeccionGradoSeeder::class,
            TurnoEstudioSeeder::class,
            ParentescoSeeder::class,
            ApoyoHijoSeeder::class,
            ProyectoSeeder::class, //here is the relationship bewtteen proyecto and pais
            CohorteSeeder::class,
            EstadoRegistroSeeder::class,
            //ParticipanteSeeder::class,
            PerfilSeeder::class,

            SocioImplementadorSeeder::class,
            PaisProyectoSocioSeeder::class,

            // auth
            RoleSeeder::class,
            PermissionSeeder::class,

            CoordinadorGestorSeeder::class,

            PersonaViveSeeder::class,
            CasaDispositivoSeeder::class,
            FuenteIngresoSeeder::class,
            DineroSuficientePreguntaSeeder::class,
            DineroSuficienteOpcionSeeder::class,
            DineroSuficienteTablaSeeder::class,
            SocioeconomicoSeeder::class,
            CriterioSeeder::class,
            EstadoSeeder::class,
            CategoriaRazonSeeder::class,
            RazonSeeder::class,
            GrupoSeeder::class,
            ModuloSeeder::class,
            SubmoduloSeeder::class,
            SubactividadSeeder::class,

            //CohorteProyectoSocioSeeder::class,
            CohortePaisProyectoSeeder::class,


            TituloSeeder::class,
            TipoAlianzaSeeder::class,
            TipoSectorSeeder::class,
            TipoSectorPublicoSeeder::class,
            TipoSectorPrivadoSeeder::class,
            OrigenEmpresaPrivadaSeeder::class,
            TamanoEmpresaPrivadaSeeder::class,
            TipoSectorComunitariaSeeder::class,
            PropositoAlianzaSeeder::class,
            ModalidadEstrategiaAlianzaSeeder::class,
            ObjetivoAsistenciaAlianzaSeeder::class,
            OrganizacionAlianzaSeeder::class,
            OrigenEmpresaPrivadaSeeder::class,
            TipoSectorAcademicaSeeder::class,
            ComunidadLinguisticaSeeder::class,

            ResultadoSeeder::class,
            TipoRecursoSeeder::class,
            OrigenRecursoSeeder::class,
            FuenteRecursoSeeder::class,
            CoberturaGeograficaSeeder::class,
            PersonaViveParejaSeeder::class,
            TipoInstitucionSeeder::class,
            AreaIntervencionSeeder::class,
            TipoApoyoSeeder::class,
            MedioVidaSeeder::class,
            SectorEmpresaOrganizacionSeeder::class,
            TipoEmpleoSeeder::class,
            SalarioSeeder::class,
            MedioVerificacionSeeder::class,
            MotivosCambioOrganizacionSeeder::class,
            ServiciosDesarrollarSeeder::class,
            HabilidadesAdquirirSeeder::class,
            VinculadoDebidoSeeder::class,
            MedioVerificacionVoluntarioSeeder::class,
            MedioVerificacionFormacionSeeder::class,
            TipoEstudioSeeder::class,
            AreaFormacionSeeder::class,
            NivelEducativoFormacionSeeder::class,
            RubroEmprendimientoSeeder::class,
            EtapaEmprendimientoSeeder::class,
            CapitalSemillaSeeder::class,
            MedioVerificacionEmprendimientoSeeder::class,

            // Formularios
            TipoFormularioSeeder::class,
            FormularioSeeder::class, // GUATERMALA REGISTRO



            RecursoPrevistoSeeder::class,
            RecursoPrevistoUsaidSeeder::class,
            RecursoPrevistoCostShareSeeder::class,
            RecursoPrevistoLeverageSeeder::class,
            PcjSostenibilidadSeeder::class,
            PcjAlcanceSeeder::class,
            PcjFortaleceAreasSeeder::class,
            PoblacionBeneficiadaSeeder::class,
            IngresosPromedioSeeder::class,
        ]);

        // Create the relationship between modalidad and pais_proyecto
        // foreach ( \App\Models\Modalidad::all() as $modalidad) {
        //     ModalidadPaisProyecto::create([
        //         'modalidad_id'     => $modalidad->id,
        //         'pais_proyecto_id' => 1,
        //         'created_at'       => now(),
        //         'created_by'       => 1,
        //     ]);
        // }


       // User::factory(5)->create();

        $usuario = User::factory()->create([
            'username' => 'amos41',
            'email' => 'amos41@example.com',
            'socio_implementador_id' => rand(1,3),
        ])->assignRole(2);

        $usuario = User::factory()->create([
            'username' => 'wgazar',
            'email' => 'wgazar@example.com',
            'socio_implementador_id' => rand(1,3),
        ])->assignRole(3);

        $usuario = User::factory()->create([
            'username' => 'david',
            'email' => 'david@example.com',
            'socio_implementador_id' => rand(1,3),
        ])->assignRole(1);

        $usuario = User::factory()->create([
            'username' => 'mariano',
            'email' => 'mariano@example.com',
            'socio_implementador_id' => rand(1,3),
        ])->assignRole(2);

        // Asign Roles
        $roles = ['admin','gestor','coordinador'];
        foreach (User::all() as $user) {
            if($user->username != "amos41" && $user->username != "wgazar" && $user->username != "david" && $user->username != "mariano") {
                $user->assignRole($roles[rand(0, 2)]);
            }

            //$user->gestor_id = rand(1,11);
            $user->save();

            \App\Models\CohorteProyectoUser::create([
                'user_id'                  => $user->id,
                'cohorte_pais_proyecto_id' => 1,
                'rol'                      => 'gestor',
                'active_at'                => now(),
            ]);

        }

       // $this->call([ CohorteSocioUserSeeder::class,]);
        $this->call([ CohorteProyectoUserSeeder::class,]);

        // If there are not data it will run again to assign them
        if (CoordinadorGestor::all()->count() == 0) {
            $this->call([CoordinadorGestorSeeder::class]);
        }

        foreach (Participante::all() as $participante) {
            $participante->cohortePaisProyecto()->attach(1);
        }


    }
}
