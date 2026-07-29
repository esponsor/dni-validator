<?php

namespace Esponsor\DniValidator;

class CpfBrazil
{
    public function validate(mixed $cpf): bool
    {
        if (! is_string($cpf)) {
            return false;
        }

        $cpf = $this->clean($cpf);

        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }

        $base = substr($cpf, 0, 9);
        $base .= $this->getExpectedCheckDigit($base);
        $base .= $this->getExpectedCheckDigit($base);

        return substr($base, -2) === substr($cpf, -2);
    }

    public function clean(mixed $cpf): string
    {
        if (! is_string($cpf)) {
            return '';
        }

        return preg_replace('/\D/', '', $cpf) ?? '';
    }

    public function format(mixed $cpf): string
    {
        return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $this->clean($cpf)) ?? '';
    }

    public function getExpectedCheckDigit(string $base): int
    {
        $modulus = strlen($base) + 1;
        $sum = 0;

        for ($i = 0; $i < strlen($base); $i++) {
            $sum += (int) $base[$i] * ($modulus - $i);
        }

        $remainder = $sum % 11;

        return $remainder < 2 ? 0 : 11 - $remainder;
    }
}
