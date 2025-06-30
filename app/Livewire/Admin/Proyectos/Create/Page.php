<?php
namespace App\Livewire\Admin\Proyectos\Create;

use App\Livewire\Admin\Proyectos\Forms\ProyectosForm;
use App\Models\Pais;
use Livewire\Component;
use Livewire\Attributes\On;

class Page extends Component{

    public ProyectosForm $form;

    public $openDrawer = false;

    public $showSuccessIndicator = false;

    public $paises = [];

    public function mount(){
        $this->paises = Pais::pluck('nombre', 'id')->toArray();     
    }

    public function render(){
        return view('livewire.admin.proyectos.create.page');
    }

    #[On('openCreate')]
    public function openCreate(){
        $this->openDrawer = true;
    }

    public function save(){
        $this->form->save();
        $this->showSuccessIndicator = true;
        $this->openDrawer = false;

        $this->dispatch('refresh-proyectos');
    }
}
