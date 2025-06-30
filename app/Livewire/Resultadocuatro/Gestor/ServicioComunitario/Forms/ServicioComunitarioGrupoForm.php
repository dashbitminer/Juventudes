<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Forms;

use App\Models\Pais;
use App\Models\Participante;
use App\Models\ServicioComunitario;
use App\Models\ServicioComunitarioParticipante;
use Livewire\Form;

class ServicioComunitarioGrupoForm extends Form
{
    public $pais;

    public $participantes = [];

    public $participantesIncluidos = [];

    public $participantesIncluidosList = [];

    public $grupo;

    public $grupoSelected; 

    public ServicioComunitario $servicioComunitario;

    
    public $readonly = false;

    public function setPais(Pais $pais) {
        $this->pais = $pais;
    }

    public function setParticipantes($grupo)
    {
        $this->grupoSelected = $grupo;

        $this->participantes = Participante::with([
            'grupoactivo',
            "grupoParticipante.lastEstadoParticipante.estado",
            ])
           ->misRegistros()
            ->whereHas('grupoactivo', function ($q) {
                $q->where('grupo_participante.grupo_id', $this->grupoSelected)
                  ->whereNotNull('grupo_participante.active_at')
                  ->where('grupo_participante.user_id', auth()->user()->id);
            })
            ->whereNotIn('id', $this->participantesIncluidosList)
            ->get();
    }

    public function setParticipantesIncluidos()
    {
        $this->participantesIncluidosList = \DB::table('sc_participantes')
            ->where('servicio_comunitario_id', $this->servicioComunitario->id)
            ->pluck('participante_id')
            ->toArray();

        $this->participantesIncluidos =  Participante::with([
            "grupoParticipante.lastEstadoParticipante.estado:id,nombre" 
        ])
        ->whereIn('id', $this->participantesIncluidosList)
        ->get();
    }

    public function deleteParticipante($participante_id){
        $servicioComunitarioParticipante = ServicioComunitarioParticipante::where('servicio_comunitario_id', $this->servicioComunitario->id )
        ->where('participante_id', $participante_id)
        ->first();


        if ($servicioComunitarioParticipante) {
            $servicioComunitarioParticipante->delete();
        }
    }

    public function init()
    {
        $this->participantes = [];
        $this->participantesIncluidos = [];
    }

    public function save($participantes)
    {
        foreach($participantes as $participante){
            ServicioComunitarioParticipante::firstOrCreate(
                [
                    'participante_id' => $participante,
                    'grupo_participante_id' => $this->grupo,
                    'servicio_comunitario_id' => $this->servicioComunitario->id,
                ]
            );
        }
    }
}