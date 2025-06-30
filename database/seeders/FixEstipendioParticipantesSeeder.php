<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GrupoParticipante;
use App\Models\Participante;
use App\Models\Estipendio;
use App\Models\EstipendioParticipante;

class FixEstipendioParticipantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $participantes = [];

        // Obtiene todos los participantes que no tienen un perfil en el grupo
        $grupos = GrupoParticipante::with('cohorteParticipanteProyecto')
            ->whereNull('cohorte_pais_proyecto_perfil_id')
            ->get();

        foreach ($grupos as $grupo) {
            $defaultPerfilId = $grupo->cohorteParticipanteProyecto->cohorte_pais_proyecto_perfil_id;

            if ($defaultPerfilId) {
                // Actualiza el perfil en el grupo por el perfil que se le fue asignado al editar el Participante
                $grupo->update([
                    'cohorte_pais_proyecto_perfil_id' => $defaultPerfilId,
                ]);

                $participantes[] = $grupo->cohorteParticipanteProyecto->participante_id;
            }
        }

        // Si hay participantes, se va agregar al estipendio al que deberia de ir
        if (!empty($participantes)) {
            $estipendios = Estipendio::all();

            foreach ($estipendios as $estipendio) {
                $listParticipantes = Participante::whereHas('cohorteParticipanteProyecto', function ($query) use ($estipendio)  {
                    $query->where('cohorte_pais_proyecto_id', $estipendio->cohorte_pais_proyecto_id);
                })
                ->whereHas('gestor.socioImplementador', function ($query) use ($estipendio) {
                    $query->where('socios_implementadores.id', $estipendio->socio_implementador_id);
                })
                ->whereHas('grupoParticipante', function ($query) use ($estipendio) {
                    $query->where('grupo_participante.cohorte_pais_proyecto_perfil_id', $estipendio->cohorte_pais_proyecto_perfil_id);
                })
                ->whereHas('lastEstado', function ($q) {
                    $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
                })
                ->whereIn('id', $participantes)
                ->get();

                foreach ($listParticipantes as $participante) {
                    EstipendioParticipante::create([
                        'estipendio_id' => $estipendio->id,
                        'participante_id' => $participante->id,
                    ]);
                }
            }
        }
    }
}
