<?php


use Illuminate\Support\Facades\Route;
use App\Livewire\Financiero\Mecla\Estipendios\Index\Page as IndexEstipendios;
use App\Livewire\Financiero\Mecla\Estipendios\Detail\Page as ConfigurarEstipendios;
use App\Livewire\Financiero\Mecla\Estipendios\Revisar\Page as RevisarEstipendios;
use App\Livewire\Financiero\Mecla\Estipendios\Financiero\Page as FinancieroEstipendios;
use App\Livewire\Financiero\Mecla\Estipendios\Financiero\Ver\Page as VerEstipendios;
use App\Livewire\Financiero\Mecla\Estipendios\Visualizar\Page as VisualizarEstipendios;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/estipendios', IndexEstipendios::class)
        ->name('estipendios.mecla.index');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/estipendios/{estipendio}/configurar', ConfigurarEstipendios::class)
        ->name('estipendios.mecla.configurar');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/estipendios/{estipendio}/revisar', RevisarEstipendios::class)
        ->name('estipendios.mecla.revisar');


    Route::get('/financiero/estipendios', FinancieroEstipendios::class)
        ->name('financiero.estipendios');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/financiero/estipendios/{estipendio}/ver', VerEstipendios::class)
        ->name('financiero.estipendios.ver');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/financiero/estipendios/{estipendio}/visualizar', VisualizarEstipendios::class)
        ->name('financiero.estipendios.visualizar');
});
