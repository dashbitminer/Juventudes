<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Edit;

use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados;
use App\Models\Pais;
use App\Models\Cohorte;
use Livewire\Component;
use App\Models\Proyecto;
use App\Models\RecursoPrevisto;
use Livewire\Attributes\Layout;
use App\Models\ServicioComunitario;
use App\Models\RecursoPrevistoLeverage;
use App\Models\RecursoPrevistoCostShare;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\InitForm;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Forms\ServicioComunitarioForm;

class Page extends Component
{
    use InitForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public ServicioComunitarioForm $form;

    public $showSuccessIndicator = false;

    public $titulo = 'Editar Servicio Comunitario';

    public $recursoPrevistoUSAID;

    public $recursoPrevistoCOST_SHARE;

    public $recursoPrevistoLEVERAGE;

    public $recursoPrevistoCOST_SHARE_OTRO;

    public $recursoPrevistoLEVERAGE_OTRO;


    public $edit = true;

    public function mount(?ServicioComunitario $servicioComunitario)
    {
        $this->form->setPais($this->pais);
        $this->form->setServicioComunitario($servicioComunitario);
        $this->form->setCohorte($this->cohorte);
        $this->form->setProyecto($this->proyecto);
        $this->form->setSocioImplementador($this->getSocioImplementador());
         $this->form->setCohortePaisProyecto();
        $this->form->init();

        $this->recursoPrevistoUSAID = RecursoPrevisto::USAID;
        $this->recursoPrevistoCOST_SHARE = RecursoPrevisto::COST_SHARE;
        $this->recursoPrevistoLEVERAGE = RecursoPrevisto::LEVERAGE;
        $this->recursoPrevistoCOST_SHARE_OTRO = RecursoPrevistoCostShare::OTRO;
        $this->recursoPrevistoLEVERAGE_OTRO = RecursoPrevistoLeverage::OTRO;


        if($servicioComunitario->estado == Estados::Completado->value){
            $this->form->readonly = true;
        }

        $this->form->fecha_entrega = optional($this->form->fecha_entrega)->format('Y-m-d');
        $this->form->fecha_elaboracion = optional($this->form->fecha_elaboracion)->format('Y-m-d');
        $this->form->fecha_valida = optional($this->form->fecha_valida)->format('Y-m-d');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.servicio_comunitario.create.page', $this->getData())
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte,
                'resultadocuatro' => true,
            ]);
    }

    public function updated($name, $value)
    {
        switch ($name) {
            case 'form.departamento_id':
                $this->form->setCiudades($value);
                break;
            case 'form.recursos_previstos':
                    $this->form->recursos_previstos_usaid = '';
                    $this->form->recursos_previstos_cost_share = '';
                    $this->form->recursos_previstos_leverage = '';
                break;
            case 'form.total_jovenes':
            case 'form.total_adultos_jovenes':
            case 'form.monto_local':
            case 'form.monto_dolar':
            case 'form.total_poblacion_directa':
            case 'form.total_poblacion_indirecta':
            case 'form.progreso':
                if($value < 0){
                    $field = explode('.', $name);
                    $this->form->{$field[1]} = 0;
                }
            break;

            case 'form.fecha_entrega':
                $this->validate([
                   $name => 'required|date|after_or_equal:'.$this->form->cohorteStartDate.'|before_or_equal:' . $this->form->cohorteEndDate,
               ]);
           break;

            default:
                # code...
                break;
        }
    }

    public function save()
    {
        $this->form->save();
        $this->showSuccessIndicator = true;

        sleep(1);

        return redirect()->route('servicio-comunitario.index', [
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'cohorte' => $this->cohorte,
        ]);
    }


}
