<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Usuarios',
            'Roles',
            'Permisos',
            'Configuración',
            'Proyectos',
            'Cohortes',
            'Participantes',
            'Paises',
        ];

        $permisosUsuarios = [
            'Ver usuarios',
            'Crear usuarios',
            'Editar usuarios',
            'Eliminar usuarios',
        ];

        foreach ($permisosUsuarios as $permiso) {
            Permission::create([
                'name' => $permiso,
                'categoria' => $categorias[0],
            ]);
        }

        $permisosRoles = [
            'Ver roles',
            'Crear roles',
            'Editar roles',
            'Eliminar roles',
        ];

        foreach ($permisosRoles as $permiso) {
            Permission::create([
                'name' => $permiso,
                'categoria' => $categorias[1],
            ]);
        }

        $permisosPermisos = [
            'Ver permisos',
            'Crear permisos',
            'Editar permisos',
            'Eliminar permisos',
        ];

        foreach ($permisosPermisos as $permiso) {
            Permission::create([
                'name' => $permiso,
                'categoria' => $categorias[2],
            ]);
        }

        $permisosConfiguracion = [
            'Ver configuración',
            'Editar configuración',
        ];

        foreach ($permisosConfiguracion as $permiso) {
            Permission::create([
                'name' => $permiso,
                'categoria' => $categorias[3],
            ]);
        }

        $permisosProyectos = [
            'Ver proyectos',
            'Crear proyectos',
            'Editar proyectos',
            'Eliminar proyectos',
        ];

        foreach ($permisosProyectos as $permiso) {
            Permission::create([
                'name' => $permiso,
                'categoria' => $categorias[4],
            ]);
        }

        $permisosCohortes = [
            'Ver cohortes',
            'Crear cohortes',
            'Editar cohortes',
            'Eliminar cohortes',
        ];

        foreach ($permisosCohortes as $permiso) {
            Permission::create([
                'name' => $permiso,
                'categoria' => $categorias[5],
            ]);
        }

        $permisosParticipantes = [
            'Ver participantes',
            'Crear participantes',
            'Editar participantes',
            'Eliminar participantes',
        ];

        foreach ($permisosParticipantes as $permiso) {
            Permission::create([
                'name' => $permiso,
                'categoria' => $categorias[6],
            ]);
        }

        $permisosPais = [
            'Ver mi pais',
            'Ver todos los paises',
        ];

        foreach ($permisosPais as $permiso) {
            Permission::create([
                'name' => $permiso,
                'categoria' => $categorias[7],
            ]);
        }





    }
}
