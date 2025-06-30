<?php

namespace App\Livewire\Admin\Cohortes\Usuarios\Index;

use App\Models\CohortePaisProyecto;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Page extends Component
{
    public Filters $filters;

    public CohortePaisProyecto $cohortePaisProyecto;

    public function mount(CohortePaisProyecto $cohortePaisProyecto)
    {
        $this->cohortePaisProyecto = $cohortePaisProyecto;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        
        return view('livewire.admin.cohortes.usuarios.index.page')
            ->layoutData([
                'adminpanel' => true,
            ]);
    }
}
