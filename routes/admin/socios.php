<?php

use Illuminate\Support\Facades\Route;


Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('socios', App\Livewire\Admin\Socios\Index\Page::class)->name('admin.socios');

});
