<?php

namespace Esponsor\DniValidator;

class DniSpain
{
    private const CHECK_LETTERS = 'TRWAGMYFPDXBNJZSQVHLCKET';

    private const NIE_PREFIXES = 'XYZ';

    /**
     * Validates both the DNI (digits only) and the NIE (X, Y or Z prefix) using the modulo-23 letter.
     */
    public function validate(mixed $dni): bool
    {
        if (! is_string($dni)) {
            return false;
        }

        $dni = $this->clean($dni);

        if (! preg_match('/^[XYZ]?\d{5,8}[A-Z]$/', $dni)) {
            return false;
        }

        $body = preg_replace_callback(
            '/^[XYZ]/',
            fn (array $matches): string => (string) strpos(self::NIE_PREFIXES, $matches[0]),
            substr($dni, 0, -1)
        ) ?? '';

        return self::CHECK_LETTERS[(int) $body % 23] === substr($dni, -1);
    }

    public function clean(mixed $dni): string
    {
        if (! is_string($dni)) {
            return '';
        }

        return preg_replace('/[^\dA-Z]/', '', strtoupper($dni)) ?? '';
    }

    public function format(mixed $dni): string
    {
        return $this->clean($dni);
    }
}
