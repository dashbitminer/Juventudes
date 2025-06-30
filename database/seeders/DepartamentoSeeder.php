<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array with Guatemala's departments
        $guatemalaDepartments = [
            ['id' => 1, 'name' => 'Alta Verapaz', 'pais_id' => 1, 'codigo' => '15'],
            ['id' => 2, 'name' => 'Baja Verapaz', 'pais_id' => 1, 'codigo' => '16'],
            ['id' => 3, 'name' => 'Chimaltenango', 'pais_id' => 1, 'codigo' => '04'],
            ['id' => 4, 'name' => 'Chiquimula', 'pais_id' => 1, 'codigo' => '20'],
            ['id' => 5, 'name' => 'El Progreso', 'pais_id' => 1, 'codigo' => '02'],
            ['id' => 6, 'name' => 'Escuintla', 'pais_id' => 1, 'codigo' => '05'],
            ['id' => 7, 'name' => 'Guatemala', 'pais_id' => 1, 'codigo' => '01'],
            ['id' => 8, 'name' => 'Huehuetenango', 'pais_id' => 1, 'codigo' => '13'],
            ['id' => 9, 'name' => 'Izabal', 'pais_id' => 1, 'codigo' => '18'],
            ['id' => 10, 'name' => 'Jalapa', 'pais_id' => 1, 'codigo' => '21'],
            ['id' => 11, 'name' => 'Jutiapa', 'pais_id' => 1, 'codigo' => '22'],
            ['id' => 12, 'name' => 'Petén', 'pais_id' => 1, 'codigo' => '17'],
            ['id' => 13, 'name' => 'Quetzaltenango', 'pais_id' => 1, 'codigo' => '09'],
            ['id' => 14, 'name' => 'Quiché', 'pais_id' => 1, 'codigo' => '14'],
            ['id' => 15, 'name' => 'Retalhuleu', 'pais_id' => 1, 'codigo' => '11'],
            ['id' => 16, 'name' => 'Sacatepéquez', 'pais_id' => 1, 'codigo' => '03'],
            ['id' => 17, 'name' => 'San Marcos', 'pais_id' => 1, 'codigo' => '12'],
            ['id' => 18, 'name' => 'Santa Rosa', 'pais_id' => 1, 'codigo' => '06'],
            ['id' => 19, 'name' => 'Sololá', 'pais_id' => 1, 'codigo' => '07'],
            ['id' => 20, 'name' => 'Suchitepéquez', 'pais_id' => 1, 'codigo' => '10'],
            ['id' => 21, 'name' => 'Totonicapán', 'pais_id' => 1, 'codigo' => '08'],
            ['id' => 22, 'name' => 'Zacapa', 'pais_id' => 1, 'codigo' => '19'],
        ];

        foreach ($guatemalaDepartments as $departamento) {
            \App\Models\Departamento::create([
                'id' => $departamento['id'],
                'nombre' => $departamento['name'],
                'codigo' => $departamento['codigo'],
                'slug' => \Illuminate\Support\Str::slug($departamento['name']),
                'pais_id' => $departamento['pais_id'],
                'active_at' => now(),
            ]);
        }

        $elsalvadorDepartments = [
            ['id' => 23, 'name' => 'Ahuachapán', 'pais_id' => 2],
            ['id' => 24, 'name' => 'Cabañas', 'pais_id' => 2],
            ['id' => 25, 'name' => 'Chalatenango', 'pais_id' => 2],
            ['id' => 26, 'name' => 'Cuscatlán', 'pais_id' => 2],
            ['id' => 27, 'name' => 'La Libertad', 'pais_id' => 2],
            ['id' => 28, 'name' => 'La Paz', 'pais_id' => 2],
            ['id' => 29, 'name' => 'La Unión', 'pais_id' => 2],
            ['id' => 30, 'name' => 'Morazán', 'pais_id' => 2],
            ['id' => 31, 'name' => 'San Miguel', 'pais_id' => 2],
            ['id' => 32, 'name' => 'San Salvador', 'pais_id' => 2],
            ['id' => 33, 'name' => 'Santa Ana', 'pais_id' => 2],
            ['id' => 34, 'name' => 'San Vicente', 'pais_id' => 2],
            ['id' => 35, 'name' => 'Sonsonate', 'pais_id' => 2],
            ['id' => 36, 'name' => 'Usulután', 'pais_id' => 2],
        ];

        foreach ($elsalvadorDepartments as $departamento) {
            \App\Models\Departamento::create([
                'id' => $departamento['id'],
                'nombre' => $departamento['name'],
                'slug' => \Illuminate\Support\Str::slug($departamento['name']),
                'pais_id' => $departamento['pais_id'],
                'active_at' => now(),
            ]);
        }

        // Array with Honduras's departments
        $hondurasDepartments = [
            ['id' => 37, 'name' => 'Atlántida', 'pais_id' => 3],
            ['id' => 38, 'name' => 'Choluteca', 'pais_id' => 3],
            ['id' => 39, 'name' => 'Colón', 'pais_id' => 3],
            ['id' => 40, 'name' => 'Comayagua', 'pais_id' => 3],
            ['id' => 41, 'name' => 'Copán', 'pais_id' => 3],
            ['id' => 42, 'name' => 'Cortés', 'pais_id' => 3],
            ['id' => 43, 'name' => 'El Paraíso', 'pais_id' => 3],
            ['id' => 44, 'name' => 'Francisco Morazán', 'pais_id' => 3],
            ['id' => 45, 'name' => 'Gracias a Dios', 'pais_id' => 3],
            ['id' => 46, 'name' => 'Intibucá', 'pais_id' => 3],
            ['id' => 47, 'name' => 'Islas de la Bahía', 'pais_id' => 3],
            ['id' => 48, 'name' => 'La Paz', 'pais_id' => 3],
            ['id' => 49, 'name' => 'Lempira', 'pais_id' => 3],
            ['id' => 50, 'name' => 'Ocotepeque', 'pais_id' => 3],
            ['id' => 51, 'name' => 'Olancho', 'pais_id' => 3],
            ['id' => 52, 'name' => 'Santa Bárbara', 'pais_id' => 3],
            ['id' => 53, 'name' => 'Valle', 'pais_id' => 3],
            ['id' => 54, 'name' => 'Yoro', 'pais_id' => 3],
        ];

        foreach ($hondurasDepartments as $departamento) {
            \App\Models\Departamento::create([
                'id' => $departamento['id'],
                'nombre' => $departamento['name'],
                'slug' => \Illuminate\Support\Str::slug($departamento['name']),
                'pais_id' => $departamento['pais_id'],
                'active_at' => now(),
            ]);
        }


    }
}
