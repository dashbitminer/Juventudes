<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Estados;

use Livewire\Component;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\Participante;
use App\Models\EstadoParticipante;
use App\Models\Estado;
use App\Models\Razon;
use App\Models\Categoria;
use App\Models\CohortePaisProyecto;
use App\Models\PaisProyecto;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\GrupoTrait;

class Page extends Component
{
    use GrupoTrait;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public Participante $participante;

    public CohortePaisProyecto $cohortePaisProyecto;

    public PaisProyecto $paisProyecto;

    public $openDrawer = false;

    public $openDrawerEdit = false;

    public $showSuccessIndicator = false;

    public EstadoParticipante $estadoParticipante;

    public $comentario;

    public $estados;
    public $selectedEstado;

    public $categorias;
    public $selectedCategoria;

    public $razones;
    public $selectedRazon;

    public $fechaCambioEstado;

    public $resultado;

    public function mount()
    {
        $this->estados = Estado::active()->pluck("nombre", "id");
        $this->categorias = collect([]);

        $this->paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->firstOrFail();

        $this->cohortePaisProyecto = \App\Models\CohortePaisProyecto::with('perfilesParticipante:id,nombre')
            ->where('pais_proyecto_id', $this->paisProyecto->id)
            ->where('cohorte_id', $this->cohorte->id)
            ->firstOrFail();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->resultado = 1;

        return view('livewire.resultadouno.gestor.participante.estados.page')
            ->layoutData([
                'cohorte' => $this->cohorte,
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'resultadouno' => true,
            ]);
    }

    #[On('openEdit')]
    public function openEdit($id) {
        $this->estadoParticipante = EstadoParticipante::with('razon.categoriaRazon')->find($id);

        if ($this->estadoParticipante instanceof EstadoParticipante) {
            $this->clearValidation();

            $this->updatedSelectedEstado($this->estadoParticipante->estado_id);

            if ($this->estadoParticipante->razon instanceof Razon) {
                $this->updatedSelectedCategoria($this->estadoParticipante->razon->categoriaRazon->id);
                $this->selectedCategoria = $this->estadoParticipante->razon->categoriaRazon->id;
            }

            $this->selectedEstado = $this->estadoParticipante->estado_id;
            $this->fechaCambioEstado = $this->estadoParticipante->fecha;
            $this->selectedRazon = $this->estadoParticipante->razon_id;
            $this->comentario = $this->estadoParticipante->comentario;

            $this->openDrawerEdit = true;
        }
    }

    public function rules()
    {
        return [
            'selectedRazon' => Rule::requiredIf(function ()  {
                return in_array($this->selectedEstado, [Estado::REINGRESO, Estado::DESERTADO, Estado::PAUSADO]);
            }),
            'fechaCambioEstado' => [
                'required',
                'after_or_equal:' . $this->cohortePaisProyecto->fecha_inicio,
                'before_or_equal:' . $this->cohortePaisProyecto->fecha_fin,
            ],
            'selectedEstado' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'selectedEstado.required' => 'El estado es obligatorio.',
            'selectedRazon.required' => 'La razon es obligatoria.',
            'fechaCambioEstado.required' => 'La fecha de cambio de estado es obligatoria.',
            'fechaCambioEstado.after_or_equal' => 'La fecha de cambio de estado debe ser igual o posterior a la fecha de inicio de la cohorte.',
            'fechaCambioEstado.before_or_equal' => 'La fecha de cambio de estado debe ser igual o anterior a la fecha de finalización de la cohorte.',
        ];
    }

    public function editRole()
    {
        $this->validate();

        $this->estadoParticipante->estado_id = $this->selectedEstado;
        $this->estadoParticipante->razon_id = $this->selectedRazon;
        $this->estadoParticipante->fecha = $this->fechaCambioEstado;
        $this->estadoParticipante->comentario = $this->comentario;
        $this->estadoParticipante->save();

        $this->reset(['selectedEstado', 'selectedRazon', 'selectedCategoria', 'fechaCambioEstado', 'comentario']);

        $this->openDrawerEdit = false;
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-participante-estados');
    }
}
