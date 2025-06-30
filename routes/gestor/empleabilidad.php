<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Index\Page as Empleabilidad;
use App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Create\Page as CreateEmpleabilidad;
use App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Edit\Page as EditEmpleabilidad;
use App\Livewire\Resultadocuatro\Gestor\PracticasEmpleabilidad\Revisar\Page as RevisarEmpleabilidad;

Route::group(['middleware' => ['auth', \App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte::class]], function () {

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/practicas-empleabilidad', Empleabilidad::class)
        ->name('practicas.empleabilidad.index');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/practicas-empleabilidad/{participante}/create', CreateEmpleabilidad::class)
        ->name('practicas.empleabilidad.create');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/practicas-empleabilidad/{practica}/edit', EditEmpleabilidad::class)
        ->name('practicas.empleabilidad.edit');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/practicas-empleabilidad/{practica}/revisar', RevisarEmpleabilidad::class)
            ->name('practicas.empleabilidad.revisar');
});
