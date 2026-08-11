<?php

namespace Esponsor\DniValidator;

class SsnUnitedStates
{
    /**
     * Structural check only: rejects area, group and serial ranges the SSA never issues.
     */
    public function validate(mixed $ssn): bool
    {
        if (! is_string($ssn)) {
            return false;
        }

        return (bool) preg_match(
            '/^(?!666|000|9\d{2})\d{3}(?!00)\d{2}(?!0{4})\d{4}$/',
            $this->clean($ssn)
        );
    }

    public function clean(mixed $ssn): string
    {
        if (! is_string($ssn)) {
            return '';
        }

        return preg_replace('/\D/', '', $ssn) ?? '';
    }

    public function format(mixed $ssn): string
    {
        return preg_replace('/^(\d{3})(\d{2})(\d{4})$/', '$1-$2-$3', $this->clean($ssn)) ?? '';
    }
}
