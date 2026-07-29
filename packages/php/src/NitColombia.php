<?php

namespace Esponsor\DniValidator;

class NitColombia
{
    /**
     * Structural check only: the NIT check digit is not verified.
     */
    public function validate(mixed $nit): bool
    {
        if (! is_string($nit)) {
            return false;
        }

        return strlen($this->clean($nit)) === 10;
    }

    public function clean(mixed $nit): string
    {
        if (! is_string($nit)) {
            return '';
        }

        return preg_replace('/\D/', '', $nit) ?? '';
    }

    public function format(mixed $nit): string
    {
        return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d)$/', '$1.$2.$3-$4', $this->clean($nit)) ?? '';
    }
}
