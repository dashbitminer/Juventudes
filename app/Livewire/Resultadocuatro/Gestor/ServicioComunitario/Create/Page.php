<?php

namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Create;

use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Forms\ServicioComunitarioForm;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\InitForm;
use App\Models\Cohorte;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\RecursoPrevisto;
use App\Models\RecursoPrevistoCostShare;
use App\Models\RecursoPrevistoLeverage;
use App\Models\ServicioComunitario;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Page extends Component
{
    use InitForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public Cohorte $cohorte;

    public ServicioComunitarioForm $form;

    public $showSuccessIndicator = false;

    public $titulo = 'Crear proyecto de servicio comunitario';

    public $recursoPrevistoUSAID;

    public $recursoPrevistoCOST_SHARE;

    public $recursoPrevistoLEVERAGE;

    public $recursoPrevistoCOST_SHARE_OTRO;

    public $recursoPrevistoLEVERAGE_OTRO;

    public $edit = true;

    public function mount(?ServicioComunitario $servicioComunitario)
    {

        // abort_if(
        //     !auth()->user()->can('Registrar servicio comunitario'),
        //     403
        // );

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

        $this->form->estado = Estados::EnTiempo;
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

        $field = explode('.', $name);
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
                    $this->form->{$field[1]} = 0;
                }
            break;

            case 'form.fecha_entrega':
                 $this->validate([
                    $name => 'required|date|after_or_equal:'.$this->form->cohorteStartDate.'|before_or_equal:' . $this->form->cohorteEndDate,
                ]);
            break;

            case 'form.personal_socio_seguimiento':
            case 'form.nombre':
            case 'form.nombre_reporta':
            case 'form.nombre_valida':
                if (preg_match('/^\d+$/', $value)) {
                    $this->addError($name, 'El campo no puede contener solo números.');
                }
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

    public function messages(){
        return [
            'form.fecha_entrega.required' => 'La fecha entrega es obligatoria.',
            'form.fecha_entrega.date' => 'Por favor, introduce una fecha entrega válida.',
            'form.fecha_entrega.after_or_equal' => 'La fecha entrega debe ser igual o posterior a :date.',
            'form.fecha_entrega.before_or_equal' => 'La fecha entrega debe ser igual o anterior a :date.',

            'form.fecha_elaboracion.required' => 'La fecha elaboracion es obligatoria.',
            'form.fecha_elaboracion.date' => 'Por favor, introduce una fecha elaboracion válida.',
            //'form.fecha_elaboracion.after_or_equal' => 'La fecha elaboracion debe ser igual o posterior a :date.',
            //'form.fecha_elaboracion.before_or_equal' => 'La fecha elaboracion debe ser igual o anterior a :date.',

            'form.fecha_valida.required' => 'La fecha de validacion es obligatoria.',
            'form.fecha_valida.date' => 'Por favor, introduce una fecha de validacion válida.',
            //'form.fecha_valida.after_or_equal' => 'La fecha de validacion debe ser igual o posterior a :date.',
            //'form.fecha_valida.before_or_equal' => 'La fecha de validacion debe ser igual o anterior a :date.',
        ];
    }
}
