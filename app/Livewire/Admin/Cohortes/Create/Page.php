<?php
namespace App\Livewire\Admin\Cohortes\Create;

use App\Livewire\Admin\Cohortes\Forms\CohortesForm;
use App\Models\Cohorte;
use App\Models\CohortePaisProyecto;
use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\Attributes\On;

class Page extends Component{

    public Proyecto $proyecto;

    public $paises = [];

    public $cohortes = [];

    public $openDrawer = false;

    public $showSuccessIndicator = false;

    public $cohorte;

    public $fecha_inicio;

    public $fecha_fin;

    public $paisProyectoIds = [];

    public function render(){

        return view('livewire.admin.cohortes.create.page');
    }

    #[On('openCreate')]
    public function openCreate(){

        $paisProyectos = \App\Models\PaisProyecto::with(['pais'])
            ->where('proyecto_id', $this->proyecto->id)
            ->active();

        $this->paises = $paisProyectos->get()
            ->pluck('pais.nombre', 'id')
            ->toArray();

        $proyectoCohorte = CohortePaisProyecto::whereIn('pais_proyecto_id', $paisProyectos->pluck('id')->toArray())
            ->pluck('cohorte_id')
            ->toArray();

        $this->cohortes = Cohorte::whereNotIn('id', $proyectoCohorte)
            ->pluck('nombre', 'id');

        $this->openDrawer = true;
    }
    protected $rules = [
        'cohorte' => 'required|string|max:255',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after:fecha_inicio',
        'paisProyectoIds' => 'required|array|min:1',
        'paisProyectoIds.*' => 'exists:pais_proyecto,id',
    ];

    public function save()
    {
        $this->validate();

        $cohorte = Cohorte::firstOrCreate(['nombre' => $this->cohorte]);

        foreach ($this->paisProyectoIds as $paisProyectoId) {
            CohortePaisProyecto::create([
                'cohorte_id' => $cohorte->id,
                'pais_proyecto_id' => $paisProyectoId,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'active_at' => now(),
            ]);
        }

        $this->showSuccessIndicator = true;
        $this->openDrawer = false;

        $this->reset(['cohorte', 'fecha_inicio', 'fecha_fin', 'paisProyectoIds']);

        $this->dispatch('refresh-cohortes');
    }

    protected $messages = [
        'cohorte.required' => 'El nombre del cohorte es obligatorio.',
        'cohorte.string' => 'El nombre del cohorte debe ser una cadena de texto.',
        'cohorte.max' => 'El nombre del cohorte no debe exceder los 255 caracteres.',
        'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
        'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
        'fecha_fin.required' => 'La fecha de fin es obligatoria.',
        'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
        'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
        'paisProyectoIds.required' => 'Debe seleccionar al menos un país proyecto.',
        'paisProyectoIds.array' => 'La selección de país proyecto debe ser un arreglo.',
        'paisProyectoIds.min' => 'Debe seleccionar al menos un país proyecto.',
        'paisProyectoIds.*.exists' => 'El país proyecto seleccionado no es válido.',
    ];
}
