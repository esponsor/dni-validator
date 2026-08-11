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

it('rejects oversized and adversarial RUT values without hanging', function (string $value) {
    $started = hrtime(true);
    expect($this->validator->validate($value))->toBeFalse();
    expect((hrtime(true) - $started) / 1e6)->toBeLessThan(1000);
})->with([
    '100 digits' => [str_repeat('9', 100).'-1'],
    '1000 digits' => [str_repeat('9', 1000).'-1'],
    '100000 digits' => [str_repeat('9', 100000).'-1'],
    '310 nines' => [str_repeat('9', 310)],
    'wrapped markup' => ['<script>11.111.111-1</script>'],
    '9 body digits' => ['999999999-1'],
]);
