<?php

use Esponsor\DniValidator\DocumentValidatorRegistry;
use Esponsor\DniValidator\Tests\AssertSpec;

/**
 * @return array<int, array{
 *     country: string,
 *     type: string,
 *     name: string,
 *     subject: string,
 *     validation: string,
 *     patterns?: array<int, string>,
 *     valid: array<int, string>,
 *     invalid: array<int, array{value: string, reason: string}>,
 *     format_cases?: array<string, string>
 * }>
 */
function loadSpecs(): array
{
    $root = dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'spec';
    $paths = [];

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if (! $file->isFile() || $file->getExtension() !== 'json') {
            continue;
        }

        $paths[] = $file->getPathname();
    }

    sort($paths);

    $specs = [];

    foreach ($paths as $path) {
        $decoded = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        AssertSpec::assertValid($decoded, $path);
        $specs[] = $decoded;
    }

    return $specs;
}

/**
 * @return array<string, array{0: string, 1: string, 2: string}>
 */
function validSpecCases(): array
{
    $cases = [];

    foreach (loadSpecs() as $spec) {
        foreach ($spec['valid'] as $value) {
            $cases["{$spec['country']} {$spec['type']} {$value}"] = [$spec['country'], $spec['type'], (string) $value];
        }
    }

    return $cases;
}

/**
 * @return array<string, array{0: string, 1: string, 2: string}>
 */
function invalidSpecCases(): array
{
    $cases = [];

    foreach (loadSpecs() as $spec) {
        foreach ($spec['invalid'] as $entry) {
            $value = (string) $entry['value'];
            $cases["{$spec['country']} {$spec['type']} {$value}"] = [$spec['country'], $spec['type'], $value];
        }
    }

    return $cases;
}

/**
 * @return array<string, array{0: string, 1: string, 2: string, 3: string}>
 */
function formatSpecCases(): array
{
    $cases = [];

    foreach (loadSpecs() as $spec) {
        foreach ($spec['format_cases'] ?? [] as $input => $expected) {
            $cases["{$spec['country']} {$spec['type']} {$input}"] = [
                $spec['country'],
                $spec['type'],
                (string) $input,
                (string) $expected,
            ];
        }
    }

    return $cases;
}

dataset('valid-documents', fn () => validSpecCases());

dataset('invalid-documents', fn () => invalidSpecCases());

dataset('document-formats', fn () => formatSpecCases());

it('accepts valid document vectors', function (string $country, string $type, string $value) {
    expect(DocumentValidatorRegistry::validate($country, $type, $value))->toBeTrue();
})->with('valid-documents');

it('rejects invalid document vectors', function (string $country, string $type, string $value) {
    expect(DocumentValidatorRegistry::validate($country, $type, $value))->toBeFalse();
})->with('invalid-documents');

it('formats document vectors', function (string $country, string $type, string $input, string $expected) {
    expect(DocumentValidatorRegistry::for($country, $type)->format($input))->toBe($expected);
})->with('document-formats');
