<?php

namespace App\Livewire\Resultadocuatro\Gestor\Directorio\Create;

use App\Models\Directorio;
use App\Models\Pais;
use App\Models\Ciudad;
use Livewire\Component;
use App\Models\Proyecto;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Livewire\Resultadocuatro\Gestor\Directorio\initForm;
use App\Livewire\Resultadocuatro\Gestor\Directorio\Forms\DirectorioForm;
use App\Models\Cohorte;

class Page extends Component
{

    use WithFileUploads, initForm;

    public Pais $pais;

    public Proyecto $proyecto;

    public DirectorioForm $form;

    public ?Cohorte $cohorte;

    public $showSuccessIndicator = false;

    public $titulo = 'Crear Directorio';

    public function mount(?Directorio $directorio)
    {
        $this->form->setPais($this->pais);
        $this->form->setProyecto($this->proyecto);
        $this->form->setDirectorio($directorio);
        $this->form->init();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadocuatro.gestor.directorio.create.page', $this->getData())
            ->layoutData([
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'cohorte' => $this->cohorte ?? '',
                'directorio' => true,
                'resultadocuatro' => true,
            ]);
    }

    public function updated($name, $value)
    {
        switch ($name) {
            case 'form.departamento_id':
                $this->form->setCiudades($value);
                break;

            default:
                # code...
                break;
        }
    }

    public function save()
    {
        $this->form->save();

        $this->showSuccessIndicator = true;

        sleep(1);

        $route = $this->cohorte ? 'directorio.cohorte.index' : 'directorio.index';

        $params = [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
        ];

        if ($this->cohorte) {
            $params['cohorte'] = $this->cohorte->slug;
        }

        return redirect()->route($route, $params);
    }
}
