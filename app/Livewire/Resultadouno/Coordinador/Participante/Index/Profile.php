<?php

namespace App\Livewire\Resultadouno\Coordinador\Participante\Index;

use Livewire\Component;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Etnia;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\ApoyoHijo;
use App\Models\Parentesco;
use App\Models\EstadoCivil;
use App\Models\Discapacidad;
use App\Models\PaisProyecto;
use App\Models\Participante;
use App\Models\ProyectoVida;
use App\Models\SeccionGrado;
use App\Models\TurnoEstudio;
use App\Models\NivelAcademico;
use App\Models\NivelEducativo;
use App\Models\CohorteSocioUser;
use App\Models\PaisProyectoSocio;
use App\Models\GrupoPerteneciente;
use App\Models\ComparteResponsabilidadHijo;
use App\Livewire\Resultadouno\Gestor\Participante\Forms\ParticipanteForm;
use App\Models\ComunidadLinguistica;
use App\Models\CohortePaisProyecto;
use App\Models\SocioImplementador;

class Profile extends Component
{
    public Participante $participante;

    public ParticipanteForm $form;

    public Cohorte $cohorte;

    public Proyecto $proyecto;

    public Pais $pais;

    public $showSuccessIndicator = false;

    public $showValidarionErrorIndicator = false;

    // Deshabilitar todos los campos del formulario
    public $disabled = true;

    public PaisProyecto $paisProyecto;

    public $cohortePaisProyecto;

    public $departamentoNacimientoSelected;

    public $ciudadesNacimiento;



    public function mount()
    {
        $this->paisProyecto = PaisProyecto::where('pais_id', $this->pais->id)
            ->where('proyecto_id', $this->proyecto->id)
            ->with(['socioImplementador'])
            ->active()
            ->firstOrFail();

        $cohortePaisProyecto = CohortePaisProyecto::where('cohorte_id', $this->cohorte->id)
            ->where('pais_proyecto_id', $this->paisProyecto->id)
            ->firstOrFail();


        $this->cohortePaisProyecto = $cohortePaisProyecto;

        $this->form->init($this->cohorte, $this->proyecto, $this->pais, $cohortePaisProyecto);
        $this->form->setParticipante($this->participante);

        $this->cohortePaisProyecto->load('perfilesParticipante:id,nombre');

        if($this->participante->municipio_nacimiento_id){
            $this->departamentoNacimientoSelected = Ciudad::find($this->participante->municipio_nacimiento_id, ['departamento_id'])->departamento_id ?? '';
            $this->ciudadesNacimiento = Ciudad::where("departamento_id", $this->departamentoNacimientoSelected)->pluck("nombre", "id");
        }

        //dd($this->participante);
    }

    public function render()
    {
        $user = auth()->user()->load('socioImplementador');

        // 1. Get the PaisProyecto model instance
        $paisProyecto = $this->paisProyecto;

        // 2. Get Socio Implementador


        $modalidad = "";

        //7. Get Nivel Academico
        $nivelAcademico = NivelAcademico::active()
            ->get();

        $nivelAcademicoCategorias = $nivelAcademico->pluck('categoria')
            ->unique()
            ->toArray();

        $nivelconcategorias = [];

        foreach ($nivelAcademicoCategorias as $categoria) {
            $nivelconcategorias[$categoria] = $nivelAcademico->where('categoria', $categoria)
                ->pluck('nombre', 'id');
        }

        $currentDepto = Ciudad::find($this->participante->ciudad_id, ['departamento_id'])->departamento_id ?? '';



        $comunidadesLinguisticas = $this->pais->grupoEtnico()->whereNotNull('grupo_etnicos.active_at')
            ->whereNotNull('grupo_etnico_pais.active_at')
            ->with('comunidadesEtnicas')
            ->whereHas('comunidadesEtnicas', function ($query) {
                $query->whereNotNull('active_at');
            })
            ->get()
            ->pluck('comunidadesEtnicas')
            ->flatten()
            ->unique('id')
            ->values();

        $gruposEtnicos =  $this->pais->grupoEtnico()
            ->whereNotNull('grupo_etnicos.active_at')
            ->whereNotNull('grupo_etnico_pais.active_at')
            ->with(['comunidadesEtnicas' => function ($query) {
                $query->whereNotNull('active_at');
            }])
            ->get();

        $nivelEducativo = NivelEducativo::active()->get();
        $nivelEducativoCategorias = $nivelEducativo->pluck('categoria')->unique()->toArray();
        $niveleducativoconcategorias = [];
        foreach ($nivelEducativoCategorias as $categoria) {
            $niveleducativoconcategorias[$categoria] = $nivelEducativo->where('categoria', $categoria)->pluck('nombre', 'id');
        }


        return view('livewire.resultadouno.coordinador.participante.index.profile', [
            'user' => $user,
            'paisProyecto' => $paisProyecto,
            'modalidad' => $modalidad,
            'departamentos' => $this->pais->departamentos()->active()->pluck("nombre", "id"),
            'discapacidades' => Discapacidad::active()->pluck("nombre", "id"),
            'proyectoVidas' => ProyectoVida::active()->get(["id", "nombre", "comentario"]),
            'responsabilidadHijos' => ComparteResponsabilidadHijo::active()->pluck("nombre", "id"),
            'apoyoHijos' => ApoyoHijo::active()->pluck("nombre", "id"),
            'seccionGrado' => SeccionGrado::active()->pluck("nombre", "id"),
            'turnoJornada' => TurnoEstudio::active()->pluck("nombre", "id"),
            'nivelconcategorias' => $nivelconcategorias,
            'nivelEducativo' => $niveleducativoconcategorias,
            'parentescos' => Parentesco::active()->pluck("nombre", "id"),
            'estadosCiviles' => EstadoCivil::active()->pluck("nombre", "id"),
            'ciudades' => Ciudad::where("departamento_id", $currentDepto)->pluck("nombre", "id"),
            'comunidadesLinguisticas' => $comunidadesLinguisticas,
            'gruposEtnicos' => $gruposEtnicos,
        ]);
    }
}
