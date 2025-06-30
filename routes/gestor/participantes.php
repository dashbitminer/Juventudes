<?php
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\GestorController;
use App\Http\Controllers\PruebaController;
use App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte;
use App\Livewire\Resultadouno\Gestor\Participante\Edit\Page as EditParticipante;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Page as PageParticipante;
use App\Livewire\Resultadouno\Gestor\Participante\Create\Page as CreateParticipante;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\Page as GruposParticipantes;
use App\Livewire\Resultadouno\Gestor\Participante\Socioeconomico\Page as PageSocioEconomico;
use App\Livewire\Resultadouno\Gestor\Participante\Estados\Page as EstadosParticipantes;
use App\Livewire\Resultadouno\Gestor\Participante\Estados\R4 as EstadosParticipantesR4;

use App\Livewire\Resultadouno\Gestor\Participante\Socioeconomico\MostrarPdf;

Route::group(['middleware' => ['auth', \App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte::class]], function () {


//1. REGISTRO
Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participantes/create', CreateParticipante::class)
       ->name('participantes.create');

Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/edit', EditParticipante::class)
        ->name('participantes.edit')
        ->middleware('can:view,participante');

Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/pdf', [GestorController::class, 'registropdf'])
        ->name('participantes.pdf');
       // ->middleware('can:view,participante');

//2. SOCIOECONOMICO
Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/socioeconomico', PageSocioEconomico::class)
        ->name('participantes.socioeconomico')
        ->middleware('can:view,participante');

Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/socioeconomico/pdf', [GestorController::class, 'socioeconomicoPdf'])
      ->name('participantes.socioeconomico.pdf');

Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/socioeconomico/mostrar-pdf', [MostrarPdf::class, 'socioeconomicoPdf'])
      ->name('participantes.socioeconomico.mostrar.pdf');


// GRUPOS
// Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/grupos', GruposParticipantes::class)->name('participantes.grupos');
// Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/grupo/{id}', GruposParticipantes::class)->name('participantes.grupo.show');

    // HISTORIAL DE ESTADOS
    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/r1/estados', EstadosParticipantes::class)
        ->name('participantes.r1.estados')
        ->middleware('can:view,participante');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participante/{participante}/r4/estados', EstadosParticipantesR4::class)
        ->name('participantes.r4.estados')
        ->middleware('can:view,participante');
});
