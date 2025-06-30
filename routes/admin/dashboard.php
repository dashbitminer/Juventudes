<?php

use Illuminate\Support\Facades\Route;


Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', App\Livewire\Admin\Dashboard::class)->name('dashboard');

});
