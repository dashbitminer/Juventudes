<?php

namespace App\Livewire\Admin\Proyectos\Index;

use App\Models\Pais;
use App\Models\Proyecto;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;

class Page extends Component
{

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.proyectos.index.page', [
            'proyectos' => Proyecto::all(),
            'paises' => Pais::active()->pluck("nombre", "id"),
        ]);
    }

    
}
