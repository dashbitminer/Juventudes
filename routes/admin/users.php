<?php

use Illuminate\Support\Facades\Route;


Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('users', App\Livewire\Admin\User\Index\Page::class)->name('admin.users');

});
