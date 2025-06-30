<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadotres\Gestor\Visualizador\Index\Page as VisualizadorForm;
use App\Livewire\Resultadotres\Gestor\Alianzas\Index\Revisar as RevisarAlianza;
use App\Livewire\Resultadotres\Gestor\Apalancamientos\Index\Revisar as RevisarApalancamiento;
use App\Livewire\Resultadotres\Gestor\CostShares\Index\Revisar as RevisarCostShare;


Route::group(['middleware' => ['auth', App\Http\Middleware\EnsureGestorPermissionPeriodoProyectoUser::class]], function () {
    Route::get('/pais/{pais}/proyecto/{proyecto}/visualizador/resultadotres/formularios', VisualizadorForm::class)
        ->name('visualizador.resultadotres.index');

    Route::get('/pais/{pais}/proyecto/{proyecto}/alianza/{alianza}/revisar', RevisarAlianza::class)->name('alianza.revisar');
    Route::get('/pais/{pais}/proyecto/{proyecto}/apalancamiento/{apalancamiento}/revisar', RevisarApalancamiento::class)->name('apalancamiento.revisar');
    Route::get('/pais/{pais}/proyecto/{proyecto}/costo-compartido/{costShare}/revisar', RevisarCostShare::class)->name('cost-share.revisar');
});