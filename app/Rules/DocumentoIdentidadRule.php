<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DocumentoIdentidadRule implements ValidationRule
{

    protected $pais;


    public function __construct($pais)
    {
        $this->pais = $pais;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // GUATEMALA
        // if ($this->pais->id == 1 && strlen($value) != 13 ) {
        //     $fail('El :attribute debe de ser de 13 caracteres.');
        // }

        if ($this->pais->id == 1 && !$this->isDpiGuatemala($value)) {
            $fail('El :attribute debe de ser un DPI valido para Guatemala con exactamente 13 digitos.');
        }

        //EL SALVADOR

        // if ($this->pais->id == 2 && strlen($value) != 9) {
        //     $fail('El :attribute debe de tener 9 digitos.');
        // }

        if ($this->pais->id == 2 && !$this->isDuiElSalvador($value)) {
            $fail('El :attribute debe de ser un DUI valido para El Salvador en el formato 123456789.');
        }

        //HONDURAS
        // if ($this->pais->id == 3 && strlen($value) != 13) {
        //     $fail('El :attribute debe de tener 13 digitos.');
        // }
        if ($this->pais->id == 3 && !$this->isDniHonduras($value)) {
            $fail('El :attribute debe de ser un DUI valido para Honduras en el formato 1234567812345 con exactamente 13 digitos.');
        }

        //return true;
    }

    // if (isDui("00016297-5"))
    private function isDuiElSalvador($dui)
    {

        // Remove any non-digit characters
        $dui = preg_replace('/\D/', '', $dui);

        // Check if the DUI matches the required format (9 digits)
        if (!preg_match('/^\d{9}$/', $dui)) {
            return false;
        }

        // Extract the first 8 digits and the 9th digit (check digit)
        $digits = substr($dui, 0, 8);
        $checkDigit = (int)substr($dui, 8, 1);

        // Calculate the sum using the provided formula
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += (int)$digits[$i] * (9 - $i);
        }

        // Calculate the check digit
        $calculatedCheckDigit = 10 - ($sum % 10);
        if ($calculatedCheckDigit == 10) {
            $calculatedCheckDigit = 0;
        }

        // Check if the calculated check digit matches the check digit
        return $calculatedCheckDigit === $checkDigit;
    }

    private function isDpiGuatemala($dpi)
    {
        // Remove any non-digit characters
        $dpi = preg_replace('/\D/', '', $dpi);

        // Check if the DPI matches the required format (13 digits)
        if (!preg_match('/^\d{13}$/', $dpi)) {
            return false;
        }

        // Extract the first 8 digits and the 9th digit (check digit)
        $digits = substr($dpi, 0, 8);
        $checkDigit = (int)substr($dpi, 8, 1);

        // Calculate the sum using the provided formula
        $sum = 0;
        //$weights = [8, 7, 6, 5, 4, 3, 2, 1];
        $weights = [2, 3, 4, 5, 6, 7, 8, 9];
        for ($i = 0; $i < 8; $i++) {
            $sum += (int)$digits[$i] * $weights[$i];
        }

        // Calculate the result mod 11
        $result = $sum % 11;

        // If the result is greater than or equal to 10, take the unit digit
        if ($result >= 10) {
            $result = $result % 10;
        }

        // Check if the calculated result matches the check digit
        return $result === $checkDigit;
    }

    private function isDniHonduras($dni)
    {
        $dni = str_replace('-', '', $dni);
        // Check if the DNI matches the required format (13 digits)
        return preg_match('/^\d{13}$/', $dni);
    }
}
