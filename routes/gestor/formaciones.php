<?php

use Illuminate\Support\Facades\Route;
// use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Index\Page as FichaVoluntario;
use App\Livewire\Resultadocuatro\Gestor\Formacion\Create\Page as CreateFormaciones;
use App\Livewire\Resultadocuatro\Gestor\Formacion\Edit\Page as EditFormaciones;
use App\Livewire\Resultadocuatro\Gestor\Formacion\Revisar\Page as RevisarFormaciones;

Route::group(['middleware' => ['auth']], function () {

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/formaciones/{participante}/create', CreateFormaciones::class)
        ->name('ficha.formacion.create');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/formacion/{id}/edit', EditFormaciones::class)
        ->name('ficha.formacion.edit');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/formacion/{id}/revisar', RevisarFormaciones::class)
            ->name('ficha.formacion.revisar');
});
