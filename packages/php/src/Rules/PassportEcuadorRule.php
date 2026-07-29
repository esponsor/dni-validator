<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\PassportEcuador;

class PassportEcuadorRule extends DocumentRule
{
    public function __construct(?PassportEcuador $validator = null)
    {
        $this->validator = $validator ?? new PassportEcuador();
    }

    protected function message(): string
    {
        return 'El pasaporte ingresado no es válido.';
    }
}
