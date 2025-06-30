<?php

use Illuminate\Support\Facades\Route;


Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('mantenimientos', App\Livewire\Admin\Mantenimientos\Page::class)->name('mantenimientos.index');

    //Socios Implementadores

    Route::get('mantenimientos/socios-implementadores', App\Livewire\Admin\Mantenimientos\SociosImplementadores\Index\Page::class)
                ->name('mantenimientos.socios-implementadores.index');

    Route::get('mantenimientos/razones', App\Livewire\Admin\Mantenimientos\Razones\Index\Page::class)
                ->name('mantenimientos.razones.index');

});
