<?php

namespace App\Livewire\Admin\Sesiones\Sesion;

use App\Models\Modulo;
use App\Models\Sesion;
use App\Models\Titulo;
use App\Models\Actividad;
use App\Models\Submodulo;
use App\Models\SesionTitulo;
use App\Models\Subactividad;
use App\Models\CohorteActividad;
use Livewire\Attributes\Validate;
use App\Models\CohorteSubactividad;
use App\Models\CohorteSubactividadModulo;
use App\Models\ModuloSubactividadSubmodulo;


trait CreateAction
{

    public function save()
    {
        $this->validate();


        // Cargar los niveles
        $actividad = Actividad::find($this->actividad_id);
        $subactividad = Subactividad::find($this->subactividad_id);
        $modulo = Modulo::find($this->modulo_id);
        $submodulo = Submodulo::find($this->submodulo_id);

        $model = $submodulo ?? $modulo ?? $subactividad ?? $actividad ?? null;


        // Guarda la relacion por niveles
        $cohorte_actividad = CohorteActividad::firstOrCreate(
            [
                'cohorte_pais_proyecto_id' => $this->cohorte_pais_proyecto_id,
                'cohorte_pais_proyecto_perfil_id' => $this->perfil_id,
                'actividad_id' => $actividad->id,
            ],
            ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
        );

        if (!empty($subactividad)) {
            $cohorte_subactividad = CohorteSubactividad::firstOrCreate(
                [
                    'cohorte_pais_proyecto_id' => $this->cohorte_pais_proyecto_id,
                    'cohorte_pais_proyecto_perfil_id' => $this->perfil_id,
                    'cohorte_actividad_id' => $cohorte_actividad->id,
                    'subactividad_id' => $subactividad->id
                ],
                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
            );
        }

        if (!empty($modulo)) {
            $modulo_subactividad_submodulo = CohorteSubactividadModulo::firstOrCreate(
                [
                    'cohorte_pais_proyecto_id' => $this->cohorte_pais_proyecto_id,
                    'cohorte_pais_proyecto_perfil_id' => $this->perfil_id,
                    'cohorte_subactividad_id' => $cohorte_subactividad->id,
                    'modulo_id' => $modulo->id
                ],
                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
            );
        }

        if (!empty($submodulo)) {
            ModuloSubactividadSubmodulo::firstOrCreate(
                [
                    'cohorte_pais_proyecto_id' => $this->cohorte_pais_proyecto_id,
                    'cohorte_pais_proyecto_perfil_id' => $this->perfil_id,
                    'cohorte_subactividad_modulo_id' => $modulo_subactividad_submodulo->id,
                    'submodulo_id' => $submodulo->id
                ],
                ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
            );
        }


        // Guardar el tipo de sesion
        if ($model) {
            $model->tipoSesion()->firstOrCreate(
                [
                    'cohorte_pais_proyecto_id' => $this->cohorte_pais_proyecto_id,
                    'cohorte_pais_proyecto_perfil_id' => $this->perfil_id,
                    'actividad_id' => $actividad->id ?? null,
                    'subactividad_id' => $subactividad?->id ?? null,
                    'modulo_id' => $modulo?->id ?? null,
                    'submodulo_id' => $submodulo?->id ?? null,
                    'tipo' => $this->tipo_sesion
                ]
            );

            if ($this->tipo_titulo == SesionTitulo::CERRADO) {
                $model->tituloSesion()->firstOrCreate(
                    [
                        'cohorte_pais_proyecto_id' => $this->cohorte_pais_proyecto_id,
                        'cohorte_pais_proyecto_perfil_id' => $this->perfil_id,
                        'actividad_id' => $actividad->id ?? null,
                        'subactividad_id' => $subactividad?->id ?? null,
                        'modulo_id' => $modulo?->id ?? null,
                        'submodulo_id' => $submodulo?->id ?? null,
                        'titulo_id' => $this->titulo_id,
                        'titulo_abierto' => $this->tipo_titulo,
                    ]
                );
            }
            else {
                foreach ($this->months as $month) {
                    $titulo = Titulo::firstOrCreate(
                        ['nombre' => trim($month)],
                        ['created_at' => now(), 'active_at' => now(), 'created_by' => 1]
                    );

                    $model->tituloSesion()->firstOrCreate(
                        [
                            'cohorte_pais_proyecto_id' => $this->cohorte_pais_proyecto_id,
                            'cohorte_pais_proyecto_perfil_id' => $this->perfil_id,
                            'actividad_id' => $actividad->id ?? null,
                            'subactividad_id' => $subactividad?->id ?? null,
                            'modulo_id' => $modulo?->id ?? null,
                            'submodulo_id' => $submodulo?->id ?? null,
                            'titulo_id' => $titulo->id,
                            'titulo_abierto' => $this->tipo_titulo,
                        ]
                    );
                }
            }
        }


        // Close the drawer
        $this->openDrawer = false;
        $this->showSuccessIndicator = true;

        $this->resetFields();

        $this->dispatch('refresh-sesiones');
    }
}
