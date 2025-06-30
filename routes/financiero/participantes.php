<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Financiero\Coordinador\Participante\Index\Page as IndexFinanciero;
use App\Livewire\Financiero\Admin\Participante\Index\Page as IndexAdminFinanciero;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/bancarizacion', IndexFinanciero::class)
        ->name('bancarizacion.coordinador.index');
});



Route::group(['middleware' => ['auth']], function () {
    Route::get('/financiero/admin/participantes', IndexAdminFinanciero::class)
        ->name('financiero.admin.participantes.index');
});
