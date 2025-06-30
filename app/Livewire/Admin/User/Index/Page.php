<?php

namespace App\Livewire\Admin\User\Index;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Page extends Component
{
    public Filters $filters;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.user.index.page')
            ->layoutData([
                'adminpanel' => true,
            ]);
    }
}
