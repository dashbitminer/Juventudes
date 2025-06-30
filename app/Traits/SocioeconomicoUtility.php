<?php
namespace App\Traits;

use App\Enums\RespuestaOpcion;
use App\Livewire\Resultadouno\Gestor\Participante\Forms\SocioeconomicoForm;
use App\Models\CasaDispositivo;
use App\Models\DineroSuficienteOpcion;
use App\Models\DineroSuficientePregunta;
use App\Models\FuenteIngreso;
use App\Models\PersonaVive;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

trait SocioeconomicoUtility
{
    public function getDineroSuficientePregunta()
    {
        return DineroSuficientePregunta::all();
    }

    public function getDineroSuficienteOpcion()
    {
        return DineroSuficienteOpcion::all();
    }

    public function getRespuestaOpcion()
    {
        return RespuestaOpcion::cases();
    }

    public function getCasaDispositivos()
    {
        return CasaDispositivo::pluck('nombre', 'id')->toArray();
    }

    public function getFactorEconomicos(){
        return $this->pais->factorEconomico()
        ->whereNotNull('factores_economicos.active_at')
        ->pluck('factores_economicos.nombre', 'pais_factores_economicos.id');
    }

    public function getFactorSaludes(){
        return $this->pais->factorSalud()
        ->whereNotNull('factores_saludes.active_at')
        ->pluck('factores_saludes.nombre', 'pais_factores_saludes.id');
    }

    public function getFactorPersonalSocial(){
        return $this->pais->factorPersonalSocial()
        ->whereNotNull('factores_persoces.active_at')
        ->pluck('factores_persoces.nombre', 'pais_factores_persoces.id');
    }

    public function getPersonaVive()
    {
        $otrosLabel = 'Otros (especificar)';

        $personas = PersonaVive::where('nombre', '!=', $otrosLabel)
            ->pluck('nombre', 'id')
            ->toArray();

        $otros = PersonaVive::where('nombre', $otrosLabel)
            ->pluck('nombre', 'id')
            ->toArray();

        return $personas + $otros;
    }

    public function getFuenteIngresos()
    {
        return FuenteIngreso::pluck('nombre', 'id')->toArray();
    }

    public function getPersonasViveSocioeconomico($socioeconomico): array
    {
        return $this->getSocioeconomicoData(
            $socioeconomico,
            'personaVive',
            'id',
            SocioeconomicoForm::PERSONA_VIVES_OTROS
        );
    }

    public function getFuentesIngresosSocioeconomico($socioeconomico): array
    {
        return $this->getSocioeconomicoData(
            $socioeconomico,
            'fuenteIngreso',
            'id',
            SocioeconomicoForm::FUENTE_INGRESO_OTROS
        );
    }

    public function getSocioeconomicoData($socioeconomico, $relation, $fieldId, $fieldOtros): array
    {
        $otroText = '';
        $records = $socioeconomico->$relation;

        $selectedIds = $records->pluck($fieldId)->toArray();

        $record = $records->firstWhere($fieldId, $fieldOtros);

        if ($record) {
            $otroText = $record->pivot->otro ?? '';
        }

        return [$selectedIds, $otroText];
    }

    private function updateDineroSuficienteTablas(): void
    {
        foreach( $this->answers as $answerId => $optionId){
            $this->socioeconomico->dineroSuficienteTabla()->updateOrCreate(
                [
                    'dinero_suficiente_pregunta_id' => $answerId,
                ],
                [
                    'dinero_suficiente_opcion_id' => $optionId,
                    'socioeconomico_id' => $this->socioeconomico->id,
                ]
            );
        }
    }

    private function updateCasaDispositivos(): void
    {
        $this->socioeconomico->casaDispositivo()->detach();
        $this->socioeconomico->casaDispositivo()->sync($this->casaDispositivosSelected);
    }

    private function updatePersonasVive(): void
    {
        $this->socioeconomico->personaVive()->detach();

        $personaViveData = collect($this->personasViveSelected)
            ->mapWithKeys(function($personaViveId) {
            return [
                $personaViveId => [
                    'otro' => $personaViveId == SocioeconomicoForm::PERSONA_VIVES_OTROS ? $this->personaViveText : null,
                ]
            ];
        })->toArray();

        $this->socioeconomico->personaVive()->sync($personaViveData);
    }

    private function updateFuentesIngresos(): void
    {
        $this->socioeconomico->fuenteIngreso()->detach();

        $fuenteIngresoData = collect($this->fuenteIngresoSelected)
            ->mapWithKeys(function($fuenteIngresoId) {
            return [
                $fuenteIngresoId => [
                    'otro' => $fuenteIngresoId == SocioeconomicoForm::FUENTE_INGRESO_OTROS ? $this->fuenteIngresoText : null,
                ]
            ];
        })->toArray();

        $this->socioeconomico->fuenteIngreso()->sync($fuenteIngresoData);
    }

    private function generatePDF(){
        $socioeconomico = $this->socioeconomico;
        $participante = $this->participante;

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
            'participante' => $participante,
            'socioeconomico' => $socioeconomico,
            'participantName' => $participante->fullName,
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


        $pdf = Pdf::loadView('livewire.resultadouno.gestor.participante.socioeconomico.pdf', $data);

        $content = $pdf->download()->getOriginalContent();

        $path = sprintf('%s/%s/%s/%s/socioeconomico_%s.pdf',
            $this->proyecto->slug,
            $this->pais->slug,
            $this->cohorte->slug,
            $this->participante->id,
            $this->participante->slug
        );

        Storage::disk('s3')->put($path, $content);

        $this->socioeconomico->update(['pdf' => $path]);

        return $path;
    }


}
