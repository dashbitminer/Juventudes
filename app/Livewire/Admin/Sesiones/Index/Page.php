<?php

namespace App\Livewire\Admin\Sesiones\Index;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\Sesion;

class Page extends Component
{
    #[Layout('layouts.table8xl')]
    public function render()
    {
        return view('livewire.admin.sesiones.index.page');
    }
}
