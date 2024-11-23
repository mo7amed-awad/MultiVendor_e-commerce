<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Filter implements ValidationRule
{
    protected $forbidden;

    public function __construct($forbidden)
    {
        $this->forbidden=$forbidden;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the value equals 'mohamed' (case-insensitive)
        if (strtolower($value) == $this->forbidden) {
            $fail('The :attribute value is forbidden.');
        }
    }
}
