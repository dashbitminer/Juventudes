<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UltimoAnioEstudioRule implements ValidationRule
{
    public $estudiaActualmente;

    public function __construct($estudiaActualmente = false)
    {
        $this->estudiaActualmente = $estudiaActualmente;
    }


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->estudiaActualmente == false) {
            if (!preg_match('/^\d{4}$/', $value)) {
                $fail('This is not a valid year');
                return;
            }

            if ($value > now()->year - 1 || $value < now()->year - 20) {
                $fail('The year must be between ' . (now()->year - 20) . ' and ' . (now()->year - 1));
            }
        }
    }
}
