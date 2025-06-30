<?php

namespace App\Livewire\Financiero\Coordinador\Participante\Index;

trait CoordinadorTrait
{
    public function getMisGestores()
    {
        $miUsuarioCoordinador = \App\Models\CohorteProyectoUser::where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                                ->where('user_id', auth()->id())
                                ->where('rol', 'coordinador')
                                ->first();


        $gestores = \App\Models\CoordinadorGestor::join('cohorte_proyecto_user', 'coordinador_gestores.gestor_id', '=', 'cohorte_proyecto_user.id')
                                ->where('coordinador_id', $miUsuarioCoordinador->id)
                                ->where('cohorte_proyecto_user.cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                                ->pluck('cohorte_proyecto_user.user_id');

        return $gestores->unique()->toArray();
    }
}
