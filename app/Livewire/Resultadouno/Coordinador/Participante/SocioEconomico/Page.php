<?php

namespace App\Livewire\Resultadouno\Coordinador\Participante\SocioEconomico;

use Livewire\Component;
use App\Models\Participante;
use App\Models\Socioeconomico;
use App\Models\Pais;
use App\Livewire\Resultadouno\Gestor\Participante\Forms\SocioeconomicoForm;

class Page extends Component
{

    public Participante $participante;

    public SocioeconomicoForm $form;

    public Pais $pais;

    // Deshabilitar todos los campos del formulario
    public $disabled = true;

    public $factoresPerSocOtro = false;

    public function mount()
    {
        $this->form->setPais($this->pais);

        $socioeconomico = Socioeconomico::firstOrCreate([
            'participante_id' => $this->participante->id
        ]);

        $this->form->setSocioEconomico($socioeconomico, $this->participante);

        $this->mostrarFactorOtro();

    }

    public function render()
    {
        return view('livewire.resultadouno.coordinador.participante.socio-economico.page');
    }

    public function mostrarFactorOtro()
    {
        // $auxArray = $this->form->factorPerSocs->toArray();
        // $id = array_search('Otros (especificar)', $auxArray);
        // $this->factoresPerSocOtro = in_array($id, $this->form->factoresPerSocSelected);

        // Ensure factorPerSocs is an object
        if (is_object($this->form->factorPerSocs)) {
            $auxArray = $this->form->factorPerSocs->toArray();
            $id = array_search('Otros (especificar)', $auxArray);
            $this->factoresPerSocOtro = in_array($id, $this->form->factoresPerSocSelected);
        } else {
            // Handle the case where factorPerSocs is not an object
            throw new \Exception('Expected factorPerSocs to be an object.');
        }
    }

}
