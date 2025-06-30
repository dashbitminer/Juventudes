<?php

namespace Database\Seeders;

use App\Models\ComunidadEtnica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComunidadEtnicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ComunidadEtnica::create([
            'nombre' => 'Garífuna',
            'grupo_etnico_id' => 1, // Garifuna
            'active_at' => now(),
        ]);

        ComunidadEtnica::create([
            'nombre' => 'Español/Castellano',
            'grupo_etnico_id' => 2, // Ladino Metizo
            'active_at' => now(),
        ]);

        $mayas = [
            "Achi'",
            "Akateko",
            "Chalchiteko",
            "Ch'orti'",
            "Chuj",
            "Itza'",
            "Ixil",
            "Kaqchikel",
            "K'iche'",
            "Mam",
            "Mopan",
            "Popti'",
            "Poqomam",
            "Poqomchi'",
            "Q'anjob'al",
            "Q'eqchi'",
            "Sakapulteko",
            "Sipakapense",
            "Tektiteko",
            "Tz'utujil",
            "Uspanteko",
        ];

        foreach ($mayas as $maya) {
            ComunidadEtnica::create([
                'nombre' => $maya,
                'grupo_etnico_id' => 3, // Maya
                'active_at' => now(),
            ]);
        }

        ComunidadEtnica::create([
            'nombre' => 'Xinca',
            'grupo_etnico_id' => 4, // Ladino Metizo
            'active_at' => now(),
        ]);


        $indigenas = [
            "Lenca",
            "Chortí",
            "Miskito",
            "Pech",
            "Tawahka",
            "Tolupan (Jicaque)",
            "Nahualt",
        ];

        foreach ($indigenas as $indigena) {
            ComunidadEtnica::create([
                'nombre' => $indigena,
                'grupo_etnico_id' => 5, // Indigena
                'active_at' => now(),
            ]);
        }

        $afrodescendientes = [
            "Garífuna",
            "Criollo inglés (Isleños)"
        ];

        foreach ($afrodescendientes as $afrodescendiente) {
            ComunidadEtnica::create([
                'nombre' => $afrodescendiente,
                'grupo_etnico_id' => 6, // Afrodescendiente
                'active_at' => now(),
            ]);
        }

    }
}
