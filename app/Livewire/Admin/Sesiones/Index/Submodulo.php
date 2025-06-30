<?php

namespace App\Livewire\Admin\Sesiones\Index;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Submodulo extends Component
{
    #[Layout('layouts.table8xl')]
    public function render()
    {
        return view('livewire.admin.sesiones.index.submodulo');
    }
}
