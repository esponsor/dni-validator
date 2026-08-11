<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\CuitCuilArgentina;

class CuitCuilArgentinaRule extends DocumentRule
{
    public function __construct(?CuitCuilArgentina $validator = null)
    {
        $this->validator = $validator ?? new CuitCuilArgentina();
    }

    protected function message(): string
    {
        return 'El CUIT/CUIL ingresado no es válido.';
    }
}
