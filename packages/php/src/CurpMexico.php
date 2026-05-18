<?php

namespace Esponsor\DniValidator;

class CurpMexico
{
    private const CHARLIST = '0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';

    private const INCONVENIENT_WORDS = [
        'BACA', 'BAKA', 'BUEI', 'BUEY', 'CACA', 'CACO', 'CAGA', 'CAGO', 'CAKA', 'CAKO',
        'COGE', 'COGI', 'COJA', 'COJE', 'COJI', 'COJO', 'COLA', 'CULO', 'FALO', 'FETO',
        'GETA', 'GUEI', 'GUEY', 'JETA', 'JOTO', 'KACA', 'KACO', 'KAGA', 'KAGO', 'KAKA',
        'KAKO', 'KOGE', 'KOGI', 'KOJA', 'KOJE', 'KOJI', 'KOJO', 'KOLA', 'KULO', 'LILO',
        'LOCA', 'LOCO', 'LOKA', 'LOKO', 'MAME', 'MAMO', 'MEAR', 'MEAS', 'MEON', 'MIAR',
        'MION', 'MOCO', 'MOKO', 'MULA', 'MULO', 'NACA', 'NACO', 'PEDA', 'PEDO', 'PENE',
        'PIPI', 'PITO', 'POPO', 'PUTA', 'PUTO', 'QULO', 'RATA', 'ROBA', 'ROBE', 'ROBO',
        'RUIN', 'SENO', 'TETA', 'VACA', 'VAGA', 'VAGO', 'VAKA', 'VUEI', 'VUEY', 'WUEI',
        'WUEY',
    ];

    public function validate(mixed $curp): bool
    {
        if (! is_string($curp)) {
            return false;
        }

        $curp = strtoupper($this->clean($curp));

        if (! preg_match('/^[A-Z]{4}[0-9]{6}(H|M)[A-Z]{5}[A-Z0-9][0-9]$/', $curp)) {
            return false;
        }

        if (in_array(substr($curp, 0, 4), self::INCONVENIENT_WORDS, true)) {
            return false;
        }

        return $this->getExpectedCheckDigit($curp) === $curp[17];
    }

    public function clean(mixed $curp): string
    {
        if (! is_string($curp)) {
            return '';
        }

        return preg_replace('/[^a-zA-Z0-9]/', '', $curp) ?? '';
    }

    public function format(mixed $curp): string
    {
        return strtoupper($this->clean($curp));
    }

    public function getExpectedCheckDigit(string $curp): string
    {
        $curp = strtoupper($this->clean($curp));
        $sum = 0;

        for ($i = 0; $i < 17; $i++) {
            $position = mb_strpos(self::CHARLIST, $curp[$i]);

            if ($position === false) {
                return '';
            }

            $sum += $position * (18 - $i);
        }

        return (string) ((abs($sum % 10 - 10)) % 10);
    }
}
