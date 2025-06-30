<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $route     = $request->route();
        $getaction = $route->getAction();

        $check_controller = [
            "App\Livewire\Resultadouno\Gestor\Dashboard",
            "App\Livewire\Resultadouno\Gestor\Participante\Index\Page",
            "App\Livewire\Resultadouno\Gestor\Participante\Index\Page@__invoke",
        ];

        $controladores = [
            "App\Livewire\Resultadouno\Gestor\Dashboard" => "App\Livewire\Resultadouno\Coordinador\Dashboard",
            "App\Livewire\Resultadouno\Gestor\Participante\Index\Page" => "App\Livewire\Resultadouno\Coordinador\Participante\Index\Page",
            "App\Livewire\Resultadouno\Gestor\Participante\Index\Page@__invoke" => "App\Livewire\Resultadouno\Coordinador\Participante\Index\Page@__invoke",
        ];

        $uses = [
            "App\Livewire\Resultadouno\Gestor\Dashboard@__invoke" => "App\Livewire\Resultadouno\Coordinador\Dashboard@__invoke",
            "App\Livewire\Resultadouno\Gestor\Participante\Index\Page@__invoke" => "App\Livewire\Resultadouno\Coordinador\Participante\Index\Page@__invoke",
        ];

        $as = [
            "dashboard" => "coordinador.dashboard",
            "participantes" => "coordinador.participantes",
        ];

         //dd($request, $route, $getaction);

        if (Auth::user()->hasRole('Coordinador')) {
            if (in_array($getaction['controller'], $check_controller)) {
                $routeAction = array_merge($route->getAction(), [
                    'as'         => $as[$getaction["as"]],
                    'uses'       => $uses[$getaction["uses"]],
                    'controller' => $controladores[$getaction["controller"]],
                ]);

                $route->setAction($routeAction);
                $route->controller = false;
            }
        }

        return $next($request);
    }
}
