<?php
namespace App\Livewire\Admin\Cohortes\Create;

use App\Livewire\Admin\Cohortes\Forms\CohortesForm;
use App\Models\CohortePaisProyectoPerfil;
use App\Models\Pais;
use App\Models\Perfil;
use App\Models\PerfilesParticipante;
use Livewire\Component;
use Livewire\Attributes\On;

class Perfiles extends Component{

    public $openDrawer = false;

    public $showSuccessIndicator = false;

    public $perfil;

    public $comentario;

    public $cohortePaisProyectoPerfiles;

    public $perfiles;

    public $cohortePaisProyectoID;

    public $showPerfilesDropdown = false;


    public function render(){
        return view('livewire.admin.cohortes.create.perfiles');
    }

    #[On('openPerfiles')]
    public function openPerfiles($cohortePaisProyectoID){
        $this->openDrawer = true;

        $this->cohortePaisProyectoID = $cohortePaisProyectoID;
        
        $this->setPerfil($this->cohortePaisProyectoID);

    }

    public function save(){

        $this->validate([
            'perfil' => 'required',
            'comentario' => 'required|string',
        ]);

        CohortePaisProyectoPerfil::create([
            'cohorte_pais_proyecto_id' => $this->cohortePaisProyectoID,
            'perfil_participante_id' => $this->perfil,
            'comentario' => $this->comentario,
        ]);

        $this->reset(['perfil', 'comentario']);
       
        $this->showSuccessIndicator = true;

        $this->setPerfil($this->cohortePaisProyectoID);
    }

    public function setPerfil($cohortePaisProyectoID){
        $this->cohortePaisProyectoPerfiles = CohortePaisProyectoPerfil::where('cohorte_pais_proyecto_id', $cohortePaisProyectoID)
        ->get();

        $perfilesSelected = $this->cohortePaisProyectoPerfiles->pluck('perfil_participante_id')->toArray();

        $this->perfiles = PerfilesParticipante::whereNotIn('id', $perfilesSelected)
        ->pluck('nombre', 'id');

        $this->showPerfilesDropdown = $this->perfiles->count() > 0;
    }

    protected $messages = [
        'perfil.required' => 'El perfil es obligatorio.',
        'comentario.string' => 'El comentario debe ser una cadena de texto.',
    ];

    public function removePerfilParticipante($cohortePaisProyectoPerfilID){
        CohortePaisProyectoPerfil::find($cohortePaisProyectoPerfilID)->delete();
        $this->setPerfil($this->cohortePaisProyectoID);
    }

}
