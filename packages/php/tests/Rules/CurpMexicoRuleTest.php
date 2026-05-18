<?php

use Esponsor\DniValidator\Rules\CurpMexicoRule;

it('passes validation for a valid CURP', function () {
    $rule = new CurpMexicoRule();
    $failed = false;

    $rule->validate('curp', 'GICJ020605HDGRHNA2', function () use (&$failed) {
        $failed = true;
    });

    expect($failed)->toBeFalse();
});

it('fails validation for an invalid CURP', function () {
    $rule = new CurpMexicoRule();
    $failed = false;

    $rule->validate('curp', 'BUFA051003MSPNGMA3', function () use (&$failed) {
        $failed = true;
    });

    expect($failed)->toBeTrue();
});

it('fails validation for non-string values', function () {
    $rule = new CurpMexicoRule();
    $failed = false;

    $rule->validate('curp', 123, function () use (&$failed) {
        $failed = true;
    });

    expect($failed)->toBeTrue();
});
