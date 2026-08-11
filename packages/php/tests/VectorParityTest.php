<?php

use Esponsor\DniValidator\DocumentValidatorRegistry;

/**
 * @return array<int, array{country: string, type: string, valid: array<int, string>, invalid: array<int, string>, formats?: array<string, string>}>
 */
function loadVectors(): array
{
    $vectors = [];

    foreach (glob(dirname(__DIR__, 3).'/tests/vectors/*.json') ?: [] as $path) {
        $vectors[] = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    }

    return $vectors;
}

/**
 * @return array<string, array{0: string, 1: string, 2: string}>
 */
function vectorCases(string $bucket): array
{
    $cases = [];

    foreach (loadVectors() as $vector) {
        foreach ($vector[$bucket] as $value) {
            $cases["{$vector['country']} {$vector['type']} {$value}"] = [$vector['country'], $vector['type'], (string) $value];
        }
    }

    return $cases;
}

/**
 * @return array<string, array{0: string, 1: string, 2: string, 3: string}>
 */
function vectorFormatCases(): array
{
    $cases = [];

    foreach (loadVectors() as $vector) {
        foreach ($vector['formats'] ?? [] as $input => $expected) {
            $cases["{$vector['country']} {$vector['type']} {$input}"] = [$vector['country'], $vector['type'], (string) $input, $expected];
        }
    }

    return $cases;
}

dataset('valid-documents', fn () => vectorCases('valid'));

dataset('invalid-documents', fn () => vectorCases('invalid'));

dataset('document-formats', fn () => vectorFormatCases());

it('accepts valid document vectors', function (string $country, string $type, string $value) {
    expect(DocumentValidatorRegistry::validate($country, $type, $value))->toBeTrue();
})->with('valid-documents');

it('rejects invalid document vectors', function (string $country, string $type, string $value) {
    expect(DocumentValidatorRegistry::validate($country, $type, $value))->toBeFalse();
})->with('invalid-documents');

it('formats document vectors', function (string $country, string $type, string $input, string $expected) {
    expect(DocumentValidatorRegistry::for($country, $type)->format($input))->toBe($expected);
})->with('document-formats');
