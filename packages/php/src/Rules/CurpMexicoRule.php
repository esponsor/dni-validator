<?php

namespace Esponsor\DniValidator\Rules;

use Closure;
use Esponsor\DniValidator\CurpMexico;
use Illuminate\Contracts\Validation\ValidationRule;

class CurpMexicoRule implements ValidationRule
{
    public function __construct(private ?CurpMexico $validator = null)
    {
        $this->validator ??= new CurpMexico();
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! $this->validator->validate($value)) {
            $fail('El CURP ingresado no es válido.');
        }
    }
}
