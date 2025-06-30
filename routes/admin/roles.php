<?php

use Illuminate\Support\Facades\Route;


Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('roles', App\Livewire\Admin\Roles\Index\Page::class)->name('admin.roles');

});
