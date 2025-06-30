<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Financiero\Admin\Participante\Cuentas\Page as CuentasPage;


Route::group(['middleware' => ['auth']], function () {
    Route::get('/financiero/cuentas', CuentasPage::class)
        ->name('financiero.cuentas');
});
