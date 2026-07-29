<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\RucPeru;

class RucPeruRule extends DocumentRule
{
    public function __construct(?RucPeru $validator = null)
    {
        $this->validator = $validator ?? new RucPeru();
    }

    protected function message(): string
    {
        return 'El RUC ingresado no es válido.';
    }
}
