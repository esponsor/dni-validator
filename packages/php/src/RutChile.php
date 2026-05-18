<?php

namespace Esponsor\DniValidator;

class RutChile
{
    public function validate(mixed $rut): bool
    {
        if (! is_string($rut)) {
            return false;
        }

        $rut = $this->clean($rut);

        if ($rut === '' || strlen($rut) < 2) {
            return false;
        }

        $digits = (int) substr($rut, 0, -1);
        $m = 0;
        $s = 1;

        while ($digits > 0) {
            $s = ($s + $digits % 10 * (9 - $m++ % 6)) % 11;
            $digits = (int) floor($digits / 10);
        }

        $check = ($s > 0) ? (string) ($s - 1) : 'K';

        return $check === $rut[strlen($rut) - 1];
    }

    public function clean(mixed $rut): string
    {
        if (! is_string($rut)) {
            return '';
        }

        return strtoupper(preg_replace('/^0+/', '', preg_replace('/[^0-9kK]+/', '', $rut) ?? ''));
    }

    public function format(mixed $rut): string
    {
        $clean = $this->clean($rut);

        if ($clean === '') {
            return '';
        }

        $body = substr($clean, 0, -1);
        $check = substr($clean, -1);

        return number_format((int) $body, 0, '', '.').'-'.$check;
    }
}
