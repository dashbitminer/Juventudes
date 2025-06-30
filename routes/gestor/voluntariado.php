<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Index\Page as FichaVoluntario;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Create\Page as CreateFichaVoluntariado;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Edit\Page as EditFichaVoluntariado;
use App\Livewire\Resultadocuatro\Gestor\Voluntariado\Revisar\Page as RevisarFichaVoluntariado;

Route::group(['middleware' => ['auth']], function () {

    // Route::get('/pais/{pais}/proyecto/{proyecto}/ficha-voluntariado', FichaVoluntario::class)
    //     ->name('ficha.voluntariado.index');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/voluntario/{participante}/create', CreateFichaVoluntariado::class)
        ->name('ficha.voluntariado.create');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/voluntario/{voluntario}/edit', EditFichaVoluntariado::class)
        ->name('ficha.voluntariado.edit');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/voluntario/{voluntario}/revisar', RevisarFichaVoluntariado::class)
                ->name('ficha.voluntariado.revisar');

});


