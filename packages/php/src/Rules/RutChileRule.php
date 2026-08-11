<?php

namespace Esponsor\DniValidator\Rules;

use Esponsor\DniValidator\RutChile;

class RutChileRule extends DocumentRule
{
    public function __construct(?RutChile $validator = null)
    {
        $this->validator = $validator ?? new RutChile();
    }

    protected function message(): string
    {
        return 'El RUT ingresado no es válido.';
    }
}
