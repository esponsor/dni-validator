<?php

namespace Esponsor\DniValidator;

class DniPeru
{
    /**
     * Structural check only: eight digits plus an optional verification character (0-9 or A-K).
     */
    public function validate(mixed $dni): bool
    {
        if (! is_string($dni)) {
            return false;
        }

        return (bool) preg_match('/^\d{8}[\dA-K]?$/', $this->clean($dni));
    }

    public function clean(mixed $dni): string
    {
        if (! is_string($dni)) {
            return '';
        }

        return preg_replace('/[^\dA-K]/', '', strtoupper($dni)) ?? '';
    }

    public function format(mixed $dni): string
    {
        return preg_replace('/^(\d{8})([\dA-K])$/', '$1-$2', $this->clean($dni)) ?? '';
    }
}
