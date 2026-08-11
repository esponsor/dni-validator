<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\CurpMexico;

class CurpMexicoRule extends DocumentRule
{
    public function __construct(?CurpMexico $validator = null)
    {
        $this->validator = $validator ?? new CurpMexico();
    }

    protected function message(): string
    {
        return 'El CURP ingresado no es válido.';
    }
}
