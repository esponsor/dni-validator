<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\DniPeru;

class DniPeruRule extends DocumentRule
{
    public function __construct(?DniPeru $validator = null)
    {
        $this->validator = $validator ?? new DniPeru();
    }

    protected function message(): string
    {
        return 'El DNI ingresado no es válido.';
    }
}
