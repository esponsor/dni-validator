<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\RutUruguay;

class RutUruguayRule extends DocumentRule
{
    public function __construct(?RutUruguay $validator = null)
    {
        $this->validator = $validator ?? new RutUruguay();
    }

    protected function message(): string
    {
        return 'El RUT ingresado no es válido.';
    }
}
