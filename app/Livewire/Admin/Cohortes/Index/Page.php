<?php

namespace App\Livewire\Admin\Cohortes\Index;

use App\Models\CohortePaisProyecto;
use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;

class Page extends Component
{

    public Proyecto $proyecto;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.cohortes.index.page');
    }

    
}
