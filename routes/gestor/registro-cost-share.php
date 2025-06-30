<?php
use App\Livewire\Resultadotres\Gestor\CostShares\Create\Page as CreateCostShare;
use App\Livewire\Resultadotres\Gestor\CostShares\Edit\Page as EditCostShare;
use App\Livewire\Resultadotres\Gestor\CostShares\Index\Page as CostShares;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', App\Http\Middleware\EnsureGestorPermissionPeriodoProyectoUser::class]], function () {
    // REGISTRO
    Route::get('/pais/{pais}/proyecto/{proyecto}/costo-compartido', CostShares::class)->name('cost-share.index');
    Route::get('/pais/{pais}/proyecto/{proyecto}/costo-compartido/create', CreateCostShare::class)->name('cost-share.create');
    Route::get('/pais/{pais}/proyecto/{proyecto}/costo-compartido/{costShare}/edit', EditCostShare::class)->name('cost-share.edit');
});