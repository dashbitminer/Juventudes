<?php

namespace App\Livewire\Resultadouno\Coordinador\Participante\EstadoRegistro;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Participante;
use App\Models\EstadoRegistroParticipante;

class Index extends Component
{

    public Participante $participante;

    #[On('refresh-estadoregistro')]
    public function render()
    {
        $estados = EstadoRegistroParticipante::with([
            'estado_registro:id,nombre,color,icon',
            'coordinador:id,name,email'
            ])
            ->where('participante_id', $this->participante->id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('livewire.resultadouno.coordinador.participante.estado-registro.index', [
            'estados' => $estados,
        ]);
    }
}
