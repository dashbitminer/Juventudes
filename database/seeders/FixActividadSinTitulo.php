<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CohorteActividad;
use App\Models\CohorteSubactividad;
use App\Models\CohorteSubactividadModulo;
use App\Models\ModuloSubactividadSubmodulo;

class FixActividadSinTitulo extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $results = DB::select('SELECT ca.id AS cohorte_actividades_id, cs.id AS cohorte_subactividad_id,
            csm.id AS cohorte_subactividad_modulo_id, mss.id AS modulo_subactividad_submodulo_id
            FROM actividades a
            INNER JOIN cohorte_actividades ca ON a.id = ca.actividad_id
            LEFT JOIN cohorte_subactividad cs ON ca.id = cs.cohorte_actividad_id
            LEFT JOIN subactividades s ON cs.subactividad_id = s.id
            LEFT JOIN cohorte_subactividad_modulo csm ON cs.id = csm.cohorte_subactividad_id
            LEFT JOIN modulos m ON csm.modulo_id = m.id
            LEFT JOIN modulo_subactividad_submodulo mss ON csm.id = mss.cohorte_subactividad_modulo_id
            LEFT JOIN submodulos s2 ON mss.submodulo_id = s2.id
            LEFT JOIN sesion_titulos st ON st.cohorte_pais_proyecto_id = ca.cohorte_pais_proyecto_id
                AND st.cohorte_pais_proyecto_perfil_id = ca.cohorte_pais_proyecto_perfil_id
                AND (
                (st.actividad_id IS NOT NULL AND st.actividad_id = a.id) OR
                (st.subactividad_id IS NOT NULL AND st.subactividad_id = s.id) OR
                (st.modulo_id IS NOT NULL AND st.modulo_id = m.id) OR
                (st.submodulo_id IS NOT NULL AND st.submodulo_id = s2.id)
                )
            WHERE st.id IS NULL');

        // dd($results);

        foreach ($results as $result) {
            if ($result->modulo_subactividad_submodulo_id) {
                ModuloSubactividadSubmodulo::destroy($result->modulo_subactividad_submodulo_id);
            }

            if ($result->cohorte_subactividad_modulo_id) {
                CohorteSubactividadModulo::destroy($result->cohorte_subactividad_modulo_id);
            }

            if ($result->cohorte_subactividad_id) {
                CohorteSubactividad::destroy($result->cohorte_subactividad_id);
            }

            if ($result->cohorte_actividades_id) {
                CohorteActividad::destroy($result->cohorte_actividades_id);
            }
        }
    }
}
