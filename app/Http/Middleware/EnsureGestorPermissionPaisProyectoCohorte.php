<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\PaisProyecto;
use Illuminate\Http\Request;
use App\Models\CohorteProyectoUser;
use App\Models\CohortesPaisProyecto;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureGestorPermissionPaisProyectoCohorte
{
    public function handle(Request $request, Closure $next): Response
    {
        //dd(auth()->user()->getRoleNames());
        if (Auth::check() && auth()->user()->hasAnyRole(['Admin', 'Staff', 'MECLA'])) {

            return $next($request);

        }


        if (!$request->pais || !$request->proyecto || !$request->cohorte) {

            return $next($request);
        }

        $paisProyecto = PaisProyecto::where('pais_id', $request->pais->id)
            ->where('proyecto_id', $request->proyecto->id)
            ->firstOrFail();


        $cohortePaisProyecto = \App\Models\CohortePaisProyecto::where('pais_proyecto_id', $paisProyecto->id)
            ->where('cohorte_id', $request->cohorte->id)
            ->firstOrFail();


        $hasPermission = CohorteProyectoUser::where('user_id', auth()->id())
            ->where('cohorte_pais_proyecto_id', $cohortePaisProyecto->id)
            ->exists();

        if (!$hasPermission) {
            abort(404);
        }

        return $next($request);
    }
}
