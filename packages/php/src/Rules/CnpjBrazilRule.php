<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\CnpjBrazil;

class CnpjBrazilRule extends DocumentRule
{
    public function __construct(?CnpjBrazil $validator = null)
    {
        $this->validator = $validator ?? new CnpjBrazil();
    }

    protected function message(): string
    {
        return 'El CNPJ ingresado no es válido.';
    }
}
