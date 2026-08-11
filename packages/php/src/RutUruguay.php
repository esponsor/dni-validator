<?php

namespace Esponsor\DniValidator;

class RutUruguay
{
    private const WEIGHTS = [4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    public function validate(mixed $rut): bool
    {
        if (! is_string($rut)) {
            return false;
        }

        $rut = $this->clean($rut);

        if (strlen($rut) !== 12) {
            return false;
        }

        return $this->getExpectedCheckDigit(substr($rut, 0, 11)) === (int) substr($rut, -1);
    }

    public function clean(mixed $rut): string
    {
        if (! is_string($rut)) {
            return '';
        }

        return preg_replace('/\D/', '', $rut) ?? '';
    }

    public function format(mixed $rut): string
    {
        return preg_replace('/^(\d{2})(\d{6})(\d{3})(\d)$/', '$1-$2-$3-$4', $this->clean($rut)) ?? '';
    }

    public function getExpectedCheckDigit(string $body): int
    {
        if (strlen($body) !== 11) {
            return -1;
        }

        $sum = 0;

        foreach (self::WEIGHTS as $index => $weight) {
            $sum += (int) $body[$index] * $weight;
        }

        $digit = 11 - $sum % 11;

        if ($digit === 11) {
            return 0;
        }

        return $digit === 10 ? 1 : $digit;
    }
}
