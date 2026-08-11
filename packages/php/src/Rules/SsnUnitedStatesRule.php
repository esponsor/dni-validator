<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\SsnUnitedStates;

class SsnUnitedStatesRule extends DocumentRule
{
    public function __construct(?SsnUnitedStates $validator = null)
    {
        $this->validator = $validator ?? new SsnUnitedStates();
    }

    protected function message(): string
    {
        return 'El SSN ingresado no es válido.';
    }
}
