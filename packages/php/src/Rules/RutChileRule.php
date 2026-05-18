<?php

namespace Esponsor\DniValidator\Rules;

use Closure;
use Esponsor\DniValidator\RutChile;
use Illuminate\Contracts\Validation\ValidationRule;

class RutChileRule implements ValidationRule
{
    public function __construct(private ?RutChile $validator = null)
    {
        $this->validator ??= new RutChile();
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! $this->validator->validate($value)) {
            $fail('El RUT ingresado no es válido.');
        }
    }
}
