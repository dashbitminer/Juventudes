<?php
namespace App\Livewire\Admin\Proyectos\Forms;

use App\Models\Proyecto;
use Livewire\Form;

class ProyectosForm extends Form
{
    public Proyecto $proyecto;

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
        $this->proyecto = Proyecto::find($id);
        $this->nombre = $this->proyecto->nombre;
        $this->pais = $this->proyecto->paises->pluck('id')->toArray();
    }

    public function save()
    {
        $this->validate();

        if($this->isEdit){
            $this->proyecto->nombre = $this->nombre;
            $this->proyecto->save();
            
        }else {
            // Save the proyecto to the database
            
            $proyecto = Proyecto::create([
                'nombre' => $this->nombre,
            ]);

            // Save the paises to the database
            $proyecto->paises()->sync(
                collect($this->pais)->mapWithKeys(function ($paisId) {
                    return [$paisId => ['active_at' => now()]];
                })
            );
        }
        
        
    
    }
}