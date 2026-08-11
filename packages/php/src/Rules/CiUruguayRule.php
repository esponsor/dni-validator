<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\CiUruguay;

class CiUruguayRule extends DocumentRule
{
    public function __construct(?CiUruguay $validator = null)
    {
        $this->validator = $validator ?? new CiUruguay();
    }

    protected function message(): string
    {
        return 'La cédula de identidad ingresada no es válida.';
    }
}
