<?php

namespace App\Livewire\Financiero\Coordinador\Participante\Index;

use App\Models\BancarizacionGrupo;
use App\Models\BancarizacionGrupoParticipante;
use App\Models\Participante;
use Illuminate\Support\Facades\DB;


trait GrupoTrait
{


    public function addList()
    {
        $this->lista = Participante::whereIn('id', $this->selectedParticipanteIds)
            ->with(
                'grupoactivo.lastEstadoParticipante.estado',
                'grupoactivo.grupo',
                'bancarizacionGrupos',
            )
            ->get([
                'id',
                "primer_nombre",
                "segundo_nombre",
                "tercer_nombre",
                "primer_apellido",
                "segundo_apellido",
                "tercer_apellido",
                'fecha_nacimiento'
            ]);
    }

    public function removeList($id)
    {

        $this->lista = $this->lista->filter(function ($participante) use ($id) {
            return $participante->id != $id;
        });


        // Remove from selectedParticipanteIds array and reindex keys
        $this->selectedParticipanteIds = array_values(array_filter($this->selectedParticipanteIds, function ($value) use ($id) {
            return $value != $id;
        }));
    }

    public function crearGrupo()
    {

        $this->validate();


        //1 Get Cohorte Participante Proyecto Record
        $participantesProyectoCohorte = \App\Models\CohorteParticipanteProyecto::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->whereIn('participante_id', $this->selectedParticipanteIds)
            ->pluck("id")
            ->toArray();

        DB::transaction(function () use ($participantesProyectoCohorte) {

            // Create a new "bancarizacion grupo" record to group participants for financial purposes
            $grupo = \App\Models\BancarizacionGrupo::create([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
               // 'monto' => $this->monto,
                'cohorte_pais_proyecto_id' => $this->cohortePaisProyecto->id,
                'active_at' => now(),
            ]);

            // 2. Creo el nuevo grupo
            foreach ($participantesProyectoCohorte as $participanteId) {
                BancarizacionGrupoParticipante::create([
                    'bancarizacion_grupo_id' => $grupo->id,
                    'participante_id' => $participanteId,
                    'active_at' => now(),
            // 2. Create a new group record in the database
            // This step is crucial as it establishes a new group for the selected participants,
            // linking them to the current project cohort and enabling further group-specific operations.
                ]);
            }
        });


        $this->reset('nombre', 'descripcion', 'selectedParticipanteIds', 'openDrawer', 'titulo', 'mensaje');

        $this->dispatch('update-financierons-grupos-cards');

        $this->showSuccessIndicator = true;

        sleep(1);

        $this->reset('lista');
    }


    public function editarGrupo()
    {

        $grupo = \App\Models\BancarizacionGrupo::find($this->selectedGrupoView->id);

        $grupo->nombre = $this->nombre;

        $grupo->descripcion = $this->descripcion;

        $grupo->save();

        $this->openDrawerView = false;
    }


    public function selectGroup($id)
    {
        $this->selectedGrupoView = \App\Models\BancarizacionGrupo::find($id);

        $this->selectedGrupoView->load(['participantes' => function ($query) {
            $query->wherePivot('active_at', '!=', null)
              ->wherePivot('deleted_at', null);
        }]);

        foreach ($this->selectedGrupoView->participantes as $participante) {
            $participante->full_name = trim("{$participante->primer_nombre} {$participante->segundo_nombre} {$participante->tercer_nombre} {$participante->primer_apellido} {$participante->segundo_apellido} {$participante->tercer_apellido}");
            $participante->edad = \Carbon\Carbon::parse($participante->fecha_nacimiento)->age;
        }

        $this->nombre = $this->selectedGrupoView->nombre;

        $this->descripcion = $this->selectedGrupoView->descripcion;

        $this->openDrawerView = true;

        $this->addList();

        $this->allparticipantes = $this->getRestOfList();

      //  dump($this->getRestOfList());
    }

    public function removeFromGroup($id)
    {
        BancarizacionGrupoParticipante::destroy($id);

        $this->dispatch('removeParticipanteFromGroup', ['id' => $id]);

        //$this->openDrawerView = false;
    }

    public function deleteGroup($id)
    {
        $grupo = \App\Models\BancarizacionGrupo::with('participantes')->where('id', $id)->first();

        $grupo->participantes()->each(function ($participante) {
            $participante->pivot->delete();
        });

        $grupo->delete();

        $this->dispatch('update-financierons-grupos-cards');

        $this->deleteGrupoIndicator = true;

    }


    public function getRestOfList()
    {
        $socioImplementadorId = auth()->user()->socio_implementador_id;

        $query = \App\Models\Participante::whereHas('cohortePaisProyecto', function ($query) {
            $query->where('cohorte_pais_proyecto.id', $this->cohortePaisProyecto->id)
                ->whereNotNull('cohorte_participante_proyecto.active_at');
        })
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
            })
            ->whereHas('gestor', function ($q) use ($socioImplementadorId) {
                $q->where('socio_implementador_id', $socioImplementadorId);
            })

            ->with([
                'creator',
                'lastEstado.estado_registro',
                'ciudad.departamento',
                'cohortePaisProyecto',
                "bancarizacionGrupos:id,nombre,cohorte_pais_proyecto_id,monto",
                "cohortePaisProyectoPerfiles:id,cohorte_pais_proyecto_id,perfil_participante_id",
                "cohortePaisProyectoPerfiles.perfilesParticipante:id,nombre",
                "gestor"
            ])
            ->leftJoin('users', 'participantes.gestor_id', '=', 'users.id')
            ->leftJoin('ciudades', 'participantes.ciudad_id', '=', 'ciudades.id')
            ->whereIn("gestor_id", $this->getMisGestores())
            ->whereNotIn('participantes.id', $this->selectedParticipanteIds)
            ->select([
                "participantes.id",
                "participantes.slug",
                "participantes.email",
                "primer_nombre",
                "segundo_nombre",
                "tercer_nombre",
                "primer_apellido",
                "segundo_apellido",
                "tercer_apellido",
                "ciudad_id",
                "participantes.created_by",
                "participantes.created_at",
                "documento_identidad",
                "fecha_nacimiento",
                "sexo",
                "gestor_id",
                "users.name as nombre_gestor",
                "ciudades.nombre as nombre_ciudad",
            ])
            ->get();

            return $query;


    }


    public function getlistagrupos()
    {
       return $this->listagrupos = BancarizacionGrupo::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->whereNotNull('active_at')
                ->where('created_by', auth()->id())
                ->withCount(['participantes' => function ($query) {
                    $query->where('bancarizacion_grupo_participantes.active_at', '!=', null)
                        ->where('bancarizacion_grupo_participantes.deleted_at', null);
                }])
                ->get(['id', 'nombre', 'participantes_count', 'monto']);

    }

    public function moverAGrupo()
    {

        $this->validate();

        $participantesProyectoCohorte = \App\Models\CohorteParticipanteProyecto::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->whereIn('participante_id', $this->selectedParticipanteIds)
            ->pluck("id")
            ->toArray();

        DB::transaction(function () use ($participantesProyectoCohorte) {

            //Delete all previous grupos assignments where group is not the grupo destino
            BancarizacionGrupoParticipante::whereIn('participante_id', $participantesProyectoCohorte)
                            ->where('bancarizacion_grupo_id', '!=', $this->grupodestino)
                            ->delete();

            foreach ($participantesProyectoCohorte as $participanteId) {
                BancarizacionGrupoParticipante::firstOrCreate([
                    'bancarizacion_grupo_id' => $this->grupodestino,
                    'participante_id' => $participanteId,
                ], [
                    'active_at' => now(),
                ]);
            }

        });


        $this->reset('grupodestino',  'selectedParticipanteIds', 'openDrawerMover', 'titulo', 'mensaje');

        $this->dispatch('update-financierons-grupos-cards');

        $this->showSuccessIndicator = true;

        sleep(1);

        $this->reset('lista');

    }
}
