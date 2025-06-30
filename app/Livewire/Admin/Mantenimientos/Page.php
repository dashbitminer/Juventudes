<?php

namespace App\Livewire\Admin\Mantenimientos;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Page extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.mantenimientos.page')->layoutData([
            'adminpanel' => true,
        ]);
    }
}
