<?php
use App\Livewire\Resultadotres\Gestor\Apalancamientos\Create\Page as CreateApalancamiento;
use App\Livewire\Resultadotres\Gestor\Apalancamientos\Edit\Page as EditApalancamiento;
use App\Livewire\Resultadotres\Gestor\Apalancamientos\Index\Page as Apalancamientos;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', App\Http\Middleware\EnsureGestorPermissionPeriodoProyectoUser::class]], function () {
    // REGISTRO
    Route::get('/pais/{pais}/proyecto/{proyecto}/apalancamientos', Apalancamientos::class)->name('apalancamientos.index');
    Route::get('/pais/{pais}/proyecto/{proyecto}/apalancamientos/create', CreateApalancamiento::class)->name('apalancamiento.create');
    Route::get('/pais/{pais}/proyecto/{proyecto}/apalancamiento/{apalancamiento}/edit', EditApalancamiento::class)->name('apalancamiento.edit');
});