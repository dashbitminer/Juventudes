<?php

namespace App\Http\Controllers;

use App\Livewire\Resultadouno\Gestor\Participante\Forms\SocioeconomicoForm;
use App\Models\Pais;
use App\Models\Cohorte;
use App\Models\Proyecto;
use App\Models\PaisProyecto;
use App\Models\Participante;
use App\Models\Socioeconomico;
use App\Traits\SocioeconomicoRelatedData;
use App\Traits\SocioeconomicoUtility;
use Illuminate\Http\Request;
use App\Models\NivelAcademico;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PaisProyectoSocio;

class GestorController extends Controller
{

    use SocioeconomicoUtility;

    public function registropdf(Pais $pais, Proyecto $proyecto, Cohorte $cohorte, Participante $participante) {


        // 1. Get the PaisProyecto model instance
        $paisProyecto = PaisProyecto::where('pais_id', $pais->id)
            ->where('proyecto_id', $proyecto->id)
            ->with(['socioImplementador'])
            //->active()
            ->firstOrFail();

        //7. Get Nivel Academico
        $nivelAcademico = NivelAcademico::active()->get();
        $nivelAcademicoCategorias = $nivelAcademico->pluck('categoria')->unique()->toArray();
        $nivelconcategorias = [];
        foreach ($nivelAcademicoCategorias as $categoria) {
            $nivelconcategorias[$categoria] = $nivelAcademico->where('categoria', $categoria)->pluck('nombre', 'id');
        }

        $participante->loadCount('socioeconomico');

        $participante->load([
            "estadoCivil:id,nombre",
            "ciudad:id,nombre,departamento_id",
            "ciudad.departamento:id,nombre",
            "discapacidades",
            "etnias",
            "apoyohijos",
            "nivelAcademico",
            "proyectoVida",
            "responsabilidadHijos",
            "seccionGrado:id,nombre",
            "turnoEstudio:id,nombre",
            "nivelEducativo:id,nombre",
            "parentesco:id,nombre",
            "municipioNacimiento:id,nombre,departamento_id",
            "municipioNacimiento.departamento:id,nombre",
            "gestor.socioImplementador",
            "lastEstado.estado_registro",
            "lastEstado.coordinador",
            "comunidadEtnica.grupoEtnico",
        ]);

        //dd($participante);

        $pdf = Pdf::loadView('registro', [
            'pais'         => $pais,
            'proyecto'     => $proyecto,
            'cohorte'      => $cohorte,
            'participante' => $participante,
            'paisProyecto' => $paisProyecto,
            'nivelconcategorias' => $nivelconcategorias,
        ]);
        //return $pdf->download('pdf.pdf');
        return $pdf->stream($participante->full_name . '.pdf');
    }

    public function socioeconomicoPdf(Pais $pais, Proyecto $proyecto, Cohorte $cohorte, Participante $participante)
    {

        $socioeconomico = Socioeconomico::find([
            'participante_id' => $participante->id
        ])->first();



        $dineroSuficiente = $socioeconomico->dineroSuficienteTabla
            ->mapWithKeys(function ($item) {
                return [$item->dinero_suficiente_pregunta_id => $item->dinero_suficiente_opcion_id];
            })
            ->toArray();

        list($personasVivesSelected, $personasVivesText)  =
            $this->getPersonasViveSocioeconomico($socioeconomico);

        list($fuenteIngresoSelected, $fuenteIngresoText) =
            $this->getFuentesIngresosSocioeconomico($socioeconomico);

        $data = [
            'socioeconomico' => $socioeconomico,
            'participantName' => $participante->nombres . ' ' . $participante->apellidos,
            'fechaLevantamiento' => $socioeconomico->updated_at->format('d/m/Y'),
            'questions' => $this->getDineroSuficientePregunta(),
            'options' => $this->getDineroSuficienteOpcion(),
            'respuestaOpciones' => $this->getRespuestaOpcion(),
            'casaDispositivos' => $this->getCasaDispositivos(),
            'personaVives' => $this->getPersonaVive(),
            'fuenteIngresos' => $this->getFuenteIngresos(),
            'dineroSuficiente' => $dineroSuficiente,
            'personaVivesSelected' => $personasVivesSelected,
            'personasVivesText' => $personasVivesText,
            'fuenteIngresoSelected' => $fuenteIngresoSelected,
            'fuenteIngresoText' => $fuenteIngresoText
        ];


        $documentName = $participante->slug . '-socioeconomico-' . now()->format('YmdHis') . '.pdf';
        $pdf = Pdf::loadView('livewire.gestor.participante.socioeconomico.pdf', $data);
        return $pdf->download($documentName);


        //return view('livewire.gestor.participante.socioeconomico.pdf', $data);
    }
}
