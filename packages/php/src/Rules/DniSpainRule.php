<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\DniSpain;

class DniSpainRule extends DocumentRule
{
    public function __construct(?DniSpain $validator = null)
    {
        $this->validator = $validator ?? new DniSpain();
    }

    protected function message(): string
    {
        return 'El DNI/NIE ingresado no es válido.';
    }
}
