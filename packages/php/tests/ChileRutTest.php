<?php

use Esponsor\DniValidator\RutChile;

beforeEach(function () {
    $this->validator = new RutChile();
});

it('cleans formatted RUT values', function () {
    expect($this->validator->clean('11.111.111-1'))->toBe('111111111');
    expect($this->validator->clean('9.083.469-K'))->toBe('9083469K');
});

it('validates known valid RUT values', function () {
    expect($this->validator->validate('11.111.111-1'))->toBeTrue();
    expect($this->validator->validate('9.083.469-K'))->toBeTrue();
});

it('rejects known invalid RUT values', function () {
    expect($this->validator->validate('12.345.678-9'))->toBeFalse();
    expect($this->validator->validate('11.111.111-2'))->toBeFalse();
    expect($this->validator->validate('not-a-rut'))->toBeFalse();
});

it('formats cleaned RUT values', function () {
    expect($this->validator->format('111111111'))->toBe('11.111.111-1');
    expect($this->validator->format('9083469K'))->toBe('9.083.469-K');
});
