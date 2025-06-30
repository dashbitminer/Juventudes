<?php

namespace App\Livewire\Resultadotres\Gestor\Apalancamientos\Index;

use App\Livewire\Resultadotres\Gestor\Apalancamientos\Forms\ApalancamientoForm;
use App\Livewire\Resultadotres\Gestor\Apalancamientos\InitializeApalancamientoForm;
use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Page extends Component
{
    use InitializeApalancamientoForm;

    public ApalancamientoForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Listado Apalancamiento'),
            403
        );
        return view('livewire.resultadotres.gestor.apalancamientos.index.page',
        $this->initializeProperties())
        ->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'apalancamiento' => true,
            'alianza' => true,
            'resultadotres' => true,
        ]);
    }
}
