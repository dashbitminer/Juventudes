<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadocuatro\Gestor\Empleo\Create\Page as CreateEmpleo;
use App\Livewire\Resultadocuatro\Gestor\Empleo\Edit\Page as EditEmpleo;
use App\Livewire\Resultadocuatro\Gestor\Empleo\Index\Page as EmpleoPage;
use App\Livewire\Resultadocuatro\Gestor\Empleo\Revisar\Page as RevisarEmpleo;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/empleo/create', CreateEmpleo::class)
        ->name('empleo.create');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/empleo/{empleo}/edit', EditEmpleo::class)
        ->name('empleo.edit');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/empleo/{empleo}/revisar', RevisarEmpleo::class)
            ->name('empleo.revisar');
    // Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/empleos', EmpleoPage::class)
    //     ->name('empleo.index');
});
