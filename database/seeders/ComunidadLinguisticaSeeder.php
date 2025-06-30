<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComunidadLinguisticaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comunidades = [
            "Chalchiteka",
            "Awakateka",
            "Kaqchikel",
            "Ixil",
            "Mam",
            "Poqomam",
            "Poqomchi’",
            "Q’anjob’al",
            "Sipakapense",
            "Tektiteka",
            "Akateka",
            "K’iche’",
            "Jakalteka/Popti’",
            "Uspanteka",
            "Achi",
            "Chuj",
            "Mopan",
            "Sakapulteka",
            "Q’eqchi’",
            "Tz’utujil",
            "Ch’orti",
            "Itza’",
            "Náhuat",
            "Español",
        ];

        foreach ($comunidades as $key => $comunidad) {
            $comunidad = \App\Models\ComunidadLinguistica::create([
                'nombre' => $comunidad,
                'active_at' => now(),
            ]);

            if ($key == 21 ) {
                $comunidad->paises()->syncWithoutDetaching([2 => ['active_at' => now()]]);
            } elseif ($key == 22) {
                $comunidad->paises()->syncWithoutDetaching([
                    1 => ['active_at' => now()],
                    2 => ['active_at' => now()],
                ]);
            }else{
                $comunidad->paises()->syncWithoutDetaching([1 => ['active_at' => now()]]);
            }
        }

    }
}
