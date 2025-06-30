
<?php
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckUserRole;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\Grupo\Page as GrupoDetalle;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\Page as GruposParticipantes;


Route::group(['middleware' => ['auth']], function () {


// GRUPOS
Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/grupos', GruposParticipantes::class)->name('participantes.grupos');
Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/grupo/{grupo}', GrupoDetalle::class)->name('participantes.grupo.show');

});
