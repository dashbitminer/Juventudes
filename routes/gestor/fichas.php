<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadocuatro\Gestor\Fichas\Index\Page as Fichas;
use App\Livewire\Resultadocuatro\Gestor\Fichas\Show\Page as FichasShow;

Route::group(['middleware' => ['auth', \App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte::class]], function () {

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/formularios', Fichas::class)
        ->name('fichas.index');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/fichas', FichasShow::class)
        ->name('fichas.show');
});
