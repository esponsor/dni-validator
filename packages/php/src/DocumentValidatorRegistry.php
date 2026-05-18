<?php

namespace Esponsor\DniValidator;

class DocumentValidatorRegistry
{
    private const MAP = [
        'CL:RUT' => RutChile::class,
        'MX:CURP' => CurpMexico::class,
    ];

    public static function for(string $country, string $type): ?object
    {
        $class = self::MAP[strtoupper($country).':'.$type] ?? null;

        return $class ? new $class() : null;
    }

    public static function validate(string $country, string $type, string $value): bool
    {
        $validator = self::for($country, $type);

        return $validator ? $validator->validate($value) : false;
    }
}
