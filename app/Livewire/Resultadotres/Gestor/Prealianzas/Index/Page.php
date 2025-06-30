<?php

namespace App\Livewire\Resultadotres\Gestor\Prealianzas\Index;

use App\Models\Pais;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\Attributes\Layout;

class Page extends Component
{

    public Pais $pais;

    public Proyecto $proyecto;

    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Listado Pre Alianza'),
            403
        );

        return view('livewire.resultadotres.gestor.prealianzas.index.page')
        ->layoutData([
            //    'cohorte' => $this->cohorte,
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'alianza' => true,
                'resultadotres' => true,
            ]);
    }
}
