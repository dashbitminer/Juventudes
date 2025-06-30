<?php
namespace App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Revisar;

use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Edit\Page as EditPage;
use App\Models\ServicioComunitario;
use Livewire\Attributes\Layout;

class Page extends EditPage
{
    public ServicioComunitario $servicio_comunitario;
    #[Layout('layouts.app')]
    public function render()
    {
        abort_if(
            !auth()->user()->can('Ver visualizador'),
            403
        );

        $this->servicio_comunitario = $this->form->servicioComunitario;

        $this->form->readonly = true;
        return view('livewire.resultadocuatro.gestor.servicio_comunitario.revisar.page', $this->getData())
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte,
                'resultadocuatro' => true,
            ]);
    }
}
