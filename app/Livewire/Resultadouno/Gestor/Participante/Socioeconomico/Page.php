<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Socioeconomico;

use App\Livewire\Resultadouno\Gestor\Participante\Forms\SocioeconomicoForm;
use App\Models\Participante;
use App\Models\Socioeconomico;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\Pais;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Page extends Component
{
    public SocioeconomicoForm $form;

    public Participante $participante;

    public Cohorte $cohorte;

    public Proyecto $proyecto;

    public Pais $pais;
    public $participanteName;

    public $showSuccessIndicator = false;

    public $showValidationErrorIndicator = false;

    public $factoresPerSocOtro = false;

    public function mount(Participante $participante)
    {
        $this->participante = $participante;

        $socioeconomico = Socioeconomico::firstOrCreate([
            'participante_id' => $participante->id
        ]);

        $this->participanteName = $participante->full_name;

        $this->form->estudia_actualmente = $participante->estudia_actualmente;

        $this->form->setCohorte($this->cohorte);
        $this->form->setProyecto($this->proyecto);
        $this->form->setPais($this->pais);

        $this->form->setSocioEconomico($socioeconomico, $participante);

        $this->mostrarFactorOtro();
    }

    public function submit($action)
    {
        $status = ($action === 'draft') ? SocioeconomicoForm::DRAFT : SocioeconomicoForm::PENDING;
        $this->form->setStatus($status);
        $this->form->update();
        $this->showSuccessIndicator = true;

        if ($status !== SocioeconomicoForm::DRAFT) {
            //$this->redirectAfterDelay("/dashboard");
            $this->participante->estados_registros()->attach(2);

            $this->redirectAfterDelay();

            // // Redirect to the named route 'participantes'
            // return redirect()->route('participantes', [
            //     'pais' => $this->pais->slug,
            //     'proyecto' => $this->proyecto->slug,
            //     'cohorte' => $this->cohorte->slug,
            // ]);
        }else{
             $this->redirectAfterDelay();
        }
    }

    private function redirectAfterDelay()
    {
        //$this->redirect($url);
        // Wait for 2 seconds before redirecting
        usleep(3000000);

        return redirect()->route('participantes', [
            'pais' => $this->pais->slug,
            'proyecto' => $this->proyecto->slug,
            'cohorte' => $this->cohorte->slug,
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.resultadouno.gestor.participante.socioeconomico.page')
            ->layoutData([
                'cohorte' => $this->cohorte,
                'pais' => $this->pais,
                'proyecto' => $this->proyecto,
                'resultadouno' => true,
            ]);
    }

    public function updated($property, $value)
    {
        if (str($property)->startsWith('form.factoresPerSocSelected')) {

            $this->mostrarFactorOtro();
        }
    }

    public function mostrarFactorOtro()
    {
        $id = array_search('Otros (especificar)', $this->form->factorPerSocs->toArray());
        $this->factoresPerSocOtro = in_array($id, $this->form->factoresPerSocSelected);
    }
}
