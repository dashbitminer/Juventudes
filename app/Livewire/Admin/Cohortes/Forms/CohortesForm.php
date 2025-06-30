<?php
namespace App\Livewire\Admin\Cohortes\Forms;

use App\Models\Cohorte;
use Livewire\Form;

class CohortesForm extends Form
{
    public Cohorte $cohorte;

    public $readonly = false;

    public $showValidationErrorIndicator;

    public $nombre;

    public $pais = [];

    public $isEdit = false;


    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    protected function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'pais' => 'required'
        ];
    }

    public function setProyecto($id){
        /*$this->proyecto = Proyecto::find($id);
        $this->nombre = $this->proyecto->nombre;
        $this->pais = $this->proyecto->paises->pluck('id')->toArray();*/
    }

    public function save()
    {
        $this->validate();

        if($this->isEdit){
           
            
        }else {
           
        }
        
        
    
    }
}