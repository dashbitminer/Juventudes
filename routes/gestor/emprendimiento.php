<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Create\Page as CreateEmprendimiento;
use App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Edit\Page as EditEmprendimiento;
use App\Livewire\Resultadocuatro\Gestor\Emprendimiento\Revisar\Page as RevisarEmprendimiento;

Route::group(['middleware' => ['auth']], function () {
    Route::get(
        '/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/emprendimiento/create',
        CreateEmprendimiento::class
    )->name('ficha.emprendimiento.create');

    Route::get(
        '/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/emprendimiento/{emprendimiento}/edit',
        EditEmprendimiento::class
    )->name('ficha.emprendimiento.edit');

    Route::get(
            '/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/emprendimiento/{emprendimiento}/revisar',
            RevisarEmprendimiento::class
        )->name('ficha.emprendimiento.revisar');
});
