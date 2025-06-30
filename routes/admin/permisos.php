<?php

use Illuminate\Support\Facades\Route;


Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('permisos', App\Livewire\Admin\Permisos\Index\Page::class)->name('admin.permisos');

});
