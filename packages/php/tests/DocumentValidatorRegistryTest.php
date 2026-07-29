<?php

use Esponsor\DniValidator\CurpMexico;
use Esponsor\DniValidator\DocumentValidatorRegistry;
use Esponsor\DniValidator\RutChile;
use Esponsor\DniValidator\RutUruguay;
use Esponsor\DniValidator\SsnUnitedStates;

it('returns the correct validator instance', function () {
    expect(DocumentValidatorRegistry::for('CL', 'RUT'))->toBeInstanceOf(RutChile::class);
    expect(DocumentValidatorRegistry::for('MX', 'CURP'))->toBeInstanceOf(CurpMexico::class);
    expect(DocumentValidatorRegistry::for('UY', 'RUT'))->toBeInstanceOf(RutUruguay::class);
});

it('shares the SSN validator between the United States and Puerto Rico', function () {
    expect(DocumentValidatorRegistry::for('US', 'SSN'))->toBeInstanceOf(SsnUnitedStates::class);
    expect(DocumentValidatorRegistry::for('PR', 'SSN'))->toBeInstanceOf(SsnUnitedStates::class);
});

it('looks up country and type case insensitively', function () {
    expect(DocumentValidatorRegistry::for('cl', 'rut'))->toBeInstanceOf(RutChile::class);
    expect(DocumentValidatorRegistry::validate('ar', 'cuit/cuil', '20-12345678-6'))->toBeTrue();
});

it('validates through the registry', function () {
    expect(DocumentValidatorRegistry::validate('CL', 'RUT', '11.111.111-1'))->toBeTrue();
    expect(DocumentValidatorRegistry::validate('MX', 'CURP', 'GICJ020605HDGRHNA2'))->toBeTrue();
    expect(DocumentValidatorRegistry::validate('CL', 'RUT', '11.111.111-2'))->toBeFalse();
});

it('returns null for unknown country and type combinations', function () {
    expect(DocumentValidatorRegistry::for('CL', 'UNKNOWN'))->toBeNull();
    expect(DocumentValidatorRegistry::for('XX', 'RUT'))->toBeNull();
});
