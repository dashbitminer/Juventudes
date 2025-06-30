<?php

use Livewire\Volt\Volt;
use Maatwebsite\Excel\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\DashboardController;
use App\Livewire\Resultadouno\Gestor\Dashboard;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte;
use App\Livewire\Resultadouno\Gestor\Participante\Index\Page as PageParticipante;


//Route::view('/', 'welcome');
Volt::route('/', 'pages.auth.login')->name('login.page');





/**************************GESTOR********************************/
// RESULTADO 1
require __DIR__ . '/gestor/participantes.php';
require __DIR__ . '/gestor/grupos.php';
require __DIR__ . '/financiero/participantes.php';
require __DIR__ . '/financiero/cuentas.php';
require __DIR__ . '/financiero/estipendios.php';

// RESULTDO 3
require __DIR__ . '/gestor/registro-pre-alianzas.php';
require __DIR__ . '/gestor/registro-alianzas.php';
require __DIR__ . '/gestor/registro-apalancamientos.php';
require __DIR__ . '/gestor/registro-cost-share.php';


// RESULTDO 4
require __DIR__ . '/gestor/directorios.php';
require __DIR__ . '/gestor/fichas.php';
require __DIR__ . '/gestor/servicio-comunitarios.php';
require __DIR__ . '/gestor/empleo.php';
require __DIR__ . '/gestor/empleabilidad.php';
require __DIR__ . '/gestor/voluntariado.php';
require __DIR__ . '/gestor/formaciones.php';
require __DIR__ . '/gestor/emprendimiento.php';
require __DIR__ . '/gestor/aprendizaje-servicio.php';

/**************************ADMIN********************************/
require __DIR__ . '/admin/dashboard.php';
require __DIR__ . '/admin/users.php';
require __DIR__ . '/admin/mantenimientos.php';
require __DIR__ . '/admin/permisos.php';
require __DIR__ . '/admin/roles.php';
require __DIR__ . '/admin/proyectos.php';
require __DIR__ . '/admin/sesiones.php';
require __DIR__ . '/admin/socios.php';


/**************************COORDINADOR********************************/
require __DIR__ . '/coordinador/coordinador.php';


/**************************MECLA********************************/
require __DIR__ . '/mecla/visualizador.php';

require __DIR__ . '/resultadotres/visualizador.php';


Route::group(['middleware' => ['auth', CheckUserRole::class]], function () {


    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participantes', PageParticipante::class)
        ->name('participantes')
        ->middleware(\App\Http\Middleware\EnsureGestorPermissionPaisProyectoCohorte::class);


});

Route::get('prueba', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('prueba');

Route::get('import/directorio', [App\Http\Controllers\DashboardController::class, 'importDirectorio'])
    ->name('import.directorio');

Route::get('generarmecla', [App\Http\Controllers\DashboardController::class, 'generarmecla'])
    ->name('generarmecla');

Route::get('permisosr4', [App\Http\Controllers\DashboardController::class, 'permisosr4'])
    ->name('permisosr4');

Route::get('permisosr3', [App\Http\Controllers\DashboardController::class, 'permisosr3'])
    ->name('permisosr3');

Route::get('permisosr3Staff', [App\Http\Controllers\DashboardController::class, 'permisosr3Staff'])
    ->name('permisosr3Staff');

    Route::get('permisosValidadorR4', [App\Http\Controllers\DashboardController::class, 'permisosValidadorR4'])
    ->name('permisosValidadorR4');

Route::get('/import/sesiones/jli', [DashboardController::class, 'importSesionesJLI'])
    ->name('sesiones');

Route::get('/import/sesiones/jli/gt/7', [DashboardController::class, 'importSesionesJLIGt7'])
    ->name('importSesionesJLIGt7');

Route::get('/import/sesiones/jli-hn', [DashboardController::class, 'importSesionesJLIHN'])
    ->name('sesioneshnjli');

Route::get('/import/sesiones/jli-hn-7', [DashboardController::class, 'importSesionesJLIHN7'])
    ->name('sesioneshnjli7');

Route::get('/import/sesiones/jcp', [DashboardController::class, 'importSesionesJCP'])
    ->name('sesionesjcp');

// Route::get('/import/sesiones-b', [DashboardController::class, 'importSesionesGrupoB'])
//     ->name('sesiones');

Route::get('updatepermisos', [App\Http\Controllers\DashboardController::class, 'updatepermisos'])
    ->name('updatepermisos');

Route::get('updatenombres', [App\Http\Controllers\DashboardController::class, 'updateNames'])
    ->name('updatenombres');

Route::get('importarcohorte8', [DashboardController::class, 'importarcohorte8'])
    ->name('importarcohorte8');

Route::get('importarcohorte8array', [DashboardController::class, 'importarcohorte8array'])
    ->name('importarcohorte8array');

Route::get('importarcohorte8guatemala', [DashboardController::class, 'importarcohorte8guatemala'])
    ->name('importarcohorte8guatemala');

Route::get('importarcohorte8guatemalaarray', [DashboardController::class, 'importarcohorte8guatemalaarray'])
    ->name('importarcohorte8guatemalaarray');

Route::get('runasociaciones', [DashboardController::class, 'runasociaciones']);

Route::get('repararguate', [DashboardController::class, 'repararguate']);

Route::get('importarjli', [DashboardController::class, 'importarjli']);

Route::get('importarmao', [DashboardController::class, 'importarmao']);

Route::get('importarmao2', [DashboardController::class, 'importarmao2']);

Route::get('fixlinkjcp', [DashboardController::class, 'fixlinkjcp']);

Route::get('asociarmao2parteuno', [DashboardController::class, 'asociarmao2parteuno']);
Route::get('asociarmao2partedos', [DashboardController::class, 'asociarmao2partedos']);
Route::get('fixrelacionregistro3', [DashboardController::class, 'fixrelacionregistro3']);
Route::get('nuevosgestorescohorte8jli', [DashboardController::class, 'nuevosgestorescohorte8jli']);
Route::get('mover3actors', [DashboardController::class, 'mover3actors']);

Route::get('fixestipendios', [DashboardController::class, 'estipendiosfix']);



Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


require __DIR__.'/auth.php';


Route::get('example', function () {
   // return Excel::download(new InvoicesExport, 'invoices.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    $pdf = Pdf::loadView('registro');
    return $pdf->download('registsro.pdf');
})->name('example');
