<?php

namespace Esponsor\DniValidator;

class CcColombia
{
    /**
     * Structural check only: the cédula de ciudadanía carries no published check digit.
     */
    public function validate(mixed $cc): bool
    {
        if (! is_string($cc)) {
            return false;
        }

        $length = strlen($this->clean($cc));

        return $length === 8 || $length === 10;
    }

    public function clean(mixed $cc): string
    {
        if (! is_string($cc)) {
            return '';
        }

        return preg_replace('/\D/', '', $cc) ?? '';
    }

    public function format(mixed $cc): string
    {
        return preg_replace('/^(\d)(\d{3})(\d{3})(\d{3})$/', '$1.$2.$3.$4', $this->clean($cc)) ?? '';
    }
}
