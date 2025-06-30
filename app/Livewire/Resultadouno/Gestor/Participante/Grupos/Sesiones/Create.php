<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Grupos\Sesiones;

use App\Models\Estado;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Pais;
use App\Models\CohortePaisProyecto;
use App\Models\Grupo;
use App\Models\GrupoParticipante;
use App\Models\Participante;
use App\Models\Sesion;
use App\Models\SesionParticipante;
use App\Models\Titulo;
use App\Models\EstadoRegistro;
use App\Models\SesionTitulo;
use App\Models\SesionTipo;
use App\Models\Actividad;
use App\Models\Subactividad;
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Livewire\Resultadouno\Gestor\Participante\Grupos\Sesiones\Forms\SesionForm;
use App\Traits\Sesionable;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Create extends Component
{
    use Sesionable;

    public CohortePaisProyecto $cohortePaisProyecto;

    public Grupo $grupo;

    public GrupoParticipante $grupoParticipante;

    public Actividad $actividad;

    public ?Subactividad $subactividad = null;

    public ?Modulo $modulo = null;

    public ?Submodulo $submodulo = null;

    public Actividad | Subactividad | Modulo | Submodulo $model;

    public SesionForm $form;

    public $openDrawer = false;

    public $showSuccessIndicator = false;

    public $isNew = true;

    public $search = '';

    public $minDate;

    public $maxDate;

    public $participantes;

    public $marcarTodo;

    public $titulos;

    public $titulo_abierto;

    public $tipo_sesion;

    public function mount(?Sesion $sesion)
    {
        $this->model = $this->submodulo ?? $this->modulo ?? $this->subactividad ?? $this->actividad;


        $this->grupoParticipante = GrupoParticipante::whereHas('cohorteParticipanteProyecto', function ($query) {
                $query->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
            })
            ->active()
            ->where('user_id', auth()->id())
            ->where('grupo_id', $this->grupo->id)
            ->whereNotNull('cohorte_pais_proyecto_perfil_id')
            ->groupBy("grupo_id")
            ->first();

        // dd($this->grupoParticipante);

        if ($this->grupoParticipante) {
            $this->form->cohorte_pais_proyecto_perfil_id = $this->grupoParticipante->cohorte_pais_proyecto_perfil_id;
        }


        $this->form->setSesion($sesion);


        $this->titulo_abierto = $this->model->tituloSesion()
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->when($this->form->cohorte_pais_proyecto_perfil_id != null, function ($query) {
                $query->where('cohorte_pais_proyecto_perfil_id', $this->form->cohorte_pais_proyecto_perfil_id);
            })
            ->when($this->actividad, function ($query) {
                $query->where('actividad_id', $this->actividad->id);
            })
            ->when($this->subactividad, function ($query) {
                $query->where('subactividad_id', $this->subactividad->id);
            })
            ->when($this->modulo, function ($query) {
                $query->where('modulo_id', $this->modulo->id);
            })
            ->when($this->submodulo, function ($query) {
                $query->where('submodulo_id', $this->submodulo->id);
            })
            ->first();
            // dd($this->titulo_abierto);

        $this->tipo_sesion = $this->model->tipoSesion()
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->when($this->form->cohorte_pais_proyecto_perfil_id != null, function ($query) {
                $query->where('cohorte_pais_proyecto_perfil_id', $this->form->cohorte_pais_proyecto_perfil_id);
            })
            ->when($this->actividad, function ($query) {
                $query->where('actividad_id', $this->actividad->id);
            })
            ->when($this->subactividad, function ($query) {
                $query->where('subactividad_id', $this->subactividad->id);
            })
            ->when($this->modulo, function ($query) {
                $query->where('modulo_id', $this->modulo->id);
            })
            ->when($this->submodulo, function ($query) {
                $query->where('submodulo_id', $this->submodulo->id);
            })
            ->first();



        // El titulo y tipo de sesion se define por la actividad/subactividad/modulo/submodulo
        $this->form->titulo_abierto = $this->titulo_abierto->titulo_abierto ?? SesionTitulo::CERRADO;
        $this->form->tipo_sesion = $this->tipo_sesion->tipo ?? SesionTipo::SESION_GENERAL;

        $this->form->model = $this->model;
        $this->form->cohortePaisProyecto = $this->cohortePaisProyecto;

        $this->minDate = $this->cohortePaisProyecto->fecha_inicio ?? null;
        $this->maxDate = $this->cohortePaisProyecto->fecha_fin ?? null;

        $this->participantes = [];
        $this->marcarTodo = false;
        $this->titulos = [];


        $tituloSesion = $this->model->tituloSesion()
            ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
            ->when($this->form->cohorte_pais_proyecto_perfil_id != null, function ($query) {
                $query->where('cohorte_pais_proyecto_perfil_id', $this->form->cohorte_pais_proyecto_perfil_id);
            })
            ->when($this->actividad, function ($query) {
                $query->where('actividad_id', $this->actividad->id);
            })
            ->when($this->subactividad, function ($query) {
                $query->where('subactividad_id', $this->subactividad->id);
            })
            ->when($this->modulo, function ($query) {
                $query->where('modulo_id', $this->modulo->id);
            })
            ->when($this->submodulo, function ($query) {
                $query->where('submodulo_id', $this->submodulo->id);
            })
            ->pluck('titulo_id');

        // dd($tituloSesion);

        if ($tituloSesion->count()) {
            $this->titulos = Titulo::whereIn('id', $tituloSesion)
                ->pluck('nombre', 'id');
        }
        else {
            $this->titulos = [];
        }
    }

    public function updated($propertyName, $value)
    {
        switch ($propertyName) {
            case 'form.fecha':
                $fecha = Carbon::parse($this->form->fecha);

                if (!$fecha->isValid()) {
                    $this->resetErrorBag('form.fecha');
                    $this->addError('form.fecha', 'Ingrese una fecha valida.');
                }
                break;

            case 'form.fecha_fin':
                $fecha = Carbon::parse($this->form->fecha);
                $fecha_fin = Carbon::parse($this->form->fecha_fin);
                $howManyDays = 0;

                $this->resetErrorBag('form.fecha_fin');
                $this->form->resetRangeDates();

                if (!$fecha_fin->isValid()) {
                    $this->addError('form.fecha_fin', 'Ingrese una fecha valida.');

                    return;
                }

                if ($fecha_fin < $fecha) {
                    $this->addError('form.fecha_fin', 'La fecha fin debe ser mayor o igual a la fecha inicial.');

                    return;
                }

                while ($fecha->lte($fecha_fin)) {
                    $howManyDays++;

                    $this->form->rangeDates[] = $fecha->format('d-m-Y');
                    $fecha->addDay();
                }


                // Validacion por maximo de 7 dias
                if ($howManyDays > 7) {
                    $this->form->resetRangeDates();
                    $this->form->enableSesionByFecha = false;

                    $this->addError('form.fecha_fin', 'El numero maximo de dias es de 7.');

                    return;
                }


                // Agrega los dias a los participantes
                foreach ($this->participantes as $participante) {
                    foreach ($this->form->rangeDates as $date) {
                        $this->form->rangoParticipanteHora[$participante->id][] = 0;
                        $this->form->rangoParticipanteMinutos[$participante->id][] = 0;
                    }
                }

                $this->form->enableSesionByFecha = true;
                break;

            case 'form.hora':
                if ($this->form->tipo_sesion == SesionTipo::HORAS_PARTICIPANTE) {
                    if (!empty($this->form->rangoParticipanteHora)) {

                        foreach ($this->form->rangoParticipanteHora as &$horas) {
                            foreach ($horas as &$hora) {
                                $hora = $this->form->hora;
                            }
                        }

                    }
                }
                break;

            case 'form.minuto':
                if ($this->form->tipo_sesion == SesionTipo::HORAS_PARTICIPANTE) {
                    if (!empty($this->form->rangoParticipanteMinutos)) {

                        foreach ($this->form->rangoParticipanteMinutos as &$minutos) {
                            foreach ($minutos as &$minuto) {
                                $minuto = $this->form->minuto;
                            }
                        }

                    }
                }
                break;
        }
    }

    public function render()
    {
        $this->loadParticipantes();

        return view('livewire.resultadouno.gestor.participante.grupos.sesiones.create');
    }

    #[On('sesiones-open-new-form')]
    public function openNewSesionForm() {
        $this->form->customReset();
        $this->resetErrorBag();
        $this->form->resetRangeDates();

        $sesion = new Sesion();
        $this->form->setSesion($sesion);

        $this->isNew = true;
        $this->openDrawer = true;
        $this->marcarTodo = true;

        $this->loadParticipantes();

        // Inicializa como vacio solo cuando es nuevo registro
        if (empty($this->form->selectedParticipanteIds) && $this->form->tipo_sesion == SesionTipo::SESION_GENERAL) {
            foreach ($this->participantes as $participante) {
                $this->form->selectedParticipanteIds[$participante->id] = true;
            }
        }
    }

    public function cleanSearch()
    {
        $this->search = '';
    }

    public function saveSesion(): void {
        $this->form->actividad_id = $this->actividad->id;
        $this->form->subactividad_id = $this->subactividad?->id ?? null;
        $this->form->modulo_id = $this->modulo?->id ?? null;
        $this->form->submodulo_id = $this->submodulo?->id ?? null;
        $this->form->grupo = $this->grupo;

        // Para la sesion por fechas todos los participantes son validos
        if ($this->form->tipo_sesion == SesionTipo::HORAS_PARTICIPANTE) {
            foreach ($this->participantes as $participante) {
                $this->form->selectedParticipanteIds[$participante->id] = true;
            }
        }

        $this->form->update();

        $sesion = new Sesion();
        $this->form->setSesion($sesion);

        $this->dispatch('refresh-sesiones');
        $this->showSuccessIndicator = true;
        $this->openDrawer = false;
    }

    #[On('edit-sesion')]
    public function editSesion(Sesion $sesion)
    {
        $this->isNew = false;
        $this->resetErrorBag();
        $this->form->resetRangeDates();

        $this->form->setSesion($sesion);
        $this->form->isNew = $this->isNew;

        $this->loadParticipantes();

        $column = 'duracion';

        if ($isChecked = $this->form->tipo_sesion == SesionTipo::SESION_GENERAL) {
            $column = 'asistencia';
        }

        $participantes = SesionParticipante::where('sesion_id', $sesion->id)
            ->pluck($column, 'participante_id')
            ->toArray();

        if (!empty($participantes)) {
            foreach ($participantes as $participanteId => $value) {
                $this->form->selectedParticipanteIds[$participanteId] = $isChecked ? (bool) $value : (int) $value;
            }

            // Si hay participantes que no estaban Activos cuando se creo la sesion, se marcan como Inactivos.
            // Esto se hace para que los participantes que no estaban Activos cuando se creo la sesion, se muestren en la lista de participantes
            // y se puedan marcar como Activos o Inactivos
            if (!empty($this->participantes) && !empty($this->form->selectedParticipanteIds)) {
                if ($this->participantes->count() > count($this->form->selectedParticipanteIds)) {

                    foreach ($this->participantes as $participante) {
                        if (!array_key_exists($participante->id, $this->form->selectedParticipanteIds)) {
                            $this->form->selectedParticipanteIds[$participante->id] = false;
                        }
                    }

                }
            }
        }
        else {
            foreach ($this->participantes as $participante) {
                $this->form->selectedParticipanteIds[$participante->id] = true;
            }

            $this->marcarTodo = true;
        }

        $this->openDrawer = true;
    }

    private function loadParticipantes() {
        if (!empty($this->grupo)) {
            $query = Participante::with([
                'ciudad:id,nombre,departamento_id',
                'ciudad.departamento:id,nombre,pais_id',
                'lastEstado.estado_registro:id,nombre,color,icon',
                'grupoactivo.lastEstadoParticipante.estado',
                'grupoactivo.grupo',
                //"grupoParticipante.lastEstadoParticipante.estado",
            ])->whereHas('cohortePaisProyecto', function($query) {
                    $query->where('cohorte_pais_proyecto.id', $this->cohortePaisProyecto->id)
                        ->whereNotNull('cohorte_participante_proyecto.active_at');
                })
                ->misRegistros()
                ->whereHas('grupoactivo', function ($subquery) {
                    $subquery->where('grupo_participante.grupo_id', $this->grupo->id)
                      ->whereNotNull('grupo_participante.active_at')
                      ->where('grupo_participante.user_id', auth()->user()->id);
                });

            if ($this->isNew) {
                $query->whereHas('grupoactivo.lastEstadoParticipante', function ($subquery) {
                    $subquery->whereIn('estado_participante.estado_id', [
                        Estado::ACTIVO,
                        Estado::REINGRESO,
                    ]);
                });
            }

            $query->select([
                    "id",
                    "slug",
                    "email",
                    "primer_nombre",
                    "segundo_nombre",
                    "tercer_nombre",
                    "primer_apellido",
                    "segundo_apellido",
                    "tercer_apellido",
                    "ciudad_id",
                    "created_at",
                    "documento_identidad",
                    "fecha_nacimiento",
                    "sexo",
                ]);

            if ($this->search !== '') {
                $query->where(function (Builder $builder) {
                    $builder->whereRaw(
                            "
                            CONCAT(
                                TRIM(COALESCE(primer_nombre, '')),
                                IF(TRIM(COALESCE(segundo_nombre, '')) != '', CONCAT(' ', TRIM(COALESCE(segundo_nombre, ''))), ''),
                                IF(TRIM(COALESCE(tercer_nombre, '')) != '', CONCAT(' ', TRIM(COALESCE(tercer_nombre, ''))), ''),
                                IF(TRIM(COALESCE(primer_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(primer_apellido, ''))), ''),
                                IF(TRIM(COALESCE(segundo_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(segundo_apellido, ''))), ''),
                                IF(TRIM(COALESCE(tercer_apellido, '')) != '', CONCAT(' ', TRIM(COALESCE(tercer_apellido, ''))), '')
                            ) like ?",
                            ['%' . $this->search . '%']
                        )
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('documento_identidad', 'like', '%' . $this->search . '%');
                });
            }

            $this->participantes = $query->get();
        }
    }
}
