<?php

use Esponsor\DniValidator\Rules\CcColombiaRule;
use Esponsor\DniValidator\Rules\CiEcuadorRule;
use Esponsor\DniValidator\Rules\CiUruguayRule;
use Esponsor\DniValidator\Rules\CnpjBrazilRule;
use Esponsor\DniValidator\Rules\CpfBrazilRule;
use Esponsor\DniValidator\Rules\CuitCuilArgentinaRule;
use Esponsor\DniValidator\Rules\CurpMexicoRule;
use Esponsor\DniValidator\Rules\DniPeruRule;
use Esponsor\DniValidator\Rules\DniSpainRule;
use Esponsor\DniValidator\Rules\NitColombiaRule;
use Esponsor\DniValidator\Rules\PassportColombiaRule;
use Esponsor\DniValidator\Rules\PassportEcuadorRule;
use Esponsor\DniValidator\Rules\RucPeruRule;
use Esponsor\DniValidator\Rules\RutChileRule;
use Esponsor\DniValidator\Rules\RutEcuadorRule;
use Esponsor\DniValidator\Rules\RutUruguayRule;
use Esponsor\DniValidator\Rules\SinCanadaRule;
use Esponsor\DniValidator\Rules\SsnUnitedStatesRule;
use Illuminate\Contracts\Validation\ValidationRule;

function ruleFailure(ValidationRule $rule, mixed $value): ?string
{
    $message = null;

    $rule->validate('document', $value, function (string $failure) use (&$message) {
        $message = $failure;
    });

    return $message;
}

dataset('document-rules', [
    'AR CUIT/CUIL' => [CuitCuilArgentinaRule::class, '20-12345678-6', '20-12345678-5'],
    'BR CNPJ' => [CnpjBrazilRule::class, '11.222.333/0001-81', '11.222.333/0001-82'],
    'BR CPF' => [CpfBrazilRule::class, '111.444.777-35', '111.444.777-36'],
    'CA SIN' => [SinCanadaRule::class, '046-454-286', '046-454-287'],
    'CL RUT' => [RutChileRule::class, '11.111.111-1', '11.111.111-2'],
    'CO CC' => [CcColombiaRule::class, '1.020.304.050', '123456789'],
    'CO NIT' => [NitColombiaRule::class, '900.123.456-1', '900123456'],
    'CO PASS' => [PassportColombiaRule::class, 'AB123456', 'A'],
    'EC CI' => [CiEcuadorRule::class, '1710034065', '171003406'],
    'EC PASS' => [PassportEcuadorRule::class, 'AB123456', 'AB12345'],
    'EC RUT' => [RutEcuadorRule::class, '1710034065001', '171003406500'],
    'ES DNI' => [DniSpainRule::class, '12345678Z', '12345678A'],
    'MX CURP' => [CurpMexicoRule::class, 'GICJ020605HDGRHNA2', 'BUFA051003MSPNGMA3'],
    'PE DNI' => [DniPeruRule::class, '12345678', '1234567'],
    'PE RUC' => [RucPeruRule::class, '20123456789', '30123456789'],
    'US SSN' => [SsnUnitedStatesRule::class, '219-09-9999', '666-12-1234'],
    'UY CI' => [CiUruguayRule::class, '1.234.567-2', '1.234.567-3'],
    'UY RUT' => [RutUruguayRule::class, '211003360014', '211003360015'],
]);

it('passes validation for valid values', function (string $rule, string $valid, string $invalid) {
    expect(ruleFailure(new $rule(), $valid))->toBeNull();
})->with('document-rules');

it('fails validation with a message for invalid values', function (string $rule, string $valid, string $invalid) {
    expect(ruleFailure(new $rule(), $invalid))->toBeString()->not->toBeEmpty();
})->with('document-rules');

it('fails validation for non-string values', function (string $rule, string $valid, string $invalid) {
    expect(ruleFailure(new $rule(), 12345))->toBeString();
})->with('document-rules');
