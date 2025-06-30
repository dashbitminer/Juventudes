<?php

use Illuminate\Support\Facades\Route;


Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('proyectos', App\Livewire\Admin\Proyectos\Index\Page::class)->name('admin.proyectos');
    Route::get('proyecto/{proyecto}/cohortes', App\Livewire\Admin\Cohortes\Index\Page::class)->name('admin.proyecto.cohortes');
    Route::get('proyecto/{proyecto}/cohorte_pais_proyecto/{cohortePaisProyecto}/usuarios', App\Livewire\Admin\Cohortes\Usuarios\Index\Page::class)->name('admin.proyecto.cohortes.usuarios');
    Route::get('proyecto/{proyecto}/cohorte_pais_proyecto/{cohortePaisProyecto}/participantes', App\Livewire\Admin\Cohortes\Participantes\Index\Page::class)->name('admin.proyecto.cohortes.participantes');
});
