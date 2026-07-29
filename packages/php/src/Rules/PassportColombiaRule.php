<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\PassportColombia;

class PassportColombiaRule extends DocumentRule
{
    public function __construct(?PassportColombia $validator = null)
    {
        $this->validator = $validator ?? new PassportColombia();
    }

    protected function message(): string
    {
        return 'El pasaporte ingresado no es válido.';
    }
}
