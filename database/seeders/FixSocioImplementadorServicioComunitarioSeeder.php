<?php

namespace Database\Seeders;

use App\Models\ServicioComunitario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixSocioImplementadorServicioComunitarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $records =  ServicioComunitario::leftJoin('users', 'servicio_comunitarios.created_by', '=', 'users.id')
            ->select(
                "servicio_comunitarios.id",
                "servicio_comunitarios.socio_implementador_id",
                "servicio_comunitarios.created_by",
                "users.socio_implementador_id as sociouser"
            )
            ->get();

            foreach ($records as $record) {
                if ($record->socio_implementador_id != $record->sociouser) {
                    ServicioComunitario::where('id', $record->id)
                        ->update(['socio_implementador_id' => $record->sociouser]);
                }
            }
    }
}
