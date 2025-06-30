<?php

namespace App\Livewire\Resultadotres\Gestor\Visualizador\Forms;

use App\Models\Apalancamiento;
use App\Models\CostShare;
use App\Models\Alianza;
use Livewire\Form;

class ValidarForm extends Form
{
    public Apalancamiento $apalancamiento;

    public CostShare $costShare;

    public Alianza $alianza;

    public $showValidationErrorIndicator = false;

    public $tipoFormulario;


    public function boot()
    {
        $this->withValidator(function ($validator) {

            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    public function init($tipoFormulario){
        $this->tipoFormulario = $tipoFormulario;
    }

    public function save(){
        
    }

}
