<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Sesiones\Index\Page as SesionesPage;
use App\Livewire\Admin\Sesiones\Index\Titulo as SesionesTitulo;
use App\Livewire\Admin\Sesiones\Index\Actividad;
use App\Livewire\Admin\Sesiones\Index\Subactividad;
use App\Livewire\Admin\Sesiones\Index\Modulo;
use App\Livewire\Admin\Sesiones\Index\Submodulo;

Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('sesiones', SesionesPage::class)->name('admin.sesiones');
    Route::get('sesiones/titulos', SesionesTitulo::class)->name('admin.sesiones.titulos');
    Route::get('sesiones/actividad', Actividad::class)->name('admin.sesiones.actividad');
    Route::get('sesiones/subactividad', Subactividad::class)->name('admin.sesiones.subactividad');
    Route::get('sesiones/modulo', Modulo::class)->name('admin.sesiones.modulo');
    Route::get('sesiones/submodulo', Submodulo::class)->name('admin.sesiones.submodulo');

});
