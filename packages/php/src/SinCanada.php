<?php

namespace Esponsor\DniValidator;

class SinCanada
{
    /**
     * Validates the Luhn check digit of the Social Insurance Number.
     */
    public function validate(mixed $sin): bool
    {
        if (! is_string($sin)) {
            return false;
        }

        $sin = $this->clean($sin);

        if (strlen($sin) !== 9) {
            return false;
        }

        $sum = 0;

        for ($i = 0; $i < 8; $i++) {
            $digit = (int) $sin[$i];

            if ($i % 2 === 1) {
                $digit *= 2;

                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return (int) $sin[8] === (10 - $sum % 10) % 10;
    }

    public function clean(mixed $sin): string
    {
        if (! is_string($sin)) {
            return '';
        }

        return preg_replace('/\D/', '', $sin) ?? '';
    }

    public function format(mixed $sin): string
    {
        return preg_replace('/^(\d{3})(\d{3})(\d{3})$/', '$1-$2-$3', $this->clean($sin)) ?? '';
    }
}
