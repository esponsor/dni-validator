<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\CpfBrazil;

class CpfBrazilRule extends DocumentRule
{
    public function __construct(?CpfBrazil $validator = null)
    {
        $this->validator = $validator ?? new CpfBrazil();
    }

    protected function message(): string
    {
        return 'El CPF ingresado no es válido.';
    }
}
