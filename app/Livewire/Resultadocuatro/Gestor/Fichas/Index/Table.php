<?php

namespace App\Livewire\Resultadocuatro\Gestor\Fichas\Index;

use Livewire\WithPagination;
use App\Models\Participante;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Sortable;
use App\Livewire\Resultadouno\Coordinador\Participante\Index\Searchable;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\Table AS TableGrupos;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\GrupoTrait;
use App\Models\SocioImplementador;

class Table extends TableGrupos
{
    use WithPagination, Sortable, Searchable, GrupoTrait;

    //$this->reset('selectedParticipanteIds', 'lista', 'historial', 'modo', 'selectedRazon', 'selectedEstado', 'selectedCategoria', 'comentario');

    public $socios;

    public function render()
    {
        $query = Participante::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'lastEstado.estado_registro:id,nombre,color,icon',
            'grupoactivo.lastEstadoParticipante.estado',
            'grupoactivo.grupo',
            'cohortePaisProyecto',
            'gestor',
        ])
        ->whereHas('lastEstado', function ($q) {
            $q->where('estado_registro_id', \App\Models\EstadoRegistro::VALIDADO);
        })
        ->when(auth()->user()->can('Ver mis participantes R4'), function ($query) {
            ///dd('Ver mis participantes R4');
            $query->misRegistros();
        })
        ->when(auth()->user()->can('Ver participantes mi socio implementador R4'), function ($query) {
            $query->whereHas('gestor', function ($q) {
                $q->where('socio_implementador_id', auth()->user()->socio_implementador_id);
            });
        })
        ->when(auth()->user()->can('Ver participantes mi pais R4'), function ($query) {
            $query->whereHas('gestor.socioImplementador', function ($q) {
                $q->where('pais_id', auth()->user()->socioImplementador->pais_id);
            });
        })

            ->whereHas('cohortePaisProyecto', function ($q) {
                $q->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
            })
            ->select([
                "id",
                "slug",
                "email",
                "primer_nombre",
                "segundo_nombre",
                "tercer_nombre",
                "primer_apellido",
                "segundo_apellido",
                "tercer_apellido",
                "ciudad_id",
                "created_at",
                "documento_identidad",
                "fecha_nacimiento",
                "sexo",
                "gestor_id"
            ]);

        $query = $this->applySearch($query);

        $query = $this->applySorting($query);

        $query = $this->filters->apply($query);

        $participantes = $query->paginate($this->perPage);

        $this->participanteIdsOnPage = $participantes->map(fn($participante) => (string) $participante->id)->toArray();


        return view('livewire.resultadocuatro.gestor.fichas.index.table', [
            'participantes' => $participantes,
            'cohorteId' => $this->cohorte->id,
            'cohortePaisProyecto' => $this->cohortePaisProyecto,
            'paisProyectoId' => $this->paisProyecto->id,
        ]);
    }

    public function deleteSelected()
    {
        Participante::whereIn('id', $this->selectedParticipanteIds)->each(function ($participante) {
            $this->delete($participante);
        });

        $this->selectedParticipanteIds = [];

        $this->showSuccessIndicator = true;
    }

    public function delete(Participante $participante)
    {
        $participante->delete();

        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-component');
    }
}
