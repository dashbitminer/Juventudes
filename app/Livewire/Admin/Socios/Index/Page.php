<?php

namespace App\Livewire\Admin\Socios\Index;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\SocioImplementador;
use App\Models\Pais;

class Page extends Component
{
    #[Validate('required', message: 'El nombre es obligatorio.')]
    public $nombre;

    #[Validate('required', message: 'El pais es obligatorio.')]
    public $pais_id;

    public $paises;

    public $openDrawer = false;

    public $openDrawerEdit = false;

    public $showSuccessIndicator = false;

    public SocioImplementador $socio;

    public function mount()
    {
        $this->paises = Pais::all();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.socios.index.page');
    }

    public function save()
    {
        $this->validate();

        SocioImplementador::create([
            'nombre' => $this->nombre,
            'pais_id' => $this->pais_id,
            'active_at' =>now(),
        ]);

        $this->reset(['nombre', 'pais_id']);

        $this->showSuccessIndicator = true;
        $this->openDrawer = false;

        $this->dispatch('refresh-socios');
    }

    #[On('openEdit')]
    public function openEdit($id) {
        $this->socio = SocioImplementador::find($id);

        if ($this->socio instanceof SocioImplementador) {
            $this->nombre = $this->socio->nombre;
            $this->pais_id = $this->socio->pais_id;

            $this->openDrawerEdit = true;
        }
    }

    public function editSocio()
    {
        $this->validate();

        $this->socio->nombre = $this->nombre;
        $this->socio->pais_id = $this->pais_id;
        $this->socio->save();

        $this->reset(['nombre', 'pais_id']);

        $this->openDrawerEdit = false;
        $this->showSuccessIndicator = true;

        $this->dispatch('refresh-socios');
    }
}
