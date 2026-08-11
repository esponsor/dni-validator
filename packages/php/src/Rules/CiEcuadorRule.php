<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\CiEcuador;

class CiEcuadorRule extends DocumentRule
{
    public function __construct(?CiEcuador $validator = null)
    {
        $this->validator = $validator ?? new CiEcuador();
    }

    protected function message(): string
    {
        return 'La cédula de identidad ingresada no es válida.';
    }
}
