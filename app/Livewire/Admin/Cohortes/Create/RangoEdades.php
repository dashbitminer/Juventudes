<?php
namespace App\Livewire\Admin\Cohortes\Create;

use App\Livewire\Admin\Cohortes\Forms\CohortesForm;
use App\Models\CohortePaisProyectoRangoEdad;
use App\Models\Pais;
use Livewire\Component;
use Livewire\Attributes\On;

class RangoEdades extends Component{

    public CohortesForm $form;

    public $openDrawer = false;

    public $showSuccessIndicator = false;

    public $cohortePaisProyectoID;

    public $cohortePaisProyectoRangoEdades;

    public $rangoEdades;

    public $showRangoEdadesDropdown = false;

    public $edadInicio;

    public $edadFin;

    public $fechaComparacionInicio;

    public $fechaComparacionFin;

    public $fechaInicioLimite;

    public $fechaFinLimite;


    public function render(){
        return view('livewire.admin.cohortes.create.rango-edades');
    }

    #[On('openRangoEdades')]
    public function openRangoEdades($cohortePaisProyectoID){
        $this->openDrawer = true;
        $this->cohortePaisProyectoID = $cohortePaisProyectoID;

        $this->setRangoEdades($this->cohortePaisProyectoID);
    }

    public function save(){
        
        $this->validate([
            'edadInicio' => 'required|integer|min:0',
            'edadFin' => 'required|integer|min:0|gte:edadInicio',
            'fechaComparacionInicio' => 'required|date',
            'fechaComparacionFin' => 'required|date|after_or_equal:fechaComparacionInicio',
            'fechaInicioLimite' => 'required|date',
            'fechaFinLimite' => 'required|date|after_or_equal:fechaComparacionInicio',
        ]);

        CohortePaisProyectoRangoEdad::create([
            'cohorte_pais_proyecto_id' => $this->cohortePaisProyectoID,
            'edad_inicio' => $this->edadInicio,
            'edad_fin' => $this->edadFin,
            'fecha_comparacion_inicio' => $this->fechaComparacionInicio,
            'fecha_comparacion_fin' => $this->fechaComparacionFin,
            'fecha_inicio_limite' => $this->fechaInicioLimite,
            'fecha_fin_limite' => $this->fechaFinLimite,
        ]);

        $this->reset([
            'edadInicio', 
            'edadFin', 
            'fechaComparacionInicio', 
            'fechaComparacionFin', 
            'fechaInicioLimite', 
            'fechaFinLimite'
        ]);

        $this->setRangoEdades($this->cohortePaisProyectoID);


        $this->showSuccessIndicator = true;
    }

    public function setRangoEdades($cohortePaisProyectoID){
        $this->cohortePaisProyectoRangoEdades = CohortePaisProyectoRangoEdad::where('cohorte_pais_proyecto_id', $cohortePaisProyectoID)
        ->get();

        
    }

    protected $messages = [
        'edadInicio.required' => 'La edad de inicio es obligatoria.',
        'edadInicio.integer' => 'La edad de inicio debe ser un número entero.',
        'edadInicio.min' => 'La edad de inicio debe ser al menos 0.',
        'edadFin.required' => 'La edad de fin es obligatoria.',
        'edadFin.integer' => 'La edad de fin debe ser un número entero.',
        'edadFin.min' => 'La edad de fin debe ser al menos 0.',
        'edadFin.gte' => 'La edad de fin debe ser mayor o igual a la edad de inicio.',
        'fechaComparacionInicio.required' => 'La fecha de comparación de inicio es obligatoria.',
        'fechaComparacionInicio.date' => 'La fecha de comparación de inicio debe ser una fecha válida.',
        'fechaComparacionFin.required' => 'La fecha de comparación de fin es obligatoria.',
        'fechaComparacionFin.date' => 'La fecha de comparación de fin debe ser una fecha válida.',
        'fechaComparacionFin.after_or_equal' => 'La fecha de comparación de fin debe ser igual o posterior a la fecha de comparación de inicio.',
        'fechaInicioLimite.required' => 'La fecha de inicio límite es obligatoria.',
        'fechaInicioLimite.date' => 'La fecha de inicio límite debe ser una fecha válida.',
        'fechaFinLimite.required' => 'La fecha de fin límite es obligatoria.',
        'fechaFinLimite.date' => 'La fecha de fin límite debe ser una fecha válida.',
        'fechaFinLimite.after_or_equal' => 'La fecha de fin límite debe ser igual o posterior a la fecha de comparación de inicio.',
    ];

    public function removeRangoEdad($cohortePaisProyectoRangoEdadID){
        CohortePaisProyectoRangoEdad::find($cohortePaisProyectoRangoEdadID)->delete();
        $this->setRangoEdades($this->cohortePaisProyectoID);
    }
}
