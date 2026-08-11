<?php

namespace Esponsor\DniValidator;

class RutChile
{
    /**
     * Validates a Chilean RUT (modulo-11). Body length is capped at 8 digits so checksum
     * work is bounded; calculation walks digits as characters (no integer conversion of the body).
     */
    public function validate(mixed $rut): bool
    {
        if (! is_string($rut) || ! $this->isAllowedRutShape($rut)) {
            return false;
        }

        $rut = $this->clean($rut);

        // 1–8 body digits + check digit (SII-style bodies; leading zeros already stripped by clean).
        if ($rut === '' || preg_match('/^\d{1,8}[0-9K]$/', $rut) !== 1) {
            return false;
        }

        $body = substr($rut, 0, -1);
        $m = 0;
        $s = 1;

        for ($i = strlen($body) - 1; $i >= 0; $i--) {
            $s = ($s + ((int) $body[$i]) * (9 - $m++ % 6)) % 11;
        }

        $check = ($s > 0) ? (string) ($s - 1) : 'K';

        return $check === $rut[strlen($rut) - 1];
    }

    public function clean(mixed $rut): string
    {
        if (! is_string($rut)) {
            return '';
        }

        return strtoupper(preg_replace('/^0+/', '', preg_replace('/[^0-9kK]+/', '', $rut) ?? '') ?? '');
    }

    public function format(mixed $rut): string
    {
        $clean = $this->clean($rut);

        if ($clean === '' || preg_match('/^\d+[0-9K]$/', $clean) !== 1) {
            return '';
        }

        $body = substr($clean, 0, -1);
        $check = substr($clean, -1);

        return preg_replace('/\B(?=(\d{3})+(?!\d))/', '.', $body).'-'.$check;
    }

    /** Digits and conventional RUT separators only (dots, hyphens, spaces, K). */
    private function isAllowedRutShape(string $rut): bool
    {
        return preg_match('/^[0-9kK.\-\s]+$/', $rut) === 1;
    }
}
