<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\RutEcuador;

class RutEcuadorRule extends DocumentRule
{
    public function __construct(?RutEcuador $validator = null)
    {
        $this->validator = $validator ?? new RutEcuador();
    }

    protected function message(): string
    {
        return 'El RUT ingresado no es válido.';
    }
}
