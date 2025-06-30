<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureGestorPermissionPeriodoProyectoUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Staff', 'MECLA'])) {

            return $next($request);
        }


        if (!isset($request->pais) || !isset($request->proyecto)) {

            return $next($request);
        }

        $paisProyecto = \App\Models\PaisProyecto::where([
            'pais_id' => $request->pais->id,
            'proyecto_id' => $request->proyecto->id
        ])->firstOrFail();

        $hasPermission = \App\Models\PeriodoProyectoUser::where([
            'user_id' => Auth::id(),
            'pais_proyecto_id' => $paisProyecto->id
        ])->exists();

        if (!$hasPermission) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
