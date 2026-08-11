<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\NitColombia;

class NitColombiaRule extends DocumentRule
{
    public function __construct(?NitColombia $validator = null)
    {
        $this->validator = $validator ?? new NitColombia();
    }

    protected function message(): string
    {
        return 'El NIT ingresado no es válido.';
    }
}
