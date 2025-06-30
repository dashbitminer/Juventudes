<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadocuatro\Gestor\Visualizador\Index\Page;

Route::group(['middleware' => ['auth']], function () {
    // Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/visualizador/formularios', Page::class)
    //     ->name('visualizador.resultadocuatro.index');
    Route::get('/pais/{pais}/proyecto/{proyecto}/visualizador/formularios', Page::class)
        ->name('visualizador.resultadocuatro.index');
});
