<?php

use App\Livewire\Resultadotres\Gestor\Alianzas\Create\Page as CreateAlianza;
use App\Livewire\Resultadotres\Gestor\Alianzas\Edit\Page as EditAlianza;
use App\Livewire\Resultadotres\Gestor\Alianzas\Index\Page as Alianzas;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['auth', App\Http\Middleware\EnsureGestorPermissionPeriodoProyectoUser::class]], function () {
    // REGISTRO
    Route::get('/pais/{pais}/proyecto/{proyecto}/alianzas', Alianzas::class)->name('alianzas.index');
    Route::get('/pais/{pais}/proyecto/{proyecto}/alianzas/create', CreateAlianza::class)->name('alianza.create');
    Route::get('/pais/{pais}/proyecto/{proyecto}/alianza/{alianza}/edit', EditAlianza::class)->name('alianza.edit');
});
