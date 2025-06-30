<?php

namespace App\Livewire\Resultadocuatro\Gestor\Directorio\Create;

use Livewire\Component;
use App\Models\Directorio;
use Livewire\Attributes\On;
use App\Livewire\Resultadocuatro\Gestor\Directorio\Create\Page as CreateDirectorio;

class Modal extends CreateDirectorio
{
    public $showSuccessIndicatorModal = false;

    public $openDrawer = false;

    public function render()
    {
        return view('livewire.resultadocuatro.gestor.directorio.create.modal', $this->getData())
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
            ]);
    }

    public function save()
    {
        $this->form->save();

        $directorio = Directorio::pluck("nombre", "id");


        $nuevoDirectorio = [$this->form->directorio->id => $this->form->directorio->nombre];

        $this->dispatch('refresh-list-directorios', $nuevoDirectorio);

        //$this->dispatch('nuevo-directorio', directorio: $this->form->directorio);
        $this->openDrawer = false;

        $this->showSuccessIndicatorModal = true;
    }

    #[On('open-directorio-form')]
    public function openDirectorioForm()
    {
        $directorio = new Directorio();

        $this->form->customReset();
        $this->form->setPais($this->pais);
        $this->form->setProyecto($this->proyecto);
        $this->form->setDirectorio($directorio);
        $this->form->init();

        $this->openDrawer = true;
    }
}
