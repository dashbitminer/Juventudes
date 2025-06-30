<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadocuatro\Gestor\Directorio\Index\Page as Directorio;
use App\Livewire\Resultadocuatro\Gestor\Directorio\Create\Page as CreateDirectorio;
use App\Livewire\Resultadocuatro\Gestor\Directorio\Edit\Page as EditDirectorio;

Route::group(['middleware' => ['auth', \App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte::class]], function () {
    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/directorios', Directorio::class)
        ->name('directorio.cohorte.index');
    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/directorios/create', CreateDirectorio::class)
        ->name('directorio.cohorte.create');
    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/directorios/{directorio}/edit', EditDirectorio::class)
        ->name('directorio.cohorte.edit');

    Route::get('/pais/{pais}/proyecto/{proyecto}/directorios', Directorio::class)
        ->name('directorio.index');
    Route::get('/pais/{pais}/proyecto/{proyecto}/directorios/create', CreateDirectorio::class)
        ->name('directorio.create');
    Route::get('/pais/{pais}/proyecto/{proyecto}/directorios/{directorio}/edit', EditDirectorio::class)
        ->name('directorio.edit');
});
