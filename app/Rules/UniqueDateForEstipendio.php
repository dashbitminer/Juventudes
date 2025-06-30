<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueDateForEstipendio implements ValidationRule
{

    public $mes;
    public $anio;
    public $cohortePaisProyecto;


    public function __construct($mes, $anio, $cohortePaisProyecto)
    {
        $this->mes = $mes;
        $this->anio = $anio;
        $this->cohortePaisProyecto = $cohortePaisProyecto;

        //dd($this->anio);
    }


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ocurrencia =\App\Models\Estipendio::where('mes', $this->mes)
        ->where('anio', $this->anio)
        ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
        ->whereNull('deleted_at')
        ->exists();


        if ($ocurrencia) {
            //dd($this->anio, $ocurrencia);
            $fail('El estipendio para el mes, año y proyecto proporcionados ya existe.');
        }
    }
}
