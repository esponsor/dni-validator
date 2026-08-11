<?php

namespace Esponsor\DniValidator;

class CiEcuador
{
    /**
     * Structural check only: ten digits; the check digit is not verified.
     */
    public function validate(mixed $ci): bool
    {
        if (! is_string($ci)) {
            return false;
        }

        return strlen($this->clean($ci)) === 10;
    }

    public function clean(mixed $ci): string
    {
        if (! is_string($ci)) {
            return '';
        }

        return preg_replace('/\D/', '', $ci) ?? '';
    }

    public function format(mixed $ci): string
    {
        return preg_replace('/^(\d{9})(\d)$/', '$1-$2', $this->clean($ci)) ?? '';
    }
}
