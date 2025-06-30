<?php

use App\Livewire\Resultadotres\Gestor\Prealianzas\Create\Page as CreatePreAlianza;
use App\Livewire\Resultadotres\Gestor\Prealianzas\Edit\Page as EditPreAlianza;
use App\Livewire\Resultadotres\Gestor\Prealianzas\Actualizacion\Page as ActualizarPreAlianza;
use App\Livewire\Resultadotres\Gestor\Prealianzas\Index\Page as Prealianzas;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', App\Http\Middleware\EnsureGestorPermissionPeriodoProyectoUser::class]], function () {
    // REGISTRO
    Route::get('/pais/{pais}/proyecto/{proyecto}/prealianzas', Prealianzas::class)->name('pre.alianzas.index');
    Route::get('/pais/{pais}/proyecto/{proyecto}/prealianzas/create', CreatePreAlianza::class)->name('pre.alianza.create');
    Route::get('/pais/{pais}/proyecto/{proyecto}/prealianza/{prealianza}/edit', EditPreAlianza::class)->name('pre.alianza.edit');

    Route::get('/pais/{pais}/proyecto/{proyecto}/prealianza/{prealianza}/actualizar', ActualizarPreAlianza::class)->name('pre.alianza.actualizar');

});
