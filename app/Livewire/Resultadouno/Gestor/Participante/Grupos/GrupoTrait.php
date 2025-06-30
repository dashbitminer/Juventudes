<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos;

use App\Models\Razon;
use App\Models\Estado;
use App\Models\Participante;
use App\Models\CategoriaRazon;
use App\Models\CohorteParticipanteProyecto;
use App\Models\GrupoParticipante;
use Database\Seeders\CohorteParticipanteSeeder;
use Illuminate\Support\Facades\DB;


trait GrupoTrait
{

    public function selectParticipanteListaEstados($participanteId)
    {
        $this->reset('selectedParticipanteIds', 'lista', 'historial', 'modo', 'selectedRazon', 'selectedEstado', 'selectedCategoria', 'comentario', 'fechaCambioEstado');

        $this->modo = "lista_estados";

        $this->selectedParticipanteIds = [$participanteId];

        $this->addList();

        $participante = $this->lista->first();

        if (!empty($participante->grupoactivo)) {

            $this->historial = $participante->grupoactivo->estado;

            $this->comentario = $participante->grupoactivo->lastEstadoParticipante->comentario;

            $this->selectedEstado = $participante->grupoactivo->lastEstadoParticipante->estado_id;

            $this->updatedSelectedEstado($this->selectedEstado);

            if($participante->grupoactivo->lastEstadoParticipante->fecha){
                $this->fechaCambioEstado = \Carbon\Carbon::parse($participante->grupoactivo->lastEstadoParticipante->fecha)->format('M d, Y');
            }else{
                $this->fechaCambioEstado = 'No disponible';
            }


            if ($participante->grupoactivo->lastEstadoParticipante->razon_id) {

                $this->selectedRazon = $participante->grupoactivo->lastEstadoParticipante->razon_id;

                $razon = Razon::find($this->selectedRazon);

                $this->selectedCategoria = $razon->categoria_razon_id;

                if (empty($this->razones)) {

                    $this->updatedSelectedCategoria($this->selectedCategoria);
                }
            }
        }

        // dd($this->selectedEstado, $this->selectedRazon, $this->selectedCategoria);

        $this->openDrawerListaEstados = true;
    }

    public function closeLIstaEstados()
    {
        $this->openDrawerListaEstados = false;
        $this->reset('selectedParticipanteIds', 'lista', 'historial', 'modo', 'selectedRazon', 'selectedEstado', 'selectedCategoria', 'comentario');
    }

    public function selectParticipanteCambioEstado($participanteId)
    {
        $this->reset('selectedParticipanteIds', 'lista', 'historial', 'modo', 'selectedRazon', 'selectedEstado', 'selectedCategoria', 'comentario');

        $this->modo = "estado";

        $this->selectedParticipanteIds = [$participanteId];

        $this->addList();

        $this->openDrawerEstado = true;
    }

    public function addList()
    {
        $this->lista = Participante::whereIn('id', $this->selectedParticipanteIds)
            ->with(
                'grupoactivo.lastEstadoParticipante.estado',
                'grupoactivo.grupo',
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


    public function updatedSelectedEstado($value)
    {
        $this->categorias = [];
        $this->razones = [];

        if ($value == Estado::PAUSADO) {
            $this->categorias = CategoriaRazon::where('tipo', 2)->pluck('nombre', 'id');
        } elseif ($value == Estado::DESERTADO) {
            $this->categorias = CategoriaRazon::where('tipo', 1)->pluck('nombre', 'id');
        } elseif ($value == Estado::REINGRESO) {
            $this->razones = Razon::where("categoria_razon_id", CategoriaRazon::CATEGORIA_REINGRESO)->pluck('nombre', 'id');
        } else {
            $this->categorias = [];
        }
    }

    public function updatedSelectedCategoria($value)
    {
        $this->selectedRazon = null;
        $this->razones = Razon::where("categoria_razon_id", $value)->pluck('nombre', 'id');
    }

    public function cambiarEstadoParticipante()
    {

        $this->validate();

        DB::transaction(function () {

            $participantesProyectoCohorte = \App\Models\CohorteParticipanteProyecto::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->whereIn('participante_id', $this->selectedParticipanteIds)
                ->pluck("id")
                ->toArray();

            // 2. Creo el nuevo grupo
            foreach ($participantesProyectoCohorte as $participanteId) {
                $participanteEnGrupo = GrupoParticipante::where('cohorte_participante_proyecto_id', $participanteId)
                    ->where('user_id', auth()->id())
                    ->whereNotNull('active_at')
                    ->first();
            //dd($this->fechaCambioEstado);
                //3. Agrego el estado activo
                $participanteEnGrupo->estado()->attach($this->selectedEstado, [
                    'active_at' => now(),
                    'comentario' => $this->comentario,
                    'fecha' => $this->fechaCambioEstado,
                    'razon_id' => $this->selectedRazon,
                ]);
            }
        });

        $this->filters->resetSelectedEstadosIds();

        //$this->filters->resetSelectedEstadosParticipantesIds();

        $this->showSuccessIndicator = true;

        $this->reset('nombre', 'descripcion', 'selectedParticipanteIds', 'lista', 'openDrawerEstado', 'modo', 'selectedRazon', 'selectedEstado', 'comentario', 'fechaCambioEstado', 'categorias', 'razones');



        // if (!in_array($this->selectedEstado, $this->filters->selectedEstadosParticipanteIds)) {
        //     $this->filters->selectedEstadosParticipanteIds[] = $this->selectedEstado;

        // }
        // dump($this->filters->selectedEstadosParticipanteIds);
        $this->filters->selectedEstadosParticipanteIds = Estado::active()->pluck('id')->toArray();
        array_push($this->filters->selectedEstadosParticipanteIds, 0);
    }


    public function crearGrupo()
    {

        $this->validate();

        DB::transaction(function () {

            //1 Get Cohorte Participante Proyecto Record
            $participantesProyectoCohorte = \App\Models\CohorteParticipanteProyecto::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->whereIn('participante_id', $this->selectedParticipanteIds)
                ->pluck("id")
                ->toArray();


            //2. Pongo cualquier otro grupo del mismo cohorte-pais-proyecto como NULL o inactivo
            GrupoParticipante::whereIn('cohorte_participante_proyecto_id', $participantesProyectoCohorte)
                //->where('cohorte_participante_proyecto_id', $this->cohortePaisProyecto->id)
                ->where('user_id', auth()->id())
                ->update(['active_at' => NULL]);

            // 2. Creo el nuevo grupo
            foreach ($participantesProyectoCohorte as $participanteId) {
                $participanteEnGrupo = GrupoParticipante::create([
                    'grupo_id' => $this->nextGroup->id,
                    'cohorte_participante_proyecto_id' => $participanteId,
                    'cohorte_pais_proyecto_perfil_id' => $this->perfilSelected ?? null,
                    'user_id' => auth()->id(),
                    'active_at' => now(),
                ]);

                //3. Agrego el estado activo
                $participanteEnGrupo->estado()->attach(Estado::ACTIVO, [
                    'active_at' => now(),
                ]);
            }
        });

        $this->openDrawer = FALSE;

        $this->selectedParticipanteIds = [];

        $this->filters->resetSelectedEstadosIds();

        $this->dispatch('update-grupos-cards');

        $this->showSuccessIndicator = true;

        $this->reset('nombre', 'descripcion');

        sleep(1);

        $this->reset('lista');
    }

    public function moverAGrupo()
    {

        $this->validate();

        DB::transaction(function () {

            //1 Get Cohorte Participante Proyecto Record
            $participantesProyectoCohorte = \App\Models\CohorteParticipanteProyecto::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                ->whereIn('participante_id', $this->selectedParticipanteIds)
                ->pluck("id")
                ->toArray();

            //2. Pongo cualquier otro grupo del mismo cohorte-pais-proyecto como NULL o inactivo
            GrupoParticipante::whereIn('cohorte_participante_proyecto_id', $participantesProyectoCohorte)
                //->where('cohorte_participante_proyecto_id', $this->cohortePaisProyecto->id)
                ->where('user_id', auth()->id())
                ->update(['active_at' => NULL]);


            foreach ($participantesProyectoCohorte as $participanteId) {

                $participanteEnGrupo = GrupoParticipante::create([
                    'grupo_id' => $this->nuevogrupo,
                    'cohorte_participante_proyecto_id' => $participanteId,
                    'cohorte_pais_proyecto_perfil_id' => $this->perfilSelected ?? null,
                    'user_id' => auth()->id(),
                    'active_at' => now(),
                ]);

                //3. Agrego el estado activo
                $participanteEnGrupo->estado()->attach(Estado::ACTIVO, [
                    'active_at' => now(),
                ]);
            }
        });

        $this->openDrawerMover = FALSE;

        $this->filters->resetSelectedEstadosIds();

        $this->dispatch('update-grupos-cards');

        sleep(1);

        $this->showSuccessIndicator = true;

        $this->reset('nombre', 'descripcion', 'selectedParticipanteIds', 'lista', 'modo');
    }

    public function removerGrupo(GrupoParticipante $grupoParticipante)
    {
        if (!empty($grupoParticipante) && !empty($this->cohortePaisProyecto)) {

            GrupoParticipante::with('cohorteParticipanteProyecto')
                ->whereHas('cohorteParticipanteProyecto', function ($query) {
                    $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
                })
                ->where('grupo_id', $grupoParticipante->grupo_id)
                ->where('user_id', $grupoParticipante->user_id)
                ->delete();

            $this->dispatch('update-grupos-cards');
            $this->dispatch('update-grupos-participantes');

        }
    }

    public function openModalEditar()
    {
        if (!empty($this->grupoParticipante) && !empty($this->cohortePaisProyecto)) {
            
            $selectedParticipanteIds = [];

            $grupoParticipantes = GrupoParticipante::with('cohorteParticipanteProyecto')
                ->whereHas('cohorteParticipanteProyecto', function ($query) {
                    $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
                })
                ->where('grupo_id', $this->grupoParticipante->grupo_id)
                ->where('user_id', $this->grupoParticipante->user_id)
                ->get();

            
            foreach ($grupoParticipantes as $cohorteParticipanteProyecto) {
                $selectedParticipanteIds[] = $cohorteParticipanteProyecto->cohorteParticipanteProyecto->participante_id;
            }

            $this->selectedParticipanteIds = $selectedParticipanteIds;

            $this->modo = "editar";

            $this->addList();

            $this->openDrawerEditar = true;

        }
    }

    public function editarGrupo()
    {
        if (!empty($this->grupoParticipante) && !empty($this->cohortePaisProyecto)) {

            $grupoParticipantes = GrupoParticipante::with('cohorteParticipanteProyecto')
                ->whereHas('cohorteParticipanteProyecto', function ($query) {
                    $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                        ->whereIn('participante_id', $this->selectedParticipanteIds);
                })
                ->where('grupo_id', $this->grupoParticipante->grupo_id)
                ->where('user_id', $this->grupoParticipante->user_id)
                ->get();

            foreach ($grupoParticipantes as $grupoParticipante) {
                $grupoParticipante->update([
                    'grupo_id' => $this->nuevogrupo,
                    'cohorte_pais_proyecto_perfil_id' => $this->perfilSelected,
                ]);
            }

            $this->openDrawerEditar = false;

            $this->filters->resetSelectedEstadosIds();

            $this->dispatch('update-grupos-cards');
            $this->dispatch('update-grupos-participantes');

            sleep(1);

            $this->showSuccessIndicator = true;

            $this->reset('nuevogrupo', 'perfilSelected', 'selectedParticipanteIds', 'lista', 'modo', 'grupoParticipante');

        }
    }



    public function selectParticipanteMover($participanteId)
    {

        $this->modo = "mover";

        $this->selectedParticipanteIds = [$participanteId];

        $this->previewSelectedMover();

        $this->openDrawerMover = true;
    }

    public function previewSelectedMover()
    {
        $this->addList();

        $this->openDrawerMover = true;
    }
}
