<?php

namespace App\Livewire\Resultadouno\Coordinador\Participante\Forms;

use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\Participante;
use App\Models\EstadoRegistro;
use App\Models\Socioeconomico;
use Livewire\Attributes\Validate;
use App\Models\EstadoRegistroParticipante;

class Comentario extends Component
{

    public Participante $participante;

    public Socioeconomico $socioeconomico;

    public Cohorte $cohorte;

    public Proyecto $proyecto;

    public Pais $pais;

    #[Validate('required', message: 'El campo estado es requerido')]
    public $estadoId;

    public $comentario;

    public $readonlyParticipante;

    public $readonlySocioeconomico;

    public $enableReadonlyRadios = false;

    public $showSuccessIndicator = false;

    public function mount()
    {
        $this->socioeconomico = Socioeconomico::where('participante_id', $this->participante->id)
            ->first();

        $ultimoEstado = $this->participante->lastEstado->estado_registro->slug;
        $this->enableReadonlyRadios = $ultimoEstado === 'validado';

        $this->readonlyParticipante = $this->participante->readonly_by === null;
        $this->readonlySocioeconomico = $this->socioeconomico->readonly_by === null;
    }

    public function render()
    {
        // $estados = EstadoRegistro::where('id', '!=', EstadoRegistro::PENDIENTE_REVISION)
        //     ->pluck('nombre', 'id');
        $estados = EstadoRegistro::whereNotIn('id', [EstadoRegistro::PENDIENTE_REVISION, EstadoRegistro::DOCUMENTACION_PENDIENTE])
            ->pluck('nombre', 'id');

        return view('livewire.resultadouno.coordinador.participante.forms.comentario', [
            'estados' => $estados,
        ]);
    }

    public function save()
    {
        $this->validateOnly('estadoId');

        $created = [
            'participante_id' => $this->participante->id,
            'estado_registro_id' => $this->estadoId,
        ];

        if (!empty($this->comentario)) {
            $created['comentario'] = $this->comentario;
        }

        //sleep(1);

        EstadoRegistroParticipante::create($created);

        // Comprueba el estado del formulario para deshabilitar ambos formulario
        if ($this->estadoId == EstadoRegistro::VALIDADO) {
            $this->toggleReadonlyParticipante(true);
            $this->toggleReadonlySocioeconomico(true);

            $this->enableReadonlyRadios = true;
        } else {
            $this->toggleReadonlyParticipante(false);
            $this->toggleReadonlySocioeconomico(false);

            $this->enableReadonlyRadios = false;
        }

        $this->reset('estadoId', 'comentario');
        $this->showSuccessIndicator = true;
        $this->dispatch('refresh-estadoregistro');

        sleep(4);

        return redirect()->route('participantes', [
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
        ]);


    }

    public function toggleReadonlyParticipante(bool $toggle)
    {
        if ($toggle) {
            $this->participante->readonly_at = now();
            $this->participante->readonly_by = auth()->id();
        } else {
            $this->participante->readonly_at = null;
            $this->participante->readonly_by = null;
        }

        $this->participante->save();
        $this->readonlyParticipante = $this->participante->readonly_by === null;
        $this->showSuccessIndicator = true;
    }

    public function toggleReadonlySocioeconomico(bool $toggle)
    {
        if ($toggle) {
            $this->socioeconomico->readonly_at = now();
            $this->socioeconomico->readonly_by = auth()->id();
        } else {
            $this->socioeconomico->readonly_at = null;
            $this->socioeconomico->readonly_by = null;
        }

        $this->socioeconomico->save();
        $this->readonlySocioeconomico = $this->socioeconomico->readonly_by === null;
        $this->showSuccessIndicator = true;
    }
}
