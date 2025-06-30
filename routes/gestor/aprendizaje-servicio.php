<?php

use Illuminate\Support\Facades\Route;
// use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Index\Page as FichaVoluntario;
use App\Livewire\Resultadocuatro\Gestor\AprendizajeServicio\Create\Page as CreateAprendizajeServicio;
use App\Livewire\Resultadocuatro\Gestor\AprendizajeServicio\Edit\Page as EditAprendizajeServicio;
use App\Livewire\Resultadocuatro\Gestor\AprendizajeServicio\Revisar\Page as RevisarAprendizajeServicio;

Route::group(['middleware' => ['auth', \App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte::class]], function () {

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/aprendizaje-servicio/{participante}/create', CreateAprendizajeServicio::class)
        ->name('ficha.aprendizaje.servicio.create');

     Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/aprendizaje-servicio/{id}/edit', EditAprendizajeServicio::class)
         ->name('ficha.aprendizaje.servicio.edit');

     Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/aprendizaje-servicio/{id}/revisar', RevisarAprendizajeServicio::class)
              ->name('ficha.aprendizaje.servicio.revisar');
});
