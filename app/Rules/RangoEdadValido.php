<?php

namespace App\Rules;

use App\Models\CohortePaisProyecto;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RangoEdadValido implements ValidationRule
{

    protected $fechaNacimiento;

    protected $cohortePaisProyecto;

    public function __construct( $fechaNacimiento,  CohortePaisProyecto $cohortePaisProyecto)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        $this->cohortePaisProyecto = $cohortePaisProyecto;

        $this->cohortePaisProyecto->load([
            "rangoEdades" => function ($query) {
              $query
                ->active()
                ->select("id", "cohorte_pais_proyecto_id", "edad_inicio", "edad_fin", 'fecha_comparacion_inicio', 'fecha_comparacion_fin', 'fecha_fin_limite', 'fecha_inicio_limite');
            }
        ]);


    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if ($this->cohortePaisProyecto->rangoEdades->isEmpty() ) {
            return;
        }

        $fechaNacimientoParsed = Carbon::parse($this->fechaNacimiento); //2003-02-09
        $edad = $fechaNacimientoParsed->age;

        $valid = false;
        foreach ($this->cohortePaisProyecto->rangoEdades as $rango) {
            if ($rango->fecha_inicio_limite && $rango->fecha_fin_limite) {


                $fechaInicioLimite = Carbon::parse($rango->fecha_inicio_limite); //2003-02-10
                $fechaFinLimite = Carbon::parse($rango->fecha_fin_limite); //2010-02-15


                // Calcular la edad normal en base a los valores numericos
                if ($fechaNacimientoParsed->between($fechaInicioLimite, $fechaFinLimite)) {
                    $valid = true;
                   return;
                }

                // if ($fechaNacimientoParsed->greaterThanOrEqualTo($fechaInicioLimite) &&
                //      $fechaNacimientoParsed->lessThanOrEqualTo($fechaFinLimite)) {
                //     $valid = true;
                //     return;
                // }
            }else{
                return;
            }
        }

         if (!$valid) {

            $diffInicio = abs($fechaNacimientoParsed->diffInYears($fechaInicioLimite));
            $diffFin = abs($fechaNacimientoParsed->diffInYears($fechaFinLimite));

            if ($diffInicio < $diffFin) {
                $edadFutura = $fechaNacimientoParsed->diffInYears($rango->fecha_comparacion_inicio);
            } else {
                $edadFutura = $fechaNacimientoParsed->diffInYears($rango->fecha_comparacion_fin);
            }

            $fail('La edad '.$edadFutura.' años no esta dentro del rango válido para la presente cohorte.');
            return;
        }


        // $fechaNacimientoParsed = Carbon::parse($this->fechaNacimiento);
        // $edad = $fechaNacimientoParsed->age;

        // $valid = false;
        // foreach ($this->cohortePaisProyecto->rangoEdades as $rango) {
        //     $valid = $this->isValidAge($rango, $fechaNacimientoParsed, $edad);
        // }



        // if (!$valid) {

        //     $fail('La edad '.$edad.' años no esta dentro del rango válido para la presente cohorte.');
        //     return;
        // }


    }

    private function isValidAge($rango, $fechaNacimientoParsed, $edad): bool
    {
        if ($rango->fecha_comparacion) {
            $fechaComparacion = Carbon::parse($rango->fecha_comparacion);
            $edadComparacion = $fechaNacimientoParsed->diffInYears($fechaComparacion);

            if ($edad >= $rango->edad_inicio && $edad <= $rango->edad_fin) {
                return true;
            }

            if ($edadComparacion >= $rango->edad_inicio && $edadComparacion <= $rango->edad_fin) {
                return true;
            }
        } else {
            if ($edad >= $rango->edad_inicio && $edad <= $rango->edad_fin) {
                return true;
            }
        }

        return false;
    }


}
