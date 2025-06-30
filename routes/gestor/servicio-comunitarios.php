<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Index\Page as ServicioComunitario;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Create\Page as CreateServicioComunitario;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Edit\Page as EditServicioComunitario;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Revisar\Page as RevisarServicioComunitario;

Route::group(['middleware' => ['auth']], function () {

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/servicio-comunitarios', ServicioComunitario::class)
        ->name('servicio-comunitario.index');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/servicio-comunitarios/create', CreateServicioComunitario::class)
        ->name('servicio-comunitario.create');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/servicio-comunitarios/{servicioComunitario}/edit', EditServicioComunitario::class)
        ->name('servicio-comunitario.edit');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/servicio-comunitarios/{servicioComunitario}/revisar', RevisarServicioComunitario::class)
            ->name('servicio-comunitario.revisar');

});
