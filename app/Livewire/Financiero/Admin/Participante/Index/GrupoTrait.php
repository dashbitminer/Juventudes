<?php

namespace App\Livewire\Financiero\Admin\Participante\Index;


use App\Models\Participante;
use Illuminate\Support\Facades\DB;


trait GrupoTrait
{


    public function addList()
    {
        $this->lista = \App\Models\BancarizacionGrupo::whereIn('id', $this->selectedParticipanteIds)
            ->with('user:id,name,socio_implementador_id', 'user.socioImplementador:id,nombre', 'creator:id,name')
            ->withCount('participantes')
            ->get();
        // dd($this->lista);
    }

    public function addParticipanteList()
    {
        $this->lista = \App\Models\Participante::whereIn('id', $this->selectedParticipanteIds)
            ->with([
                'gestor:id,name,socio_implementador_id',
                'gestor.socioImplementador:id,nombre',
                'creator:id,name',
                'bancarizacionGrupos'
            ])
            ->get();
        // dd($this->lista);
    }

    public function removeList($id)
    {

        $this->lista = $this->lista->filter(function ($grupo) use ($id) {
            return $grupo->id != $id;
        });


        // Remove from selectedParticipanteIds array and reindex keys
        $this->selectedParticipanteIds = array_values(array_filter($this->selectedParticipanteIds, function ($value) use ($id) {
            return $value != $id;
        }));
    }

    public function editarGrupo()
    {

        $this->validate();

        //selectedParticipanteIds is an array of ids of the SELECTED GROUPS not Participantes
        \App\Models\BancarizacionGrupo::whereIn('id', $this->selectedParticipanteIds)
            ->update(['monto' => $this->monto]);

        if ($this->sobreescribir) {
            \App\Models\BancarizacionGrupoParticipante::whereIn('bancarizacion_grupo_id', $this->selectedParticipanteIds)
                ->update(['monto' => $this->monto]);
        }

        $this->showSuccessIndicator = true;

        $this->reset('monto', 'selectedParticipanteIds', 'openEditDrawer');

        sleep(2);

        $this->reset('lista');

        $this->dispatch('actualizar-monto-grupos');
    }

    public function editarParticipante()
    {

        //dd($this->selectedParticipanteIds);

        $this->validate();

        \App\Models\BancarizacionGrupoParticipante::whereIn('participante_id', $this->selectedParticipanteIds)
            ->update(['monto' => $this->monto]);


        $this->showSuccessIndicator = true;

        $this->reset('monto', 'selectedParticipanteIds', 'openEditDrawer');

        sleep(2);

        $this->reset('lista');

        $this->dispatch('actualizar-monto-grupos');

        // //selectedParticipanteIds is an array of ids of the SELECTED GROUPS not Participantes
        // \App\Models\BancarizacionGrupo::whereIn('id', $this->selectedParticipanteIds)
        //     ->update(['monto' => $this->monto]);

        // if ($this->sobreescribir) {
        //     \App\Models\BancarizacionGrupoParticipante::whereIn('bancarizacion_grupo_id', $this->selectedParticipanteIds)
        //         ->update(['monto' => $this->monto]);
        // }

        // $this->showSuccessIndicator = true;

        // $this->reset('monto', 'selectedParticipanteIds', 'openEditDrawer');

        // sleep(2);

        // $this->reset('lista');

        // $this->dispatch('actualizar-monto-grupos');
    }
}
