<?php

use Esponsor\DniValidator\CurpMexico;

beforeEach(function () {
    $this->validator = new CurpMexico();
});

it('cleans CURP values', function () {
    expect($this->validator->clean('GICJ020605HDGRHNA2'))->toBe('GICJ020605HDGRHNA2');
    expect($this->validator->clean('gicj-020605-hdgrhna2'))->toBe('gicj020605hdgrhna2');
});

it('validates known valid CURP values', function () {
    expect($this->validator->validate('GICJ020605HDGRHNA2'))->toBeTrue();
    expect($this->validator->validate('BOOL051031MDFRRNA8'))->toBeTrue();
});

it('rejects known invalid CURP values', function () {
    expect($this->validator->validate('BUFA051003MSPNGMA'))->toBeFalse();
    expect($this->validator->validate('BUFA051003MSPNGMA3'))->toBeFalse();
});

it('computes the expected check digit', function () {
    expect($this->validator->getExpectedCheckDigit('GICJ020605HDGRHNA2'))->toBe('2');
    expect($this->validator->getExpectedCheckDigit('BOOL051031MDFRRNA8'))->toBe('8');
});

it('formats CURP values', function () {
    expect($this->validator->format('gicj-020605-hdgrhna2'))->toBe('GICJ020605HDGRHNA2');
});
