<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Resultadouno\Coordinador\Participante\Index\View AS ViewParticipante;

Route::group(['middleware' => ['auth']], function () {
    // Ver detalle de participante
    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/view', ViewParticipante::class)
        ->name('participante.view')
        ->middleware('can:view,participante');
});
