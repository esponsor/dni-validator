<?php

namespace Esponsor\DniValidator;

class CnpjBrazil
{
    public function validate(mixed $cnpj): bool
    {
        if (! is_string($cnpj)) {
            return false;
        }

        $cnpj = $this->clean($cnpj);

        if (strlen($cnpj) !== 14 || preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }

        $base = substr($cnpj, 0, 12);
        $base .= $this->getExpectedCheckDigit($base);
        $base .= $this->getExpectedCheckDigit($base);

        return substr($base, -2) === substr($cnpj, -2);
    }

    public function clean(mixed $cnpj): string
    {
        if (! is_string($cnpj)) {
            return '';
        }

        return preg_replace('/\D/', '', $cnpj) ?? '';
    }

    public function format(mixed $cnpj): string
    {
        return preg_replace(
            '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/',
            '$1.$2.$3/$4-$5',
            $this->clean($cnpj)
        ) ?? '';
    }

    public function getExpectedCheckDigit(string $base): int
    {
        $weight = 2;
        $sum = 0;

        for ($i = strlen($base) - 1; $i >= 0; $i--) {
            $sum += (int) $base[$i] * $weight;
            $weight = $weight === 9 ? 2 : $weight + 1;
        }

        $remainder = $sum % 11;

        return $remainder < 2 ? 0 : 11 - $remainder;
    }
}
