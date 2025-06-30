<?php

namespace App\Livewire\Admin\Sesiones\Sesion;

use App\Models\CohortePaisProyecto;
use App\Models\CohortePaisProyectoPerfil;
use App\Models\Pais;
use App\Models\Modulo;
use App\Models\Sesion;
use App\Models\SesionTitulo;
use App\Models\SesionTipo;
use App\Models\Titulo;
use Livewire\Component;
use App\Models\Actividad;
use App\Models\Submodulo;
use Livewire\Attributes\On;
use App\Models\Subactividad;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

class Table extends Component
{
    use WithPagination, Searchable, CreateAction, EditAction, DeleteAction;

    public $perPage = 10;

    public $selectedIds = [];

    public $openDrawer = false;

    public $openDrawerEdit = false;

    public $showSuccessIndicator = false;

    public $tableIdsOnPage = [];

    public SesionTitulo $sesionTitulo;

    public SesionTipo $sesionTipo;


    public $titulos;

    public $actividades;

    public $subactividades;

    public $modulos;

    public $submodulos;

    public $paises;

    public $proyectos;

    public $cohortes;

    public $perfiles;

    public $cohortePaisProyectos;

    public $months;

    #[Validate(rule: 'required', message: 'El campo es requerido')]
    public $tipo_sesion;

    #[Validate(rule: 'required', message: 'El campo es requerido')]
    public $tipo_titulo;

    #[Validate(rule: 'required_if:tipo_titulo,0', message: 'El campo es requerido')]
    public $titulo_id;

    #[Validate(rule: 'required', message: 'El campo es requerido')]
    public $pais_id;

    #[Validate(rule: 'required', message: 'El campo es requerido')]
    public $proyecto_id;

    #[Validate(rule: 'required', message: 'El campo es requerido')]
    public $cohorte_id;

    public $cohorte_pais_proyecto_id;

    #[Validate(rule: 'required', message: 'El campo es requerido')]
    public $perfil_id;

    #[Validate(rule: 'required', message: 'El campo es requerido')]
    public $actividad_id;

    public $subactividad_id;

    public $modulo_id;

    public $submodulo_id;


    public function mount()
    {
        $this->titulos = Titulo::all()->pluck('nombre', 'id');
        $this->actividades = Actividad::all()->pluck('nombre', 'id');
        $this->subactividades = Subactividad::all()->pluck('nombre', 'id');
        $this->modulos = Modulo::all()->pluck('nombre', 'id');
        $this->submodulos = Submodulo::all()->pluck('nombre', 'id');
        $this->paises = Pais::all()->pluck('nombre', 'id');

        $this->months = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        ];
    }

    public function updated($propertyName, $value)
    {
        switch ($propertyName) {
            case 'pais_id':
                $this->clearValidation('pais_id');
                $this->proyectos = null;

                $proyectos = Pais::with('proyectos')->find($this->pais_id);

                $this->proyectos = $proyectos->proyectos()->pluck('proyectos.nombre', 'proyectos.id');

                if ($this->proyectos->count() == 0) {
                    $this->proyectos = null;
                    $this->cohortes = null;

                    $this->addError('pais_id', 'El pais no tiene ningun proyecto!');
                }
                break;

            case 'proyecto_id':
                $this->clearValidation('proyecto_id');
                $this->cohortes = null;

                $this->cohortePaisProyectos = CohortePaisProyecto::with(['paisProyecto', 'cohorte'])
                    ->whereHas('paisProyecto', function ($query) {
                        $query->where('pais_id', $this->pais_id)
                            ->where('proyecto_id', $this->proyecto_id);
                    })
                    ->get();

                foreach ($this->cohortePaisProyectos as $result) {
                    // El ID de CohortePaisProyecto sera para la lista de cohortes
                    $this->cohortes[$result->id] = $result->cohorte->nombre;
                }

                if (empty($this->cohortes)) {
                    $this->cohortes = null;
                    $this->addError('proyecto_id', 'No hay cohortes para este proyecto');
                }
                else {
                    asort($this->cohortes);
                }
                break;

            case 'cohorte_id':
                $this->clearValidation('cohorte_id');
                $this->perfiles = null;

                $this->cohorte_pais_proyecto_id = $this->cohorte_id;

                if (!empty($this->cohorte_pais_proyecto_id)) {
                    $perfiles = CohortePaisProyectoPerfil::with('perfilesParticipante')
                        ->where('cohorte_pais_proyecto_id', $this->cohorte_pais_proyecto_id)
                        ->get();

                    foreach ($perfiles as $perfil) {
                        // El ID de CohortePaisProyectoPerfil sera para la lista de perfiles
                        $this->perfiles[$perfil->id] = $perfil->perfilesParticipante->nombre;
                    }

                    if (empty($this->perfiles)) {
                        $this->perfiles = null;
                        $this->addError('cohorte_id', 'No hay perfiles para esta cohorte');
                    }
                }
                break;
        }
    }

    #[On('refresh-sesiones')]
    public function render()
    {
        $query = SesionTitulo::with([
            'titulos',
            'actividad',
            'subactividad',
            'modulo',
            'submodulo',
            'cohortePaisProyecto.cohorte',
            // 'cohortePaisProyecto.paisProyecto.proyecto',
            'cohortePaisProyecto.paisProyecto.pais',
            'cohortePaisProyectoPerfil.perfilesParticipante',
            ])
            ->orderBy('created_at', 'desc');

        $query = $this->applySearch($query);

        $sesiones = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $sesiones->map(fn ($model) => (string) $model->id)->toArray();

        return view('livewire.admin.sesiones.sesion.table', [
            'sesiones' => $sesiones,
        ])
        ->layout('layouts.app', ['title' => 'Sesiones', 'breadcrumb' => 'Sesiones', 'admin' => true]);
    }

    public function resetFields()
    {
        $this->reset([
            'tipo_sesion',
            'tipo_titulo',
            'titulo_id',
            'pais_id',
            'proyecto_id',
            'cohorte_id',
            'cohorte_pais_proyecto_id',
            'perfil_id',
            'actividad_id',
            'subactividad_id',
            'modulo_id',
            'submodulo_id',
        ]);

        $this->proyectos = null;
        $this->cohortes = null;
        $this->perfiles = null;
    }

}
