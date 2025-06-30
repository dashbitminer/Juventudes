<?php

namespace App\Livewire\Resultadouno\Gestor\Participante;

use App\Models\Etnia;
use App\Models\Ciudad;
use App\Models\ApoyoHijo;
use App\Models\Parentesco;
use App\Models\EstadoCivil;
use App\Models\Discapacidad;
use App\Models\PaisProyecto;
use App\Models\ProyectoVida;
use App\Models\SeccionGrado;
use App\Models\TurnoEstudio;
use App\Models\NivelAcademico;
use App\Models\NivelEducativo;
use App\Models\PaisProyectoSocio;
use App\Models\GrupoPerteneciente;
use App\Models\ComparteResponsabilidadHijo;
use App\Models\ComunidadLinguistica;
use App\Models\Modalidad;

trait InitializeForm
{

    public $errorDoumentoIdentidad = false;

    public function initializeProperties()
    {

             //7. Get Nivel Academico
            $nivelAcademico = NivelAcademico::active()->get();
            $nivelAcademicoCategorias = $nivelAcademico->pluck('categoria')->unique()->toArray();
            $nivelconcategorias = [];
            foreach ($nivelAcademicoCategorias as $categoria) {
                $nivelconcategorias[$categoria] = $nivelAcademico->where('categoria', $categoria)->pluck('nombre', 'id');
            }

            //8. Get nivel educativo
            $nivelEducativo = NivelEducativo::active()->get();
            $nivelEducativoCategorias = $nivelEducativo->pluck('categoria')->unique()->toArray();
            $niveleducativoconcategorias = [];
            foreach ($nivelEducativoCategorias as $categoria) {
                $niveleducativoconcategorias[$categoria] = $nivelEducativo->where('categoria', $categoria)->pluck('nombre', 'id');
            }

            // $comunidadesLinguisticas = $this->pais->comunidadesLinguisticas()->whereNotNull('comunidad_linguisticas.active_at')
            //     ->whereNotNull('comunidad_linguistica_pais.active_at')
            //     ->select("comunidad_linguisticas.nombre", "comunidad_linguisticas.id", "comunidad_linguistica_pais.id as pivotid")->get();

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

               // dd($comunidadesLinguisticas);

            $etnias = $this->pais->etnias()->whereNotNull('etnias.active_at')
                ->whereNotNull('etnia_pais.active_at')
                ->select("etnias.nombre", "etnias.id", "etnia_pais.id as pivotid")->get();

           // dd($etnias);

            $gruposPertenecientes = $this->pais->grupoPertenecientes()->whereNotNull('grupo_pertenecientes.active_at')
                ->whereNotNull('grupo_perteneciente_pais.active_at')
                ->select("grupo_pertenecientes.nombre", "grupo_pertenecientes.id", "grupo_perteneciente_pais.id as pivotid")->get();

            $gruposEtnicos =  $this->pais->grupoEtnico()->whereNotNull('grupo_etnicos.active_at')
                                ->whereNotNull('grupo_etnico_pais.active_at')
                                ->with(['comunidadesEtnicas' => function ($query) {
                                    $query->whereNotNull('active_at');
                                }])
                                ->get();

        return [
            'nivelconcategorias' => $nivelconcategorias,
            'socioImplementador' => auth()->user()->load('socioImplementador'),
            'modalidad' => Modalidad::active()->first(),
            'departamentos' => $this->pais->departamentos()->active()->pluck("nombre", "id"),
            'discapacidades' => Discapacidad::active()->pluck("nombre", "id"),
            'gruposPertenecientes' => $gruposPertenecientes,
            'etnias' => $etnias,
            'proyectoVidas' => ProyectoVida::active()->get(["id", "nombre", "comentario"]),
            'responsabilidadHijos' => ComparteResponsabilidadHijo::active()->pluck("nombre", "id"),
            'apoyoHijos' => ApoyoHijo::active()->pluck("nombre", "id"),
            'seccionGrado' => SeccionGrado::active()->pluck("nombre", "id"),
            'turnoJornada' => TurnoEstudio::active()->pluck("nombre", "id"),
            'nivelEducativo' => $niveleducativoconcategorias,
            'parentescos' => Parentesco::active()->pluck("nombre", "id"),
            'estadosCiviles' => EstadoCivil::active()->pluck("nombre", "id"),
            'comunidadesLinguisticas' => $comunidadesLinguisticas,
            'gruposEtnicos' => $gruposEtnicos,
        ];
    }

    public function updated($propertyName, $value)
    {
        //dd($propertyName, $value);
        if (str($propertyName)->startsWith('form.discapacidadesSelected')) {
            $this->updatedFormDiscapacidadesSelected($value);
        }elseif (str($propertyName)->startsWith('form.apoyoHijosSelected')) {
            $this->updatedFormApoyoHijosSelected($value);
        }elseif (str($propertyName)->startsWith('form.departamentoSelected')) {
             $this->updatedFormDepartamentoSelected($value);
        }elseif (str($propertyName)->startsWith('form.responsabilidadHijosSelected')) {
            $this->updatedFormResponsabilidadHijosSelected($value);
        }elseif(str($propertyName)->startsWith('form.departamentoNacimientoSelected')){
            $this->updatedFormDepartamentoNacimientoSelected($value);
        }elseif(str($propertyName)->startsWith('form.documento_identidad')){
           // $this->resetValidation(['form.documento_identidad']);
            $this->updatedDocumentoIdentidad($value);
        }
        // elseif (str($propertyName)->startsWith('form.responsabilidadHijosSelected')) {
        //     $this->updatedFormCiudadSelected($value);
        // }
    }

    public function updating($propertyName, $value){
        if(str($propertyName)->startsWith('form.documento_identidad')){
            $this->resetValidation(['form.documento_identidad']);
         }
    }

    public function updatedDocumentoIdentidad($value)
    {

        if (empty($value)) {
            return;
        }

        $allow = $this->allowDui();

        $documentoCount = \App\Models\Participante::where('documento_identidad', $value)
            ->when(!empty($allow), function ($query) use ($allow) {
                return $query->whereNotIn('documento_identidad', $allow);
            })
            ->when($this->formMode == 'edit', function ($query) {
                return $query->where('id', '!=', $this->form->participante->id);
            })
            ->count();

        if ($documentoCount > 0) {
            // Handle the case where there are other participants with the same documento_identidad
            $this->errorDoumentoIdentidad = true;
            //$this->addError('form.documento_identidad', 'El documento de identidad ya está en uso por otro participante.');
        }
    }

    public function updatedFormDepartamentoSelected()
    {
        $this->ciudades = [];
        if (!empty($this->form->departamentoSelected)) {
            $this->ciudades = Ciudad::where('departamento_id', $this->form->departamentoSelected)->orderBy('nombre', 'asc')->pluck('nombre', 'id');
        }
    }

    public function updatedFormDepartamentoNacimientoSelected()
    {
        $this->ciudadesNacimiento = [];
        if (!empty($this->form->departamentoNacimientoSelected)) {
            $this->ciudadesNacimiento = Ciudad::where('departamento_id', $this->form->departamentoNacimientoSelected)->orderBy('nombre', 'asc')->pluck('nombre', 'id');
        }
    }

    public function updatedFormDiscapacidadesSelected($value)
    {
       // dd($value);
        if ($value == Discapacidad::NOCONTESTAR) {
            $this->form->discapacidadesSelected = [Discapacidad::NOCONTESTAR];
        }elseif($value  == Discapacidad::NOPOSEO){
            $this->form->discapacidadesSelected = [Discapacidad::NOPOSEO];
        }else{
            if (($key = array_search(Discapacidad::NOCONTESTAR, $this->form->discapacidadesSelected)) !== false) {
                unset($this->form->discapacidadesSelected[$key]);
                // Reindex the array to maintain proper indexing
                $this->form->discapacidadesSelected = array_values($this->form->discapacidadesSelected);
            }

            if (($key = array_search(Discapacidad::NOPOSEO, $this->form->discapacidadesSelected)) !== false) {
                unset($this->form->discapacidadesSelected[$key]);
                // Reindex the array to maintain proper indexing
                $this->form->discapacidadesSelected = array_values($this->form->discapacidadesSelected);
            }
        }
    }

    public function updatedFormResponsabilidadHijosSelected($value){
        if ($value == ComparteResponsabilidadHijo::SOLA) {
            $this->form->responsabilidadHijosSelected = [ComparteResponsabilidadHijo::SOLA];
        }else{
            if (($key = array_search(ComparteResponsabilidadHijo::SOLA, $this->form->responsabilidadHijosSelected)) !== false) {
                unset($this->form->responsabilidadHijosSelected[$key]);
                // Reindex the array to maintain proper indexing
                $this->form->responsabilidadHijosSelected = array_values($this->form->responsabilidadHijosSelected);
            }
        }
    }

    public function updatedFormApoyoHijosSelected($value){
        if ($value == ApoyoHijo::NOTENGO) {
            $this->form->apoyoHijosSelected = [ApoyoHijo::NOTENGO];
        }else{
            if (($key = array_search(ApoyoHijo::NOTENGO, $this->form->apoyoHijosSelected)) !== false) {
                unset($this->form->apoyoHijosSelected[$key]);
                // Reindex the array to maintain proper indexing
                $this->form->apoyoHijosSelected = array_values($this->form->apoyoHijosSelected);
            }
        }
    }

    public function allowDui(): array{
        return [
            '3340850631301',
            '3177442161303',
            '3176273331303',
            '3154218431301',
            '3515932091301',
            '3150807601301',
            '3075905851207',
            '2786588650901',
            '2754238910914',
            '2946249880909',
            '2930566331301',
            '3162515931302',
            '3461270681303',
            '3248049621330',
            '3212864801320',
            '2841598671320',
            '2312929531301',
            '3196891071306',
            '2905484891311',
            '3151337321301',
            '2835275281302',
            '3154367940902',
            '3341047851301',
            '3148305610901',
            '3649947970901',
            '3357398060901',
            '3161614540804',
        ];
    }


}
