<?php

namespace Esponsor\DniValidator;

class RutEcuador
{
    /**
     * Structural check only: thirteen digits; the check digit is not verified.
     */
    public function validate(mixed $rut): bool
    {
        if (! is_string($rut)) {
            return false;
        }

        return strlen($this->clean($rut)) === 13;
    }

    public function clean(mixed $rut): string
    {
        if (! is_string($rut)) {
            return '';
        }

        return preg_replace('/\D/', '', $rut) ?? '';
    }
}
