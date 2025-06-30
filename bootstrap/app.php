<?php

use App\Http\Middleware\CheckUserRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->alias([
        //     'permisoCohorte' => \App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte::class
        // ]);
      // $middleware->append(\App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
