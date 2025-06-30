<?php

namespace App\Livewire\Resultadouno\Gestor\Participante\Forms;

use App\Models\{
    Participante,
    Socioeconomico,
    Pais,
    Cohorte,
    Proyecto
};
use App\Traits\SocioeconomicoUtility;
use Livewire\Form;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SocioeconomicoForm extends Form
{
    use SocioeconomicoUtility;

    public Socioeconomico $socioeconomico;

    public Participante $participante;

    public Cohorte $cohorte;

    public Proyecto $proyecto;

    public Pais $pais;

    const PERSONA_VIVES_OTROS = 10;
    const FUENTE_INGRESO_OTROS = 7;
    const RESPUESTA_SI = 1;

    const DRAFT = 1;
    const PENDING = 2;
    const VALIDATED = 3;


    public array $answers = [];
    public $questions;
    public $options;
    public array $casaDispositivosSelected = [];

    public array $personasViveSelected = [];

    public string $personaViveText = '';

    public array $fuenteIngresoSelected = [];

    public string $fuenteIngresoText = '';

    public array $respuestaOpciones;

    public array $casaDispositivos;

    public array $personaVives;

    public array $fuenteIngresos;

    public  $factorEconomicos;

    public  $factorSaludes;

    public  $factorPerSocs = [];

    public $razonNoEstudiar;

    public $factoresEconomicosSelected = [];

    public $factoresSaludesSelected = [];

    public $factoresPerSocSelected = [];

    public $factoresPerSocOtros;

    public $participanteMigradoRetornado, $participanteMiembroMigrado, $sentidoInseguroEnComunidad;
    public $victimaViolencia, $conocidoViolenciaGenero, $espaciosSegurosVictimas;
    public $participasProyectoRecibeBono, $proyectoOngBonosText, $familiaParticipaProyectoRecibeBono;
    public $informacionRelevante, $miembrosFamiliaVives, $cuartosEnHogar, $cuartosComoDormitorios;
    public $focosElectricosHogar, $hogarPersonasCondicionesTrabajar, $trabajanConIngresosFijos;
    public $familiaProyectoOngBonosText, $contratadasPermanentemente, $contratadasTemporalmente;

    public $status = '';

    public $showSuccessIndicator = false;
    public $showValidationErrorIndicator = false;

    public $readonly = false;

    public $estudia_actualmente = false;

    public function boot()
    {
        $this->withValidator(function ($validator) {

            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    private function getAttributes(): array
    {
        return [
            'miembrosFamiliaVives' => 'miembros_familia_vives',
            'cuartosEnHogar' => 'cuartos_en_hogar',
            'cuartosComoDormitorios' => 'cuartos_como_dormitorios',
            'focosElectricosHogar' => 'focos_electricos_hogar',
            'participanteMigradoRetornado' => 'participante_migrado_retornado',
            'participanteMiembroMigrado' => 'participante_miembro_hogar_migrado',
            'hogarPersonasCondicionesTrabajar' => 'hogar_personas_condiciones_trabajar',
            'trabajanConIngresosFijos' => 'trabajan_con_ingresos_fijos',
            'contratadasPermanentemente' => 'contratadas_permanentemente',
            'contratadasTemporalmente' => 'contratadas_temporalmente',
            'sentidoInseguroEnComunidad' => 'sentido_inseguro_en_comunidad',
            'victimaViolencia' => 'victima_violencia',
            'conocidoViolenciaGenero' => 'conocido_violencia_genero',
            'espaciosSegurosVictimas' => 'espacios_seguros_para_victimas',
            'participasProyectoRecibeBono' => 'participas_proyecto_recibir_bonos',
            'familiaParticipaProyectoRecibeBono' => 'familiar_participa_proyecto_recibir_bonos',
            'informacionRelevante' => 'informacion_relevante',
            'proyectoOngBonosText' => 'proyecto_ong_bonos',
            'familiaProyectoOngBonosText' => 'familiar_proyecto_ong_bonos',
            'factoresPerSocOtros' => 'factor_persoc_otro'
        ];
    }

    protected function rules(): array
    {
        return [
            'miembrosFamiliaVives' => ['required'],
            'personasViveSelected' => ['required'],
            'cuartosEnHogar' => ['required'],
            'cuartosComoDormitorios' => ['required',
                function ($attribute, $value, $fail) {
                    if ($value > $this->cuartosEnHogar) {
                        $fail('El número de cuartos como dormitorios no puede ser mayor que el número de cuartos en el hogar.');
                    }
                }
            ],
            'focosElectricosHogar' => ['required'],
            'casaDispositivosSelected' => ['required'],
            'participanteMigradoRetornado' => ['required'],
            'participanteMiembroMigrado' => ['required'],
            'hogarPersonasCondicionesTrabajar' => [ //3
                'required',
                function ($attribute, $value, $fail) {
                    if ($value > $this->miembrosFamiliaVives) {
                        $fail('El número de personas en el hogar con condiciones de trabajar no puede ser mayor que el número de miembros de la familia.');
                    }
                }
            ],
            'trabajanConIngresosFijos' => [ //4
                'required',
                function ($attribute, $value, $fail) {
                    if ($value > $this->miembrosFamiliaVives) {
                        $fail('El número de personas trabajando no puede ser mayor que el número de miembros de la familia.');
                    }else if($value > $this->hogarPersonasCondicionesTrabajar){
                        $fail('El número de personas trabajando no puede ser mayor que el número de personas en edad y condición de trabajar dentro de los miembros de tu hogar.');
                    }
                }
            ],
            'contratadasPermanentemente' => [ //5
                'required',
                function ($attribute, $value, $fail) {
                    if ($value > $this->miembrosFamiliaVives) {
                        $fail('El número de personas con ingresos fijos no puede ser mayor que el número de miembros de la familia.');
                    }else if($value > $this->hogarPersonasCondicionesTrabajar){
                        $fail('El número de personas con ingresos fijos no puede ser mayor que el número de personas en edad y condición de trabajar dentro de los miembros de tu hogar.');
                    }else if($value > $this->trabajanConIngresosFijos){
                        $fail('El número de personas trabajando no puede ser mayor que el número de personas de tu hogar que están en edad y condición de trabajar.');
                    }
                }
            ],
            'contratadasTemporalmente' => [//6
                'required',
                function ($attribute, $value, $fail) {
                    if ($value > $this->miembrosFamiliaVives) {
                        $fail('El número de personas que están contratadas de manera permanente o tienen contrato temporal no puede ser mayor que el número de miembros de la familia.');
                    }else if($value > $this->hogarPersonasCondicionesTrabajar){
                        $fail('El número de personas que están contratadas de manera permanente o tienen contrato temporal no puede ser mayor que el número de personas en edad y condición de trabajar dentro de los miembros de tu hogar.');
                    }else if($value > $this->trabajanConIngresosFijos){
                        $fail('El número de personas trabajando no puede ser mayor que el número de personas de tu hogar que están en edad y condición de trabajar.');
                    }
                }
            ],
            'fuenteIngresoSelected' => ['required'],
            'sentidoInseguroEnComunidad' => ['required'],
            'victimaViolencia' => ['required'],
            'conocidoViolenciaGenero' => ['required'],
            'espaciosSegurosVictimas' => ['required'],
            'participasProyectoRecibeBono' => ['required'],
            'familiaParticipaProyectoRecibeBono' => ['required'],
            'razonNoEstudiar' => [
                function ($attribute, $value, $fail) {
                    if(!$this->estudia_actualmente){
                        if (
                            empty($this->factoresEconomicosSelected) &&
                            empty($this->factoresSaludesSelected) &&
                            empty($this->factoresPerSocSelected)
                        ) {
                            $fail('Por favor, selecciona al menos una razón para justificar por qué dejaste de estudiar.');
                        }
                    }
                }
            ],
            'factoresPerSocOtros' => [
                Rule::requiredIf(function () {
                    $id = array_search('Otros (especificar)', $this->factorPerSocs->toArray());
                    return in_array($id, $this->factoresPerSocSelected);
                })
            ],
        ];

    }

    protected function draftRules(): array
    {
        $rules = [];

        $drafRules = [
            'miembrosFamiliaVives' => ['sometimes', 'numeric'],
            'cuartosEnHogar' =>  ['sometimes', 'numeric'],
            'cuartosComoDormitorios' => ['sometimes', 'numeric'],
            'focosElectricosHogar' => ['sometimes', 'numeric'],
            'hogarPersonasCondicionesTrabajar' => ['sometimes', 'numeric'],
            'trabajanConIngresosFijos' => ['sometimes', 'numeric'],
            'contratadasPermanentemente' => ['sometimes', 'numeric'],
            'contratadasTemporalmente' => ['sometimes', 'numeric'],
        ];

        foreach ($drafRules as $field => $rule) {
            if (!is_null($this->{$field})) {
                $rules[$field] = $rule;
            }
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'answers.*.required' => 'Debe seleccionar una opción de cada pregunta.',
            'miembrosFamiliaVives.required' => 'El campo con ¿cuántos miembros de tu familia vives en tu casa? es requerido',
            'personasViveSelected.required' => 'Selecciona las personas con quienes vive en tu casa',
            'cuartosEnHogar.required'   => 'El campo ¿cuántos cuartos tiene tu hogar?',
            'cuartosComoDormitorios.required' => 'El campo ¿cuántos de esos cuartos se usan como habitación para dormir? es requerido',
            'focosElectricosHogar.required' => 'El campo ¿cuántos focos o bombillos eléctricos hay en tu hogar? es requerido',
            'casaDispositivosSelected.required' => 'Selecciona los equipos o dispositivos que hay en tu casa',
            'participanteMigradoRetornado.required' => 'Selecciona una opción de la persona participante expresa haber migrado y haber sido retornada al país',
            'participanteMiembroMigrado.required' => 'Selecciona una opción de la persona participante expresa que al menos un miembro de su hogar ha migrado',
            'hogarPersonasCondicionesTrabajar.required' => 'El campo ¿cuántas están en edad y condición de trabajar? es requerido',
            'trabajanConIngresosFijos.required' => 'El campo ¿cuántas se encuentran trabajando? es requerido',
            'contratadasPermanentemente.required' => 'El campo De las personas de tu hogar que trabajan, ¿cuántas tienen ingresos fijos? es requerido',
            'contratadasTemporalmente.required' => 'El campo De las personas de tu hogar que trabajan, ¿cuántas están contratadas de manera permanente o tienen contrato temporal? es requerido',
            'fuenteIngresoSelected.required' => 'Selecciona de dónde provienen los ingresos del hogar',
            'sentidoInseguroEnComunidad.required' => 'Selecciona una opción de te has sentido inseguro/a en tu comunidad durante el último año',
            'victimaViolencia.required' => 'Selecciona una opción de Has sido víctima de algún tipo de violencia en los últimos seis meses',
            'conocidoViolenciaGenero.required' => 'Selecciona una opción de Conoces a alguien en tu comunidad que haya sido víctima de violencia de género',
            'espaciosSegurosVictimas.required' => 'Selecciona una opción de Hay espacios seguros en tu comunidad donde puedas buscar ayuda si eres víctima de violencia',
            'participasProyectoRecibeBono.required' => 'Selecciona una opción de ¿Actualmente participas en algún proyecto u ONG del cual recibas bonos o beneficios económicos?',
            'familiaParticipaProyectoRecibeBono.required' => 'Selecciona una opción de ¿Algún miembro de tu familia participa en algún proyecto u ONG del cual reciba beneficios económicos?'
        ];
    }

    public function setSocioEconomico(Socioeconomico $socioeconomico, Participante $participante): void
    {
        $this->socioeconomico = $socioeconomico;
        $this->participante = $participante;

        $this->initializeForm();

        $this->readonly = $socioeconomico->readonly_at ? true : false;
    }

    private function initializeForm(): void
    {
        $this->loadRelatedData();
        $this->setAttributes();
        $this->getSelectedOptions();
    }

    private function loadRelatedData(): void
    {
        $this->questions = $this->getDineroSuficientePregunta();
        $this->options = $this->getDineroSuficienteOpcion();
        $this->respuestaOpciones = $this->getRespuestaOpcion();
        $this->casaDispositivos = $this->getCasaDispositivos();
        $this->personaVives = $this->getPersonaVive();
        $this->fuenteIngresos = $this->getFuenteIngresos();
        $this->factorEconomicos = $this->getFactorEconomicos();
        $this->factorSaludes = $this->getFactorSaludes();
        $this->factorPerSocs = $this->getFactorPersonalSocial();
    }

    private function getSelectedOptions(): void
    {

        $this->answers = $this->socioeconomico->dineroSuficienteTabla
            ->mapWithKeys(function ($item) {
                return [$item->dinero_suficiente_pregunta_id => $item->dinero_suficiente_opcion_id];
            })
            ->toArray();


        $this->casaDispositivosSelected = $this->socioeconomico->casaDispositivo
            ->pluck('id')
            ->toArray();

        list($this->personasViveSelected, $this->personaViveText) =
            $this->getPersonasViveSocioeconomico($this->socioeconomico);

        list($this->fuenteIngresoSelected, $this->fuenteIngresoText) =
            $this->getFuentesIngresosSocioeconomico($this->socioeconomico);

        $this->factoresEconomicosSelected =  $this->socioeconomico->factorEconomico
            ->pluck('id')
            ->toArray();

        $this->factoresSaludesSelected =  $this->socioeconomico->factorSalud
            ->pluck('id')
            ->toArray();

        $this->factoresPerSocSelected =  $this->socioeconomico->factorPersoc
            ->pluck('id')
            ->toArray();
    }


    private function setAttributes() : void
    {
        $mappings = $this->getAttributes();

        foreach ($mappings as $classAttribute => $modelAttribute) {
            $this->{$classAttribute} = $this->socioeconomico->{$modelAttribute};
        }
    }

    private function fillAttributes(): array
    {
        $mappings = $this->getAttributes();

        $attributes = [];
        foreach ($mappings as $classAttribute => $modelAttribute) {
            $attributes[$modelAttribute] = $this->{$classAttribute};
        }

        return $attributes;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setCohorte(Cohorte $cohorte) : void {
        $this->cohorte = $cohorte;
    }

    public function setProyecto(Proyecto $proyecto) : void {
        $this->proyecto = $proyecto;
    }

    public function setPais(Pais $pais) : void {
        $this->pais = $pais;
    }

    public function update(): void
    {
        $rules = $this->status === self::DRAFT ? $this->draftRules() : $this->getValidationRules();

        if(!empty($rules)){
            $this->validate($rules, $this->messages());
        }

        $this->updateRelatedModels();
        $this->socioeconomico->update( $this->fillAttributes());

        /// Generate PDF after validation
        if ($this->status !== self::DRAFT){
            $this->generatePDF();
        }
    }

    private function getValidationRules(): array
    {
        $rules = $this->rules();

        foreach ($this->questions as $question) {
            $rules['answers.' . $question->id] = 'required';
        }

        if (in_array(self::PERSONA_VIVES_OTROS, $this->personasViveSelected)) {
            $rules['personaViveText'] = 'required';
        }else{
            $this->personaViveText = '';
        }

        if (in_array(self::FUENTE_INGRESO_OTROS, $this->fuenteIngresoSelected)) {
            $rules['fuenteIngresoText'] = 'required';
        }else{
            $this->fuenteIngresoText = '';
        }

        if ($this->familiaParticipaProyectoRecibeBono == self::RESPUESTA_SI) {
            $rules['familiaProyectoOngBonosText'] = 'required';
        }else{
            $this->familiaProyectoOngBonosText = '';
        }

        if ($this->participasProyectoRecibeBono == self::RESPUESTA_SI) {
            $rules['proyectoOngBonosText'] = 'required';
        }else{
            $this->proyectoOngBonosText = '';
        }




        return $rules;
    }

    private function updateRelatedModels(): void
    {
        $this->updateDineroSuficienteTablas();
        $this->updateCasaDispositivos();
        $this->updatePersonasVive();
        $this->updateFuentesIngresos();

        $this->socioeconomico->factorEconomico()->detach();
        $this->socioeconomico->factorEconomico()->sync($this->factoresEconomicosSelected);

        $this->socioeconomico->factorSalud()->detach();
        $this->socioeconomico->factorSalud()->sync($this->factoresSaludesSelected);

        $this->socioeconomico->factorPersoc()->detach();
        $this->socioeconomico->factorPersoc()->sync($this->factoresPerSocSelected);

    }
}
