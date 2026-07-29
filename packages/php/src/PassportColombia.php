<?php

namespace Esponsor\DniValidator;

class PassportColombia
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

        return $length > 1 && $length <= 12;
    }
}
