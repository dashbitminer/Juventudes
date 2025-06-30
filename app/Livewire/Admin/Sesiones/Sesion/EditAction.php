<?php

namespace App\Livewire\Admin\Sesiones\Sesion;

use Livewire\Attributes\On;
use App\Models\SesionTitulo;
use App\Models\SesionTipo;
use App\Models\CohortePaisProyecto;
use App\Models\Titulo;
use App\Models\Actividad;
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Subactividad;
use App\Models\CohorteActividad;
use App\Models\CohorteSubactividad;
use App\Models\CohorteSubactividadModulo;
use App\Models\ModuloSubactividadSubmodulo;

trait EditAction
{
    #[On('openEdit')]
    public function openEdit($id) {
        $this->resetFields();

        $this->sesionTitulo = SesionTitulo::find($id);

        if ($this->sesionTitulo instanceof SesionTitulo) {
            $this->cohorte_pais_proyecto_id = $this->sesionTitulo->cohorte_pais_proyecto_id;
            $this->cohorte_id = $this->sesionTitulo->cohorte_pais_proyecto_id;
            $this->perfil_id = $this->sesionTitulo->cohorte_pais_proyecto_perfil_id;
            $this->actividad_id = $this->sesionTitulo->actividad_id;
            $this->subactividad_id = $this->sesionTitulo->subactividad_id;
            $this->modulo_id = $this->sesionTitulo->modulo_id;
            $this->submodulo_id = $this->sesionTitulo->submodulo_id;
            $this->titulo_id = $this->sesionTitulo->titulo_id;
            $this->tipo_titulo = $this->sesionTitulo->titulo_abierto;

            $cohortePaisProyecto = CohortePaisProyecto::with([
                    'paisProyecto.pais',
                    'perfilesParticipante',
                    'cohorte',
                ])
                ->where('id', $this->cohorte_pais_proyecto_id)
                ->first();

            $this->pais_id = $cohortePaisProyecto->paisProyecto->pais_id;
            $this->proyecto_id = $cohortePaisProyecto->paisProyecto->proyecto_id;

            // Cargar proyectos
            $this->updated('pais_id', '');
            $this->updated('proyecto_id', '');
            $this->updated('cohorte_id', '');

            $this->sesionTipo = SesionTipo::where('cohorte_pais_proyecto_id', $this->cohorte_pais_proyecto_id)
                ->where('cohorte_pais_proyecto_perfil_id', $this->perfil_id)
                ->where('actividad_id', $this->actividad_id)
                ->where('subactividad_id', $this->subactividad_id)
                ->where('modulo_id', $this->modulo_id)
                ->where('submodulo_id', $this->submodulo_id)
                ->first();

            if ($this->sesionTipo) {
                $this->tipo_sesion = $this->sesionTipo->tipo;
            }

            $this->openDrawerEdit = true;
        }
    }

    public function editPermiso()
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

        if (!empty($modulo)) {
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
            if ($this->sesionTipo) {
                $this->sesionTipo->cohorte_pais_proyecto_id = $this->cohorte_pais_proyecto_id;
                $this->sesionTipo->cohorte_pais_proyecto_perfil_id = $this->perfil_id;
                $this->sesionTipo->actividad_id = $actividad->id ?? null;
                $this->sesionTipo->subactividad_id = $subactividad?->id ?? null;
                $this->sesionTipo->modulo_id = $modulo?->id ?? null;
                $this->sesionTipo->submodulo_id = $submodulo?->id ?? null;
                $this->sesionTipo->tipo = $this->tipo_sesion;
                $this->sesionTipo->save();
            }

            if ($this->tipo_titulo == SesionTitulo::CERRADO) {
                $this->sesionTitulo->cohorte_pais_proyecto_id = $this->cohorte_pais_proyecto_id;
                $this->sesionTitulo->cohorte_pais_proyecto_perfil_id = $this->perfil_id;
                $this->sesionTitulo->actividad_id = $actividad->id ?? null;
                $this->sesionTitulo->subactividad_id = $subactividad?->id ?? null;
                $this->sesionTitulo->modulo_id = $modulo?->id ?? null;
                $this->sesionTitulo->submodulo_id = $submodulo?->id ?? null;
                $this->sesionTitulo->titulo_id = $this->titulo_id;
                $this->sesionTitulo->titulo_abierto = $this->tipo_titulo;
                $this->sesionTitulo->save();
            }
            else {
                //
            }
        }


        $this->resetFields();

        $this->openDrawerEdit = false;
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-sesiones');
    }
}
