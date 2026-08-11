<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\SinCanada;

class SinCanadaRule extends DocumentRule
{
    public function __construct(?SinCanada $validator = null)
    {
        $this->validator = $validator ?? new SinCanada();
    }

    protected function message(): string
    {
        return 'El SIN ingresado no es válido.';
    }
}
