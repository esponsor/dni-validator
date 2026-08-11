<?php

namespace Esponsor\DniValidator;

class PassportEcuador
{
    /**
     * Length check only: passport numbers have no verifiable structure.
     */
    public function validate(mixed $passport): bool
    {
        if (! is_string($passport)) {
            return false;
        }

        $length = strlen($passport);

        return $length >= 8 && $length <= 12;
    }
}
