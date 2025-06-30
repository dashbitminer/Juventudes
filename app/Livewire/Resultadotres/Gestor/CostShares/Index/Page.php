<?php

namespace App\Livewire\Resultadotres\Gestor\CostShares\Index;


use App\Livewire\Resultadotres\Gestor\CostShares\Forms\CostShareForm;
use App\Livewire\Resultadotres\Gestor\CostShares\InitializeForm;
use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Page extends Component
{
    use InitializeForm;

    public CostShareForm $form;

    public Pais $pais;

    public Proyecto $proyecto;

    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Listado Costo Compartido'),
            403
        );

        return view('livewire.resultadotres.gestor.cost-shares.index.page',
        $this->initializeProperties())
        ->layoutData([
            'pais' => $this->pais,
            'proyecto' => $this->proyecto,
            'resultadotres' => true,
        ]);
    }
}
