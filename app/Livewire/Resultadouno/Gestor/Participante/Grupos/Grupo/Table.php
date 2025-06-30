<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos\Grupo;

use Livewire\Component;
use App\Models\Participante;
use App\Models\EstadoRegistro;
use App\Models\Grupo;
use App\Models\CohortePaisProyecto;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\Table as TableGroup;
use App\Livewire\Resultadouno\Coordinador\Participante\Index\Searchable;

/**
 * Extiende de Grupos pero filtra por Grupo.
 */
class Table extends TableGroup
{

    use Searchable;

    public CohortePaisProyecto $cohortePaisProyecto;

    public Grupo $grupo;

    public function render()
    {
        $this->nextGroup = $this->getNextrGroup();

        $query = Participante::with([
            'ciudad:id,nombre,departamento_id',
            'ciudad.departamento:id,nombre,pais_id',
            'lastEstado.estado_registro:id,nombre,color,icon',
            'grupoactivo.lastEstadoParticipante.estado',
            'grupoactivo.grupo',
            //"grupoParticipante.lastEstadoParticipante.estado",
        ])->whereHas('cohortePaisProyecto', function($query) {
            $query->where('cohorte_pais_proyecto.id', $this->cohortePaisProyecto->id)
                ->whereNotNull('cohorte_participante_proyecto.active_at');
        })
            ->misRegistros()
            ->whereHas('lastEstado', function ($q) {
                $q->where('estado_registro_participante.estado_registro_id', EstadoRegistro::VALIDADO);
            })
            ->whereHas('grupoactivo', function ($subquery) {
                $subquery->where('grupo_participante.grupo_id', $this->grupo->id)
                  ->whereNotNull('grupo_participante.active_at')
                  ->where('grupo_participante.user_id', auth()->user()->id);
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
            ]);

        $query = $this->applySearch($query);
        $query = $this->applySorting($query);
        $query = $this->filters->apply($query);
        $participantes = $query->paginate($this->perPage);

        $this->participanteIdsOnPage = $participantes->map(fn($participante) => (string) $participante->id)->toArray();

        return view('livewire.resultadouno.gestor.participante.grupos.grupo.table', [
            'participantes' => $participantes,
            'cohorteId' => $this->cohorte->id,
            //'cohortePaisProyecto' => $this->cohortePaisProyecto,
            'paisProyectoId' => $this->paisProyecto->id,
            //'participantesSinGrupo' => $this->participantesSinGrupo ?? 0,
        ]);
    }

}
