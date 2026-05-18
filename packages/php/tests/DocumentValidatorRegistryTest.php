<?php

use Esponsor\DniValidator\CurpMexico;
use Esponsor\DniValidator\DocumentValidatorRegistry;
use Esponsor\DniValidator\RutChile;

it('returns the correct validator instance', function () {
    expect(DocumentValidatorRegistry::for('CL', 'RUT'))->toBeInstanceOf(RutChile::class);
    expect(DocumentValidatorRegistry::for('MX', 'CURP'))->toBeInstanceOf(CurpMexico::class);
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
