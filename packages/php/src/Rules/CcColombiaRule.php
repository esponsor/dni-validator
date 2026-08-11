<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\CcColombia;

class CcColombiaRule extends DocumentRule
{
    public function __construct(?CcColombia $validator = null)
    {
        $this->validator = $validator ?? new CcColombia();
    }

    protected function message(): string
    {
        return 'La cédula de ciudadanía ingresada no es válida.';
    }
}
