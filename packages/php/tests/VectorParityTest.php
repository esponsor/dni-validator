<?php

use Esponsor\DniValidator\CurpMexico;
use Esponsor\DniValidator\RutChile;

function loadVectors(string $filename): array
{
    $path = dirname(__DIR__, 3).'/tests/vectors/'.$filename;
    $contents = file_get_contents($path);

    return json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
}

dataset('cl-rut-valid', function () {
    $vectors = loadVectors('cl-rut.json');

    return array_map(fn (string $value) => [$value], $vectors['valid']);
});

dataset('cl-rut-invalid', function () {
    $vectors = loadVectors('cl-rut.json');

    return array_map(fn (string $value) => [$value], $vectors['invalid']);
});

dataset('mx-curp-valid', function () {
    $vectors = loadVectors('mx-curp.json');

    return array_map(fn (string $value) => [$value], $vectors['valid']);
});

dataset('mx-curp-invalid', function () {
    $vectors = loadVectors('mx-curp.json');

    return array_map(fn (string $value) => [$value], $vectors['invalid']);
});

it('accepts valid Chile RUT vectors', function (string $value) {
    expect((new RutChile())->validate($value))->toBeTrue();
})->with('cl-rut-valid');

it('rejects invalid Chile RUT vectors', function (string $value) {
    expect((new RutChile())->validate($value))->toBeFalse();
})->with('cl-rut-invalid');

it('accepts valid Mexico CURP vectors', function (string $value) {
    expect((new CurpMexico())->validate($value))->toBeTrue();
})->with('mx-curp-valid');

it('rejects invalid Mexico CURP vectors', function (string $value) {
    expect((new CurpMexico())->validate($value))->toBeFalse();
})->with('mx-curp-invalid');
