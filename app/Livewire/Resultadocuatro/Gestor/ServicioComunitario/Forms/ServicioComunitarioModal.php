<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Forms;

use App\Models\Cohorte;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\ServicioComunitario;
use App\Models\ServicioComunitarioHistorico;
use Livewire\Form;

class ServicioComunitarioModal extends Form
{
    public $showValidationErrorIndicator = false;

    public $showSuccessIndicator = false;

    public $readonly = false;

    public Pais $pais;

    public $cohorte;

    public $proyecto;

    public $estado;

    public $progreso;

    public $observaciones;

    public $apoyos_requeridos;
    

    public ?ServicioComunitario $servicioComunitario;

    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    public function setPais(Pais $pais) {
        $this->pais = $pais;
    }

    public function setCohorte(Cohorte $cohorte) : void{
        $this->cohorte = $cohorte;
    }

    public function setProyecto(Proyecto $proyecto) : void{
        $this->proyecto = $proyecto;
    }

    public function setServicioComunitario(ServicioComunitario $servicioComunitario){
        $this->servicioComunitario = $servicioComunitario;

        $this->estado = $this->servicioComunitario->estado;
        $this->progreso = $this->servicioComunitario->progreso;
        $this->observaciones = $this->servicioComunitario->observaciones;
        $this->apoyos_requeridos = $this->servicioComunitario->apoyos_requeridos;
    }

    public function save()
    {
        

        \DB::transaction(function(){ 
            $estadoActual = $this->servicioComunitario->estado;
            
            $this->servicioComunitario->estado = $this->estado;
            $this->servicioComunitario->observaciones = $this->observaciones;
            $this->servicioComunitario->apoyos_requeridos = $this->apoyos_requeridos;
            $this->servicioComunitario->progreso = $this->progreso;

            $this->servicioComunitario->save();

            if($estadoActual != $this->estado){
                ServicioComunitarioHistorico::create([
                    'servicio_comunitario_id' => $this->servicioComunitario->id,
                    'estado' => $this->estado,
                ]);
            }
            
        });
    }
}