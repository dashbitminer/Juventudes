<?php
namespace App\Livewire\Admin\Cohortes\Edit;

use App\Livewire\Admin\Cohortes\Forms\CohortesForm;
use App\Models\CohortePaisProyecto;
use App\Models\Pais;
use Livewire\Component;
use Livewire\Attributes\On;


class Page extends Component{

    public $openDrawer = false;

    public $showSuccessIndicator = false;

    public $nombre;

    public $fecha_inicio;

    public $fecha_fin;

    public CohortePaisProyecto $cohortePaisProyecto;

    public function mount(){
        
    }

    public function render(){
        return view('livewire.admin.cohortes.edit.page');
    }

    #[On('openEdit')]
    public function openEdit($cohortePaisProyectoID){

        $this->openDrawer = true;

        $this->cohortePaisProyecto = CohortePaisProyecto::where('id', $cohortePaisProyectoID)->firstOrFail();

        $this->nombre = $this->cohortePaisProyecto->cohorte->nombre;
        $this->fecha_inicio = $this->cohortePaisProyecto->fecha_inicio;
        $this->fecha_fin = $this->cohortePaisProyecto->fecha_fin;
        
    }

    public function save(){
        $this->validate();
       // dd($this->cohortePaisProyecto->id);

        $this->cohortePaisProyecto->fecha_inicio = $this->fecha_inicio;
        $this->cohortePaisProyecto->fecha_fin = $this->fecha_fin;

        $this->cohortePaisProyecto->save();

        $this->showSuccessIndicator = true;
        $this->openDrawer = false;

        $this->cohortePaisProyecto = new CohortePaisProyecto();

        $this->reset(['nombre', 'fecha_inicio', 'fecha_fin']);

        $this->dispatch('refresh-cohortes');
    }

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ];
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_inicio.before_or_equal' => 'La fecha de inicio debe ser anterior o igual a la fecha de fin.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
        ];
    }
}
