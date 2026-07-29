<?php

namespace Esponsor\DniValidator;

class CiUruguay
{
    private const WEIGHTS = [2, 9, 8, 7, 6, 3, 4];

    public function validate(mixed $ci): bool
    {
        if (! is_string($ci)) {
            return false;
        }

        $ci = $this->clean($ci);

        if (strlen($ci) < 7 || strlen($ci) > 8) {
            return false;
        }

        return $this->getExpectedCheckDigit(substr($ci, 0, -1)) === (int) substr($ci, -1);
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
        return preg_replace('/^(\d)(\d{3})(\d{3})(\d)$/', '$1.$2.$3-$4', $this->clean($ci)) ?? '';
    }

    public function getExpectedCheckDigit(string $body): int
    {
        $padded = str_pad($body, 7, '0', STR_PAD_LEFT);
        $sum = 0;

        foreach (self::WEIGHTS as $index => $weight) {
            $sum += ($weight * (int) $padded[$index]) % 10;
        }

        return (10 - $sum % 10) % 10;
    }
}
