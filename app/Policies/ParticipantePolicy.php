<?php

namespace App\Policies;

use App\Models\CohorteParticipanteProyecto;
use App\Models\CoordinadorGestor;
use App\Models\Participante;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ParticipantePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Participante $participante)
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if ($user->hasRole('Gestor')) {
            // if ($user->id === $participante->created_by) {
            //     return Response::allow();
            // }

            if ($user->id === $participante->gestor_id) {
                return Response::allow();
            }
        }

        if ($user->hasRole('Coordinador')) {


            $getProyecto = CohorteParticipanteProyecto::where('participante_id', $participante->id)->first();
            //dd($getProyecto);

            $coordinadores = $this->getMisCoordinadores($participante->gestor_id, $getProyecto->cohorte_pais_proyecto_id);

//            dd($coordinadores, auth()->id());

            if (in_array(auth()->id(), $coordinadores)) {
                return Response::allow();
            }
        }

        return Response::deny('No estas autorizado a ver este participante.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Participante $participante)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Participante $participante)
    {
         // if ($user->hasRole('admin')) {
        //     return Response::allow();
        // }

        // if ($user->id === $participante->created_by) {
        //     return Response::allow();
        // }

        if ($user->id === $participante->gestor_id) {
            return Response::allow();
        }

        return Response::deny('No estas autorizado a eliminar este participante.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Participante $participante)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Participante $participante)
    {
        //
    }


    public function getMisCoordinadores($gestorId, $cohortePaisProyectoId)
    {

        //dd($cohortePaisProyectoId, $gestorId);

        $miUsuarioGestor = \App\Models\CohorteProyectoUser::where('cohorte_pais_proyecto_id', $cohortePaisProyectoId)
                                ->where('user_id', $gestorId)
                                //->where('rol', 'gestor')
                                ->first();


        $coordinadores = \App\Models\CoordinadorGestor::join('cohorte_proyecto_user', 'coordinador_gestores.coordinador_id', '=', 'cohorte_proyecto_user.id')
                                ->where('gestor_id', $miUsuarioGestor->id)
                                ->where('cohorte_proyecto_user.rol', 'coordinador')
                              //  ->where('cohorte_proyecto_user.cohorte_pais_proyecto_id', $cohortePaisProyectoId)
                                ->pluck('cohorte_proyecto_user.user_id');

        return $coordinadores->unique()->toArray();
    }

}
