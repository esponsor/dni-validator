<?php

namespace Esponsor\DniValidator;

class RucPeru
{
    private const VALID_PREFIXES = ['10', '15', '16', '17', '20'];

    /**
     * Structural check only: eleven digits with a known taxpayer prefix; the check digit is not verified.
     */
    public function validate(mixed $ruc): bool
    {
        if (! is_string($ruc)) {
            return false;
        }

        $ruc = $this->clean($ruc);

        return strlen($ruc) === 11 && in_array(substr($ruc, 0, 2), self::VALID_PREFIXES, true);
    }

    public function clean(mixed $ruc): string
    {
        if (! is_string($ruc)) {
            return '';
        }

        return preg_replace('/\D/', '', $ruc) ?? '';
    }

    public function format(mixed $ruc): string
    {
        return $this->clean($ruc);
    }
}
