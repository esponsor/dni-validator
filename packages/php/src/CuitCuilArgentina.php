<?php

namespace Esponsor\DniValidator;

class CuitCuilArgentina
{
    private const WEIGHTS = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

    public function validate(mixed $cuit): bool
    {
        if (! is_string($cuit)) {
            return false;
        }

        $cuit = $this->clean($cuit);

        if (! preg_match('/^(20|23|24|27|30|33|34)\d{9}$/', $cuit)) {
            return false;
        }

        return $this->getExpectedCheckDigit(substr($cuit, 0, 10)) === (int) substr($cuit, -1);
    }

    public function clean(mixed $cuit): string
    {
        if (! is_string($cuit)) {
            return '';
        }

        return preg_replace('/\D/', '', $cuit) ?? '';
    }

    public function format(mixed $cuit): string
    {
        return preg_replace('/^(\d{2})(\d{8})(\d)$/', '$1-$2-$3', $this->clean($cuit)) ?? '';
    }

    public function getExpectedCheckDigit(string $body): int
    {
        if (strlen($body) !== 10) {
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

        return $digit === 10 ? 9 : $digit;
    }
}
