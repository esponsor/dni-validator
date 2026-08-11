<?php

namespace Esponsor\DniValidator;

class DocumentValidatorRegistry
{
    private const MAP = [
        'AR:CUIT/CUIL' => CuitCuilArgentina::class,
        'BR:CPF' => CpfBrazil::class,
        'BR:CNPJ' => CnpjBrazil::class,
        'CA:SIN' => SinCanada::class,
        'CL:RUT' => RutChile::class,
        'CO:CC' => CcColombia::class,
        'CO:NIT' => NitColombia::class,
        'CO:PASS' => PassportColombia::class,
        'EC:CI' => CiEcuador::class,
        'EC:RUT' => RutEcuador::class,
        'EC:PASS' => PassportEcuador::class,
        'ES:DNI' => DniSpain::class,
        'MX:CURP' => CurpMexico::class,
        'PE:DNI' => DniPeru::class,
        'PE:RUC' => RucPeru::class,
        'PR:SSN' => SsnUnitedStates::class,
        'US:SSN' => SsnUnitedStates::class,
        'UY:CI' => CiUruguay::class,
        'UY:RUT' => RutUruguay::class,
    ];

    public static function for(string $country, string $type): ?object
    {
        $class = self::MAP[strtoupper($country).':'.strtoupper($type)] ?? null;

        return $class ? new $class() : null;
    }

    public static function validate(string $country, string $type, string $value): bool
    {
        $validator = self::for($country, $type);

        return $validator ? $validator->validate($value) : false;
    }
}
