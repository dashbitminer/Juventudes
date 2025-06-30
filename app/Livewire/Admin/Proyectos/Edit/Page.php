<?php
namespace App\Livewire\Admin\Proyectos\Edit;

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
        $this->form->isEdit = true;
        $this->paises = Pais::pluck('nombre', 'id')->toArray(); 

        $this->form->isEdit = true;
    }

    public function render(){
        return view('livewire.admin.proyectos.edit.page');
    }

    #[On('openEdit')]
    public function openEdit($id){
        $this->form->isEdit = true;
        $this->form->setProyecto($id);
        $this->openDrawer = true;
    }

    public function save(){
        $this->form->save();
        $this->showSuccessIndicator = true;
        $this->openDrawer = false;

        $this->dispatch('refresh-proyectos');
    }
}
